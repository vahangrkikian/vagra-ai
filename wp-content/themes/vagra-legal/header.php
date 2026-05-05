<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="vagra-header" role="banner">
    <div class="vagra-container">
        <div class="vagra-header__inner">
            <div class="vagra-header__brand">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vagra-header__site-title">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <nav class="vagra-header__nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'vagra-legal' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'vagra-nav',
                    'fallback_cb'    => false,
                ) );
                ?>
            </nav>

            <div class="vagra-header__right">
                <span class="vagra-header__phone"><?php esc_html_e( '(555) 123-4567', 'vagra-legal' ); ?></span>
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vagra-btn vagra-btn--primary vagra-btn--sm">
                    <?php esc_html_e( 'Free Consultation', 'vagra-legal' ); ?>
                </a>
            </div>

            <button class="vagra-header__toggle" aria-label="<?php esc_attr_e( 'Toggle Menu', 'vagra-legal' ); ?>" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<main id="main-content" class="vagra-main">
