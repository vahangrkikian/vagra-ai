<?php
/**
 * Template Name: Practice Areas
 *
 * @package Vagra_Legal
 */

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

<section class="vagra-page-hero">
	<div class="vagra-container">
		<h1 class="vagra-page-hero__title"><?php esc_html_e( 'Our Practice Areas', 'vagra-legal' ); ?></h1>
		<p class="vagra-page-hero__desc"><?php esc_html_e( 'Experienced legal representation across a wide range of practice areas.', 'vagra-legal' ); ?></p>
	</div>
</section>

<section class="vagra-practice-areas-detail">
	<div class="vagra-container">

		<div class="vagra-practice-detail" id="personal-injury">
			<div class="vagra-practice-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<path d="M24 6L40 14V26C40 36 33 43 24 46C15 43 8 36 8 26V14L24 6Z" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M18 26L22 30L30 20" stroke="var(--vagra-accent)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="vagra-practice-detail__content">
				<h2><?php esc_html_e( 'Personal Injury', 'vagra-legal' ); ?></h2>
				<p><?php esc_html_e( 'We fight for maximum compensation for victims of accidents, negligence, and wrongful acts. Our track record speaks for itself with millions recovered for our clients.', 'vagra-legal' ); ?></p>
				<ul class="vagra-practice-detail__list">
					<li><?php esc_html_e( 'Car and truck accidents', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Slip and fall injuries', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Medical malpractice', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Wrongful death claims', 'vagra-legal' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-practice-detail" id="family-law">
			<div class="vagra-practice-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<circle cx="18" cy="16" r="6" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<circle cx="30" cy="16" r="6" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M8 38C8 30 12 26 18 26" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
					<path d="M40 38C40 30 36 26 30 26" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
					<path d="M18 26C20 28 28 28 30 26" stroke="var(--vagra-accent)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
				</svg>
			</div>
			<div class="vagra-practice-detail__content">
				<h2><?php esc_html_e( 'Family Law', 'vagra-legal' ); ?></h2>
				<p><?php esc_html_e( 'Compassionate and effective representation in sensitive family matters. We guide you through difficult transitions with dignity and strategic focus.', 'vagra-legal' ); ?></p>
				<ul class="vagra-practice-detail__list">
					<li><?php esc_html_e( 'Divorce and separation', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Child custody and support', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Adoption proceedings', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Prenuptial agreements', 'vagra-legal' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-practice-detail" id="criminal-defense">
			<div class="vagra-practice-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<rect x="14" y="20" width="20" height="20" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M18 20V14C18 10.7 20.7 8 24 8C27.3 8 30 10.7 30 14V20" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
					<circle cx="24" cy="30" r="3" stroke="var(--vagra-accent)" stroke-width="2.5" fill="none"/>
				</svg>
			</div>
			<div class="vagra-practice-detail__content">
				<h2><?php esc_html_e( 'Criminal Defense', 'vagra-legal' ); ?></h2>
				<p><?php esc_html_e( 'Aggressive defense of your rights and freedom. We handle cases from misdemeanors to serious felonies with the same dedication to achieving the best possible outcome.', 'vagra-legal' ); ?></p>
				<ul class="vagra-practice-detail__list">
					<li><?php esc_html_e( 'DUI and traffic offenses', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Drug charges', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'White collar crimes', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Assault and violent crimes', 'vagra-legal' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-practice-detail" id="estate-planning">
			<div class="vagra-practice-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<rect x="10" y="8" width="28" height="34" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M16 16H32M16 22H32M16 28H26" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
					<path d="M28 32L32 36L38 28" stroke="var(--vagra-accent)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="vagra-practice-detail__content">
				<h2><?php esc_html_e( 'Estate Planning', 'vagra-legal' ); ?></h2>
				<p><?php esc_html_e( 'Protect your legacy and provide for your loved ones with comprehensive estate planning tailored to your unique situation and goals.', 'vagra-legal' ); ?></p>
				<ul class="vagra-practice-detail__list">
					<li><?php esc_html_e( 'Wills and trusts', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Power of attorney', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Probate administration', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Estate tax planning', 'vagra-legal' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-practice-detail" id="business-law">
			<div class="vagra-practice-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<rect x="8" y="18" width="32" height="24" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M24 6L38 18H10L24 6Z" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M18 26V36M24 24V36M30 26V36" stroke="var(--vagra-accent)" stroke-width="2.5" stroke-linecap="round"/>
				</svg>
			</div>
			<div class="vagra-practice-detail__content">
				<h2><?php esc_html_e( 'Business Law', 'vagra-legal' ); ?></h2>
				<p><?php esc_html_e( 'Strategic legal counsel for businesses at every stage, from formation to transactions to dispute resolution.', 'vagra-legal' ); ?></p>
				<ul class="vagra-practice-detail__list">
					<li><?php esc_html_e( 'Business formation and structuring', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Contract drafting and review', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Mergers and acquisitions', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Commercial litigation', 'vagra-legal' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-practice-detail" id="real-estate">
			<div class="vagra-practice-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<path d="M8 24L24 10L40 24" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
					<rect x="14" y="24" width="20" height="16" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<rect x="20" y="30" width="8" height="10" stroke="var(--vagra-accent)" stroke-width="2.5" fill="none"/>
				</svg>
			</div>
			<div class="vagra-practice-detail__content">
				<h2><?php esc_html_e( 'Real Estate Law', 'vagra-legal' ); ?></h2>
				<p><?php esc_html_e( 'Expert guidance through residential and commercial real estate transactions, disputes, and development projects.', 'vagra-legal' ); ?></p>
				<ul class="vagra-practice-detail__list">
					<li><?php esc_html_e( 'Residential and commercial closings', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Title disputes', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Zoning and land use', 'vagra-legal' ); ?></li>
					<li><?php esc_html_e( 'Landlord-tenant matters', 'vagra-legal' ); ?></li>
				</ul>
			</div>
		</div>

	</div>
</section>

<section class="vagra-cta">
	<div class="vagra-container">
		<div class="vagra-cta__content">
			<h2 class="vagra-cta__title"><?php esc_html_e( 'Schedule Your Free Consultation', 'vagra-legal' ); ?></h2>
			<p class="vagra-cta__desc"><?php esc_html_e( 'Discuss your legal matter with an experienced attorney at no cost.', 'vagra-legal' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vagra-btn vagra-btn--cta">
				<?php esc_html_e( 'Book a Consultation', 'vagra-legal' ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
