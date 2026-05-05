<?php
/**
 * The header template.
 *
 * Sticky frosted-glass navigation with mobile burger menu.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e( 'Skip to content', 'vagra-msp' ); ?>
    </a>

    <header id="masthead" class="site-header site-header--sticky">
        <div class="site-container site-header__inner">
            <div class="site-branding">
                <?php
                if ( has_custom_logo() ) :
                    the_custom_logo();
                else :
                    ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" rel="home">
                        <svg class="site-logo__icon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect width="32" height="32" rx="8" fill="var(--vagra-primary)"/>
                            <path d="M8 16L14 22L24 10" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="site-logo__text"><?php bloginfo( 'name' ); ?></span>
                    </a>
                    <?php
                endif;
                ?>
            </div>

            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'vagra-msp' ); ?>">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'vagra_primary_menu_fallback',
                    )
                );
                ?>
            </nav>

            <a href="<?php echo esc_url( home_url( '/tools/dns-check/' ) ); ?>" class="vagra-button vagra-button--primary site-header__cta">
                <?php esc_html_e( 'Check DNS', 'vagra-msp' ); ?>
            </a>

            <button class="site-header__burger" id="mobile-menu-toggle"
                    aria-controls="site-navigation"
                    aria-expanded="false"
                    aria-label="<?php esc_attr_e( 'Toggle menu', 'vagra-msp' ); ?>">
                <span class="burger-bar"></span>
                <span class="burger-bar"></span>
                <span class="burger-bar"></span>
            </button>
        </div>
    </header>
