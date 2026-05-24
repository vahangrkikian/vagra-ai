<?php
/**
 * Plugin Name: DriveEase Core
 * Plugin URI:  https://vagra.ai/driveease
 * Description: Core functionality for the DriveEase car rental theme — Custom Post Types, booking system, availability API, reviews, email notifications, and AI chat.
 * Version:     1.0.0
 * Author:      vagra.ai
 * Author URI:  https://vagra.ai
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: driveease
 * Domain Path: /languages
 * Network:     true
 *
 * @package DriveEase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DRIVEEASE_CORE_VERSION', '1.0.0' );
define( 'DRIVEEASE_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'DRIVEEASE_CORE_URL', plugin_dir_url( __FILE__ ) );

/* ------------------------------------------------------------------
 * Custom Post Types & Taxonomy
 * ----------------------------------------------------------------*/
require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-cars.php';
require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-bookings.php';
require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-branches.php';

/* ------------------------------------------------------------------
 * Email notifications (cron + templates)
 * ----------------------------------------------------------------*/
require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-emails.php';
DriveEase_Emails::init();

/* ------------------------------------------------------------------
 * Booking AJAX handler & REST availability API
 * ----------------------------------------------------------------*/
require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-booking-handler.php';

/* ------------------------------------------------------------------
 * Reviews / ratings system
 * ----------------------------------------------------------------*/
require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-reviews.php';

/* ------------------------------------------------------------------
 * AI Chat REST endpoint
 * ----------------------------------------------------------------*/
require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-chat.php';

/* ------------------------------------------------------------------
 * Contact form AJAX handler
 * ----------------------------------------------------------------*/
require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-contact.php';

/* ------------------------------------------------------------------
 * Elementor integration (loaded when Elementor is active)
 * ----------------------------------------------------------------*/
require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-elementor.php';
DriveEase_Elementor::instance();

/* ------------------------------------------------------------------
 * Admin meta boxes (loaded only in admin)
 * ----------------------------------------------------------------*/
if ( is_admin() ) {
	require_once DRIVEEASE_CORE_DIR . 'inc/class-driveease-admin.php';
}

/* ------------------------------------------------------------------
 * Fleet archive: 12 cars per page
 * ----------------------------------------------------------------*/
function driveease_core_fleet_archive_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'driveease_car' ) ) {
		$query->set( 'posts_per_page', 12 );
	}
}
add_action( 'pre_get_posts', 'driveease_core_fleet_archive_per_page' );

/* ------------------------------------------------------------------
 * Activation / Deactivation
 * ----------------------------------------------------------------*/
register_activation_hook( __FILE__, function () {
	// Ensure CPTs are registered before flushing.
	DriveEase_Cars::register_post_type();
	DriveEase_Bookings::register_post_type();
	DriveEase_Branches::register_post_type();
	flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function () {
	DriveEase_Emails::deactivate();
	flush_rewrite_rules();
} );
