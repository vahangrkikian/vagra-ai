<?php
/**
 * DriveEase Booking Handler — AJAX endpoint and availability check.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DriveEase_Booking_Handler
 */
class DriveEase_Booking_Handler {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'wp_ajax_driveease_submit_booking', array( __CLASS__, 'handle_submit_booking' ) );
		add_action( 'wp_ajax_nopriv_driveease_submit_booking', array( __CLASS__, 'handle_submit_booking' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_rest_routes' ) );
	}

	/**
	 * Register REST API routes.
	 */
	public static function register_rest_routes() {
		register_rest_route(
			'driveease/v1',
			'/availability/(?P<car_id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'rest_get_availability' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'car_id' => array(
						'required'          => true,
						'validate_callback' => function ( $param ) {
							return is_numeric( $param ) && (int) $param > 0;
						},
						'sanitize_callback' => 'absint',
					),
					'month'  => array(
						'required'          => false,
						'validate_callback' => function ( $param ) {
							return (bool) preg_match( '/^\d{4}-\d{2}$/', $param );
						},
						'sanitize_callback' => 'sanitize_text_field',
					),
				),
			)
		);
	}

	/**
	 * REST callback: return booked periods for a car.
	 *
	 * @param WP_REST_Request $request The REST request.
	 * @return WP_REST_Response|WP_Error
	 */
	public static function rest_get_availability( $request ) {
		$car_id = $request->get_param( 'car_id' );

		// Validate car exists.
		$car = get_post( $car_id );
		if ( ! $car || 'driveease_car' !== $car->post_type ) {
			return new WP_Error(
				'driveease_invalid_car',
				__( 'Car not found.', 'driveease' ),
				array( 'status' => 404 )
			);
		}

		$meta_query = array(
			'relation' => 'AND',
			array(
				'key'     => '_booking_car_id',
				'value'   => $car_id,
				'compare' => '=',
				'type'    => 'NUMERIC',
			),
			array(
				'key'     => '_booking_status',
				'value'   => array( 'pending', 'confirmed', 'active' ),
				'compare' => 'IN',
			),
		);

		// Optional month filter.
		$month = $request->get_param( 'month' );
		if ( $month ) {
			$month_start = $month . '-01';
			$month_end   = gmdate( 'Y-m-t', strtotime( $month_start ) );

			$meta_query[] = array(
				'key'     => '_booking_pickup_date',
				'value'   => $month_end,
				'compare' => '<=',
				'type'    => 'DATE',
			);
			$meta_query[] = array(
				'key'     => '_booking_dropoff_date',
				'value'   => $month_start,
				'compare' => '>=',
				'type'    => 'DATE',
			);
		}

		$args = array(
			'post_type'      => 'driveease_booking',
			'post_status'    => 'publish',
			'posts_per_page' => 100,
			'fields'         => 'ids',
			'meta_query'     => $meta_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			'orderby'        => 'meta_value',
			'meta_key'       => '_booking_pickup_date', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'order'          => 'ASC',
		);

		$query   = new WP_Query( $args );
		$periods = array();

		foreach ( $query->posts as $booking_id ) {
			$periods[] = array(
				'start' => get_post_meta( $booking_id, '_booking_pickup_date', true ),
				'end'   => get_post_meta( $booking_id, '_booking_dropoff_date', true ),
			);
		}

		return rest_ensure_response( $periods );
	}

	/**
	 * Handle the booking submission AJAX request.
	 */
	public static function handle_submit_booking() {
		// Verify nonce.
		if ( ! check_ajax_referer( 'driveease_booking_nonce', 'nonce', false ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Security check failed. Please refresh the page and try again.', 'driveease' ) ),
				403
			);
		}

		// Sanitize inputs.
		$car_id           = isset( $_POST['car_id'] ) ? absint( $_POST['car_id'] ) : 0;
		$pickup_date      = isset( $_POST['pickup_date'] ) ? sanitize_text_field( wp_unslash( $_POST['pickup_date'] ) ) : '';
		$dropoff_date     = isset( $_POST['dropoff_date'] ) ? sanitize_text_field( wp_unslash( $_POST['dropoff_date'] ) ) : '';
		$pickup_location  = isset( $_POST['pickup_location'] ) ? sanitize_text_field( wp_unslash( $_POST['pickup_location'] ) ) : '';
		$dropoff_location = isset( $_POST['dropoff_location'] ) ? sanitize_text_field( wp_unslash( $_POST['dropoff_location'] ) ) : '';
		$customer_name    = isset( $_POST['customer_name'] ) ? sanitize_text_field( wp_unslash( $_POST['customer_name'] ) ) : '';
		$customer_email   = isset( $_POST['customer_email'] ) ? sanitize_email( wp_unslash( $_POST['customer_email'] ) ) : '';
		$customer_phone   = isset( $_POST['customer_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['customer_phone'] ) ) : '';
		$driver_license   = isset( $_POST['driver_license'] ) ? sanitize_text_field( wp_unslash( $_POST['driver_license'] ) ) : '';
		$extras           = isset( $_POST['extras'] ) ? sanitize_text_field( wp_unslash( $_POST['extras'] ) ) : '';
		$total_price      = isset( $_POST['total_price'] ) ? (float) $_POST['total_price'] : 0;
		$currency         = isset( $_POST['currency'] ) ? sanitize_text_field( wp_unslash( $_POST['currency'] ) ) : 'USD';

		// Validate required fields.
		if ( ! $car_id || empty( $pickup_date ) || empty( $dropoff_date ) || empty( $customer_name ) || empty( $customer_email ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Please fill in all required fields.', 'driveease' ) ),
				400
			);
		}

		// Validate car exists.
		$car = get_post( $car_id );
		if ( ! $car || 'driveease_car' !== $car->post_type ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Invalid car selection.', 'driveease' ) ),
				400
			);
		}

		// Validate dates.
		$pickup_ts  = strtotime( $pickup_date );
		$dropoff_ts = strtotime( $dropoff_date );

		if ( ! $pickup_ts || ! $dropoff_ts || $dropoff_ts <= $pickup_ts ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Invalid date range. Drop-off date must be after pickup date.', 'driveease' ) ),
				400
			);
		}

		// Validate email format.
		if ( ! is_email( $customer_email ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Please provide a valid email address.', 'driveease' ) ),
				400
			);
		}

		// Availability check.
		if ( ! self::is_car_available( $car_id, $pickup_date, $dropoff_date ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Car not available for selected dates.', 'driveease' ) ),
				409
			);
		}

		// Generate reference: DE- + 6 random alphanumeric characters.
		$reference = self::generate_reference();

		// Create booking post.
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'driveease_booking',
				'post_status' => 'publish',
				'post_title'  => $reference . ' — ' . $customer_name,
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Failed to create booking. Please try again.', 'driveease' ) ),
				500
			);
		}

		// Set all meta fields.
		update_post_meta( $post_id, '_booking_reference', $reference );
		update_post_meta( $post_id, '_booking_car_id', $car_id );
		update_post_meta( $post_id, '_booking_pickup_date', $pickup_date );
		update_post_meta( $post_id, '_booking_dropoff_date', $dropoff_date );
		update_post_meta( $post_id, '_booking_pickup_location', $pickup_location );
		update_post_meta( $post_id, '_booking_dropoff_location', $dropoff_location );
		update_post_meta( $post_id, '_booking_customer_name', $customer_name );
		update_post_meta( $post_id, '_booking_customer_email', $customer_email );
		update_post_meta( $post_id, '_booking_customer_phone', $customer_phone );
		update_post_meta( $post_id, '_booking_driver_license', $driver_license );
		update_post_meta( $post_id, '_booking_extras', $extras );
		update_post_meta( $post_id, '_booking_total_price', $total_price );
		update_post_meta( $post_id, '_booking_currency', $currency );
		update_post_meta( $post_id, '_booking_status', 'pending' );
		update_post_meta( $post_id, '_booking_payment_status', 'unpaid' );

		// Send confirmation email via DriveEase_Emails (HTML template).
		if ( class_exists( 'DriveEase_Emails' ) ) {
			DriveEase_Emails::send_confirmation_email( $post_id );
		}

		wp_send_json_success(
			array(
				'reference' => $reference,
				'message'   => esc_html__( 'Booking confirmed! Check your email for details.', 'driveease' ),
			)
		);
	}

	/**
	 * Check if a car is available for the given date range.
	 *
	 * @param int    $car_id      Car post ID.
	 * @param string $pickup_date  Pickup date (Y-m-d).
	 * @param string $dropoff_date Drop-off date (Y-m-d).
	 * @return bool True if available, false if conflicting booking exists.
	 */
	public static function is_car_available( $car_id, $pickup_date, $dropoff_date ) {
		$args = array(
			'post_type'      => 'driveease_booking',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				'relation' => 'AND',
				// Same car.
				array(
					'key'     => '_booking_car_id',
					'value'   => $car_id,
					'compare' => '=',
					'type'    => 'NUMERIC',
				),
				// Status not Cancelled.
				array(
					'key'     => '_booking_status',
					'value'   => 'cancelled',
					'compare' => '!=',
				),
				// Overlap check: existing pickup < requested dropoff AND existing dropoff > requested pickup.
				array(
					'key'     => '_booking_pickup_date',
					'value'   => $dropoff_date,
					'compare' => '<',
					'type'    => 'DATE',
				),
				array(
					'key'     => '_booking_dropoff_date',
					'value'   => $pickup_date,
					'compare' => '>',
					'type'    => 'DATE',
				),
			),
		);

		$query = new WP_Query( $args );

		return 0 === $query->found_posts;
	}

	/**
	 * Generate a unique booking reference: DE- + 6 alphanumeric characters.
	 *
	 * @return string The booking reference.
	 */
	private static function generate_reference() {
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$code  = '';
		for ( $i = 0; $i < 6; $i++ ) {
			$code .= $chars[ wp_rand( 0, strlen( $chars ) - 1 ) ];
		}
		return 'DE-' . $code;
	}

	/**
	 * Send a booking confirmation email to the customer.
	 *
	 * @param int $post_id Booking post ID.
	 */
	private static function send_confirmation_email( $post_id ) {
		$reference  = get_post_meta( $post_id, '_booking_reference', true );
		$email      = get_post_meta( $post_id, '_booking_customer_email', true );
		$name       = get_post_meta( $post_id, '_booking_customer_name', true );
		$car_id     = get_post_meta( $post_id, '_booking_car_id', true );
		$pickup     = get_post_meta( $post_id, '_booking_pickup_date', true );
		$dropoff    = get_post_meta( $post_id, '_booking_dropoff_date', true );
		$pickup_loc = get_post_meta( $post_id, '_booking_pickup_location', true );
		$total      = get_post_meta( $post_id, '_booking_total_price', true );
		$currency   = get_post_meta( $post_id, '_booking_currency', true );

		$car_name = get_the_title( $car_id );

		/* translators: %s: site name */
		$subject = sprintf( esc_html__( 'Booking Confirmation %s — %s', 'driveease' ), $reference, get_bloginfo( 'name' ) );

		$message  = sprintf(
			/* translators: %s: customer name */
			esc_html__( 'Dear %s,', 'driveease' ),
			$name
		) . "\n\n";
		$message .= esc_html__( 'Thank you for your booking! Here are your details:', 'driveease' ) . "\n\n";
		$message .= sprintf(
			/* translators: %s: booking reference */
			esc_html__( 'Reference: %s', 'driveease' ),
			$reference
		) . "\n";
		$message .= sprintf(
			/* translators: %s: car name */
			esc_html__( 'Car: %s', 'driveease' ),
			$car_name
		) . "\n";
		$message .= sprintf(
			/* translators: %s: pickup date */
			esc_html__( 'Pickup: %s', 'driveease' ),
			$pickup
		) . "\n";
		$message .= sprintf(
			/* translators: %s: dropoff date */
			esc_html__( 'Drop-off: %s', 'driveease' ),
			$dropoff
		) . "\n";
		$message .= sprintf(
			/* translators: %s: pickup location */
			esc_html__( 'Pickup Location: %s', 'driveease' ),
			$pickup_loc
		) . "\n";
		$message .= sprintf(
			/* translators: %1$s: currency, %2$s: total price */
			esc_html__( 'Total: %1$s %2$s', 'driveease' ),
			$currency,
			number_format( (float) $total, 2 )
		) . "\n\n";
		$message .= esc_html__( 'If you have any questions, please contact us.', 'driveease' ) . "\n\n";
		$message .= get_bloginfo( 'name' ) . "\n";
		$message .= home_url() . "\n";

		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

		wp_mail( $email, $subject, $message, $headers );
	}
}

DriveEase_Booking_Handler::init();
