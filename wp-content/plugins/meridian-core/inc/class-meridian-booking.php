<?php
/**
 * Meridian Booking handler.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Meridian_Booking {

	/**
	 * Process a booking submission.
	 *
	 * @param array $data Sanitized booking data.
	 * @return array|WP_Error Result with success flag and confirmation code, or error.
	 */
	public function process_booking( $data ) {
		// Validate required fields.
		$required = array( 'room_id', 'check_in', 'check_out', 'first_name', 'last_name', 'email' );
		foreach ( $required as $field ) {
			if ( empty( $data[ $field ] ) ) {
				return new WP_Error(
					'missing_field',
					/* translators: %s: field name */
					sprintf( __( 'The field "%s" is required.', 'meridian' ), $field ),
					array( 'status' => 400 )
				);
			}
		}

		// Validate email.
		if ( ! is_email( $data['email'] ) ) {
			return new WP_Error(
				'invalid_email',
				__( 'Please provide a valid email address.', 'meridian' ),
				array( 'status' => 400 )
			);
		}

		// Validate room exists.
		$room = get_post( $data['room_id'] );
		if ( ! $room || 'meridian_room' !== $room->post_type ) {
			return new WP_Error(
				'invalid_room',
				__( 'The selected room does not exist.', 'meridian' ),
				array( 'status' => 400 )
			);
		}

		// Validate dates.
		$check_in  = strtotime( $data['check_in'] );
		$check_out = strtotime( $data['check_out'] );

		if ( ! $check_in || ! $check_out || $check_out <= $check_in ) {
			return new WP_Error(
				'invalid_dates',
				__( 'Check-out date must be after check-in date.', 'meridian' ),
				array( 'status' => 400 )
			);
		}

		// Generate confirmation code.
		$code = $this->generate_code();

		// Calculate totals.
		$price  = (int) get_post_meta( $data['room_id'], '_meridian_price', true );
		$nights = max( 1, (int) ceil( ( $check_out - $check_in ) / DAY_IN_SECONDS ) );
		$totals = $this->calculate_total( $price, $nights );

		// Create booking post.
		$guest_name = $data['first_name'] . ' ' . $data['last_name'];
		$post_id    = wp_insert_post( array(
			'post_type'   => 'meridian_booking',
			'post_title'  => $code . ' — ' . $guest_name,
			'post_status' => 'publish',
		) );

		if ( is_wp_error( $post_id ) ) {
			return new WP_Error(
				'booking_failed',
				__( 'Could not create the booking. Please try again.', 'meridian' ),
				array( 'status' => 500 )
			);
		}

		// Save all meta.
		$meta = array(
			'_meridian_booking_code'       => $code,
			'_meridian_booking_room_id'    => $data['room_id'],
			'_meridian_booking_room_name'  => $room->post_title,
			'_meridian_booking_check_in'   => $data['check_in'],
			'_meridian_booking_check_out'  => $data['check_out'],
			'_meridian_booking_nights'     => $nights,
			'_meridian_booking_adults'     => $data['adults'],
			'_meridian_booking_children'   => $data['children'],
			'_meridian_booking_first_name' => $data['first_name'],
			'_meridian_booking_last_name'  => $data['last_name'],
			'_meridian_booking_email'      => $data['email'],
			'_meridian_booking_phone'      => $data['phone'],
			'_meridian_booking_country'    => $data['country'],
			'_meridian_booking_arrival'    => $data['arrival_time'],
			'_meridian_booking_requests'   => $data['requests'],
			'_meridian_booking_newsletter' => $data['newsletter'] ? '1' : '0',
			'_meridian_booking_subtotal'   => $totals['subtotal'],
			'_meridian_booking_resort_fee' => $totals['resort_fee'],
			'_meridian_booking_tax'        => $totals['tax'],
			'_meridian_booking_total'      => $totals['total'],
		);

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}

		// Send confirmation email.
		$this->send_confirmation_email( $data, $room->post_title, $code, $totals['total'], $nights );

		return array(
			'success' => true,
			'code'    => $code,
		);
	}

	/**
	 * Generate a unique confirmation code.
	 *
	 * @return string Code in format MRD-XXXXXX.
	 */
	public function generate_code() {
		return 'MRD-' . strtoupper( substr( md5( uniqid() ), 0, 6 ) );
	}

	/**
	 * Calculate booking total with resort fee and tax.
	 *
	 * @param int $price  Price per night in dollars.
	 * @param int $nights Number of nights.
	 * @return array Associative array with subtotal, resort_fee, tax, total.
	 */
	public function calculate_total( $price, $nights ) {
		$subtotal   = $price * $nights;
		$resort_fee = 35 * $nights;
		$tax        = ( $subtotal + $resort_fee ) * 0.1475;
		$total      = $subtotal + $resort_fee + $tax;

		return array(
			'subtotal'   => round( $subtotal, 2 ),
			'resort_fee' => round( $resort_fee, 2 ),
			'tax'        => round( $tax, 2 ),
			'total'      => round( $total, 2 ),
		);
	}

	/**
	 * Send booking confirmation email.
	 *
	 * @param array  $data         Booking data.
	 * @param string $room_name    Room title.
	 * @param string $code         Confirmation code.
	 * @param float  $total        Total amount.
	 * @param int    $nights       Number of nights.
	 */
	private function send_confirmation_email( $data, $room_name, $code, $total, $nights ) {
		$guest_name        = $data['first_name'] . ' ' . $data['last_name'];
		$check_in          = $data['check_in'];
		$check_out         = $data['check_out'];
		$confirmation_code = $code;
		$guests_count      = $data['adults'] + $data['children'];

		ob_start();
		include MERIDIAN_CORE_DIR . 'templates/email-confirmation.php';
		$message = ob_get_clean();

		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
		);

		wp_mail(
			$data['email'],
			/* translators: %s: confirmation code */
			sprintf( __( 'Booking Confirmation — %s', 'meridian' ), $code ),
			$message,
			$headers
		);
	}
}
