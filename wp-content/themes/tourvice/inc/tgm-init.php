<?php
/**
 * TGM Plugin Activation — recommended plugins for TourVice.
 *
 * @package TourVice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'tourvice_register_required_plugins' );

/**
 * Register required and recommended plugins.
 */
function tourvice_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => 'TourVice Core',
			'slug'     => 'tourvice-core',
			'required' => true,
		),
		array(
			'name'     => 'Polylang',
			'slug'     => 'polylang',
			'required' => false,
		),
		array(
			'name'     => 'Loco Translate',
			'slug'     => 'loco-translate',
			'required' => false,
		),
		array(
			'name'     => 'Elementor',
			'slug'     => 'elementor',
			'required' => false,
		),
		array(
			'name'     => 'One Click Demo Import',
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'tourvice',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'   => true,
		'dismissable'  => true,
		'is_automatic' => false,
	);

	tgmpa( $plugins, $config );
}
