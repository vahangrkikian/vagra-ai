<?php
/**
 * TGM Plugin Activation — required and recommended plugins.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'meridian_register_required_plugins' );

/**
 * Register required and recommended plugins via TGM Plugin Activation.
 */
function meridian_register_required_plugins() {
    $plugins = array(
        array(
            'name'     => 'Meridian Core',
            'slug'     => 'meridian-core',
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
        array(
            'name'     => 'Elementor',
            'slug'     => 'elementor',
            'required' => false,
        ),
    );

    tgmpa( $plugins, array(
        'id'          => 'meridian',
        'menu'        => 'tgmpa-install-plugins',
        'parent_slug' => 'themes.php',
    ) );
}
