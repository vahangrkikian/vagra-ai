<?php
/**
 * Theme header.
 *
 * Ported from: nslookup/project/shared/components.jsx — TopNav + NsLogo
 *
 * @package Vagra_NSLookup
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="nsl-nav">
	<div class="container nsl-nav-inner">
		<!-- Logo -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nsl-logo" aria-label="<?php bloginfo( 'name' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true">
					<rect width="32" height="32" rx="8" fill="var(--nsl-primary-500)"/>
					<circle cx="10" cy="10" r="2.4" fill="#fff"/>
					<circle cx="22" cy="10" r="2.4" fill="#fff" opacity="0.75"/>
					<circle cx="10" cy="22" r="2.4" fill="#fff" opacity="0.75"/>
					<circle cx="22" cy="22" r="2.4" fill="#fff"/>
					<path d="M10 10 L22 22 M22 10 L10 22" stroke="#fff" stroke-width="1.4" stroke-linecap="round" opacity="0.6"/>
				</svg>
				<span class="nsl-logo-word">nslookup<span class="nsl-logo-dot">.am</span></span>
			<?php endif; ?>
		</a>

		<!-- Primary navigation -->
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => 'nav',
				'container_aria_label' => esc_attr__( 'Primary navigation', 'vagra-nslookup' ),
				'menu_class'     => 'nsl-nav-links',
				'depth'          => 1,
			) ); ?>
		<?php endif; ?>

		<!-- CTA button -->
		<div class="nsl-nav-cta">
			<a href="<?php echo esc_url( home_url( '/#tool' ) ); ?>" class="btn btn-primary btn-sm"><?php esc_html_e( 'Check DNS', 'vagra-nslookup' ); ?></a>
		</div>

		<!-- Mobile burger -->
		<button class="nsl-nav-burger" aria-label="<?php esc_attr_e( 'Toggle menu', 'vagra-nslookup' ); ?>" aria-expanded="false" aria-controls="nsl-mobile-menu">
			<svg width="22" height="22" viewBox="0 0 22 22" fill="none" aria-hidden="true">
				<path d="M3 6h16M3 11h16M3 16h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
			</svg>
		</button>
	</div>

	<!-- Mobile menu overlay -->
	<div class="nsl-nav-mobile" id="nsl-mobile-menu" aria-hidden="true">
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => 'nav',
				'container_class' => 'nsl-nav-mobile-links',
				'container_aria_label' => esc_attr__( 'Mobile navigation', 'vagra-nslookup' ),
				'items_wrap'     => '%3$s',
				'depth'          => 1,
			) ); ?>
		<?php endif; ?>
		<a href="<?php echo esc_url( home_url( '/#tool' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Check DNS', 'vagra-nslookup' ); ?></a>
	</div>
</header>
