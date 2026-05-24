<?php
/**
 * Booking confirmation email template.
 *
 * Available variables:
 * - $guest_name        (string) Full name of the guest.
 * - $room_name         (string) Room title.
 * - $check_in          (string) Check-in date.
 * - $check_out         (string) Check-out date.
 * - $confirmation_code (string) Booking confirmation code.
 * - $total             (float)  Total amount.
 * - $guests_count      (int)    Total number of guests.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php esc_html_e( 'Booking Confirmation', 'meridian' ); ?></title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Georgia,'Times New Roman',Times,serif;">
	<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;padding:40px 0;">
		<tr>
			<td align="center">
				<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:4px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">

					<!-- Header -->
					<tr>
						<td style="background-color:#1a1f3d;padding:40px 40px 30px;text-align:center;">
							<h1 style="margin:0;font-size:28px;font-weight:400;color:#c9a84c;letter-spacing:3px;text-transform:uppercase;">The Meridian</h1>
							<p style="margin:8px 0 0;font-size:13px;color:#8a8fb0;letter-spacing:2px;text-transform:uppercase;">Luxury Hotel &amp; Resort</p>
						</td>
					</tr>

					<!-- Confirmation Badge -->
					<tr>
						<td style="padding:30px 40px 10px;text-align:center;">
							<p style="margin:0;font-size:14px;color:#1a1f3d;letter-spacing:1px;text-transform:uppercase;">Booking Confirmed</p>
							<p style="margin:10px 0 0;font-size:28px;font-weight:700;color:#c9a84c;letter-spacing:2px;"><?php echo esc_html( $confirmation_code ); ?></p>
						</td>
					</tr>

					<!-- Greeting -->
					<tr>
						<td style="padding:20px 40px 10px;">
							<p style="margin:0;font-size:16px;color:#333;line-height:1.6;">
								<?php
								/* translators: %s: guest name */
								printf( esc_html__( 'Dear %s,', 'meridian' ), esc_html( $guest_name ) );
								?>
							</p>
							<p style="margin:10px 0 0;font-size:15px;color:#555;line-height:1.6;">
								<?php esc_html_e( 'Thank you for choosing The Meridian. We are delighted to confirm your reservation. Below you will find the details of your upcoming stay.', 'meridian' ); ?>
							</p>
						</td>
					</tr>

					<!-- Divider -->
					<tr>
						<td style="padding:10px 40px;">
							<hr style="border:none;border-top:1px solid #e5e5e5;margin:0;" />
						</td>
					</tr>

					<!-- Booking Details -->
					<tr>
						<td style="padding:10px 40px 20px;">
							<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td style="padding:8px 0;font-size:14px;color:#888;text-transform:uppercase;letter-spacing:1px;width:40%;"><?php esc_html_e( 'Room', 'meridian' ); ?></td>
									<td style="padding:8px 0;font-size:15px;color:#1a1f3d;font-weight:600;"><?php echo esc_html( $room_name ); ?></td>
								</tr>
								<tr>
									<td style="padding:8px 0;font-size:14px;color:#888;text-transform:uppercase;letter-spacing:1px;"><?php esc_html_e( 'Check-in', 'meridian' ); ?></td>
									<td style="padding:8px 0;font-size:15px;color:#1a1f3d;"><?php echo esc_html( $check_in ); ?></td>
								</tr>
								<tr>
									<td style="padding:8px 0;font-size:14px;color:#888;text-transform:uppercase;letter-spacing:1px;"><?php esc_html_e( 'Check-out', 'meridian' ); ?></td>
									<td style="padding:8px 0;font-size:15px;color:#1a1f3d;"><?php echo esc_html( $check_out ); ?></td>
								</tr>
								<tr>
									<td style="padding:8px 0;font-size:14px;color:#888;text-transform:uppercase;letter-spacing:1px;"><?php esc_html_e( 'Guests', 'meridian' ); ?></td>
									<td style="padding:8px 0;font-size:15px;color:#1a1f3d;"><?php echo esc_html( $guests_count ); ?></td>
								</tr>
							</table>
						</td>
					</tr>

					<!-- Divider -->
					<tr>
						<td style="padding:0 40px;">
							<hr style="border:none;border-top:1px solid #e5e5e5;margin:0;" />
						</td>
					</tr>

					<!-- Total -->
					<tr>
						<td style="padding:20px 40px;">
							<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td style="font-size:14px;color:#888;text-transform:uppercase;letter-spacing:1px;"><?php esc_html_e( 'Total Amount', 'meridian' ); ?></td>
									<td style="text-align:right;font-size:24px;font-weight:700;color:#1a1f3d;">$<?php echo esc_html( number_format( (float) $total, 2 ) ); ?></td>
								</tr>
							</table>
							<p style="margin:8px 0 0;font-size:12px;color:#999;text-align:right;"><?php esc_html_e( 'Includes resort fee and applicable taxes', 'meridian' ); ?></p>
						</td>
					</tr>

					<!-- CTA -->
					<tr>
						<td style="padding:10px 40px 30px;text-align:center;">
							<p style="margin:0;font-size:14px;color:#555;line-height:1.6;">
								<?php esc_html_e( 'If you have any questions or special requests, please do not hesitate to contact our concierge team.', 'meridian' ); ?>
							</p>
						</td>
					</tr>

					<!-- Footer -->
					<tr>
						<td style="background-color:#1a1f3d;padding:25px 40px;text-align:center;">
							<p style="margin:0;font-size:12px;color:#8a8fb0;line-height:1.6;">
								<?php esc_html_e( 'The Meridian - Luxury Hotel & Resort', 'meridian' ); ?><br />
								<?php esc_html_e( 'This is an automated confirmation. Please do not reply to this email.', 'meridian' ); ?>
							</p>
						</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
</body>
</html>
