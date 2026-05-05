<?php
/**
 * Template Name: About
 *
 * @package Vagra_MSP
 */

get_header();
?>

<section class="vagra-page-hero">
	<div class="vagra-container">
		<h1 class="vagra-page-hero__title"><?php esc_html_e( 'About Us', 'vagra-msp' ); ?></h1>
		<p class="vagra-page-hero__desc"><?php esc_html_e( 'Protecting businesses with enterprise-grade cybersecurity since day one.', 'vagra-msp' ); ?></p>
	</div>
</section>

<section class="vagra-about-story">
	<div class="vagra-container">
		<div class="vagra-about-story__grid">
			<div class="vagra-about-story__text">
				<h2><?php esc_html_e( 'Our Story', 'vagra-msp' ); ?></h2>
				<p><?php esc_html_e( 'We started with a simple mission: make enterprise-grade cybersecurity accessible to growing businesses. Too many small and mid-sized companies were left vulnerable because security solutions were built for Fortune 500 budgets.', 'vagra-msp' ); ?></p>
				<p><?php esc_html_e( 'Today, we protect over 200 businesses with managed security services that scale with their needs. Our team of certified security professionals works around the clock so our clients can focus on what they do best.', 'vagra-msp' ); ?></p>
			</div>
			<div class="vagra-about-story__visual">
				<div class="vagra-about-story__placeholder">
					<svg width="120" height="120" viewBox="0 0 120 120" fill="none" aria-hidden="true">
						<rect width="120" height="120" rx="16" fill="var(--vagra-light)"/>
						<path d="M60 25L85 40V65C85 82 73 95 60 100C47 95 35 82 35 65V40L60 25Z" stroke="var(--vagra-primary)" stroke-width="3" fill="none"/>
						<path d="M50 62L57 69L72 52" stroke="var(--vagra-success)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="vagra-about-values">
	<div class="vagra-container">
		<h2 class="vagra-section-header__title"><?php esc_html_e( 'Our Values', 'vagra-msp' ); ?></h2>
		<div class="vagra-about-values__grid">
			<div class="vagra-card vagra-value-card">
				<h3><?php esc_html_e( 'Proactive Defense', 'vagra-msp' ); ?></h3>
				<p><?php esc_html_e( 'We prevent threats before they reach your network, not just react after the damage is done.', 'vagra-msp' ); ?></p>
			</div>
			<div class="vagra-card vagra-value-card">
				<h3><?php esc_html_e( 'Transparency', 'vagra-msp' ); ?></h3>
				<p><?php esc_html_e( 'Clear reporting, honest assessments, and no hidden fees. You always know where you stand.', 'vagra-msp' ); ?></p>
			</div>
			<div class="vagra-card vagra-value-card">
				<h3><?php esc_html_e( 'Client-First', 'vagra-msp' ); ?></h3>
				<p><?php esc_html_e( 'Your security needs drive our recommendations, not product quotas or vendor partnerships.', 'vagra-msp' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="vagra-about-team">
	<div class="vagra-container">
		<h2 class="vagra-section-header__title"><?php esc_html_e( 'Our Team', 'vagra-msp' ); ?></h2>
		<p class="vagra-section-header__desc"><?php esc_html_e( 'Certified security professionals with decades of combined experience protecting businesses like yours.', 'vagra-msp' ); ?></p>
		<div class="vagra-social-proof__stats">
			<div class="vagra-stat">
				<span class="vagra-stat__number"><?php esc_html_e( '15+', 'vagra-msp' ); ?></span>
				<span class="vagra-stat__label"><?php esc_html_e( 'Security Experts', 'vagra-msp' ); ?></span>
			</div>
			<div class="vagra-stat">
				<span class="vagra-stat__number"><?php esc_html_e( '50+', 'vagra-msp' ); ?></span>
				<span class="vagra-stat__label"><?php esc_html_e( 'Certifications', 'vagra-msp' ); ?></span>
			</div>
			<div class="vagra-stat">
				<span class="vagra-stat__number"><?php esc_html_e( '10+', 'vagra-msp' ); ?></span>
				<span class="vagra-stat__label"><?php esc_html_e( 'Years Experience', 'vagra-msp' ); ?></span>
			</div>
		</div>
	</div>
</section>

<section class="vagra-cta" id="contact">
	<div class="vagra-container">
		<div class="vagra-cta__content">
			<h2 class="vagra-cta__title"><?php esc_html_e( 'Want to Work With Us?', 'vagra-msp' ); ?></h2>
			<p class="vagra-cta__desc"><?php esc_html_e( 'Let us show you how we can protect your business.', 'vagra-msp' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vagra-btn vagra-btn--cta">
				<?php esc_html_e( 'Get in Touch', 'vagra-msp' ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
