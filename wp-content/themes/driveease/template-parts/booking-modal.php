<?php
/**
 * Template Part: Booking Modal — 3-step wizard.
 *
 * Steps: 1. Rental Details, 2. Personal Info, 3. Extras & Payment.
 * Confirmation screen with reference number on success.
 * Branch data injected via inline script for location selects.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Query published branches for pickup/dropoff selects.
$branches_query = new WP_Query(
	array(
		'post_type'      => 'driveease_branch',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'title',
		'order'          => 'ASC',
	)
);

$branch_data = array();
if ( $branches_query->have_posts() ) {
	while ( $branches_query->have_posts() ) {
		$branches_query->the_post();
		$branch_data[] = array(
			'id'      => get_the_ID(),
			'name'    => get_the_title(),
			'address' => get_post_meta( get_the_ID(), '_branch_address', true ),
		);
	}
	wp_reset_postdata();
}
?>

<div class="modal-overlay" id="bookingOverlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Book a car', 'driveease' ); ?>">
	<div class="modal" id="bookingModal">

		<!-- Booking form (hidden after confirmation) -->
		<div id="bookingForm">

			<!-- Header -->
			<div class="modal-header">
				<h2 data-i18n="modal_title"><?php esc_html_e( 'Reserve Your Car', 'driveease' ); ?></h2>
				<button class="modal-close" id="modalClose" type="button" aria-label="<?php esc_attr_e( 'Close', 'driveease' ); ?>">
					<i class="fa-solid fa-xmark"></i>
				</button>
			</div>

			<!-- Car preview (populated by JS when opened from a car page) -->
			<div class="modal-car-preview" id="carPreview">
				<img id="previewImg" src="" alt="" />
				<div class="car-info">
					<strong id="previewName"></strong>
					<span id="previewClass"></span>
				</div>
				<div class="car-price" id="previewPrice"></div>
			</div>

			<div class="modal-body">

				<!-- Step indicators -->
				<div class="modal-steps">
					<div class="modal-step active" id="step-ind-1" data-i18n="modal_step1"><?php esc_html_e( '1. Rental Details', 'driveease' ); ?></div>
					<div class="modal-step" id="step-ind-2" data-i18n="modal_step2"><?php esc_html_e( '2. Your Info', 'driveease' ); ?></div>
					<div class="modal-step" id="step-ind-3" data-i18n="modal_step3"><?php esc_html_e( '3. Extras & Pay', 'driveease' ); ?></div>
				</div>

				<!-- Step 1: Rental Details -->
				<div class="step-page active" id="step-1">
					<div class="form-row">
						<div class="form-group">
							<label for="m-pickup" data-i18n="label_pickup"><?php esc_html_e( 'Pick-Up Location', 'driveease' ); ?></label>
							<select id="m-pickup">
								<option value=""><?php esc_html_e( 'Select...', 'driveease' ); ?></option>
								<?php foreach ( $branch_data as $branch ) : ?>
									<option value="<?php echo esc_attr( $branch['id'] ); ?>">
										<?php echo esc_html( $branch['name'] ); ?>
									</option>
								<?php endforeach; ?>
							</select>
							<span class="field-error" id="err-pickup"><?php esc_html_e( 'Please select a pick-up location.', 'driveease' ); ?></span>
						</div>
						<div class="form-group">
							<label for="m-dropoff" data-i18n="label_dropoff"><?php esc_html_e( 'Drop-Off Location', 'driveease' ); ?></label>
							<select id="m-dropoff">
								<option value=""><?php esc_html_e( 'Same as Pick-Up', 'driveease' ); ?></option>
								<?php foreach ( $branch_data as $branch ) : ?>
									<option value="<?php echo esc_attr( $branch['id'] ); ?>">
										<?php echo esc_html( $branch['name'] ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group">
							<label for="m-pickdate" data-i18n="label_pickdate"><?php esc_html_e( 'Pick-Up Date', 'driveease' ); ?></label>
							<input type="date" id="m-pickdate" />
							<span class="field-error" id="err-pickdate"><?php esc_html_e( 'Please select a pick-up date.', 'driveease' ); ?></span>
						</div>
						<div class="form-group">
							<label for="m-dropdate" data-i18n="label_dropdate"><?php esc_html_e( 'Drop-Off Date', 'driveease' ); ?></label>
							<input type="date" id="m-dropdate" />
							<span class="field-error" id="err-dropdate"><?php esc_html_e( 'Drop-off must be after pick-up.', 'driveease' ); ?></span>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" id="toStep2" type="button" data-i18n="btn_continue">
							<?php esc_html_e( 'Continue', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i>
						</button>
					</div>
				</div>

				<!-- Step 2: Personal Info -->
				<div class="step-page" id="step-2">
					<div class="form-row">
						<div class="form-group">
							<label for="m-fname"><?php esc_html_e( 'First Name', 'driveease' ); ?></label>
							<input type="text" id="m-fname" placeholder="<?php esc_attr_e( 'John', 'driveease' ); ?>" />
							<span class="field-error" id="err-fname"><?php esc_html_e( 'Required.', 'driveease' ); ?></span>
						</div>
						<div class="form-group">
							<label for="m-lname"><?php esc_html_e( 'Last Name', 'driveease' ); ?></label>
							<input type="text" id="m-lname" placeholder="<?php esc_attr_e( 'Smith', 'driveease' ); ?>" />
							<span class="field-error" id="err-lname"><?php esc_html_e( 'Required.', 'driveease' ); ?></span>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group">
							<label for="m-email"><?php esc_html_e( 'Email', 'driveease' ); ?></label>
							<input type="email" id="m-email" placeholder="<?php esc_attr_e( 'john@example.com', 'driveease' ); ?>" />
							<span class="field-error" id="err-email"><?php esc_html_e( 'Valid email required.', 'driveease' ); ?></span>
						</div>
						<div class="form-group">
							<label for="m-phone"><?php esc_html_e( 'Phone', 'driveease' ); ?></label>
							<input type="tel" id="m-phone" placeholder="<?php esc_attr_e( '+1 555 000 0000', 'driveease' ); ?>" />
							<span class="field-error" id="err-phone"><?php esc_html_e( 'Required.', 'driveease' ); ?></span>
						</div>
					</div>
					<div class="form-row single">
						<div class="form-group">
							<label for="m-licence"><?php esc_html_e( "Driver's Licence", 'driveease' ); ?></label>
							<input type="text" id="m-licence" placeholder="<?php esc_attr_e( 'DL-XXXXXXXX', 'driveease' ); ?>" />
							<span class="field-error" id="err-licence"><?php esc_html_e( 'Required.', 'driveease' ); ?></span>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn" style="background:var(--light-bg);color:var(--dark)" id="backTo1" type="button">
							<i class="fa-solid fa-arrow-left"></i> <?php esc_html_e( 'Back', 'driveease' ); ?>
						</button>
						<button class="btn btn-primary" id="toStep3" type="button" data-i18n="btn_continue">
							<?php esc_html_e( 'Continue', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i>
						</button>
					</div>
				</div>

				<!-- Step 3: Extras & Payment -->
				<div class="step-page" id="step-3">
					<p style="font-size:.82rem;color:var(--gray);margin-bottom:14px;font-weight:600;text-transform:uppercase;letter-spacing:.06em" data-i18n="extras_label">
						<?php esc_html_e( 'Optional Extras', 'driveease' ); ?>
					</p>
					<div class="extras-grid">
						<label class="extra-item">
							<input type="checkbox" data-price="8" data-label="<?php esc_attr_e( 'GPS Navigation', 'driveease' ); ?>" />
							<div class="extra-label">
								<strong><?php esc_html_e( 'GPS Navigation', 'driveease' ); ?></strong>
								<span><?php esc_html_e( 'Turn-by-turn routing', 'driveease' ); ?></span>
							</div>
							<div class="extra-price"><?php echo esc_html( '+$8/' . __( 'day', 'driveease' ) ); ?></div>
						</label>
						<label class="extra-item">
							<input type="checkbox" data-price="12" data-label="<?php esc_attr_e( 'Child Seat', 'driveease' ); ?>" />
							<div class="extra-label">
								<strong><?php esc_html_e( 'Child Seat', 'driveease' ); ?></strong>
								<span><?php esc_html_e( 'Certified safety seat', 'driveease' ); ?></span>
							</div>
							<div class="extra-price"><?php echo esc_html( '+$12/' . __( 'day', 'driveease' ) ); ?></div>
						</label>
						<label class="extra-item">
							<input type="checkbox" data-price="6" data-label="<?php esc_attr_e( 'Wi-Fi Hotspot', 'driveease' ); ?>" />
							<div class="extra-label">
								<strong><?php esc_html_e( 'Wi-Fi Hotspot', 'driveease' ); ?></strong>
								<span><?php esc_html_e( 'Unlimited data', 'driveease' ); ?></span>
							</div>
							<div class="extra-price"><?php echo esc_html( '+$6/' . __( 'day', 'driveease' ) ); ?></div>
						</label>
						<label class="extra-item">
							<input type="checkbox" data-price="18" data-label="<?php esc_attr_e( 'Premium Insurance', 'driveease' ); ?>" />
							<div class="extra-label">
								<strong><?php esc_html_e( 'Premium Insurance', 'driveease' ); ?></strong>
								<span><?php esc_html_e( 'Zero excess cover', 'driveease' ); ?></span>
							</div>
							<div class="extra-price"><?php echo esc_html( '+$18/' . __( 'day', 'driveease' ) ); ?></div>
						</label>
					</div>

					<!-- Price summary -->
					<div class="summary-box">
						<div class="summary-row">
							<span data-i18n="sum_vehicle"><?php esc_html_e( 'Vehicle', 'driveease' ); ?></span>
							<span id="sum-vehicle">&mdash;</span>
						</div>
						<div class="summary-row">
							<span data-i18n="sum_duration"><?php esc_html_e( 'Duration', 'driveease' ); ?></span>
							<span id="sum-days">&mdash;</span>
						</div>
						<div class="summary-row">
							<span data-i18n="sum_base"><?php esc_html_e( 'Vehicle cost', 'driveease' ); ?></span>
							<span id="sum-base">&mdash;</span>
						</div>
						<div class="summary-row" id="sum-extras-row" style="display:none">
							<span data-i18n="sum_extras"><?php esc_html_e( 'Extras', 'driveease' ); ?></span>
							<span id="sum-extras">&mdash;</span>
						</div>
						<div class="summary-row total">
							<span data-i18n="sum_total"><?php esc_html_e( 'Total', 'driveease' ); ?></span>
							<span id="sum-total">&mdash;</span>
						</div>
					</div>

					<!-- Payment details -->
					<p style="font-size:.82rem;color:var(--gray);margin-bottom:14px;font-weight:600;text-transform:uppercase;letter-spacing:.06em">
						<?php esc_html_e( 'Payment Details', 'driveease' ); ?>
					</p>
					<div class="form-row single">
						<div class="form-group">
							<label for="m-card-name"><?php esc_html_e( 'Cardholder Name', 'driveease' ); ?></label>
							<input type="text" id="m-card-name" placeholder="<?php esc_attr_e( 'John Smith', 'driveease' ); ?>" />
							<span class="field-error" id="err-card-name"><?php esc_html_e( 'Required.', 'driveease' ); ?></span>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group">
							<label for="m-card-num"><?php esc_html_e( 'Card Number', 'driveease' ); ?></label>
							<input type="text" id="m-card-num" placeholder="0000 0000 0000 0000" maxlength="19" />
							<span class="field-error" id="err-card-num"><?php esc_html_e( 'Invalid card number.', 'driveease' ); ?></span>
						</div>
						<div class="form-group" style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
							<div class="form-group">
								<label for="m-expiry"><?php esc_html_e( 'Expiry', 'driveease' ); ?></label>
								<input type="text" id="m-expiry" placeholder="MM/YY" maxlength="5" />
								<span class="field-error" id="err-expiry"><?php esc_html_e( 'Invalid.', 'driveease' ); ?></span>
							</div>
							<div class="form-group">
								<label for="m-cvv"><?php esc_html_e( 'CVV', 'driveease' ); ?></label>
								<input type="text" id="m-cvv" placeholder="&bull;&bull;&bull;" maxlength="4" />
								<span class="field-error" id="err-cvv"><?php esc_html_e( 'Invalid.', 'driveease' ); ?></span>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn" style="background:var(--light-bg);color:var(--dark)" id="backTo2" type="button">
							<i class="fa-solid fa-arrow-left"></i> <?php esc_html_e( 'Back', 'driveease' ); ?>
						</button>
						<button class="btn btn-primary" id="confirmBtn" type="button">
							<i class="fa-solid fa-lock"></i> <span data-i18n="btn_confirm"><?php esc_html_e( 'Confirm Booking', 'driveease' ); ?></span>
						</button>
					</div>
				</div>

			</div><!-- .modal-body -->

		</div><!-- #bookingForm -->

		<!-- Confirmation screen -->
		<div class="success-screen" id="successScreen" style="display:none">
			<div class="success-icon"><i class="fa-solid fa-check"></i></div>
			<h3 data-i18n="success_title"><?php esc_html_e( 'Booking Confirmed!', 'driveease' ); ?></h3>
			<p data-i18n="success_msg"><?php esc_html_e( 'Thank you for choosing DriveEase. A summary has been sent to your email.', 'driveease' ); ?></p>
			<div class="booking-ref" id="bookingRef">DE-000000</div>
			<p style="font-size:.82rem" data-i18n="success_note"><?php esc_html_e( "Please bring this reference and your driver's licence on pick-up day.", 'driveease' ); ?></p>
			<div style="margin-top:24px">
				<button class="btn btn-primary" id="successClose" type="button" data-i18n="btn_done">
					<?php esc_html_e( 'Done', 'driveease' ); ?> <i class="fa-solid fa-check"></i>
				</button>
			</div>
		</div>

	</div><!-- .modal -->
</div><!-- .modal-overlay -->

<?php
// Inline branch data + nonce for JS consumption.
$booking_data = array(
	'ajax_url' => admin_url( 'admin-ajax.php' ),
	'nonce'    => wp_create_nonce( 'driveease_booking_nonce' ),
	'branches' => $branch_data,
);
?>
<script>
	var driveease_booking = <?php echo wp_json_encode( $booking_data ); ?>;
</script>
