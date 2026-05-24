<?php
/**
 * Plugin Name: Vagra Legal Core
 * Plugin URI:  https://vagra.ai
 * Description: Core functionality for Vagra Legal theme — AI chat REST API for legal practice websites.
 * Version:     1.0.0
 * Author:      vagra.ai
 * Author URI:  https://vagra.ai
 * License:     GPL-2.0-or-later
 * Text Domain: vagra-legal
 * Network:     true
 *
 * @package VagraLegal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VAGRA_LEGAL_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'VAGRA_LEGAL_CORE_URL', plugin_dir_url( __FILE__ ) );

// AI Chat REST endpoint.
require_once VAGRA_LEGAL_CORE_DIR . 'inc/class-vagra-chat.php';
new Vagra_Legal_Chat();

// Elementor integration (conditional).
add_action( 'plugins_loaded', function () {
	if ( did_action( 'elementor/loaded' ) ) {
		require_once VAGRA_LEGAL_CORE_DIR . 'inc/class-vagra-legal-elementor.php';
		Vagra_Legal_Elementor::instance();
	}
} );
