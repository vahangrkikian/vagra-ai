<?php
/**
 * Booking Modal (3-step wizard)
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$args      = wp_parse_args( $args, array(
	'room_id'   => 0,
	'room_name' => '',
	'category'  => '',
	'price'     => 0,
	'guests'    => 2,
	'size'      => '',
	'bed'       => '',
	'badge'     => '',
	'thumb_url' => '',
) );
?>
<div class="modal" id="booking-modal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="booking-title">
	<div class="modal__panel">
		<button class="modal__close" id="modal-close" aria-label="<?php esc_attr_e( 'Close', 'meridian' ); ?>"><?php echo meridian_icon( 'close', 20 ); ?></button>

		<!-- STEP INDICATOR -->
		<div class="modal__steps" aria-label="<?php esc_attr_e( 'Booking steps', 'meridian' ); ?>" id="modal-steps">
			<div class="mstep is-active" data-step="1">
				<span class="mstep__num">1</span>
				<span><?php esc_html_e( 'Guest details', 'meridian' ); ?></span>
			</div>
			<span class="mstep__bar"></span>
			<div class="mstep" data-step="2">
				<span class="mstep__num">2</span>
				<span><?php esc_html_e( 'Payment', 'meridian' ); ?></span>
			</div>
			<span class="mstep__bar"></span>
			<div class="mstep" data-step="3">
				<span class="mstep__num">3</span>
				<span><?php esc_html_e( 'Confirmation', 'meridian' ); ?></span>
			</div>
		</div>

		<div class="modal__body">
			<div class="modal__main">

				<!-- STEP 1: Guest Details -->
				<div class="form" id="modal-step-1">
					<h2 id="booking-title" class="form__title"><?php esc_html_e( "Who's staying?", 'meridian' ); ?></h2>
					<p class="form__sub"><?php esc_html_e( "We'll use this to prepare your room and contact you if anything changes.", 'meridian' ); ?></p>

					<div class="form__row form__row--2">
						<label class="field" data-field="firstName">
							<span class="field__label"><?php esc_html_e( 'First name', 'meridian' ); ?></span>
							<input type="text" name="first_name" id="book-first-name" />
							<span class="field__error" style="display:none;"></span>
						</label>
						<label class="field" data-field="lastName">
							<span class="field__label"><?php esc_html_e( 'Last name', 'meridian' ); ?></span>
							<input type="text" name="last_name" id="book-last-name" />
							<span class="field__error" style="display:none;"></span>
						</label>
					</div>
					<div class="form__row form__row--2">
						<label class="field" data-field="email">
							<span class="field__label"><?php esc_html_e( 'Email', 'meridian' ); ?></span>
							<input type="email" name="email" id="book-email" placeholder="you@somewhere.com" />
							<span class="field__error" style="display:none;"></span>
						</label>
						<label class="field" data-field="phone">
							<span class="field__label"><?php esc_html_e( 'Phone', 'meridian' ); ?></span>
							<input type="tel" name="phone" id="book-phone" placeholder="+1 (212) 555-0199" />
							<span class="field__error" style="display:none;"></span>
						</label>
					</div>
					<div class="form__row form__row--2">
						<label class="field">
							<span class="field__label"><?php esc_html_e( 'Country of residence', 'meridian' ); ?></span>
							<select name="country" id="book-country">
								<option>United States</option><option>Canada</option><option>United Kingdom</option><option>Germany</option><option>France</option><option>Spain</option><option>Japan</option><option>Australia</option><option>Singapore</option><option>Other</option>
							</select>
						</label>
						<label class="field">
							<span class="field__label"><?php esc_html_e( 'Estimated arrival', 'meridian' ); ?></span>
							<select name="arrival_time" id="book-arrival">
								<option value="early"><?php esc_html_e( 'Before 3:00 PM', 'meridian' ); ?></option>
								<option value="15:00">3:00 PM</option>
								<option value="16:00" selected>4:00 PM</option>
								<option value="18:00">6:00 PM</option>
								<option value="20:00">8:00 PM</option>
								<option value="late"><?php esc_html_e( 'After 10:00 PM', 'meridian' ); ?></option>
							</select>
						</label>
					</div>
					<label class="field">
						<span class="field__label"><?php esc_html_e( 'Special requests', 'meridian' ); ?> <em>· <?php esc_html_e( 'optional', 'meridian' ); ?></em></span>
						<textarea name="requests" id="book-requests" rows="3" placeholder="<?php esc_attr_e( 'High floor, late check-out, allergies — anything we should know.', 'meridian' ); ?>"></textarea>
					</label>
					<label class="checkbox">
						<input type="checkbox" name="newsletter" id="book-newsletter" checked />
						<span><?php esc_html_e( 'Send me seasonal updates from The Meridian. Once a season, never more.', 'meridian' ); ?></span>
					</label>

					<div class="form__actions">
						<button type="button" class="btn btn--outline" id="modal-cancel"><?php esc_html_e( 'Cancel', 'meridian' ); ?></button>
						<button type="button" class="btn btn--gold btn--lg" id="modal-to-step2">
							<?php esc_html_e( 'Continue to payment', 'meridian' ); ?> <?php echo meridian_icon( 'arrow-right', 16 ); ?>
						</button>
					</div>
				</div>

				<!-- STEP 2: Payment -->
				<div class="form" id="modal-step-2" style="display:none;">
					<h2 class="form__title"><?php esc_html_e( 'Payment details', 'meridian' ); ?></h2>
					<p class="form__sub"><?php esc_html_e( "No charge today — we'll authorize one night and charge the full balance at check-in. Free cancellation until 48h before arrival.", 'meridian' ); ?></p>

					<!-- Card Preview -->
					<div class="cardpreview">
						<div class="cardpreview__chip"></div>
						<div class="cardpreview__num" id="card-preview-num">•••• •••• •••• ••••</div>
						<div class="cardpreview__row">
							<div>
								<div class="cardpreview__k"><?php esc_html_e( 'Cardholder', 'meridian' ); ?></div>
								<div class="cardpreview__v" id="card-preview-name">YOUR NAME</div>
							</div>
							<div>
								<div class="cardpreview__k"><?php esc_html_e( 'Expires', 'meridian' ); ?></div>
								<div class="cardpreview__v" id="card-preview-exp">MM/YY</div>
							</div>
						</div>
					</div>

					<label class="field" data-field="cardName">
						<span class="field__label"><?php esc_html_e( 'Cardholder name', 'meridian' ); ?></span>
						<input type="text" name="card_name" id="book-card-name" placeholder="<?php esc_attr_e( 'Name on card', 'meridian' ); ?>" />
						<span class="field__error" style="display:none;"></span>
					</label>
					<label class="field" data-field="cardNumber">
						<span class="field__label"><?php esc_html_e( 'Card number', 'meridian' ); ?></span>
						<input type="text" name="card_number" id="book-card-number" placeholder="1234 5678 9012 3456" inputmode="numeric" />
						<span class="field__error" style="display:none;"></span>
					</label>
					<div class="form__row form__row--3">
						<label class="field" data-field="cardExp">
							<span class="field__label"><?php esc_html_e( 'Expiry', 'meridian' ); ?></span>
							<input type="text" name="card_exp" id="book-card-exp" placeholder="MM/YY" inputmode="numeric" />
							<span class="field__error" style="display:none;"></span>
						</label>
						<label class="field" data-field="cardCvc">
							<span class="field__label">CVC</span>
							<input type="text" name="card_cvc" id="book-card-cvc" placeholder="123" inputmode="numeric" />
							<span class="field__error" style="display:none;"></span>
						</label>
						<label class="field" data-field="billingZip">
							<span class="field__label"><?php esc_html_e( 'Billing ZIP', 'meridian' ); ?></span>
							<input type="text" name="billing_zip" id="book-billing-zip" placeholder="10036" />
							<span class="field__error" style="display:none;"></span>
						</label>
					</div>

					<label class="checkbox" id="terms-checkbox">
						<input type="checkbox" name="agree" id="book-agree" />
						<span><?php printf( __( "I have read and agree to The Meridian's %1\$scancellation policy%2\$s and %3\$sterms of stay%4\$s.", 'meridian' ), '<a href="#" class="link">', '</a>', '<a href="#" class="link">', '</a>' ); ?></span>
					</label>
					<div class="field__error field__error--block" id="agree-error" style="display:none;"></div>

					<div class="form__actions">
						<button type="button" class="btn btn--outline" id="modal-back-step1"><?php echo meridian_icon( 'chevron-left', 14 ); ?> <?php esc_html_e( 'Back', 'meridian' ); ?></button>
						<button type="button" class="btn btn--gold btn--lg" id="modal-submit">
							<?php esc_html_e( 'Confirm reservation', 'meridian' ); ?> <?php echo meridian_icon( 'check', 16 ); ?>
						</button>
					</div>
					<div class="form__secure">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
						<?php esc_html_e( '256-bit encryption · We never store your full card number', 'meridian' ); ?>
					</div>
				</div>

				<!-- STEP 3: Confirmation -->
				<div class="form form--confirm" id="modal-step-3" style="display:none;">
					<div class="confirm__icon"><?php echo meridian_icon( 'check', 32 ); ?></div>
					<div class="eyebrow"><?php esc_html_e( 'Confirmed', 'meridian' ); ?></div>
					<h2 class="form__title"><?php esc_html_e( 'Your room is booked.', 'meridian' ); ?></h2>
					<p class="form__sub"><?php esc_html_e( 'A confirmation has been sent to', 'meridian' ); ?> <strong id="confirm-email"></strong>. <?php esc_html_e( 'We look forward to welcoming you.', 'meridian' ); ?></p>
					<div class="confirm__code">
						<span class="confirm__code-label"><?php esc_html_e( 'Confirmation', 'meridian' ); ?></span>
						<span class="confirm__code-num" id="confirm-code"></span>
					</div>
					<div class="confirm__details" id="confirm-details">
						<div><span><?php esc_html_e( 'Guest', 'meridian' ); ?></span><strong id="confirm-guest"></strong></div>
						<div><span><?php esc_html_e( 'Room', 'meridian' ); ?></span><strong><?php echo esc_html( $args['room_name'] ); ?></strong></div>
						<div><span><?php esc_html_e( 'Check in', 'meridian' ); ?></span><strong id="confirm-checkin"></strong></div>
						<div><span><?php esc_html_e( 'Check out', 'meridian' ); ?></span><strong id="confirm-checkout"></strong></div>
						<div><span><?php esc_html_e( 'Guests', 'meridian' ); ?></span><strong id="confirm-guests"></strong></div>
						<div><span><?php esc_html_e( 'Total at check-in', 'meridian' ); ?></span><strong id="confirm-total"></strong></div>
					</div>
					<div class="form__actions form__actions--center">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--outline"><?php esc_html_e( 'Return home', 'meridian' ); ?></a>
						<button type="button" class="btn btn--gold btn--lg" id="modal-done"><?php esc_html_e( 'Done', 'meridian' ); ?></button>
					</div>
				</div>
			</div>

			<!-- SIDEBAR SUMMARY -->
			<aside class="modal__summary" id="modal-summary">
				<div class="msummary">
					<?php if ( $args['thumb_url'] ) : ?>
					<div class="msummary__media">
						<img src="<?php echo esc_url( $args['thumb_url'] ); ?>" alt="<?php echo esc_attr( $args['room_name'] ); ?>" />
						<?php if ( $args['badge'] ) : ?>
							<span class="room-card__badge"><?php echo esc_html( $args['badge'] ); ?></span>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<div class="msummary__body">
						<div class="eyebrow"><?php echo esc_html( $args['category'] ); ?></div>
						<h3 class="msummary__title"><?php echo esc_html( $args['room_name'] ); ?></h3>
						<div class="msummary__specs">
							<span><?php echo meridian_icon( 'guests', 12 ); ?> <?php echo esc_html( $args['guests'] ); ?></span>
							<span><?php echo meridian_icon( 'ruler', 12 ); ?> <?php echo esc_html( $args['size'] ); ?> m²</span>
							<span><?php echo meridian_icon( 'bed', 12 ); ?> <?php echo esc_html( $args['bed'] ); ?></span>
						</div>
						<div class="msummary__dates">
							<div>
								<span class="msummary__k"><?php esc_html_e( 'Check in', 'meridian' ); ?></span>
								<span class="msummary__v" id="msummary-checkin">—</span>
							</div>
							<div class="msummary__arrow"><?php echo meridian_icon( 'arrow-right', 14 ); ?></div>
							<div>
								<span class="msummary__k"><?php esc_html_e( 'Check out', 'meridian' ); ?></span>
								<span class="msummary__v" id="msummary-checkout">—</span>
							</div>
						</div>
						<div class="msummary__guests" id="msummary-guests">—</div>
						<ul class="msummary__lines">
							<li><span id="msummary-nightly">—</span><span id="msummary-subtotal">—</span></li>
							<li><span><?php esc_html_e( 'Resort & service', 'meridian' ); ?></span><span id="msummary-resort">—</span></li>
							<li><span><?php esc_html_e( 'Taxes', 'meridian' ); ?></span><span id="msummary-tax">—</span></li>
							<li class="msummary__total"><span><?php esc_html_e( 'Total', 'meridian' ); ?></span><span id="msummary-total">—</span></li>
						</ul>
						<div class="msummary__perk"><?php echo meridian_icon( 'check', 14 ); ?> <?php esc_html_e( 'Free cancellation until 48h before arrival', 'meridian' ); ?></div>
						<div class="msummary__perk"><?php echo meridian_icon( 'check', 14 ); ?> <?php esc_html_e( 'Best rate guaranteed', 'meridian' ); ?></div>
					</div>
				</div>
			</aside>
		</div>
	</div>
</div>
