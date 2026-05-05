<?php
/**
 * Template Name: Attorneys
 *
 * @package Vagra_Legal
 */

get_header();
?>

<section class="vagra-page-hero">
	<div class="vagra-container">
		<h1 class="vagra-page-hero__title"><?php esc_html_e( 'Our Attorneys', 'vagra-legal' ); ?></h1>
		<p class="vagra-page-hero__desc"><?php esc_html_e( 'Experienced advocates dedicated to protecting your rights and interests.', 'vagra-legal' ); ?></p>
	</div>
</section>

<section class="vagra-attorneys-grid-section">
	<div class="vagra-container">
		<div class="vagra-attorneys-grid">

			<div class="vagra-card vagra-attorney-card">
				<div class="vagra-attorney-card__photo">
					<div class="vagra-attorney-card__placeholder" aria-hidden="true">
						<svg width="80" height="80" viewBox="0 0 80 80" fill="none">
							<circle cx="40" cy="30" r="14" stroke="var(--vagra-primary)" stroke-width="2" fill="none"/>
							<path d="M16 68C16 54 26 46 40 46C54 46 64 54 64 68" stroke="var(--vagra-primary)" stroke-width="2" fill="none"/>
						</svg>
					</div>
				</div>
				<h3 class="vagra-attorney-card__name"><?php esc_html_e( 'James A. Mitchell', 'vagra-legal' ); ?></h3>
				<p class="vagra-attorney-card__title"><?php esc_html_e( 'Managing Partner', 'vagra-legal' ); ?></p>
				<p class="vagra-attorney-card__specialty"><?php esc_html_e( 'Personal Injury, Criminal Defense', 'vagra-legal' ); ?></p>
			</div>

			<div class="vagra-card vagra-attorney-card">
				<div class="vagra-attorney-card__photo">
					<div class="vagra-attorney-card__placeholder" aria-hidden="true">
						<svg width="80" height="80" viewBox="0 0 80 80" fill="none">
							<circle cx="40" cy="30" r="14" stroke="var(--vagra-primary)" stroke-width="2" fill="none"/>
							<path d="M16 68C16 54 26 46 40 46C54 46 64 54 64 68" stroke="var(--vagra-primary)" stroke-width="2" fill="none"/>
						</svg>
					</div>
				</div>
				<h3 class="vagra-attorney-card__name"><?php esc_html_e( 'Sarah L. Chen', 'vagra-legal' ); ?></h3>
				<p class="vagra-attorney-card__title"><?php esc_html_e( 'Senior Partner', 'vagra-legal' ); ?></p>
				<p class="vagra-attorney-card__specialty"><?php esc_html_e( 'Family Law, Estate Planning', 'vagra-legal' ); ?></p>
			</div>

			<div class="vagra-card vagra-attorney-card">
				<div class="vagra-attorney-card__photo">
					<div class="vagra-attorney-card__placeholder" aria-hidden="true">
						<svg width="80" height="80" viewBox="0 0 80 80" fill="none">
							<circle cx="40" cy="30" r="14" stroke="var(--vagra-primary)" stroke-width="2" fill="none"/>
							<path d="M16 68C16 54 26 46 40 46C54 46 64 54 64 68" stroke="var(--vagra-primary)" stroke-width="2" fill="none"/>
						</svg>
					</div>
				</div>
				<h3 class="vagra-attorney-card__name"><?php esc_html_e( 'Michael R. Torres', 'vagra-legal' ); ?></h3>
				<p class="vagra-attorney-card__title"><?php esc_html_e( 'Partner', 'vagra-legal' ); ?></p>
				<p class="vagra-attorney-card__specialty"><?php esc_html_e( 'Business Law, Real Estate', 'vagra-legal' ); ?></p>
			</div>

			<div class="vagra-card vagra-attorney-card">
				<div class="vagra-attorney-card__photo">
					<div class="vagra-attorney-card__placeholder" aria-hidden="true">
						<svg width="80" height="80" viewBox="0 0 80 80" fill="none">
							<circle cx="40" cy="30" r="14" stroke="var(--vagra-primary)" stroke-width="2" fill="none"/>
							<path d="M16 68C16 54 26 46 40 46C54 46 64 54 64 68" stroke="var(--vagra-primary)" stroke-width="2" fill="none"/>
						</svg>
					</div>
				</div>
				<h3 class="vagra-attorney-card__name"><?php esc_html_e( 'Emily K. Dawson', 'vagra-legal' ); ?></h3>
				<p class="vagra-attorney-card__title"><?php esc_html_e( 'Associate', 'vagra-legal' ); ?></p>
				<p class="vagra-attorney-card__specialty"><?php esc_html_e( 'Criminal Defense, Personal Injury', 'vagra-legal' ); ?></p>
			</div>

		</div>
	</div>
</section>

<section class="vagra-cta">
	<div class="vagra-container">
		<div class="vagra-cta__content">
			<h2 class="vagra-cta__title"><?php esc_html_e( 'Schedule a Consultation', 'vagra-legal' ); ?></h2>
			<p class="vagra-cta__desc"><?php esc_html_e( 'Speak directly with one of our attorneys about your legal matter.', 'vagra-legal' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vagra-btn vagra-btn--cta">
				<?php esc_html_e( 'Contact Us Today', 'vagra-legal' ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
