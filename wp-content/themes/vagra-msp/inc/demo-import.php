<?php
/**
 * Demo Import - Recommends One Click Demo Import plugin
 *
 * Uses the recommended plugin pattern per WordPress.org guidelines.
 * Does NOT auto-install content.
 *
 * @package Vagra_MSP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add admin notice recommending demo import plugin.
 */
function vagra_msp_demo_import_notice() {
    if ( ! current_user_can( 'import' ) ) {
        return;
    }

    $dismissed = get_option( 'vagra_msp_demo_notice_dismissed', false );
    if ( $dismissed ) {
        return;
    }

    // Don't show if OCDI is already active
    if ( class_exists( 'OCDI_Plugin' ) ) {
        return;
    }

    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'themes' ) {
        return;
    }
    ?>
    <div class="notice notice-info is-dismissible vagra-msp-demo-notice">
        <p>
            <?php
            printf(
                /* translators: %s: link to install One Click Demo Import plugin */
                esc_html__( 'Vagra MSP Cybersecurity: Want to import demo content? Install the %s plugin, then go to Appearance > Import Demo Data.', 'vagra-msp' ),
                '<a href="' . esc_url( admin_url( 'plugin-install.php?s=one+click+demo+import&tab=search&type=term' ) ) . '">One Click Demo Import</a>'
            );
            ?>
        </p>
    </div>
    <?php
}
add_action( 'admin_notices', 'vagra_msp_demo_import_notice' );

/**
 * Register demo import files for OCDI plugin.
 *
 * @param array $demos Existing demo configurations.
 * @return array
 */
function vagra_msp_ocdi_import_files( $demos ) {
    $demos[] = array(
        'import_file_name'   => __( 'ShieldNet MSP Demo', 'vagra-msp' ),
        'local_import_file'  => get_template_directory() . '/demo-content/demo-content.xml',
        'import_notice'      => __( 'This will import pages, posts, and settings for the ShieldNet MSP demo site.', 'vagra-msp' ),
    );
    return $demos;
}
add_filter( 'ocdi/import_files', 'vagra_msp_ocdi_import_files' );

/**
 * After import: set front page and menus.
 */
function vagra_msp_ocdi_after_import() {
    // Set static front page
    $front_page = get_page_by_path( 'home' );
    if ( $front_page ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page->ID );
    }

    // Set blog page if it exists
    $blog_page = get_page_by_path( 'blog' );
    if ( $blog_page ) {
        update_option( 'page_for_posts', $blog_page->ID );
    }

    // Assign primary menu
    $primary_menu = wp_get_nav_menu_object( 'Primary' );
    if ( $primary_menu ) {
        $locations = get_theme_mod( 'nav_menu_locations', array() );
        $locations['primary'] = $primary_menu->term_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
add_action( 'ocdi/after_import', 'vagra_msp_ocdi_after_import' );
