<?php
/**
 * DriveEase Emails — HTML email templates for booking lifecycle.
 *
 * Booking Confirmation, Reminder (wp-cron 1 day before pickup),
 * and Cancellation emails. All HTML with inline CSS.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DriveEase_Emails
 */
class DriveEase_Emails {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		// Fire cancellation email when booking status changes to Cancelled.
		add_action( 'save_post_driveease_booking', array( __CLASS__, 'on_booking_save' ), 20, 3 );

		// Cron event for daily reminder check.
		add_action( 'driveease_daily_booking_reminders', array( __CLASS__, 'send_pending_reminders' ) );

		// Schedule the cron event if not already scheduled.
		if ( ! wp_next_scheduled( 'driveease_daily_booking_reminders' ) ) {
			wp_schedule_event( time(), 'daily', 'driveease_daily_booking_reminders' );
		}
	}

	/**
	 * Detect booking status changes on save and fire appropriate emails.
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    Post object.
	 * @param bool     $update  Whether this is an existing post being updated.
	 */
	public static function on_booking_save( $post_id, $post, $update ) {
		if ( ! $update ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( 'driveease_booking' !== $post->post_type ) {
			return;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified in DriveEase_Admin::save_booking_meta at priority 10.
		$new_status = isset( $_POST['_booking_status'] ) ? sanitize_text_field( wp_unslash( $_POST['_booking_status'] ) ) : '';

		if ( empty( $new_status ) ) {
			return;
		}

		// Read the previous status stored before this save.
		$old_status = get_post_meta( $post_id, '_booking_prev_status', true );

		// Persist current status as prev for next comparison.
		update_post_meta( $post_id, '_booking_prev_status', $new_status );

		if ( 'cancelled' === $new_status && 'cancelled' !== $old_status ) {
			self::send_cancellation_email( $post_id );
		}

		if ( 'confirmed' === $new_status && 'confirmed' !== $old_status ) {
			self::send_confirmation_email( $post_id );
		}
	}

	// ------------------------------------------------------------------
	// Booking Confirmation
	// ------------------------------------------------------------------

	/**
	 * Send an HTML booking confirmation email.
	 *
	 * @param int $post_id Booking post ID.
	 */
	public static function send_confirmation_email( $post_id ) {
		$data = self::get_booking_data( $post_id );
		if ( ! $data ) {
			return;
		}

		/* translators: %1$s: booking reference, %2$s: site name */
		$subject = sprintf( esc_html__( 'Booking Confirmation %1$s - %2$s', 'driveease' ), $data['reference'], get_bloginfo( 'name' ) );

		$rows = array(
			__( 'Reference', 'driveease' )       => esc_html( $data['reference'] ),
			__( 'Car', 'driveease' )              => esc_html( $data['car_name'] ),
			__( 'Pickup Date', 'driveease' )      => esc_html( $data['pickup_date'] ),
			__( 'Drop-off Date', 'driveease' )    => esc_html( $data['dropoff_date'] ),
			__( 'Pickup Location', 'driveease' )  => esc_html( $data['pickup_location'] ),
		);

		if ( ! empty( $data['extras'] ) ) {
			$rows[ __( 'Extras', 'driveease' ) ] = esc_html( $data['extras'] );
		}

		$rows[ __( 'Total', 'driveease' ) ] = esc_html( $data['currency'] . ' ' . number_format( (float) $data['total_price'], 2 ) );

		$intro = sprintf(
			/* translators: %s: customer first name */
			esc_html__( 'Dear %s,', 'driveease' ),
			esc_html( $data['customer_name'] )
		);

		$body  = '<p>' . $intro . '</p>';
		$body .= '<p>' . esc_html__( 'Thank you for your booking! Here are your details:', 'driveease' ) . '</p>';
		$body .= self::build_table( $rows );
		$body .= '<p>' . esc_html__( 'If you have any questions, please do not hesitate to contact us.', 'driveease' ) . '</p>';

		$html = self::wrap_template( $subject, $body );
		self::send( $data['customer_email'], $subject, $html );
	}

	// ------------------------------------------------------------------
	// Booking Reminder (1 day before pickup via wp-cron)
	// ------------------------------------------------------------------

	/**
	 * Cron callback: find bookings with pickup tomorrow and send reminders.
	 */
	public static function send_pending_reminders() {
		$tomorrow = gmdate( 'Y-m-d', strtotime( '+1 day' ) );

		$bookings = get_posts(
			array(
				'post_type'      => 'driveease_booking',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					'relation' => 'AND',
					array(
						'key'     => '_booking_pickup_date',
						'value'   => $tomorrow,
						'compare' => '=',
					),
					array(
						'key'     => '_booking_status',
						'value'   => array( 'confirmed', 'pending' ),
						'compare' => 'IN',
					),
					array(
						'key'     => '_booking_reminder_sent',
						'compare' => 'NOT EXISTS',
					),
				),
			)
		);

		foreach ( $bookings as $booking_id ) {
			self::send_reminder_email( $booking_id );
			update_post_meta( $booking_id, '_booking_reminder_sent', '1' );
		}
	}

	/**
	 * Send an HTML booking reminder email.
	 *
	 * @param int $post_id Booking post ID.
	 */
	public static function send_reminder_email( $post_id ) {
		$data = self::get_booking_data( $post_id );
		if ( ! $data ) {
			return;
		}

		/* translators: %1$s: booking reference, %2$s: site name */
		$subject = sprintf( esc_html__( 'Booking Reminder %1$s - %2$s', 'driveease' ), $data['reference'], get_bloginfo( 'name' ) );

		$rows = array(
			__( 'Reference', 'driveease' )       => esc_html( $data['reference'] ),
			__( 'Car', 'driveease' )              => esc_html( $data['car_name'] ),
			__( 'Pickup Date', 'driveease' )      => esc_html( $data['pickup_date'] ),
			__( 'Pickup Location', 'driveease' )  => esc_html( $data['pickup_location'] ),
		);

		$intro = sprintf(
			/* translators: %s: customer first name */
			esc_html__( 'Dear %s,', 'driveease' ),
			esc_html( $data['customer_name'] )
		);

		$body  = '<p>' . $intro . '</p>';
		$body .= '<p>' . esc_html__( 'This is a friendly reminder that your car pickup is scheduled for tomorrow.', 'driveease' ) . '</p>';
		$body .= self::build_table( $rows );
		$body .= '<p>' . esc_html__( 'We look forward to seeing you! If you need to make changes, please contact us as soon as possible.', 'driveease' ) . '</p>';

		$html = self::wrap_template( $subject, $body );
		self::send( $data['customer_email'], $subject, $html );
	}

	// ------------------------------------------------------------------
	// Booking Cancellation
	// ------------------------------------------------------------------

	/**
	 * Send an HTML booking cancellation email.
	 *
	 * @param int $post_id Booking post ID.
	 */
	public static function send_cancellation_email( $post_id ) {
		$data = self::get_booking_data( $post_id );
		if ( ! $data ) {
			return;
		}

		/* translators: %1$s: booking reference, %2$s: site name */
		$subject = sprintf( esc_html__( 'Booking Cancelled %1$s - %2$s', 'driveease' ), $data['reference'], get_bloginfo( 'name' ) );

		$rows = array(
			__( 'Reference', 'driveease' )  => esc_html( $data['reference'] ),
			__( 'Car', 'driveease' )         => esc_html( $data['car_name'] ),
			__( 'Pickup Date', 'driveease' ) => esc_html( $data['pickup_date'] ),
		);

		$intro = sprintf(
			/* translators: %s: customer first name */
			esc_html__( 'Dear %s,', 'driveease' ),
			esc_html( $data['customer_name'] )
		);

		$body  = '<p>' . $intro . '</p>';
		$body .= '<p>' . esc_html__( 'Your booking has been cancelled. Below are the details for your records:', 'driveease' ) . '</p>';
		$body .= self::build_table( $rows );
		$body .= '<p>' . esc_html__( 'If you believe this was done in error or you have questions about a refund, please contact us and reference your booking number.', 'driveease' ) . '</p>';

		$html = self::wrap_template( $subject, $body );
		self::send( $data['customer_email'], $subject, $html );
	}

	// ------------------------------------------------------------------
	// Helpers
	// ------------------------------------------------------------------

	/**
	 * Gather all booking meta into a keyed array.
	 *
	 * @param int $post_id Booking post ID.
	 * @return array|false Booking data or false on failure.
	 */
	private static function get_booking_data( $post_id ) {
		$email = get_post_meta( $post_id, '_booking_customer_email', true );
		if ( empty( $email ) || ! is_email( $email ) ) {
			return false;
		}

		$car_id   = (int) get_post_meta( $post_id, '_booking_car_id', true );
		$car_name = $car_id ? get_the_title( $car_id ) : '';

		return array(
			'reference'       => get_post_meta( $post_id, '_booking_reference', true ),
			'car_id'          => $car_id,
			'car_name'        => $car_name,
			'pickup_date'     => get_post_meta( $post_id, '_booking_pickup_date', true ),
			'dropoff_date'    => get_post_meta( $post_id, '_booking_dropoff_date', true ),
			'pickup_location' => get_post_meta( $post_id, '_booking_pickup_location', true ),
			'customer_name'   => get_post_meta( $post_id, '_booking_customer_name', true ),
			'customer_email'  => $email,
			'customer_phone'  => get_post_meta( $post_id, '_booking_customer_phone', true ),
			'extras'          => get_post_meta( $post_id, '_booking_extras', true ),
			'total_price'     => get_post_meta( $post_id, '_booking_total_price', true ),
			'currency'        => get_post_meta( $post_id, '_booking_currency', true ),
		);
	}

	/**
	 * Build an HTML table from label => value pairs.
	 *
	 * @param array $rows Associative array of label => value.
	 * @return string HTML table markup.
	 */
	private static function build_table( $rows ) {
		$html  = '<table style="width:100%;border-collapse:collapse;margin:16px 0;">';
		foreach ( $rows as $label => $value ) {
			$html .= '<tr>';
			$html .= '<td style="padding:10px 12px;border:1px solid #e0e0e0;background:#f9f9f9;font-weight:600;width:35%;">' . esc_html( $label ) . '</td>';
			$html .= '<td style="padding:10px 12px;border:1px solid #e0e0e0;">' . $value . '</td>';
			$html .= '</tr>';
		}
		$html .= '</table>';
		return $html;
	}

	/**
	 * Wrap email body content in the branded HTML template.
	 *
	 * Uses inline CSS for maximum email-client compatibility.
	 *
	 * @param string $subject Email subject (used as preheader).
	 * @param string $body    Inner HTML content.
	 * @return string Full HTML document.
	 */
	private static function wrap_template( $subject, $body ) {
		$site_name = esc_html( get_bloginfo( 'name' ) );
		$site_url  = esc_url( home_url() );
		$year      = gmdate( 'Y' );

		// Attempt to use the custom logo; fall back to site name text.
		$logo_id  = get_theme_mod( 'custom_logo' );
		$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';

		if ( $logo_url ) {
			$header_content = '<a href="' . $site_url . '" style="text-decoration:none;"><img src="' . esc_url( $logo_url ) . '" alt="' . $site_name . '" style="max-width:180px;height:auto;" /></a>';
		} else {
			$header_content = '<a href="' . $site_url . '" style="font-size:24px;font-weight:700;color:#ffffff;text-decoration:none;">' . $site_name . '</a>';
		}

		$html = '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>' . esc_html( $subject ) . '</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f7;font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#333333;">

<!-- Preheader (hidden) -->
<div style="display:none;font-size:1px;color:#f4f4f7;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;">
' . esc_html( $subject ) . '
</div>

<table role="presentation" style="width:100%;border:0;border-spacing:0;background-color:#f4f4f7;">
<tr>
<td style="padding:24px 0;" align="center">

<!-- Container -->
<table role="presentation" style="width:600px;max-width:100%;border:0;border-spacing:0;background-color:#ffffff;border-radius:8px;overflow:hidden;">

<!-- Header -->
<tr>
<td style="padding:24px 32px;background-color:#1a2238;text-align:center;">
' . $header_content . '
</td>
</tr>

<!-- Body -->
<tr>
<td style="padding:32px;">
' . $body . '
</td>
</tr>

<!-- Footer -->
<tr>
<td style="padding:20px 32px;background-color:#f4f4f7;text-align:center;font-size:12px;color:#999999;">
' . sprintf(
			/* translators: %1$s: year, %2$s: site name */
			esc_html__( '%1$s %2$s. All rights reserved.', 'driveease' ),
			'&copy; ' . $year,
			$site_name
		) . '<br />
<a href="' . $site_url . '" style="color:#1a2238;text-decoration:underline;">' . $site_url . '</a>
</td>
</tr>

</table>
<!-- /Container -->

</td>
</tr>
</table>

</body>
</html>';

		return $html;
	}

	/**
	 * Send an HTML email via wp_mail().
	 *
	 * @param string $to      Recipient email.
	 * @param string $subject Email subject.
	 * @param string $html    Full HTML content.
	 * @return bool Whether the email was accepted for delivery.
	 */
	private static function send( $to, $subject, $html ) {
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
		);

		/**
		 * Filter the email headers before sending.
		 *
		 * @param array  $headers Email headers.
		 * @param string $to      Recipient.
		 * @param string $subject Subject line.
		 */
		$headers = apply_filters( 'driveease_email_headers', $headers, $to, $subject );

		return wp_mail( $to, $subject, $html, $headers );
	}

	/**
	 * Deactivation cleanup: unschedule our cron event.
	 */
	public static function deactivate() {
		$timestamp = wp_next_scheduled( 'driveease_daily_booking_reminders' );
		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, 'driveease_daily_booking_reminders' );
		}
	}
}
