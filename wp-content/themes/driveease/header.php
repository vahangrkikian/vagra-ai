<?php
/**
 * Theme header template.
 *
 * Fixed dark navbar with backdrop-filter blur, logo, wp_nav_menu primary,
 * language switch (EN|HY), currency dropdown (USD/EUR/AMD), mobile hamburger,
 * and Book Now CTA.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
	<?php esc_html_e( 'Skip to content', 'driveease' ); ?>
</a>

<nav id="navbar" aria-label="<?php esc_attr_e( 'Primary navigation', 'driveease' ); ?>">
	<div class="container nav-inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo"><?php esc_html_e( 'Drive', 'driveease' ); ?><span><?php esc_html_e( 'Ease', 'driveease' ); ?></span></a>

		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav-links',
				'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
				'fallback_cb'    => 'driveease_primary_menu_fallback',
				'walker'         => new Driveease_Nav_Walker(),
			)
		);
		?>

		<div class="nav-right">
			<?php if ( function_exists( 'driveease_polylang_switcher' ) ) : ?>
				<?php driveease_polylang_switcher( 'lang-switch' ); ?>
			<?php else : ?>
			<div class="lang-switch">
				<button class="lang-btn active" data-lang="en" onclick="setLang('en')"><?php esc_html_e( 'EN', 'driveease' ); ?></button>
				<span class="lang-sep">|</span>
				<button class="lang-btn" data-lang="hy" onclick="setLang('hy')"><?php esc_html_e( 'HY', 'driveease' ); ?></button>
			</div>
			<?php endif; ?>
			<div class="curr-wrap" id="currWrap">
				<button class="curr-toggle" id="currToggle" onclick="toggleCurrMenu()">$ USD <i class="fa-solid fa-chevron-down fa-xs"></i></button>
				<div class="curr-menu" id="currMenu">
					<button data-curr="usd" class="selected" onclick="setCurrency('usd')">$ USD</button>
					<button data-curr="eur" onclick="setCurrency('eur')">&euro; EUR</button>
					<button data-curr="amd" onclick="setCurrency('amd')">&#1423; AMD</button>
				</div>
			</div>
			<button class="btn btn-primary open-booking" data-car="any" style="display:flex" data-i18n="btn_book"><?php esc_html_e( 'Book Now', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i></button>
			<button class="hamburger" id="menuBtn" aria-label="<?php esc_attr_e( 'Menu', 'driveease' ); ?>"><i class="fa-solid fa-bars"></i></button>
		</div>
	</div>

	<div class="mobile-menu" id="mobileMenu">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => '',
				'items_wrap'     => '%3$s',
				'fallback_cb'    => 'driveease_mobile_menu_fallback',
				'walker'         => new Driveease_Mobile_Nav_Walker(),
			)
		);
		?>
		<div class="mobile-lang">
			<?php if ( function_exists( 'driveease_polylang_switcher' ) ) : ?>
				<?php driveease_polylang_switcher( 'mobile-polylang' ); ?>
			<?php else : ?>
				<button data-lang="en" onclick="setLang('en')" class="active"><?php esc_html_e( 'EN', 'driveease' ); ?></button>
				<button data-lang="hy" onclick="setLang('hy')"><?php esc_html_e( 'HY', 'driveease' ); ?></button>
			<?php endif; ?>
		</div>
		<div class="mobile-curr">
			<button data-curr="usd" class="selected" onclick="setCurrency('usd')">$ USD</button>
			<button data-curr="eur" onclick="setCurrency('eur')">&euro; EUR</button>
			<button data-curr="amd" onclick="setCurrency('amd')">&#1423; AMD</button>
		</div>
		<button class="btn btn-primary open-booking" data-car="any" style="margin-top:8px;justify-content:center;width:100%" data-i18n="btn_book"><?php esc_html_e( 'Book Now', 'driveease' ); ?></button>
	</div>
</nav>
