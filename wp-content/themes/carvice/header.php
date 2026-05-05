<?php
/**
 * Theme header — matches Carmaster prototype layout.
 *
 * @package Carvice
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Top utility bar -->
<div class="carvice-utility-bar">
    <div class="carvice-container carvice-utility-bar__inner">
        <div class="carvice-utility-bar__left">
            <span class="carvice-utility-bar__label"><?php esc_html_e( 'Your region:', 'carvice' ); ?></span>
            <button class="carvice-utility-bar__selector">
                <svg class="carvice-icon-xs" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                Russia
                <svg class="carvice-icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <span class="carvice-utility-bar__label"><?php esc_html_e( 'Language:', 'carvice' ); ?></span>
            <button class="carvice-utility-bar__selector carvice-utility-bar__selector--bold">
                Armenian
                <svg class="carvice-icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
        </div>
        <a href="#" class="carvice-utility-bar__link"><?php esc_html_e( 'Auto Forum', 'carvice' ); ?></a>
    </div>
</div>

<!-- Main header -->
<header class="carvice-header">
    <div class="carvice-container carvice-header__inner">
        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="carvice-logo">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="carvice-logo__text">car<span class="carvice-logo__accent">v</span>ice</span>
                <span class="carvice-logo__tagline">all services<br/>for your car</span>
            <?php endif; ?>
        </a>

        <!-- Search -->
        <div class="carvice-header__search">
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/search/' ) ); ?>">
                <input
                    type="search"
                    name="q"
                    placeholder="<?php esc_attr_e( 'Search...', 'carvice' ); ?>"
                    value="<?php echo esc_attr( isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '' ); ?>"
                    class="carvice-header__search-input"
                />
                <button type="submit" class="carvice-header__search-btn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="carvice-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
        </div>

        <!-- Auth -->
        <div class="carvice-header__auth">
            <?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="carvice-header__auth-link">
                    <?php esc_html_e( 'Log Out', 'carvice' ); ?>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url( wp_login_url() ); ?>" class="carvice-header__auth-link">
                    <?php esc_html_e( 'Sign In', 'carvice' ); ?>
                </a>
                <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="carvice-header__auth-btn">
                    <?php esc_html_e( 'Sign Up', 'carvice' ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
