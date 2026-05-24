<?php
/**
 * Demo Import Configuration
 *
 * Hooks into One Click Demo Import plugin to provide demo content.
 *
 * @package House_Service
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Register demo import files.
 */
function hs_demo_import_files() {
    return array(
        array(
            'import_file_name'           => __( 'House Service Demo', 'house-service' ),
            'categories'                 => array( 'Home Services' ),
            'local_import_file'          => get_template_directory() . '/demo-content/demo-content.xml',
            'local_import_customizer_file' => get_template_directory() . '/demo-content/customizer.json',
            'import_preview_image_url'   => HS_URI . '/screenshot.png',
            'preview_url'                => 'https://vagra.ai/house-service',
            'import_notice'              => __( 'This import will set up demo providers, pages, and menus for the House Service theme.', 'house-service' ),
        ),
    );
}
add_filter( 'ocdi/import_files', 'hs_demo_import_files' );

/**
 * After import: set front page, menus, import Elementor templates.
 */
function hs_after_demo_import() {
    // Set front page.
    $front_page = get_page_by_path( 'home' );
    if ( $front_page ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page->ID );
    }

    // Assign primary menu.
    $primary_menu = wp_get_nav_menu_object( 'Primary Menu' );
    if ( $primary_menu ) {
        $locations = get_theme_mod( 'nav_menu_locations', array() );
        $locations['primary'] = $primary_menu->term_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    // Import Elementor templates for the home page.
    if ( $front_page && defined( 'ELEMENTOR_VERSION' ) ) {
        $json_file = get_template_directory() . '/demo-content/elementor/home.json';
        if ( file_exists( $json_file ) ) {
            $data = json_decode( file_get_contents( $json_file ), true );
            if ( $data ) {
                update_post_meta( $front_page->ID, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
                update_post_meta( $front_page->ID, '_elementor_edit_mode', 'builder' );
                update_post_meta( $front_page->ID, '_elementor_template_type', 'wp-page' );
                update_post_meta( $front_page->ID, '_elementor_version', ELEMENTOR_VERSION );
            }
        }
    }
}
add_action( 'ocdi/after_import', 'hs_after_demo_import' );
