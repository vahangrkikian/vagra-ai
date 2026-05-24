<?php
/**
 * Header Template
 *
 * @package House_Service
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'app' ); ?>>
<?php wp_body_open(); ?>

<header class="nav" id="site-nav">
	<div class="shell">
		<div class="nav__inner">

			<!-- Logo -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<span class="nav__logo-icon">
					<?php echo hs_icon( 'house', 22 ); ?>
				</span>
				<span class="nav__logo-text">
					<strong><?php esc_html_e( 'Service', 'house-service' ); ?></strong>
					<em><?php esc_html_e( 'Market', 'house-service' ); ?></em>
				</span>
			</a>

			<!-- Desktop Navigation -->
			<?php
			wp_nav_menu( array(
				'theme_location'  => 'primary',
				'container'       => 'nav',
				'container_class' => 'nav__desktop',
				'menu_class'      => 'nav__links',
				'fallback_cb'     => 'hs_primary_menu_fallback',
				'depth'           => 1,
			) );
			?>

			<!-- CTA + Hamburger -->
			<div class="nav__cta">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ); ?>" class="btn btn-primary">
					<?php esc_html_e( 'Get started', 'house-service' ); ?>
				</a>
				<button class="nav__hamburger" id="nav-hamburger" aria-label="<?php esc_attr_e( 'Open menu', 'house-service' ); ?>" aria-expanded="false">
					<?php echo hs_icon( 'menu', 24 ); ?>
				</button>
			</div>

		</div>
	</div>
</header>

<!-- Mobile Navigation Overlay -->
<div class="nav__mobile" id="nav-mobile" aria-hidden="true">
	<div class="nav__mobile-panel">
		<button class="nav__mobile-close" id="nav-mobile-close" aria-label="<?php esc_attr_e( 'Close menu', 'house-service' ); ?>">
			<?php echo hs_icon( 'close', 24 ); ?>
		</button>
		<nav class="nav__mobile-links">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'house-service' ); ?></a>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ); ?>"><?php esc_html_e( 'Browse', 'house-service' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/categories/' ) ); ?>"><?php esc_html_e( 'Categories', 'house-service' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/#how-it-works' ) ); ?>"><?php esc_html_e( 'How it works', 'house-service' ); ?></a>
		</nav>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ); ?>" class="btn btn-primary btn-block btn-lg">
			<?php esc_html_e( 'Get started', 'house-service' ); ?>
		</a>
	</div>
</div>

<main>
