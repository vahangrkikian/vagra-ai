<?php
/**
 * Plugin Name: Vagra NSLookup Core
 * Plugin URI:  https://nslookup.am
 * Description: Core functionality for Vagra NSLookup theme — DNS lookup/propagation REST API, page meta boxes, and AI chat.
 * Version:     1.0.0
 * Author:      vagra.ai
 * Author URI:  https://vagra.ai
 * License:     GPL-2.0-or-later
 * Text Domain: vagra-nslookup
 * Network:     true
 *
 * @package VagraNSLookup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VAGRA_NSL_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'VAGRA_NSL_CORE_URL', plugin_dir_url( __FILE__ ) );

// DNS Lookup & Propagation REST API.
require_once VAGRA_NSL_CORE_DIR . 'inc/class-vagra-nsl-dns.php';

// AI Chat REST endpoint.
require_once VAGRA_NSL_CORE_DIR . 'inc/class-vagra-nsl-chat.php';

// Page template meta boxes.
require_once VAGRA_NSL_CORE_DIR . 'inc/meta-boxes.php';

// Elementor integration (loads only when Elementor is active).
add_action( 'plugins_loaded', function () {
    if ( did_action( 'elementor/loaded' ) ) {
        require_once VAGRA_NSL_CORE_DIR . 'inc/class-vagra-nsl-elementor.php';
        Vagra_NSL_Elementor::instance();
    }
} );
