<?php
/**
 * Template Part: Booking Modal
 *
 * Full-screen booking modal overlay. Converts BookingModal from TourDetail.jsx.
 * Included by single-vagra_tour.php. Hidden by default; opened by JS.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tour_id    = get_the_ID();
$tour_name  = get_the_title();
$hero_url   = has_post_thumbnail()
	? get_the_post_thumbnail_url( $tour_id, 'tourvice-card' )
	: TOURVICE_URI . '/assets/images/placeholder-tour.jpg';
?>

<div class="tourvice-modal-overlay" id="tourvice-booking-modal" hidden aria-hidden="true" role="dialog" aria-labelledby="tourvice-modal-title">

	<div class="tourvice-modal">

		<!-- Header with image -->
		<div class="tourvice-modal__header" style="background-image: url('<?php echo esc_url( $hero_url ); ?>');">
			<div class="tourvice-modal__header-overlay" aria-hidden="true"></div>
			<div class="tourvice-modal__header-content">
				<div>
					<p class="tourvice-modal__header-label" data-i18n="modal_booking_for">
						<?php esc_html_e( 'Booking for', 'tourvice' ); ?>
					</p>
					<h3 class="tourvice-modal__header-title" id="tourvice-modal-title">
						<?php echo esc_html( $tour_name ); ?>
					</h3>
				</div>
				<button type="button" class="tourvice-modal__close" id="tourvice-modal-close" aria-label="<?php esc_attr_e( 'Close', 'tourvice' ); ?>">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<line x1="18" y1="6" x2="6" y2="18"></line>
						<line x1="6" y1="6" x2="18" y2="18"></line>
					</svg>
				</button>
			</div>
		</div>

		<!-- Summary strip -->
		<div class="tourvice-modal__summary">
			<span class="tourvice-modal__summary-item">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
					<circle cx="9" cy="7" r="4"></circle>
					<path d="M23 21v-2a4 4 0 00-3-3.87"></path>
					<path d="M16 3.13a4 4 0 010 7.75"></path>
				</svg>
				<span id="tourvice-modal-group-size">2</span>
				<span data-i18n="modal_people"><?php esc_html_e( 'people', 'tourvice' ); ?></span>
			</span>
			<span class="tourvice-modal__summary-price">
				<span data-i18n="modal_total"><?php esc_html_e( 'Total:', 'tourvice' ); ?></span>
				<span id="tourvice-modal-total" data-usd="">$0</span>
			</span>
		</div>

		<!-- Form -->
		<form class="tourvice-modal__form" id="tourvice-booking-form" method="post" action="#">
			<?php wp_nonce_field( 'tourvice_booking', 'tourvice_booking_nonce' ); ?>
			<input type="hidden" name="action" value="tourvice_submit_booking" />
			<input type="hidden" name="tour_id" value="<?php echo absint( $tour_id ); ?>" />
			<input type="hidden" name="group_size" id="tourvice-modal-group-input" value="2" />
			<input type="hidden" name="total_price" id="tourvice-modal-total-input" value="0" />

			<!-- Name -->
			<div class="tourvice-modal__form-group">
				<label class="tourvice-modal__form-label" for="tourvice-booking-name">
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
						<circle cx="12" cy="7" r="4"></circle>
					</svg>
					<span data-i18n="modal_full_name"><?php esc_html_e( 'Full Name', 'tourvice' ); ?></span>
				</label>
				<input
					type="text"
					id="tourvice-booking-name"
					name="booking_name"
					class="tourvice-modal__form-input"
					placeholder="<?php esc_attr_e( 'John Smith', 'tourvice' ); ?>"
					required
				/>
				<p class="tourvice-modal__form-error" data-field="booking_name" hidden>
					<?php esc_html_e( 'Name is required', 'tourvice' ); ?>
				</p>
			</div>

			<!-- Email -->
			<div class="tourvice-modal__form-group">
				<label class="tourvice-modal__form-label" for="tourvice-booking-email">
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
						<polyline points="22,6 12,13 2,6"></polyline>
					</svg>
					<span data-i18n="modal_email"><?php esc_html_e( 'Email', 'tourvice' ); ?></span>
				</label>
				<input
					type="email"
					id="tourvice-booking-email"
					name="booking_email"
					class="tourvice-modal__form-input"
					placeholder="<?php esc_attr_e( 'john@example.com', 'tourvice' ); ?>"
					required
				/>
				<p class="tourvice-modal__form-error" data-field="booking_email" hidden>
					<?php esc_html_e( 'Valid email required', 'tourvice' ); ?>
				</p>
			</div>

			<!-- Phone + Date row -->
			<div class="tourvice-modal__form-row">
				<div class="tourvice-modal__form-group">
					<label class="tourvice-modal__form-label" for="tourvice-booking-phone">
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"></path>
						</svg>
						<span data-i18n="modal_phone"><?php esc_html_e( 'Phone', 'tourvice' ); ?></span>
					</label>
					<input
						type="tel"
						id="tourvice-booking-phone"
						name="booking_phone"
						class="tourvice-modal__form-input"
						placeholder="<?php esc_attr_e( '+1 555 0000', 'tourvice' ); ?>"
						required
					/>
					<p class="tourvice-modal__form-error" data-field="booking_phone" hidden>
						<?php esc_html_e( 'Phone is required', 'tourvice' ); ?>
					</p>
				</div>
				<div class="tourvice-modal__form-group">
					<label class="tourvice-modal__form-label" for="tourvice-booking-date">
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
							<line x1="16" y1="2" x2="16" y2="6"></line>
							<line x1="8" y1="2" x2="8" y2="6"></line>
							<line x1="3" y1="10" x2="21" y2="10"></line>
						</svg>
						<span data-i18n="modal_travel_date"><?php esc_html_e( 'Travel Date', 'tourvice' ); ?></span>
					</label>
					<input
						type="date"
						id="tourvice-booking-date"
						name="booking_date"
						class="tourvice-modal__form-input"
						min="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>"
						required
					/>
					<p class="tourvice-modal__form-error" data-field="booking_date" hidden>
						<?php esc_html_e( 'Travel date is required', 'tourvice' ); ?>
					</p>
				</div>
			</div>

			<!-- Notes -->
			<div class="tourvice-modal__form-group">
				<label class="tourvice-modal__form-label" for="tourvice-booking-notes" data-i18n="modal_special_requests">
					<?php esc_html_e( 'Special Requests (optional)', 'tourvice' ); ?>
				</label>
				<textarea
					id="tourvice-booking-notes"
					name="booking_notes"
					class="tourvice-modal__form-textarea"
					rows="3"
					placeholder="<?php esc_attr_e( 'Dietary requirements, accessibility needs, etc.', 'tourvice' ); ?>"
				></textarea>
			</div>

			<button type="submit" class="tourvice-modal__form-submit" data-i18n="modal_confirm">
				<?php esc_html_e( 'Confirm Booking', 'tourvice' ); ?>
			</button>
		</form>

		<!-- Success screen -->
		<div class="tourvice-modal__success" id="tourvice-booking-success" hidden>
			<div class="tourvice-modal__success-icon" aria-hidden="true">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
					<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
				</svg>
			</div>
			<h4 class="tourvice-modal__success-title" data-i18n="modal_success_title">
				<?php esc_html_e( 'Booking Requested!', 'tourvice' ); ?>
			</h4>
			<p class="tourvice-modal__success-text">
				<?php esc_html_e( 'We\'ll reach out to', 'tourvice' ); ?>
				<span class="tourvice-modal__success-email" id="tourvice-booking-confirm-email"></span>
				<?php esc_html_e( 'within 24 hours to confirm your trip.', 'tourvice' ); ?>
			</p>
			<button type="button" class="tourvice-modal__success-btn" id="tourvice-modal-done" data-i18n="modal_done">
				<?php esc_html_e( 'Done', 'tourvice' ); ?>
			</button>
		</div>

	</div>
</div>
