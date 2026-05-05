<?php
/**
 * Template Name: Attorney Profile
 *
 * @package Vagra_Legal
 */

get_header();
?>

<section class="vagra-page-hero vagra-page-hero--compact">
	<div class="vagra-container">
		<a href="<?php echo esc_url( home_url( '/attorneys/' ) ); ?>" class="vagra-back-link">
			<?php esc_html_e( '&larr; All Attorneys', 'vagra-legal' ); ?>
		</a>
	</div>
</section>

<section class="vagra-attorney-profile">
	<div class="vagra-container">
		<div class="vagra-attorney-profile__grid">
			<div class="vagra-attorney-profile__sidebar">
				<div class="vagra-card">
					<div class="vagra-attorney-profile__photo">
						<div class="vagra-attorney-card__placeholder vagra-attorney-card__placeholder--large" aria-hidden="true">
							<svg width="160" height="160" viewBox="0 0 160 160" fill="none">
								<circle cx="80" cy="60" r="28" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
								<path d="M32 136C32 108 52 92 80 92C108 92 128 108 128 136" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
							</svg>
						</div>
					</div>
					<div class="vagra-attorney-profile__contact">
						<p>
							<strong><?php esc_html_e( 'Email:', 'vagra-legal' ); ?></strong><br>
							<a href="<?php echo esc_url( 'mailto:attorney@example.com' ); ?>"><?php esc_html_e( 'attorney@example.com', 'vagra-legal' ); ?></a>
						</p>
						<p>
							<strong><?php esc_html_e( 'Phone:', 'vagra-legal' ); ?></strong><br>
							<a href="<?php echo esc_url( 'tel:+15551234567' ); ?>"><?php esc_html_e( '(555) 123-4567', 'vagra-legal' ); ?></a>
						</p>
					</div>
				</div>
			</div>

			<div class="vagra-attorney-profile__main">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
						<h1 class="vagra-attorney-profile__name"><?php the_title(); ?></h1>
						<div class="vagra-attorney-profile__bio">
							<?php the_content(); ?>
						</div>
						<?php
					endwhile;
				endif;
				?>

				<?php if ( '' === trim( get_the_content() ) ) : ?>
					<h1 class="vagra-attorney-profile__name"><?php esc_html_e( 'Attorney Name', 'vagra-legal' ); ?></h1>
					<p class="vagra-attorney-profile__role"><?php esc_html_e( 'Partner', 'vagra-legal' ); ?></p>

					<h2><?php esc_html_e( 'Biography', 'vagra-legal' ); ?></h2>
					<p><?php esc_html_e( 'This attorney profile page displays individual attorney information. Create a page using the "Attorney Profile" template and add the attorney biography, education, and bar admissions in the page content.', 'vagra-legal' ); ?></p>

					<h2><?php esc_html_e( 'Practice Areas', 'vagra-legal' ); ?></h2>
					<ul>
						<li><?php esc_html_e( 'Personal Injury', 'vagra-legal' ); ?></li>
						<li><?php esc_html_e( 'Criminal Defense', 'vagra-legal' ); ?></li>
					</ul>

					<h2><?php esc_html_e( 'Education', 'vagra-legal' ); ?></h2>
					<ul>
						<li><?php esc_html_e( 'J.D., School of Law', 'vagra-legal' ); ?></li>
						<li><?php esc_html_e( 'B.A., University', 'vagra-legal' ); ?></li>
					</ul>

					<h2><?php esc_html_e( 'Bar Admissions', 'vagra-legal' ); ?></h2>
					<ul>
						<li><?php esc_html_e( 'State Bar Association', 'vagra-legal' ); ?></li>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<section class="vagra-cta">
	<div class="vagra-container">
		<div class="vagra-cta__content">
			<h2 class="vagra-cta__title"><?php esc_html_e( 'Schedule a Consultation', 'vagra-legal' ); ?></h2>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vagra-btn vagra-btn--cta">
				<?php esc_html_e( 'Contact This Attorney', 'vagra-legal' ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
