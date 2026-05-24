<?php
/**
 * Header template
 *
 * @package vagra-showcase
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> data-mode="dark">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'vagra-showcase' ); ?>">
    <div class="nav-inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand">
            <span class="brand-mark">V</span>
            <?php echo esc_html( 'vagra' ); ?><span class="brand-dot"><?php echo esc_html( '.ai' ); ?></span>
        </a>

        <div class="nav-links">
            <a href="#themes"><?php esc_html_e( 'Themes', 'vagra-showcase' ); ?></a>
            <a href="#ai"><?php esc_html_e( 'Demos', 'vagra-showcase' ); ?></a>
            <a href="#how"><?php esc_html_e( 'AI', 'vagra-showcase' ); ?></a>
            <a href="#pricing"><?php esc_html_e( 'Pricing', 'vagra-showcase' ); ?></a>
            <a href="#faq"><?php esc_html_e( 'FAQ', 'vagra-showcase' ); ?></a>
            <a href="https://github.com/vagra-ai" target="_blank" rel="noopener">
                <?php echo vagra_icon( 'github', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                <?php esc_html_e( 'GitHub', 'vagra-showcase' ); ?>
            </a>
        </div>

        <div class="nav-cta">
            <a href="#themes" class="btn btn-primary btn-sm">
                <?php esc_html_e( 'Browse themes', 'vagra-showcase' ); ?>
                <?php echo vagra_icon( 'arrow', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
            </a>
        </div>
    </div>
</nav>
