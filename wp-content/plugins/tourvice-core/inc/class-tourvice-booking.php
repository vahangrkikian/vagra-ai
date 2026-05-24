<?php
/**
 * TourVice Booking Handler — AJAX endpoint for tour booking submissions.
 *
 * @package TourVice
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TourVice_Booking
 */
class TourVice_Booking {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'wp_ajax_tourvice_submit_booking', array( __CLASS__, 'handle_submit_booking' ) );
		add_action( 'wp_ajax_nopriv_tourvice_submit_booking', array( __CLASS__, 'handle_submit_booking' ) );
	}

	/**
	 * Handle the booking submission AJAX request.
	 */
	public static function handle_submit_booking() {
		// Verify nonce.
		if ( ! check_ajax_referer( 'tourvice_booking_nonce', 'nonce', false ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Security check failed. Please refresh the page and try again.', 'tourvice' ) ),
				403
			);
		}

		// Sanitize inputs.
		$tour_id    = isset( $_POST['tour_id'] ) ? absint( $_POST['tour_id'] ) : 0;
		$name       = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$phone      = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$date       = isset( $_POST['date'] ) ? sanitize_text_field( wp_unslash( $_POST['date'] ) ) : '';
		$group_size = isset( $_POST['group_size'] ) ? absint( $_POST['group_size'] ) : 0;
		$requests   = isset( $_POST['requests'] ) ? sanitize_textarea_field( wp_unslash( $_POST['requests'] ) ) : '';

		// Validate required fields.
		if ( ! $tour_id || empty( $name ) || empty( $email ) || empty( $phone ) || empty( $date ) || ! $group_size ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Please fill in all required fields.', 'tourvice' ) ),
				400
			);
		}

		// Validate tour exists.
		$tour = get_post( $tour_id );
		if ( ! $tour || 'vagra_tour' !== $tour->post_type ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Invalid tour selection.', 'tourvice' ) ),
				400
			);
		}

		// Validate email format.
		if ( ! is_email( $email ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Please provide a valid email address.', 'tourvice' ) ),
				400
			);
		}

		// Validate date is in the future.
		$date_ts = strtotime( $date );
		if ( ! $date_ts || $date_ts < time() ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Please select a future date for your tour.', 'tourvice' ) ),
				400
			);
		}

		// Validate group size against tour limits.
		$group_min = (int) get_post_meta( $tour_id, '_tour_group_min', true );
		$group_max = (int) get_post_meta( $tour_id, '_tour_group_max', true );

		if ( $group_min && $group_size < $group_min ) {
			wp_send_json_error(
				array(
					'message' => sprintf(
						/* translators: %d: minimum group size */
						esc_html__( 'Minimum group size for this tour is %d.', 'tourvice' ),
						$group_min
					),
				),
				400
			);
		}

		if ( $group_max && $group_size > $group_max ) {
			wp_send_json_error(
				array(
					'message' => sprintf(
						/* translators: %d: maximum group size */
						esc_html__( 'Maximum group size for this tour is %d.', 'tourvice' ),
						$group_max
					),
				),
				400
			);
		}

		// Calculate total.
		$price    = (float) get_post_meta( $tour_id, '_tour_price', true );
		$discount = (float) get_post_meta( $tour_id, '_tour_discount', true );

		$unit_price = $price;
		if ( $discount > 0 && $discount <= 100 ) {
			$unit_price = $price * ( 1 - $discount / 100 );
		}
		$total = $unit_price * $group_size;

		// Generate reference: TV- + 6 random alphanumeric characters.
		$reference = self::generate_reference();

		// Create booking post.
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'vagra_booking',
				'post_status' => 'publish',
				'post_title'  => $reference . ' — ' . $name,
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Failed to create booking. Please try again.', 'tourvice' ) ),
				500
			);
		}

		// Set all meta fields.
		update_post_meta( $post_id, '_booking_tour_id', $tour_id );
		update_post_meta( $post_id, '_booking_name', $name );
		update_post_meta( $post_id, '_booking_email', $email );
		update_post_meta( $post_id, '_booking_phone', $phone );
		update_post_meta( $post_id, '_booking_date', $date );
		update_post_meta( $post_id, '_booking_group_size', $group_size );
		update_post_meta( $post_id, '_booking_total', $total );
		update_post_meta( $post_id, '_booking_requests', $requests );
		update_post_meta( $post_id, '_booking_status', 'pending' );

		// Send email notification to admin.
		self::send_admin_notification( $post_id, $tour );

		wp_send_json_success(
			array(
				'reference' => $reference,
				'total'     => number_format( $total, 2 ),
				'message'   => esc_html__( 'Booking submitted successfully! We\'ll confirm your reservation shortly.', 'tourvice' ),
			)
		);
	}

	/**
	 * Generate a unique booking reference: TV- + 6 alphanumeric characters.
	 *
	 * @return string The booking reference.
	 */
	private static function generate_reference() {
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$code  = '';
		for ( $i = 0; $i < 6; $i++ ) {
			$code .= $chars[ wp_rand( 0, strlen( $chars ) - 1 ) ];
		}
		return 'TV-' . $code;
	}

	/**
	 * Send a booking notification email to the admin.
	 *
	 * @param int      $post_id Booking post ID.
	 * @param \WP_Post $tour    Tour post object.
	 */
	private static function send_admin_notification( $post_id, $tour ) {
		$name       = get_post_meta( $post_id, '_booking_name', true );
		$email      = get_post_meta( $post_id, '_booking_email', true );
		$phone      = get_post_meta( $post_id, '_booking_phone', true );
		$date       = get_post_meta( $post_id, '_booking_date', true );
		$group_size = get_post_meta( $post_id, '_booking_group_size', true );
		$total      = get_post_meta( $post_id, '_booking_total', true );
		$requests   = get_post_meta( $post_id, '_booking_requests', true );

		$admin_email = get_option( 'admin_email' );

		/* translators: %s: site name */
		$subject = sprintf(
			esc_html__( 'New Tour Booking — %s', 'tourvice' ),
			get_bloginfo( 'name' )
		);

		$message  = esc_html__( 'A new tour booking has been submitted:', 'tourvice' ) . "\n\n";
		$message .= sprintf(
			/* translators: %s: tour name */
			esc_html__( 'Tour: %s', 'tourvice' ),
			$tour->post_title
		) . "\n";
		$message .= sprintf(
			/* translators: %s: customer name */
			esc_html__( 'Customer: %s', 'tourvice' ),
			$name
		) . "\n";
		$message .= sprintf(
			/* translators: %s: customer email */
			esc_html__( 'Email: %s', 'tourvice' ),
			$email
		) . "\n";
		$message .= sprintf(
			/* translators: %s: customer phone */
			esc_html__( 'Phone: %s', 'tourvice' ),
			$phone
		) . "\n";
		$message .= sprintf(
			/* translators: %s: tour date */
			esc_html__( 'Date: %s', 'tourvice' ),
			$date
		) . "\n";
		$message .= sprintf(
			/* translators: %d: group size */
			esc_html__( 'Group Size: %d', 'tourvice' ),
			$group_size
		) . "\n";
		$message .= sprintf(
			/* translators: %s: total price */
			esc_html__( 'Total: $%s', 'tourvice' ),
			number_format( (float) $total, 2 )
		) . "\n";

		if ( ! empty( $requests ) ) {
			$message .= sprintf(
				/* translators: %s: special requests */
				esc_html__( 'Special Requests: %s', 'tourvice' ),
				$requests
			) . "\n";
		}

		$message .= "\n" . sprintf(
			/* translators: %s: admin edit URL */
			esc_html__( 'Manage this booking: %s', 'tourvice' ),
			admin_url( 'post.php?post=' . $post_id . '&action=edit' )
		) . "\n";

		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

		wp_mail( $admin_email, $subject, $message, $headers );
	}
}

TourVice_Booking::init();
