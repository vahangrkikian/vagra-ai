<?php
/**
 * Template Part: Quote Form
 *
 * @package House_Service
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$provider_id   = get_the_ID();
$provider_name = get_the_title();
$tags_str      = get_post_meta( $provider_id, '_hs_tags', true );
$tags          = $tags_str ? array_map( 'trim', explode( ',', $tags_str ) ) : array();
?>

<div class="form-card" id="quote-form-card">
	<h3 class="form-card__title"><?php esc_html_e( 'Request a quote', 'house-service' ); ?></h3>

	<form id="hs-quote-form" novalidate>
		<?php wp_nonce_field( 'wp_rest', 'hs_quote_nonce' ); ?>
		<input type="hidden" name="provider_id" value="<?php echo absint( $provider_id ); ?>">

		<!-- Full name -->
		<div class="form-row">
			<label class="form-label" for="qf-name"><?php esc_html_e( 'Full name', 'house-service' ); ?></label>
			<input type="text" id="qf-name" name="name" class="form-input" placeholder="<?php esc_attr_e( 'Your name', 'house-service' ); ?>" required>
			<div class="form-error" id="qf-name-error"><?php esc_html_e( 'Please enter your name.', 'house-service' ); ?></div>
		</div>

		<!-- Email + Phone (2-col) -->
		<div class="form-row form-row--2col">
			<div>
				<label class="form-label" for="qf-email"><?php esc_html_e( 'Email', 'house-service' ); ?></label>
				<input type="email" id="qf-email" name="email" class="form-input" placeholder="<?php esc_attr_e( 'you@example.com', 'house-service' ); ?>" required>
				<div class="form-error" id="qf-email-error"><?php esc_html_e( 'Please enter a valid email.', 'house-service' ); ?></div>
			</div>
			<div>
				<label class="form-label" for="qf-phone"><?php esc_html_e( 'Phone', 'house-service' ); ?></label>
				<input type="tel" id="qf-phone" name="phone" class="form-input" placeholder="<?php esc_attr_e( '(555) 123-4567', 'house-service' ); ?>">
			</div>
		</div>

		<!-- Service + Date (2-col) -->
		<div class="form-row form-row--2col">
			<div>
				<label class="form-label" for="qf-service"><?php esc_html_e( 'Service needed', 'house-service' ); ?></label>
				<select id="qf-service" name="service" class="form-select">
					<option value=""><?php esc_html_e( 'Select a service', 'house-service' ); ?></option>
					<?php foreach ( $tags as $tag ) : ?>
						<option value="<?php echo esc_attr( $tag ); ?>"><?php echo esc_html( $tag ); ?></option>
					<?php endforeach; ?>
					<option value="other"><?php esc_html_e( 'Other', 'house-service' ); ?></option>
				</select>
			</div>
			<div>
				<label class="form-label" for="qf-date"><?php esc_html_e( 'Preferred date', 'house-service' ); ?></label>
				<input type="date" id="qf-date" name="date" class="form-input" min="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>">
			</div>
		</div>

		<!-- Notes -->
		<div class="form-row">
			<label class="form-label" for="qf-notes"><?php esc_html_e( 'Notes', 'house-service' ); ?></label>
			<textarea id="qf-notes" name="notes" class="form-textarea" placeholder="<?php esc_attr_e( 'Describe your project, property size, any special requirements...', 'house-service' ); ?>" rows="4"></textarea>
		</div>

		<!-- Submit -->
		<button type="submit" class="btn btn-primary btn-block btn-lg" id="qf-submit">
			<?php esc_html_e( 'Send request', 'house-service' ); ?>
			<?php echo hs_icon( 'arrow', 18 ); ?>
		</button>

		<!-- Privacy note -->
		<p class="form-privacy">
			<?php echo hs_icon( 'shield', 12 ); ?>
			<?php
			printf(
				/* translators: %s = provider company name */
				esc_html__( 'Your info stays private until %s replies. We never share your details with third parties.', 'house-service' ),
				esc_html( $provider_name )
			);
			?>
		</p>
	</form>

	<!-- Success state -->
	<div class="form-success" id="qf-success">
		<div class="form-success__icon"><?php echo hs_icon( 'check', 28 ); ?></div>
		<h3><?php esc_html_e( 'Quote request sent!', 'house-service' ); ?></h3>
		<p>
			<?php
			printf(
				/* translators: %s = provider company name */
				esc_html__( '%s will review your request and respond shortly. Check your email for updates.', 'house-service' ),
				esc_html( $provider_name )
			);
			?>
		</p>
	</div>
</div>
