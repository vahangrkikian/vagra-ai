<?php
/**
 * Booking Widget (Hero)
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<form class="booking booking--hero" id="meridian-booking-widget" action="<?php echo esc_url( get_post_type_archive_link( 'meridian_room' ) ); ?>" method="get">
	<div class="booking__row">
		<label class="booking__field">
			<span class="booking__label"><?php esc_html_e( 'Check in', 'meridian' ); ?></span>
			<input type="date" name="check_in" id="booking-checkin" />
		</label>
		<label class="booking__field">
			<span class="booking__label"><?php esc_html_e( 'Check out', 'meridian' ); ?></span>
			<input type="date" name="check_out" id="booking-checkout" />
		</label>
		<div class="booking__field booking__field--guests" id="booking-guests-field">
			<span class="booking__label"><?php esc_html_e( 'Guests', 'meridian' ); ?></span>
			<button type="button" class="booking__guests-toggle" id="booking-guests-toggle">
				<?php echo meridian_icon( 'guests', 16 ); ?>
				<span id="booking-guests-text">2 <?php esc_html_e( 'guests', 'meridian' ); ?></span>
				<?php echo meridian_icon( 'chevron-down', 14 ); ?>
			</button>
			<div class="booking__guests-pop" id="booking-guests-pop" style="display:none;">
				<div class="stepper" data-stepper="adults" data-min="1" data-max="6" data-value="2">
					<div class="stepper__text">
						<div class="stepper__label"><?php esc_html_e( 'Adults', 'meridian' ); ?></div>
						<div class="stepper__sub">13+</div>
					</div>
					<div class="stepper__controls">
						<button type="button" class="stepper-dec" aria-label="<?php esc_attr_e( 'Decrease adults', 'meridian' ); ?>"><?php echo meridian_icon( 'minus', 14 ); ?></button>
						<span class="stepper-val">2</span>
						<button type="button" class="stepper-inc" aria-label="<?php esc_attr_e( 'Increase adults', 'meridian' ); ?>"><?php echo meridian_icon( 'plus', 14 ); ?></button>
					</div>
				</div>
				<div class="stepper" data-stepper="children" data-min="0" data-max="4" data-value="0">
					<div class="stepper__text">
						<div class="stepper__label"><?php esc_html_e( 'Children', 'meridian' ); ?></div>
						<div class="stepper__sub">0–12</div>
					</div>
					<div class="stepper__controls">
						<button type="button" class="stepper-dec" aria-label="<?php esc_attr_e( 'Decrease children', 'meridian' ); ?>"><?php echo meridian_icon( 'minus', 14 ); ?></button>
						<span class="stepper-val">0</span>
						<button type="button" class="stepper-inc" aria-label="<?php esc_attr_e( 'Increase children', 'meridian' ); ?>"><?php echo meridian_icon( 'plus', 14 ); ?></button>
					</div>
				</div>
			</div>
			<input type="hidden" name="adults" id="booking-adults" value="2" />
			<input type="hidden" name="children" id="booking-children" value="0" />
		</div>
		<button type="submit" class="btn btn--gold btn--lg booking__submit" id="booking-submit">
			<?php esc_html_e( 'Check Availability', 'meridian' ); ?> <?php echo meridian_icon( 'arrow-right', 16 ); ?>
		</button>
	</div>
	<div class="booking__meta">
		<span id="booking-nights">3 <?php esc_html_e( 'nights', 'meridian' ); ?></span>
		<span class="booking__sep">·</span>
		<span><?php esc_html_e( 'Best rate guarantee', 'meridian' ); ?></span>
		<span class="booking__sep">·</span>
		<span><?php esc_html_e( 'Free cancellation up to 48h', 'meridian' ); ?></span>
	</div>
</form>
