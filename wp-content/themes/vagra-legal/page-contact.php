<?php
/**
 * Template Name: Contact
 *
 * @package Vagra_Legal
 */

get_header();
?>

<section class="vagra-page-hero">
	<div class="vagra-container">
		<h1 class="vagra-page-hero__title"><?php esc_html_e( 'Contact Us', 'vagra-legal' ); ?></h1>
		<p class="vagra-page-hero__desc"><?php esc_html_e( 'Schedule your free consultation or reach out with any questions.', 'vagra-legal' ); ?></p>
	</div>
</section>

<section class="vagra-contact">
	<div class="vagra-container">
		<div class="vagra-contact__grid">
			<div class="vagra-contact__form-area">
				<h2><?php esc_html_e( 'Request a Consultation', 'vagra-legal' ); ?></h2>
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						the_content();
					endwhile;
				endif;
				?>
				<?php if ( '' === trim( get_the_content() ) ) : ?>
					<form class="vagra-contact-form" method="post" action="#">
						<div class="vagra-contact-form__field">
							<label for="vagra-name"><?php esc_html_e( 'Full Name', 'vagra-legal' ); ?></label>
							<input type="text" id="vagra-name" name="vagra_name" required>
						</div>
						<div class="vagra-contact-form__field">
							<label for="vagra-email"><?php esc_html_e( 'Email Address', 'vagra-legal' ); ?></label>
							<input type="email" id="vagra-email" name="vagra_email" required>
						</div>
						<div class="vagra-contact-form__field">
							<label for="vagra-phone"><?php esc_html_e( 'Phone Number', 'vagra-legal' ); ?></label>
							<input type="tel" id="vagra-phone" name="vagra_phone">
						</div>
						<div class="vagra-contact-form__field">
							<label for="vagra-case-type"><?php esc_html_e( 'Case Type', 'vagra-legal' ); ?></label>
							<select id="vagra-case-type" name="vagra_case_type">
								<option value=""><?php esc_html_e( 'Select a practice area', 'vagra-legal' ); ?></option>
								<option value="personal-injury"><?php esc_html_e( 'Personal Injury', 'vagra-legal' ); ?></option>
								<option value="family-law"><?php esc_html_e( 'Family Law', 'vagra-legal' ); ?></option>
								<option value="criminal-defense"><?php esc_html_e( 'Criminal Defense', 'vagra-legal' ); ?></option>
								<option value="estate-planning"><?php esc_html_e( 'Estate Planning', 'vagra-legal' ); ?></option>
								<option value="business-law"><?php esc_html_e( 'Business Law', 'vagra-legal' ); ?></option>
								<option value="real-estate"><?php esc_html_e( 'Real Estate', 'vagra-legal' ); ?></option>
								<option value="other"><?php esc_html_e( 'Other', 'vagra-legal' ); ?></option>
							</select>
						</div>
						<div class="vagra-contact-form__field">
							<label for="vagra-message"><?php esc_html_e( 'Describe Your Situation', 'vagra-legal' ); ?></label>
							<textarea id="vagra-message" name="vagra_message" rows="5" required></textarea>
						</div>
						<button type="submit" class="vagra-btn vagra-btn--primary">
							<?php esc_html_e( 'Request Consultation', 'vagra-legal' ); ?>
						</button>
					</form>
				<?php endif; ?>
			</div>

			<div class="vagra-contact__info">
				<div class="vagra-card vagra-contact-info-card">
					<h3><?php esc_html_e( 'Office Information', 'vagra-legal' ); ?></h3>
					<ul class="vagra-contact-info__list">
						<li>
							<strong><?php esc_html_e( 'Address:', 'vagra-legal' ); ?></strong><br>
							<?php esc_html_e( '123 Justice Avenue, Suite 400', 'vagra-legal' ); ?><br>
							<?php esc_html_e( 'City, State 12345', 'vagra-legal' ); ?>
						</li>
						<li>
							<strong><?php esc_html_e( 'Phone:', 'vagra-legal' ); ?></strong><br>
							<a href="<?php echo esc_url( 'tel:+15551234567' ); ?>"><?php esc_html_e( '(555) 123-4567', 'vagra-legal' ); ?></a>
						</li>
						<li>
							<strong><?php esc_html_e( 'Email:', 'vagra-legal' ); ?></strong><br>
							<a href="<?php echo esc_url( 'mailto:info@example.com' ); ?>"><?php esc_html_e( 'info@example.com', 'vagra-legal' ); ?></a>
						</li>
						<li>
							<strong><?php esc_html_e( 'Hours:', 'vagra-legal' ); ?></strong><br>
							<?php esc_html_e( 'Mon-Fri 8:30am-5:30pm', 'vagra-legal' ); ?>
						</li>
					</ul>
				</div>
				<div class="vagra-card vagra-contact-info-card">
					<h3><?php esc_html_e( 'Free Consultation', 'vagra-legal' ); ?></h3>
					<p><?php esc_html_e( 'Your initial consultation is completely free and confidential. We will review your case and explain your options with no obligation.', 'vagra-legal' ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
