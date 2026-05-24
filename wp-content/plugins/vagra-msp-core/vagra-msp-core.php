<?php
/**
 * Plugin Name: Vagra MSP Core
 * Plugin URI:  https://vagra.ai
 * Description: Core functionality for Vagra MSP Cybersecurity theme — DNS propagation checker REST API and AI chat.
 * Version:     1.0.0
 * Author:      vagra.ai
 * Author URI:  https://vagra.ai
 * License:     GPL-2.0-or-later
 * Text Domain: vagra-msp
 * Network:     true
 *
 * @package VagraMSP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VAGRA_MSP_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'VAGRA_MSP_CORE_URL', plugin_dir_url( __FILE__ ) );

// DNS Propagation REST API.
require_once VAGRA_MSP_CORE_DIR . 'inc/class-vagra-dns-propagation.php';

// AI Chat REST endpoint.
require_once VAGRA_MSP_CORE_DIR . 'inc/class-vagra-chat.php';

// Elementor integration.
add_action( 'plugins_loaded', function () {
    if ( did_action( 'elementor/loaded' ) ) {
        require_once VAGRA_MSP_CORE_DIR . 'inc/class-vagra-msp-elementor.php';
        Vagra_MSP_Elementor::instance();
    }
} );
