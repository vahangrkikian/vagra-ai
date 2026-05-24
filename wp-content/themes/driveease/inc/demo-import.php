<?php
/**
 * Demo Import — one-click import handler under Appearance > Import Demo.
 *
 * Uses the One Click Demo Import (OCDI) plugin pattern per WordPress.org
 * guidelines. Does NOT auto-install content.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin notice recommending the OCDI plugin when it is not active.
 */
function driveease_demo_import_notice() {
	if ( ! current_user_can( 'import' ) ) {
		return;
	}

	if ( get_option( 'driveease_demo_notice_dismissed', false ) ) {
		return;
	}

	// Don't show if OCDI is already active.
	if ( class_exists( 'OCDI_Plugin' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'themes' !== $screen->id ) {
		return;
	}
	?>
	<div class="notice notice-info is-dismissible driveease-demo-notice">
		<p>
			<?php
			printf(
				/* translators: %s: link to install One Click Demo Import plugin */
				esc_html__( 'DriveEase: Want to import demo content? Install the %s plugin, then go to Appearance > Import Demo Data.', 'driveease' ),
				'<a href="' . esc_url( admin_url( 'plugin-install.php?s=one+click+demo+import&tab=search&type=term' ) ) . '">One Click Demo Import</a>'
			);
			?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'driveease_demo_import_notice' );

/**
 * AJAX handler to dismiss the demo import notice.
 */
function driveease_dismiss_demo_notice() {
	check_ajax_referer( 'driveease_dismiss_demo', 'nonce' );

	if ( ! current_user_can( 'import' ) ) {
		wp_send_json_error();
	}

	update_option( 'driveease_demo_notice_dismissed', true );
	wp_send_json_success();
}
add_action( 'wp_ajax_driveease_dismiss_demo_notice', 'driveease_dismiss_demo_notice' );

/**
 * Enqueue dismiss-notice script on the themes page.
 *
 * @param string $hook Current admin page.
 */
function driveease_demo_notice_script( $hook ) {
	if ( 'themes.php' !== $hook ) {
		return;
	}

	if ( class_exists( 'OCDI_Plugin' ) || get_option( 'driveease_demo_notice_dismissed', false ) ) {
		return;
	}

	wp_add_inline_script(
		'common',
		"jQuery(document).on('click','.driveease-demo-notice .notice-dismiss',function(){jQuery.post(ajaxurl,{action:'driveease_dismiss_demo_notice',nonce:'" . wp_create_nonce( 'driveease_dismiss_demo' ) . "'});});"
	);
}
add_action( 'admin_enqueue_scripts', 'driveease_demo_notice_script' );

/**
 * Register demo import files for the OCDI plugin.
 *
 * @return array Demo import configurations.
 */
function driveease_ocdi_import_files( $demos = array() ) {
	$demos[] = array(
		'import_file_name'             => esc_html__( 'Classic — PHP Templates', 'driveease' ),
		'local_import_file'            => DRIVEEASE_DIR . '/demo-content/demo-content.xml',
		'local_import_customizer_file' => DRIVEEASE_DIR . '/demo-content/customizer.json',
		'import_notice'                => esc_html__( 'Standard import using theme PHP templates. Works without any page builder.', 'driveease' ),
	);

	// Add Elementor demo only when Elementor is active.
	if ( did_action( 'elementor/loaded' ) ) {
		$demos[] = array(
			'import_file_name'             => esc_html__( 'Elementor — Visual Builder', 'driveease' ),
			'local_import_file'            => DRIVEEASE_DIR . '/demo-content/demo-content.xml',
			'local_import_customizer_file' => DRIVEEASE_DIR . '/demo-content/customizer.json',
			'import_notice'                => esc_html__( 'Imports the same pages, then converts Home, About, and Contact to Elementor with custom DriveEase widgets. All sections become editable in the visual builder.', 'driveease' ),
		);
	}

	return $demos;
}
add_filter( 'ocdi/import_files', 'driveease_ocdi_import_files' );

/**
 * After-import setup: assign front page, primary menu, and remap gallery IDs.
 */
function driveease_ocdi_after_import( $selected_import = array() ) {
	// Set static front page and blog page.
	$front_page = get_page_by_path( 'home' );
	if ( $front_page ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page->ID );
	}

	$blog_page = get_page_by_path( 'blog' );
	if ( $blog_page ) {
		update_option( 'page_for_posts', $blog_page->ID );
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

	// Rebuild car gallery meta from child attachments.
	// OCDI remaps IDs during import, so serialized _car_gallery arrays
	// contain stale IDs. Rebuild from the parent->child relationship.
	$cars = get_posts(
		array(
			'post_type'      => 'driveease_car',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'fields'         => 'ids',
		)
	);

	foreach ( $cars as $car_id ) {
		$thumb_id = get_post_thumbnail_id( $car_id );

		$attachments = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_parent'    => $car_id,
				'posts_per_page' => -1,
				'post_status'    => 'inherit',
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => 'ids',
			)
		);

		$gallery = array();
		foreach ( $attachments as $att_id ) {
			if ( (int) $att_id !== (int) $thumb_id ) {
				$gallery[] = (int) $att_id;
			}
		}

		if ( ! empty( $gallery ) ) {
			update_post_meta( $car_id, '_car_gallery', $gallery );
		}
	}

	// Handle Elementor import: inject Elementor data from JSON files.
	$import_name = isset( $selected_import['import_file_name'] ) ? $selected_import['import_file_name'] : '';
	if ( stripos( $import_name, 'Elementor' ) !== false && did_action( 'elementor/loaded' ) ) {
		$elementor_dir   = get_template_directory() . '/demo-content/elementor/';
		$elementor_pages = array(
			'Home'       => 'home.json',
			'About'      => 'about.json',
			'Contact'    => 'contact.json',
			'Contact Us' => 'contact.json',
			'About Us'   => 'about.json',
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
add_action( 'ocdi/after_import', 'driveease_ocdi_after_import' );
