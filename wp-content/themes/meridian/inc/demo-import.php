<?php
/**
 * Demo Import — one-click import handler under Appearance > Import Demo.
 *
 * Uses the One Click Demo Import (OCDI) plugin pattern per WordPress.org
 * guidelines. Does NOT auto-install content.
 *
 * @package Meridian
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Admin notice recommending the OCDI plugin when it is not active.
 */
function meridian_demo_import_notice() {
    if ( ! current_user_can( 'import' ) ) {
        return;
    }

    if ( get_option( 'meridian_demo_notice_dismissed', false ) ) {
        return;
    }

    if ( class_exists( 'OCDI_Plugin' ) ) {
        return;
    }

    $screen = get_current_screen();
    if ( ! $screen || 'themes' !== $screen->id ) {
        return;
    }
    ?>
    <div class="notice notice-info is-dismissible meridian-demo-notice">
        <p>
            <?php
            printf(
                /* translators: %s: link to install One Click Demo Import plugin */
                esc_html__( 'Meridian: Want to import demo content? Install the %s plugin, then go to Appearance > Import Demo Data.', 'meridian' ),
                '<a href="' . esc_url( admin_url( 'plugin-install.php?s=one+click+demo+import&tab=search&type=term' ) ) . '">One Click Demo Import</a>'
            );
            ?>
        </p>
    </div>
    <?php
}
add_action( 'admin_notices', 'meridian_demo_import_notice' );

/**
 * AJAX handler to dismiss the demo import notice.
 */
function meridian_dismiss_demo_notice() {
    check_ajax_referer( 'meridian_dismiss_demo', 'nonce' );

    if ( ! current_user_can( 'import' ) ) {
        wp_send_json_error();
    }

    update_option( 'meridian_demo_notice_dismissed', true );
    wp_send_json_success();
}
add_action( 'wp_ajax_meridian_dismiss_demo_notice', 'meridian_dismiss_demo_notice' );

/**
 * Enqueue dismiss-notice script on the themes page.
 *
 * @param string $hook Current admin page.
 */
function meridian_demo_notice_script( $hook ) {
    if ( 'themes.php' !== $hook ) {
        return;
    }

    if ( class_exists( 'OCDI_Plugin' ) || get_option( 'meridian_demo_notice_dismissed', false ) ) {
        return;
    }

    wp_add_inline_script(
        'common',
        "jQuery(document).on('click','.meridian-demo-notice .notice-dismiss',function(){jQuery.post(ajaxurl,{action:'meridian_dismiss_demo_notice',nonce:'" . wp_create_nonce( 'meridian_dismiss_demo' ) . "'});});"
    );
}
add_action( 'admin_enqueue_scripts', 'meridian_demo_notice_script' );

/**
 * Register demo import files for the OCDI plugin.
 *
 * @return array Demo import configurations.
 */
function meridian_ocdi_import_files() {
    return array(
        array(
            'import_file_name'             => esc_html__( 'Meridian Demo', 'meridian' ),
            'local_import_file'            => get_template_directory() . '/demo-content/demo-content.xml',
            'local_import_customizer_file' => get_template_directory() . '/demo-content/customizer.json',
            'import_notice'                => esc_html__( 'This will import rooms, pages, menus, and sample data for The Meridian demo site.', 'meridian' ),
        ),
    );
}
add_filter( 'ocdi/import_files', 'meridian_ocdi_import_files' );

/**
 * After-import setup: assign front page and menus.
 */
function meridian_ocdi_after_import() {
    // Set static front page.
    $front_page = get_page_by_path( 'home' );
    if ( $front_page ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page->ID );
    }

    // Assign page templates to key pages.
    $page_templates = array(
        'about'    => 'page-about.php',
        'gallery'  => 'page-gallery.php',
        'location' => 'page-location.php',
    );
    foreach ( $page_templates as $slug => $template ) {
        $page = get_page_by_path( $slug );
        if ( $page ) {
            update_post_meta( $page->ID, '_wp_page_template', $template );
        }
    }

    // Assign menus to theme locations.
    $locations = get_theme_mod( 'nav_menu_locations', array() );

    $primary_menu = wp_get_nav_menu_object( 'Primary' );
    if ( $primary_menu ) {
        $locations['primary'] = $primary_menu->term_id;
    }

    $footer_menu = wp_get_nav_menu_object( 'Footer' );
    if ( $footer_menu ) {
        $locations['footer'] = $footer_menu->term_id;
    }

    set_theme_mod( 'nav_menu_locations', $locations );

    // Flush rewrite rules after import.
    flush_rewrite_rules();
}
add_action( 'ocdi/after_import', 'meridian_ocdi_after_import' );
