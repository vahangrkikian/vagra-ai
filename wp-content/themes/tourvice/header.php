<?php
/**
 * Theme header template.
 *
 * Sticky header with transparent-on-hero behavior, logo, wp_nav_menu primary,
 * language switch (EN|HY|RU), currency dropdown (USD/EUR/AMD), mobile hamburger.
 *
 * @package TourVice
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
	<?php esc_html_e( 'Skip to content', 'tourvice' ); ?>
</a>

<header class="tourvice-header<?php echo ! is_front_page() ? ' tourvice-header--solid' : ''; ?>" id="tourvice-header" aria-label="<?php esc_attr_e( 'Primary navigation', 'tourvice' ); ?>">
	<div class="tourvice-header__inner container">

		<div class="tourvice-header__logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tourvice-header__logo-text">
					<?php esc_html_e( 'Tour', 'tourvice' ); ?><span><?php esc_html_e( 'Vice', 'tourvice' ); ?></span>
				</a>
			<?php endif; ?>
		</div>

		<nav class="tourvice-header__nav" aria-label="<?php esc_attr_e( 'Main menu', 'tourvice' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'tourvice-header__nav-list',
					'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
					'fallback_cb'    => 'tourvice_primary_menu_fallback',
					'walker'         => new Tourvice_Nav_Walker(),
				)
			);
			?>
		</nav>

		<div class="tourvice-header__actions">
			<!-- Language Switcher -->
			<div class="tourvice-header__lang">
				<?php if ( function_exists( 'tourvice_polylang_switcher' ) && function_exists( 'pll_the_languages' ) ) : ?>
					<?php tourvice_polylang_switcher(); ?>
				<?php else : ?>
					<button class="tourvice-header__lang-btn active" data-lang="en" onclick="setLang('en')">EN</button>
					<span class="tourvice-header__lang-sep">|</span>
					<button class="tourvice-header__lang-btn" data-lang="hy" onclick="setLang('hy')">HY</button>
					<span class="tourvice-header__lang-sep">|</span>
					<button class="tourvice-header__lang-btn" data-lang="ru" onclick="setLang('ru')">RU</button>
				<?php endif; ?>
			</div>

			<!-- Currency Switcher -->
			<div class="tourvice-header__currency" id="tourviceCurrWrap">
				<button class="tourvice-header__currency-toggle" id="tourviceCurrToggle" onclick="toggleCurrMenu()">
					$ USD <svg width="10" height="6" viewBox="0 0 10 6" fill="currentColor"><path d="M1 1l4 4 4-4"/></svg>
				</button>
				<div class="tourvice-header__currency-menu" id="tourviceCurrMenu">
					<button data-curr="usd" data-usd="1" class="selected" onclick="setCurrency('usd')">$ USD</button>
					<button data-curr="eur" data-usd="0.92" onclick="setCurrency('eur')">&euro; EUR</button>
					<button data-curr="amd" data-usd="387" onclick="setCurrency('amd')">&#1423; AMD</button>
				</div>
			</div>

			<!-- Hamburger -->
			<button class="tourvice-header__hamburger" id="tourviceMenuBtn" aria-label="<?php esc_attr_e( 'Menu', 'tourvice' ); ?>" aria-expanded="false">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>

	</div>

	<!-- Mobile Menu -->
	<div class="tourvice-header__mobile-menu" id="tourviceMobileMenu" aria-hidden="true">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => '',
				'items_wrap'     => '%3$s',
				'fallback_cb'    => 'tourvice_mobile_menu_fallback',
				'walker'         => new Tourvice_Mobile_Nav_Walker(),
			)
		);
		?>
		<div class="tourvice-header__mobile-lang">
			<?php if ( function_exists( 'tourvice_polylang_switcher' ) && function_exists( 'pll_the_languages' ) ) : ?>
				<?php tourvice_polylang_switcher( 'tourvice-header__mobile-lang-btn' ); ?>
			<?php else : ?>
				<button data-lang="en" onclick="setLang('en')" class="active">EN</button>
				<button data-lang="hy" onclick="setLang('hy')">HY</button>
				<button data-lang="ru" onclick="setLang('ru')">RU</button>
			<?php endif; ?>
		</div>
		<div class="tourvice-header__mobile-currency">
			<button data-curr="usd" data-usd="1" class="selected" onclick="setCurrency('usd')">$ USD</button>
			<button data-curr="eur" data-usd="0.92" onclick="setCurrency('eur')">&euro; EUR</button>
			<button data-curr="amd" data-usd="387" onclick="setCurrency('amd')">&#1423; AMD</button>
		</div>
	</div>
</header>
