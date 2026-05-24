<?php
/**
 * Template Name: Contact
 *
 * Contact page with info cards and form. Converts Contact.jsx.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Elementor: if built with Elementor, let it render.
if ( defined( 'ELEMENTOR_VERSION' )
     && \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) {
	get_header();
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	get_footer();
	return;
}

get_header();
?>

<main id="main-content" class="tourvice-contact">

	<!-- ════════ HEADER ════════ -->
	<div class="tourvice-contact-hero">
		<div class="tourvice-contact__header-inner container">
			<h1 class="tourvice-contact-hero__title" data-i18n="contact_title">
				<?php esc_html_e( 'Get In Touch', 'tourvice' ); ?>
			</h1>
			<p class="tourvice-contact-hero__desc" data-i18n="contact_subtitle">
				<?php esc_html_e( 'We\'d love to hear from you', 'tourvice' ); ?>
			</p>
		</div>
	</div>

	<div class="tourvice-contact__body container">

		<!-- ════════ CONTACT INFO CARDS ════════ -->
		<div class="tourvice-contact-cards">

			<div class="tourvice-contact-card">
				<svg class="tourvice-contact-card__icon" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
					<polyline points="22,6 12,13 2,6"></polyline>
				</svg>
				<h3 class="tourvice-contact-card__title" data-i18n="contact_email"><?php esc_html_e( 'Email', 'tourvice' ); ?></h3>
				<p class="tourvice-contact-card__text">hello@discover.com</p>
			</div>

			<div class="tourvice-contact-card">
				<svg class="tourvice-contact-card__icon" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"></path>
				</svg>
				<h3 class="tourvice-contact-card__title" data-i18n="contact_phone"><?php esc_html_e( 'Phone', 'tourvice' ); ?></h3>
				<p class="tourvice-contact-card__text">+1 (555) 123-4567</p>
			</div>

			<div class="tourvice-contact-card">
				<svg class="tourvice-contact-card__icon" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
					<circle cx="12" cy="10" r="3"></circle>
				</svg>
				<h3 class="tourvice-contact-card__title" data-i18n="contact_address"><?php esc_html_e( 'Address', 'tourvice' ); ?></h3>
				<p class="tourvice-contact-card__text">123 Travel Street<br>Adventure City, AC 12345</p>
			</div>

		</div>

		<!-- ════════ CONTACT FORM ════════ -->
		<div class="tourvice-contact-form-wrap">
			<h2 class="tourvice-contact-form-wrap__title" data-i18n="contact_form_title">
				<?php esc_html_e( 'Send us a Message', 'tourvice' ); ?>
			</h2>

			<form class="tourvice-contact-form" id="tourvice-contact-form" method="post" action="#">
				<?php wp_nonce_field( 'tourvice_contact', 'tourvice_contact_nonce' ); ?>

				<div class="tourvice-contact-form__group">
					<label class="tourvice-contact-form__label" for="tourvice-contact-name" data-i18n="contact_name">
						<?php esc_html_e( 'Name', 'tourvice' ); ?>
					</label>
					<input
						type="text"
						id="tourvice-contact-name"
						name="name"
						class="tourvice-contact-form__input"
						required
					/>
					<p class="tourvice-contact-form__error" data-field="name" hidden>
						<?php esc_html_e( 'Name required', 'tourvice' ); ?>
					</p>
				</div>

				<div class="tourvice-contact-form__group">
					<label class="tourvice-contact-form__label" for="tourvice-contact-email" data-i18n="contact_email">
						<?php esc_html_e( 'Email', 'tourvice' ); ?>
					</label>
					<input
						type="email"
						id="tourvice-contact-email"
						name="email"
						class="tourvice-contact-form__input"
						required
					/>
					<p class="tourvice-contact-form__error" data-field="email" hidden>
						<?php esc_html_e( 'Valid email required', 'tourvice' ); ?>
					</p>
				</div>

				<div class="tourvice-contact-form__group">
					<label class="tourvice-contact-form__label" for="tourvice-contact-subject" data-i18n="contact_subject">
						<?php esc_html_e( 'Subject', 'tourvice' ); ?>
					</label>
					<input
						type="text"
						id="tourvice-contact-subject"
						name="subject"
						class="tourvice-contact-form__input"
						required
					/>
					<p class="tourvice-contact-form__error" data-field="subject" hidden>
						<?php esc_html_e( 'Subject required', 'tourvice' ); ?>
					</p>
				</div>

				<div class="tourvice-contact-form__group">
					<label class="tourvice-contact-form__label" for="tourvice-contact-message" data-i18n="contact_message">
						<?php esc_html_e( 'Message', 'tourvice' ); ?>
					</label>
					<textarea
						id="tourvice-contact-message"
						name="message"
						class="tourvice-contact-form__textarea"
						rows="5"
						required
					></textarea>
					<p class="tourvice-contact-form__error" data-field="message" hidden>
						<?php esc_html_e( 'Message required', 'tourvice' ); ?>
					</p>
				</div>

				<button type="submit" class="tourvice-contact-form__submit">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<line x1="22" y1="2" x2="11" y2="13"></line>
						<polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
					</svg>
					<span data-i18n="contact_send"><?php esc_html_e( 'Send Message', 'tourvice' ); ?></span>
				</button>
			</form>

			<div class="tourvice-contact-success" id="tourvice-contact-success" hidden>
				<?php esc_html_e( 'Message sent successfully! We\'ll reply soon.', 'tourvice' ); ?>
			</div>
		</div>

	</div>
</main>

<?php get_footer(); ?>
