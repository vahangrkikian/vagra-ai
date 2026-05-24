<?php
/**
 * Carvice Theme Functions
 *
 * AI-assisted car service marketplace for Armenia, Russia, and Kazakhstan.
 *
 * @package Carvice
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CARVICE_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function carvice_setup() {
    load_theme_textdomain( 'carvice', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );

    // Image sizes for provider cards and galleries.
    add_image_size( 'carvice-card', 400, 300, true );
    add_image_size( 'carvice-gallery', 800, 600, true );
    add_image_size( 'carvice-hero', 1440, 600, true );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'carvice' ),
        'footer'  => __( 'Footer Menu', 'carvice' ),
    ) );
}
add_action( 'after_setup_theme', 'carvice_setup' );

/**
 * Fallback callback for the primary menu when no menu is assigned.
 */
function carvice_primary_menu_fallback() {
	$items = array(
		array( 'url' => home_url( '/' ), 'label' => __( 'Home', 'carvice' ) ),
		array( 'url' => home_url( '/search/' ), 'label' => __( 'Search Providers', 'carvice' ) ),
		array( 'url' => home_url( '/about/' ), 'label' => __( 'About', 'carvice' ) ),
		array( 'url' => home_url( '/contact/' ), 'label' => __( 'Contact', 'carvice' ) ),
	);
	echo '<ul class="carvice-nav__list">';
	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item"><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Fallback callback for the footer menu when no menu is assigned.
 */
function carvice_footer_menu_fallback() {
	$items = array(
		array( 'url' => home_url( '/about/' ), 'label' => __( 'About', 'carvice' ) ),
		array( 'url' => home_url( '/faq/' ), 'label' => __( 'FAQ', 'carvice' ) ),
		array( 'url' => home_url( '/contact/' ), 'label' => __( 'Contact', 'carvice' ) ),
	);
	echo '<ul class="carvice-footer__menu">';
	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item"><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Enqueue styles and scripts.
 */
function carvice_enqueue_assets() {
    // Google Fonts: Inter (Latin + Cyrillic).
    wp_enqueue_style(
        'carvice-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap&subset=latin,cyrillic',
        array(),
        null
    );

    wp_enqueue_style(
        'carvice-style',
        get_stylesheet_uri(),
        array( 'carvice-google-fonts' ),
        CARVICE_VERSION
    );

    // Tab switching JS (registration page).
    if ( is_page_template( 'page-register.php' ) ) {
        wp_enqueue_script(
            'carvice-tabs',
            get_template_directory_uri() . '/assets/js/carvice-tabs.js',
            array(),
            CARVICE_VERSION,
            true
        );
    }

    // Filter pills JS (front page).
    if ( is_front_page() ) {
        wp_enqueue_script(
            'carvice-filters',
            get_template_directory_uri() . '/assets/js/carvice-filters.js',
            array(),
            CARVICE_VERSION,
            true
        );
        wp_localize_script( 'carvice-filters', 'carviceFilters', array(
            'restUrl' => esc_url_raw( rest_url() ),
            'nonce'   => wp_create_nonce( 'wp_rest' ),
        ) );
    }

    // Gallery JS (single provider page).
    if ( is_singular( 'carvice_provider' ) ) {
        wp_enqueue_script(
            'carvice-gallery',
            get_template_directory_uri() . '/assets/js/carvice-gallery.js',
            array(),
            CARVICE_VERSION,
            true
        );

        wp_enqueue_script(
            'carvice-reviews',
            get_template_directory_uri() . '/assets/js/carvice-reviews.js',
            array(),
            CARVICE_VERSION,
            true
        );
    }

    // AI Chat widget (site-wide via footer.php).
    wp_enqueue_style(
        'carvice-chat',
        get_template_directory_uri() . '/assets/css/carvice-chat.css',
        array( 'carvice-style' ),
        CARVICE_VERSION
    );

    wp_enqueue_script(
        'carvice-chat',
        get_template_directory_uri() . '/assets/js/carvice-chat.js',
        array(),
        CARVICE_VERSION,
        true
    );
    wp_localize_script( 'carvice-chat', 'carviceChat', array(
        'restUrl' => esc_url_raw( rest_url( 'carvice/v1/chat' ) ),
        'nonce'   => wp_create_nonce( 'wp_rest' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'carvice_enqueue_assets' );

// Demo import (OCDI).
require_once get_template_directory() . '/inc/demo-import.php';

// TGM Plugin Activation — recommended plugins (including Carvice Core).
require_once get_template_directory() . '/inc/tgm-init.php';

// Polylang multilingual integration.
require_once get_template_directory() . '/inc/polylang-integration.php';
