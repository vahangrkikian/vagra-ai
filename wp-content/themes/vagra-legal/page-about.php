<?php
/**
 * Template Name: About
 *
 * @package Vagra_Legal
 */

get_header();
?>

<section class="vagra-page-hero">
	<div class="vagra-container">
		<h1 class="vagra-page-hero__title"><?php esc_html_e( 'About Our Firm', 'vagra-legal' ); ?></h1>
		<p class="vagra-page-hero__desc"><?php esc_html_e( 'A tradition of excellence, a commitment to justice.', 'vagra-legal' ); ?></p>
	</div>
</section>

<section class="vagra-about-story">
	<div class="vagra-container">
		<div class="vagra-about-story__grid">
			<div class="vagra-about-story__text">
				<h2><?php esc_html_e( 'Our History', 'vagra-legal' ); ?></h2>
				<p><?php esc_html_e( 'For over two decades, our firm has been a trusted advocate for individuals and families facing critical legal challenges. Founded on the principle that everyone deserves skilled representation, we have grown from a small practice into a full-service law firm.', 'vagra-legal' ); ?></p>
				<p><?php esc_html_e( 'Our attorneys have recovered millions of dollars for our clients, defended the wrongly accused, and guided families through their most difficult moments. We measure success not just in verdicts, but in the lives we help rebuild.', 'vagra-legal' ); ?></p>
			</div>
			<div class="vagra-about-story__visual">
				<div class="vagra-about-story__placeholder">
					<svg width="120" height="120" viewBox="0 0 120 120" fill="none" aria-hidden="true">
						<rect width="120" height="120" rx="8" fill="var(--vagra-light)"/>
						<path d="M60 20L90 38V72C90 88 76 100 60 106C44 100 30 88 30 72V38L60 20Z" stroke="var(--vagra-primary)" stroke-width="3" fill="none"/>
						<path d="M48 64L56 72L74 52" stroke="var(--vagra-accent)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="vagra-about-values">
	<div class="vagra-container">
		<h2 class="vagra-section-header__title"><?php esc_html_e( 'Our Values', 'vagra-legal' ); ?></h2>
		<div class="vagra-about-values__grid">
			<div class="vagra-card vagra-value-card">
				<h3><?php esc_html_e( 'Integrity', 'vagra-legal' ); ?></h3>
				<p><?php esc_html_e( 'We hold ourselves to the highest ethical standards. Honest counsel, even when the truth is difficult.', 'vagra-legal' ); ?></p>
			</div>
			<div class="vagra-card vagra-value-card">
				<h3><?php esc_html_e( 'Advocacy', 'vagra-legal' ); ?></h3>
				<p><?php esc_html_e( 'We fight relentlessly for our clients. Every case receives the preparation and attention it deserves.', 'vagra-legal' ); ?></p>
			</div>
			<div class="vagra-card vagra-value-card">
				<h3><?php esc_html_e( 'Compassion', 'vagra-legal' ); ?></h3>
				<p><?php esc_html_e( 'Behind every case is a person. We listen, we understand, and we guide with empathy.', 'vagra-legal' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="vagra-about-stats">
	<div class="vagra-container">
		<div class="vagra-case-results__grid">
			<div class="vagra-case-result">
				<span class="vagra-case-result__number"><?php esc_html_e( '20+', 'vagra-legal' ); ?></span>
				<span class="vagra-case-result__label"><?php esc_html_e( 'Years of Experience', 'vagra-legal' ); ?></span>
			</div>
			<div class="vagra-case-result">
				<span class="vagra-case-result__number"><?php esc_html_e( '500+', 'vagra-legal' ); ?></span>
				<span class="vagra-case-result__label"><?php esc_html_e( 'Cases Won', 'vagra-legal' ); ?></span>
			</div>
			<div class="vagra-case-result">
				<span class="vagra-case-result__number"><?php esc_html_e( '$10M+', 'vagra-legal' ); ?></span>
				<span class="vagra-case-result__label"><?php esc_html_e( 'Recovered for Clients', 'vagra-legal' ); ?></span>
			</div>
		</div>
	</div>
</section>

<section class="vagra-cta">
	<div class="vagra-container">
		<div class="vagra-cta__content">
			<h2 class="vagra-cta__title"><?php esc_html_e( 'Ready to Discuss Your Case?', 'vagra-legal' ); ?></h2>
			<p class="vagra-cta__desc"><?php esc_html_e( 'Your first consultation is free. Let us show you how we can help.', 'vagra-legal' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vagra-btn vagra-btn--cta">
				<?php esc_html_e( 'Schedule a Free Consultation', 'vagra-legal' ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
