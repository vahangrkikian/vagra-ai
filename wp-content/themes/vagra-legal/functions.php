<?php
/**
 * Vagra Legal Theme Functions
 *
 * @package Vagra_Legal
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'VAGRA_LEGAL_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function vagra_legal_setup() {
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

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'vagra-legal' ),
        'footer'  => __( 'Footer Menu', 'vagra-legal' ),
    ) );
}
add_action( 'after_setup_theme', 'vagra_legal_setup' );

/**
 * Enqueue scripts and styles.
 */
function vagra_legal_scripts() {
    wp_enqueue_style(
        'vagra-legal-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'vagra-legal-style',
        get_stylesheet_uri(),
        array( 'vagra-legal-google-fonts' ),
        VAGRA_LEGAL_VERSION
    );

    wp_enqueue_script(
        'vagra-legal-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        VAGRA_LEGAL_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'vagra_legal_scripts' );

/**
 * Register widget areas.
 */
function vagra_legal_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'vagra-legal' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Main sidebar widget area.', 'vagra-legal' ),
        'before_widget' => '<div id="%1$s" class="vagra-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="vagra-widget__title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Column 1', 'vagra-legal' ),
        'id'            => 'footer-1',
        'description'   => __( 'Footer widget area — column 1.', 'vagra-legal' ),
        'before_widget' => '<div id="%1$s" class="vagra-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="vagra-footer-widget__title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Column 2', 'vagra-legal' ),
        'id'            => 'footer-2',
        'description'   => __( 'Footer widget area — column 2.', 'vagra-legal' ),
        'before_widget' => '<div id="%1$s" class="vagra-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="vagra-footer-widget__title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Column 3', 'vagra-legal' ),
        'id'            => 'footer-3',
        'description'   => __( 'Footer widget area — column 3.', 'vagra-legal' ),
        'before_widget' => '<div id="%1$s" class="vagra-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="vagra-footer-widget__title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Column 4', 'vagra-legal' ),
        'id'            => 'footer-4',
        'description'   => __( 'Footer widget area — column 4.', 'vagra-legal' ),
        'before_widget' => '<div id="%1$s" class="vagra-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="vagra-footer-widget__title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'vagra_legal_widgets_init' );

/**
 * Content width.
 */
function vagra_legal_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'vagra_legal_content_width', 1200 );
}
add_action( 'after_setup_theme', 'vagra_legal_content_width', 0 );

/**
 * Load AI Chat component.
 */
require_once get_template_directory() . '/inc/class-vagra-chat.php';
new Vagra_Legal_Chat();

/**
 * Customizer settings.
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Admin settings page, dashboard widget, and options.
 */
if ( is_admin() ) {
    require_once get_template_directory() . '/inc/class-vagra-admin.php';
    new Vagra_Legal_Admin();
}

/**
 * Demo import support.
 */
require_once get_template_directory() . '/inc/demo-import.php';
