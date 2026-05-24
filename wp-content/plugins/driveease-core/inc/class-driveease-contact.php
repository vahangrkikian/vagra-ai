<?php
/**
 * DriveEase Contact Form Handler — AJAX endpoint for the contact page form.
 *
 * @package DriveEase
 * @since 1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DriveEase_Contact
 */
class DriveEase_Contact {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'wp_ajax_driveease_contact', array( __CLASS__, 'handle_contact' ) );
		add_action( 'wp_ajax_nopriv_driveease_contact', array( __CLASS__, 'handle_contact' ) );
	}

	/**
	 * Handle the contact form AJAX request.
	 */
	public static function handle_contact() {
		if ( ! check_ajax_referer( 'driveease_contact_nonce', 'nonce', false ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Security check failed. Please refresh the page and try again.', 'driveease' ) ),
				403
			);
		}

		// Rate limiting: 3 submissions per 10 minutes per IP.
		$ip        = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );
		$transient = 'driveease_contact_' . md5( $ip );
		$count     = (int) get_transient( $transient );

		if ( $count >= 3 ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Too many messages. Please wait a few minutes and try again.', 'driveease' ) ),
				429
			);
		}

		// Sanitize inputs.
		$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$subject = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
		$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

		// Validate required fields.
		if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Please fill in all required fields.', 'driveease' ) ),
				400
			);
		}

		if ( ! is_email( $email ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Please provide a valid email address.', 'driveease' ) ),
				400
			);
		}

		// Build subject line.
		$subject_labels = array(
			'booking'     => __( 'Booking Inquiry', 'driveease' ),
			'support'     => __( 'Customer Support', 'driveease' ),
			'partnership' => __( 'Partnership', 'driveease' ),
			'other'       => __( 'Other', 'driveease' ),
		);

		$subject_label = isset( $subject_labels[ $subject ] ) ? $subject_labels[ $subject ] : __( 'General Inquiry', 'driveease' );

		$email_subject = sprintf(
			/* translators: %1$s: subject type, %2$s: site name */
			esc_html__( '[%1$s] New contact message — %2$s', 'driveease' ),
			$subject_label,
			get_bloginfo( 'name' )
		);

		// Build email body.
		$body  = sprintf( esc_html__( 'Name: %s', 'driveease' ), $name ) . "\n";
		$body .= sprintf( esc_html__( 'Email: %s', 'driveease' ), $email ) . "\n";
		if ( $phone ) {
			$body .= sprintf( esc_html__( 'Phone: %s', 'driveease' ), $phone ) . "\n";
		}
		$body .= sprintf( esc_html__( 'Subject: %s', 'driveease' ), $subject_label ) . "\n\n";
		$body .= esc_html__( 'Message:', 'driveease' ) . "\n";
		$body .= $message . "\n";

		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			'Reply-To: ' . $name . ' <' . $email . '>',
		);

		$admin_email = get_option( 'admin_email' );
		$sent        = wp_mail( $admin_email, $email_subject, $body, $headers );

		if ( ! $sent ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Failed to send message. Please try again later.', 'driveease' ) ),
				500
			);
		}

		// Increment rate limit counter.
		set_transient( $transient, $count + 1, 10 * MINUTE_IN_SECONDS );

		wp_send_json_success(
			array( 'message' => esc_html__( 'Thank you! Your message has been sent successfully.', 'driveease' ) )
		);
	}
}

DriveEase_Contact::init();
