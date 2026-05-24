<?php
/**
 * TGM Plugin Activation — recommended plugins for DriveEase.
 *
 * @package DriveEase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'driveease_register_required_plugins' );

function driveease_register_required_plugins() {
    $plugins = array(
        array(
            'name'     => 'DriveEase Core',
            'slug'     => 'driveease-core',
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
            'name'     => 'One Click Demo Import',
            'slug'     => 'one-click-demo-import',
            'required' => false,
        ),
    );

    $config = array(
        'id'           => 'driveease',
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
