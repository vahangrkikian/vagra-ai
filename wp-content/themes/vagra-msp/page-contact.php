<?php
/**
 * Template Name: Contact
 *
 * @package Vagra_MSP
 */

get_header();
?>

<section class="vagra-page-hero">
	<div class="vagra-container">
		<h1 class="vagra-page-hero__title"><?php esc_html_e( 'Contact Us', 'vagra-msp' ); ?></h1>
		<p class="vagra-page-hero__desc"><?php esc_html_e( 'Get your free security assessment or ask us anything about protecting your business.', 'vagra-msp' ); ?></p>
	</div>
</section>

<section class="vagra-contact">
	<div class="vagra-container">
		<div class="vagra-contact__grid">
			<div class="vagra-contact__form-area">
				<h2><?php esc_html_e( 'Send Us a Message', 'vagra-msp' ); ?></h2>
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
							<label for="vagra-name"><?php esc_html_e( 'Full Name', 'vagra-msp' ); ?></label>
							<input type="text" id="vagra-name" name="vagra_name" required>
						</div>
						<div class="vagra-contact-form__field">
							<label for="vagra-email"><?php esc_html_e( 'Email Address', 'vagra-msp' ); ?></label>
							<input type="email" id="vagra-email" name="vagra_email" required>
						</div>
						<div class="vagra-contact-form__field">
							<label for="vagra-company"><?php esc_html_e( 'Company Name', 'vagra-msp' ); ?></label>
							<input type="text" id="vagra-company" name="vagra_company">
						</div>
						<div class="vagra-contact-form__field">
							<label for="vagra-message"><?php esc_html_e( 'Message', 'vagra-msp' ); ?></label>
							<textarea id="vagra-message" name="vagra_message" rows="5" required></textarea>
						</div>
						<button type="submit" class="vagra-btn vagra-btn--primary">
							<?php esc_html_e( 'Send Message', 'vagra-msp' ); ?>
						</button>
					</form>
				<?php endif; ?>
			</div>

			<div class="vagra-contact__info">
				<div class="vagra-card vagra-contact-info-card">
					<h3><?php esc_html_e( 'Get in Touch', 'vagra-msp' ); ?></h3>
					<ul class="vagra-contact-info__list">
						<li>
							<strong><?php esc_html_e( 'Email:', 'vagra-msp' ); ?></strong>
							<a href="<?php echo esc_url( 'mailto:info@example.com' ); ?>"><?php esc_html_e( 'info@example.com', 'vagra-msp' ); ?></a>
						</li>
						<li>
							<strong><?php esc_html_e( 'Phone:', 'vagra-msp' ); ?></strong>
							<a href="<?php echo esc_url( 'tel:+15551234567' ); ?>"><?php esc_html_e( '(555) 123-4567', 'vagra-msp' ); ?></a>
						</li>
						<li>
							<strong><?php esc_html_e( 'Hours:', 'vagra-msp' ); ?></strong>
							<?php esc_html_e( 'Mon-Fri 8am-6pm EST', 'vagra-msp' ); ?>
						</li>
					</ul>
				</div>
				<div class="vagra-card vagra-contact-info-card">
					<h3><?php esc_html_e( 'Emergency Response', 'vagra-msp' ); ?></h3>
					<p><?php esc_html_e( 'Active security incident? Our SOC team is available 24/7.', 'vagra-msp' ); ?></p>
					<p><strong><a href="<?php echo esc_url( 'tel:+15559110000' ); ?>"><?php esc_html_e( '(555) 911-0000', 'vagra-msp' ); ?></a></strong></p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
