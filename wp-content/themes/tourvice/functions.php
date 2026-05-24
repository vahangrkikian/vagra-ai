<?php
/**
 * TourVice Theme Functions
 *
 * @package TourVice
 * @since 0.2.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'TOURVICE_VERSION', '0.2.0' );
define( 'TOURVICE_DIR', get_template_directory() );
define( 'TOURVICE_URI', get_template_directory_uri() );

// Core theme setup: supports, menus, enqueues.
require_once TOURVICE_DIR . '/inc/theme-setup.php';

// ACF field groups (block fields).
if ( file_exists( TOURVICE_DIR . '/inc/acf-fields.php' ) ) {
    require_once TOURVICE_DIR . '/inc/acf-fields.php';
}

// ACF Gutenberg blocks registration + render callbacks.
if ( file_exists( TOURVICE_DIR . '/inc/blocks.php' ) ) {
    require_once TOURVICE_DIR . '/inc/blocks.php';
}

// Nav Walkers.
if ( file_exists( TOURVICE_DIR . '/inc/class-tourvice-nav-walker.php' ) ) {
    require_once TOURVICE_DIR . '/inc/class-tourvice-nav-walker.php';
}

// TGM Plugin Activation.
if ( file_exists( TOURVICE_DIR . '/inc/tgm-init.php' ) ) {
    require_once TOURVICE_DIR . '/inc/tgm-init.php';
}

// Demo Import.
if ( file_exists( TOURVICE_DIR . '/inc/demo-import.php' ) ) {
    require_once TOURVICE_DIR . '/inc/demo-import.php';
}

// Polylang integration.
if ( file_exists( TOURVICE_DIR . '/inc/polylang-integration.php' ) ) {
    require_once TOURVICE_DIR . '/inc/polylang-integration.php';
}
