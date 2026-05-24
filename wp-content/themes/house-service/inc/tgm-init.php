<?php
/**
 * TGM Plugin Activation Configuration
 *
 * Recommends required plugins for the House Service theme.
 *
 * @package House_Service
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Register required and recommended plugins.
 */
function hs_register_required_plugins() {
    // Only register if TGM class is available.
    if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
        return;
    }

    $plugins = array(
        array(
            'name'     => 'House Service Core',
            'slug'     => 'house-service-core',
            'required' => true,
        ),
        array(
            'name'     => 'Advanced Custom Fields PRO',
            'slug'     => 'advanced-custom-fields-pro',
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

    $config = array(
        'id'           => 'house-service',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'   => true,
        'dismissable'  => true,
        'is_automatic' => false,
    );

    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'hs_register_required_plugins' );
