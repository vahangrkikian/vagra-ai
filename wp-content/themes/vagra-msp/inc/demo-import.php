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
        'import_file_name'   => __( 'Classic — PHP Templates', 'vagra-msp' ),
        'local_import_file'  => get_template_directory() . '/demo-content/demo-content.xml',
        'import_notice'      => __( 'Standard import using theme PHP templates. Works without any page builder.', 'vagra-msp' ),
    );

    // Add Elementor demo only when Elementor is active.
    if ( did_action( 'elementor/loaded' ) ) {
        $demos[] = array(
            'import_file_name'   => __( 'Elementor — Visual Builder', 'vagra-msp' ),
            'local_import_file'  => get_template_directory() . '/demo-content/demo-content.xml',
            'import_notice'      => __( 'Imports the same pages, then converts Home, About, and Contact to Elementor with custom MSP widgets. All sections become editable in the visual builder.', 'vagra-msp' ),
        );
    }

    return $demos;
}
add_filter( 'ocdi/import_files', 'vagra_msp_ocdi_import_files' );

/**
 * After import: set front page and menus.
 */
function vagra_msp_ocdi_after_import( $selected_import ) {
    // Set static front page.
    $front_page = get_page_by_path( 'home' );
    if ( $front_page ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page->ID );
    }

    // Set blog page if it exists.
    $blog_page = get_page_by_path( 'blog' );
    if ( $blog_page ) {
        update_option( 'page_for_posts', $blog_page->ID );
    }

    // Assign primary menu.
    $primary_menu = wp_get_nav_menu_object( 'Primary' );
    if ( $primary_menu ) {
        $locations = get_theme_mod( 'nav_menu_locations', array() );
        $locations['primary'] = $primary_menu->term_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    // Handle Elementor import: inject Elementor data from JSON files.
    $import_name = isset( $selected_import['import_file_name'] ) ? $selected_import['import_file_name'] : '';
    if ( stripos( $import_name, 'Elementor' ) !== false && did_action( 'elementor/loaded' ) ) {
        $elementor_dir   = get_template_directory() . '/demo-content/elementor/';
        $elementor_pages = array(
            'Home'       => 'home.json',
            'About'      => 'about.json',
            'Contact Us' => 'contact.json',
        );
        $elementor_ver = defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.0.0';

        foreach ( $elementor_pages as $title => $json_file ) {
            $page = get_page_by_title( $title );
            $file = $elementor_dir . $json_file;
            if ( $page && file_exists( $file ) ) {
                $raw     = file_get_contents( $file );
                $decoded = json_decode( $raw, true );
                if ( is_array( $decoded ) ) {
                    $compact = wp_json_encode( $decoded );
                    update_post_meta( $page->ID, '_elementor_data', wp_slash( $compact ) );
                    update_post_meta( $page->ID, '_elementor_edit_mode', 'builder' );
                    update_post_meta( $page->ID, '_wp_page_template', 'elementor_header_footer' );
                    update_post_meta( $page->ID, '_elementor_version', $elementor_ver );
                    update_post_meta( $page->ID, '_elementor_css', '' );
                }
            }
        }

        // Clear Elementor CSS cache.
        if ( class_exists( '\Elementor\Plugin' ) ) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();
        }
    }

    flush_rewrite_rules();
}
add_action( 'ocdi/after_import', 'vagra_msp_ocdi_after_import' );
