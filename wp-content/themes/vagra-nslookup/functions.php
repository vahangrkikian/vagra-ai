<?php
/**
 * Vagra NSLookup Theme Functions
 *
 * @package Vagra_NSLookup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VAGRA_NSL_VERSION', '1.0.2' );

/**
 * Theme setup.
 */
function vagra_nsl_setup() {
	load_theme_textdomain( 'vagra-nslookup', get_template_directory() . '/languages' );

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
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	register_nav_menus( array(
		'primary'          => __( 'Primary Menu', 'vagra-nslookup' ),
		'footer-tools'     => __( 'Footer — Tools', 'vagra-nslookup' ),
		'footer-company'   => __( 'Footer — Company', 'vagra-nslookup' ),
		'footer-discover'  => __( 'Footer — Discover', 'vagra-nslookup' ),
	) );
}
add_action( 'after_setup_theme', 'vagra_nsl_setup' );

/**
 * Enqueue scripts and styles.
 */
function vagra_nsl_scripts() {
	// Google Fonts: Inter + JetBrains Mono
	wp_enqueue_style(
		'vagra-nsl-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// Theme stylesheet
	wp_enqueue_style(
		'vagra-nsl-style',
		get_stylesheet_uri(),
		array( 'vagra-nsl-google-fonts' ),
		VAGRA_NSL_VERSION
	);

	// Theme JavaScript
	wp_enqueue_script(
		'vagra-nsl-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		VAGRA_NSL_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vagra_nsl_scripts' );

/**
 * Register widget areas.
 */
function vagra_nsl_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'vagra-nslookup' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar widget area.', 'vagra-nslookup' ),
		'before_widget' => '<div id="%1$s" class="nsl-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="nsl-widget__title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'vagra-nslookup' ),
		'id'            => 'footer-1',
		'description'   => __( 'Footer widget area.', 'vagra-nslookup' ),
		'before_widget' => '<div id="%1$s" class="nsl-footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="nsl-footer-widget__title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'vagra_nsl_widgets_init' );

/**
 * Content width.
 */
function vagra_nsl_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vagra_nsl_content_width', 1200 );
}
add_action( 'after_setup_theme', 'vagra_nsl_content_width', 0 );

/**
 * Load Customizer settings.
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Load Admin settings page.
 */
require_once get_template_directory() . '/inc/class-vagra-nsl-admin.php';
new Vagra_NSL_Admin();

/**
 * Load Demo Import handler.
 */
require_once get_template_directory() . '/inc/demo-import.php';

/**
 * Enqueue React island scripts on pages that need interactive tools.
 */
function vagra_nsl_enqueue_islands() {
	if ( ! is_front_page() && ! is_page( array( 'ns-lookup', 'propagation', 'contact' ) ) ) {
		return;
	}

	$dist_dir = get_template_directory_uri() . '/assets/js/dist/';

	wp_enqueue_script(
		'vagra-nsl-shared',
		$dist_dir . 'nsl-shared.js',
		array(),
		VAGRA_NSL_VERSION,
		true
	);

	wp_enqueue_script(
		'vagra-nsl-islands',
		$dist_dir . 'nsl-islands.js',
		array( 'vagra-nsl-shared' ),
		VAGRA_NSL_VERSION,
		true
	);

	wp_localize_script( 'vagra-nsl-islands', 'nslConfig', array(
		'restUrl' => esc_url_raw( rest_url() ),
		'nonce'   => wp_create_nonce( 'wp_rest' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'vagra_nsl_enqueue_islands' );

/**
 * Estimate reading time for current post.
 *
 * @return string Formatted reading time, e.g. "7 min read".
 */
function vagra_nsl_reading_time() {
	$content    = get_post_field( 'post_content', get_the_ID() );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = max( 1, (int) ceil( $word_count / 250 ) );
	/* translators: %d: number of minutes */
	return sprintf( _n( '%d min read', '%d min read', $minutes, 'vagra-nslookup' ), $minutes );
}

// TGM Plugin Activation — recommended plugins.
require_once get_template_directory() . '/inc/tgm-init.php';

// Polylang multilingual integration.
require_once get_template_directory() . '/inc/polylang-integration.php';
