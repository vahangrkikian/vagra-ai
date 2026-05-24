<?php
/**
 * Plugin Name: TourVice Core
 * Plugin URI:  https://vagra.ai/tourvice
 * Description: Core functionality for the TourVice luxury tourism theme — Custom Post Types, booking system, REST API, and AI chat.
 * Version:     1.0.0
 * Author:      vagra.ai
 * Author URI:  https://vagra.ai
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tourvice
 * Domain Path: /languages
 * Network:     true
 *
 * @package TourVice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TOURVICE_CORE_VERSION', '1.0.0' );
define( 'TOURVICE_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'TOURVICE_CORE_URL', plugin_dir_url( __FILE__ ) );

/* ------------------------------------------------------------------
 * Custom Post Types & Taxonomies
 * ----------------------------------------------------------------*/
add_action( 'init', 'tourvice_register_tour_cpt' );
add_action( 'init', 'tourvice_register_booking_cpt' );
add_action( 'init', 'tourvice_register_taxonomies' );

/* ------------------------------------------------------------------
 * Meta Boxes (admin only)
 * ----------------------------------------------------------------*/
if ( is_admin() ) {
	add_action( 'add_meta_boxes', 'tourvice_register_meta_boxes' );
	add_action( 'save_post_vagra_tour', 'tourvice_save_tour_meta' );
	add_action( 'save_post_vagra_booking', 'tourvice_save_booking_meta' );

	// Admin columns — Tours.
	add_filter( 'manage_vagra_tour_posts_columns', 'tourvice_tour_columns' );
	add_action( 'manage_vagra_tour_posts_custom_column', 'tourvice_tour_column_content', 10, 2 );

	// Admin columns — Bookings.
	add_filter( 'manage_vagra_booking_posts_columns', 'tourvice_booking_columns' );
	add_action( 'manage_vagra_booking_posts_custom_column', 'tourvice_booking_column_content', 10, 2 );
}

/* ------------------------------------------------------------------
 * AI Chat REST endpoint
 * ----------------------------------------------------------------*/
require_once TOURVICE_CORE_DIR . 'inc/class-tourvice-chat.php';

/* ------------------------------------------------------------------
 * Booking AJAX handler
 * ----------------------------------------------------------------*/
require_once TOURVICE_CORE_DIR . 'inc/class-tourvice-booking.php';

/* ------------------------------------------------------------------
 * REST API endpoints
 * ----------------------------------------------------------------*/
require_once TOURVICE_CORE_DIR . 'inc/class-tourvice-rest.php';

/* ------------------------------------------------------------------
 * Tour Reviews (star-rating on comments)
 * ----------------------------------------------------------------*/
require_once TOURVICE_CORE_DIR . 'inc/class-tourvice-reviews.php';

/* ------------------------------------------------------------------
 * Elementor Integration
 * ----------------------------------------------------------------*/
require_once TOURVICE_CORE_DIR . 'inc/class-tourvice-elementor.php';
TourVice_Elementor::instance();

/* ------------------------------------------------------------------
 * Tour archive: 12 tours per page
 * ----------------------------------------------------------------*/
function tourvice_archive_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'vagra_tour' ) ) {
		$query->set( 'posts_per_page', 12 );
	}
}
add_action( 'pre_get_posts', 'tourvice_archive_per_page' );

/* ------------------------------------------------------------------
 * Activation / Deactivation
 * ----------------------------------------------------------------*/
register_activation_hook( __FILE__, function () {
	tourvice_register_tour_cpt();
	tourvice_register_booking_cpt();
	tourvice_register_taxonomies();
	flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function () {
	flush_rewrite_rules();
} );

/* ==================================================================
 * CPT: vagra_tour
 * ================================================================*/

/**
 * Register the vagra_tour CPT.
 */
function tourvice_register_tour_cpt() {
	$labels = array(
		'name'                  => esc_html_x( 'Tours', 'Post type general name', 'tourvice' ),
		'singular_name'         => esc_html_x( 'Tour', 'Post type singular name', 'tourvice' ),
		'menu_name'             => esc_html__( 'Tours', 'tourvice' ),
		'name_admin_bar'        => esc_html__( 'Tour', 'tourvice' ),
		'add_new'               => esc_html__( 'Add New', 'tourvice' ),
		'add_new_item'          => esc_html__( 'Add New Tour', 'tourvice' ),
		'new_item'              => esc_html__( 'New Tour', 'tourvice' ),
		'edit_item'             => esc_html__( 'Edit Tour', 'tourvice' ),
		'view_item'             => esc_html__( 'View Tour', 'tourvice' ),
		'all_items'             => esc_html__( 'All Tours', 'tourvice' ),
		'search_items'          => esc_html__( 'Search Tours', 'tourvice' ),
		'not_found'             => esc_html__( 'No tours found.', 'tourvice' ),
		'not_found_in_trash'    => esc_html__( 'No tours found in Trash.', 'tourvice' ),
		'featured_image'        => esc_html__( 'Tour Image', 'tourvice' ),
		'set_featured_image'    => esc_html__( 'Set tour image', 'tourvice' ),
		'remove_featured_image' => esc_html__( 'Remove tour image', 'tourvice' ),
		'use_featured_image'    => esc_html__( 'Use as tour image', 'tourvice' ),
		'archives'              => esc_html__( 'Tours', 'tourvice' ),
		'filter_items_list'     => esc_html__( 'Filter tours list', 'tourvice' ),
		'items_list'            => esc_html__( 'Tours list', 'tourvice' ),
		'items_list_navigation' => esc_html__( 'Tours list navigation', 'tourvice' ),
	);

	$args = array(
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => true,
		'show_in_rest' => true,
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon'    => 'dashicons-palmtree',
		'rewrite'      => array( 'slug' => 'tour' ),
	);

	register_post_type( 'vagra_tour', $args );
}

/* ==================================================================
 * CPT: vagra_booking
 * ================================================================*/

/**
 * Register the vagra_booking CPT.
 */
function tourvice_register_booking_cpt() {
	$labels = array(
		'name'                  => esc_html_x( 'Bookings', 'Post type general name', 'tourvice' ),
		'singular_name'         => esc_html_x( 'Booking', 'Post type singular name', 'tourvice' ),
		'menu_name'             => esc_html__( 'Bookings', 'tourvice' ),
		'name_admin_bar'        => esc_html__( 'Booking', 'tourvice' ),
		'add_new'               => esc_html__( 'Add New', 'tourvice' ),
		'add_new_item'          => esc_html__( 'Add New Booking', 'tourvice' ),
		'new_item'              => esc_html__( 'New Booking', 'tourvice' ),
		'edit_item'             => esc_html__( 'Edit Booking', 'tourvice' ),
		'view_item'             => esc_html__( 'View Booking', 'tourvice' ),
		'all_items'             => esc_html__( 'All Bookings', 'tourvice' ),
		'search_items'          => esc_html__( 'Search Bookings', 'tourvice' ),
		'not_found'             => esc_html__( 'No bookings found.', 'tourvice' ),
		'not_found_in_trash'    => esc_html__( 'No bookings found in Trash.', 'tourvice' ),
		'filter_items_list'     => esc_html__( 'Filter bookings list', 'tourvice' ),
		'items_list'            => esc_html__( 'Bookings list', 'tourvice' ),
		'items_list_navigation' => esc_html__( 'Bookings list navigation', 'tourvice' ),
	);

	$args = array(
		'labels'       => $labels,
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'supports'     => array( 'title' ),
		'menu_icon'    => 'dashicons-calendar-alt',
	);

	register_post_type( 'vagra_booking', $args );
}

/* ==================================================================
 * Taxonomies
 * ================================================================*/

/**
 * Register taxonomies for vagra_tour.
 */
function tourvice_register_taxonomies() {
	// Tour Location.
	$location_labels = array(
		'name'              => esc_html_x( 'Tour Locations', 'taxonomy general name', 'tourvice' ),
		'singular_name'     => esc_html_x( 'Tour Location', 'taxonomy singular name', 'tourvice' ),
		'search_items'      => esc_html__( 'Search Tour Locations', 'tourvice' ),
		'all_items'         => esc_html__( 'All Tour Locations', 'tourvice' ),
		'parent_item'       => esc_html__( 'Parent Tour Location', 'tourvice' ),
		'parent_item_colon' => esc_html__( 'Parent Tour Location:', 'tourvice' ),
		'edit_item'         => esc_html__( 'Edit Tour Location', 'tourvice' ),
		'update_item'       => esc_html__( 'Update Tour Location', 'tourvice' ),
		'add_new_item'      => esc_html__( 'Add New Tour Location', 'tourvice' ),
		'new_item_name'     => esc_html__( 'New Tour Location Name', 'tourvice' ),
		'menu_name'         => esc_html__( 'Locations', 'tourvice' ),
	);

	register_taxonomy( 'tour_location', 'vagra_tour', array(
		'hierarchical'      => true,
		'labels'            => $location_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'tour-location' ),
	) );

	// Tour Type.
	$type_labels = array(
		'name'              => esc_html_x( 'Tour Types', 'taxonomy general name', 'tourvice' ),
		'singular_name'     => esc_html_x( 'Tour Type', 'taxonomy singular name', 'tourvice' ),
		'search_items'      => esc_html__( 'Search Tour Types', 'tourvice' ),
		'all_items'         => esc_html__( 'All Tour Types', 'tourvice' ),
		'parent_item'       => esc_html__( 'Parent Tour Type', 'tourvice' ),
		'parent_item_colon' => esc_html__( 'Parent Tour Type:', 'tourvice' ),
		'edit_item'         => esc_html__( 'Edit Tour Type', 'tourvice' ),
		'update_item'       => esc_html__( 'Update Tour Type', 'tourvice' ),
		'add_new_item'      => esc_html__( 'Add New Tour Type', 'tourvice' ),
		'new_item_name'     => esc_html__( 'New Tour Type Name', 'tourvice' ),
		'menu_name'         => esc_html__( 'Types', 'tourvice' ),
	);

	register_taxonomy( 'tour_type', 'vagra_tour', array(
		'hierarchical'      => true,
		'labels'            => $type_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'tour-type' ),
	) );
}

/* ==================================================================
 * Meta Boxes
 * ================================================================*/

/**
 * Register meta boxes for tours and bookings.
 */
function tourvice_register_meta_boxes() {
	add_meta_box(
		'tourvice_tour_details',
		esc_html__( 'Tour Details', 'tourvice' ),
		'tourvice_render_tour_meta_box',
		'vagra_tour',
		'normal',
		'high'
	);

	add_meta_box(
		'tourvice_booking_details',
		esc_html__( 'Booking Details', 'tourvice' ),
		'tourvice_render_booking_meta_box',
		'vagra_booking',
		'normal',
		'high'
	);
}

/**
 * Render the Tour Details meta box.
 *
 * @param \WP_Post $post Current post object.
 */
function tourvice_render_tour_meta_box( $post ) {
	wp_nonce_field( 'tourvice_tour_meta', 'tourvice_tour_nonce' );

	$price      = get_post_meta( $post->ID, '_tour_price', true );
	$rating     = get_post_meta( $post->ID, '_tour_rating', true );
	$duration   = get_post_meta( $post->ID, '_tour_duration', true );
	$group_min  = get_post_meta( $post->ID, '_tour_group_min', true );
	$group_max  = get_post_meta( $post->ID, '_tour_group_max', true );
	$discount   = get_post_meta( $post->ID, '_tour_discount', true );
	$highlights = get_post_meta( $post->ID, '_tour_highlights', true );
	$itinerary  = get_post_meta( $post->ID, '_tour_itinerary', true );
	$gallery    = get_post_meta( $post->ID, '_tour_gallery', true );
	?>

	<style>
		.tourvice-meta-section { margin-bottom: 20px; }
		.tourvice-meta-section h4 { margin: 0 0 10px; padding: 8px 0; border-bottom: 1px solid #ddd; }
		.tourvice-meta-row { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 8px; }
		.tourvice-meta-field { flex: 1; min-width: 180px; }
		.tourvice-meta-field label { display: block; font-weight: 600; margin-bottom: 4px; }
		.tourvice-meta-field input[type="text"],
		.tourvice-meta-field input[type="number"],
		.tourvice-meta-field textarea { width: 100%; }
		.tourvice-meta-field textarea { min-height: 100px; }
	</style>

	<!-- Pricing & Rating Section -->
	<div class="tourvice-meta-section">
		<h4><?php esc_html_e( 'Pricing & Rating', 'tourvice' ); ?></h4>
		<div class="tourvice-meta-row">
			<div class="tourvice-meta-field">
				<label for="tourvice-tour-price"><?php esc_html_e( 'Price (USD)', 'tourvice' ); ?></label>
				<input type="number" id="tourvice-tour-price" name="_tour_price" value="<?php echo esc_attr( $price ); ?>" min="0" step="0.01" />
			</div>
			<div class="tourvice-meta-field">
				<label for="tourvice-tour-rating"><?php esc_html_e( 'Rating (1-5)', 'tourvice' ); ?></label>
				<input type="number" id="tourvice-tour-rating" name="_tour_rating" value="<?php echo esc_attr( $rating ); ?>" min="1" max="5" step="0.1" />
			</div>
			<div class="tourvice-meta-field">
				<label for="tourvice-tour-discount"><?php esc_html_e( 'Discount (%)', 'tourvice' ); ?></label>
				<input type="number" id="tourvice-tour-discount" name="_tour_discount" value="<?php echo esc_attr( $discount ); ?>" min="0" max="100" step="1" />
			</div>
		</div>
	</div>

	<!-- Duration & Group Size Section -->
	<div class="tourvice-meta-section">
		<h4><?php esc_html_e( 'Duration & Group Size', 'tourvice' ); ?></h4>
		<div class="tourvice-meta-row">
			<div class="tourvice-meta-field">
				<label for="tourvice-tour-duration"><?php esc_html_e( 'Duration', 'tourvice' ); ?></label>
				<input type="text" id="tourvice-tour-duration" name="_tour_duration" value="<?php echo esc_attr( $duration ); ?>" placeholder="<?php esc_attr_e( 'e.g. 7 days', 'tourvice' ); ?>" />
			</div>
			<div class="tourvice-meta-field">
				<label for="tourvice-tour-group-min"><?php esc_html_e( 'Min Group Size', 'tourvice' ); ?></label>
				<input type="number" id="tourvice-tour-group-min" name="_tour_group_min" value="<?php echo esc_attr( $group_min ); ?>" min="1" />
			</div>
			<div class="tourvice-meta-field">
				<label for="tourvice-tour-group-max"><?php esc_html_e( 'Max Group Size', 'tourvice' ); ?></label>
				<input type="number" id="tourvice-tour-group-max" name="_tour_group_max" value="<?php echo esc_attr( $group_max ); ?>" min="1" />
			</div>
		</div>
	</div>

	<!-- Highlights Section -->
	<div class="tourvice-meta-section">
		<h4><?php esc_html_e( 'Highlights', 'tourvice' ); ?></h4>
		<div class="tourvice-meta-field">
			<label for="tourvice-tour-highlights"><?php esc_html_e( 'Tour Highlights (one per line)', 'tourvice' ); ?></label>
			<textarea id="tourvice-tour-highlights" name="_tour_highlights" rows="5"><?php echo esc_textarea( $highlights ); ?></textarea>
		</div>
	</div>

	<!-- Itinerary Section -->
	<div class="tourvice-meta-section">
		<h4><?php esc_html_e( 'Itinerary', 'tourvice' ); ?></h4>
		<div class="tourvice-meta-field">
			<label for="tourvice-tour-itinerary"><?php esc_html_e( 'Itinerary (format: "Day 1: Title" per line)', 'tourvice' ); ?></label>
			<textarea id="tourvice-tour-itinerary" name="_tour_itinerary" rows="7"><?php echo esc_textarea( $itinerary ); ?></textarea>
		</div>
	</div>

	<!-- Gallery Section -->
	<div class="tourvice-meta-section">
		<h4><?php esc_html_e( 'Gallery', 'tourvice' ); ?></h4>
		<div class="tourvice-meta-field">
			<label for="tourvice-tour-gallery"><?php esc_html_e( 'Gallery (comma-separated attachment IDs)', 'tourvice' ); ?></label>
			<input type="text" id="tourvice-tour-gallery" name="_tour_gallery" value="<?php echo esc_attr( $gallery ); ?>" placeholder="<?php esc_attr_e( 'e.g. 101,102,103', 'tourvice' ); ?>" />
		</div>
	</div>
	<?php
}

/**
 * Render the Booking Details meta box.
 *
 * @param \WP_Post $post Current post object.
 */
function tourvice_render_booking_meta_box( $post ) {
	wp_nonce_field( 'tourvice_booking_meta', 'tourvice_booking_nonce' );

	$tour_id    = get_post_meta( $post->ID, '_booking_tour_id', true );
	$name       = get_post_meta( $post->ID, '_booking_name', true );
	$email      = get_post_meta( $post->ID, '_booking_email', true );
	$phone      = get_post_meta( $post->ID, '_booking_phone', true );
	$date       = get_post_meta( $post->ID, '_booking_date', true );
	$group_size = get_post_meta( $post->ID, '_booking_group_size', true );
	$total      = get_post_meta( $post->ID, '_booking_total', true );
	$requests   = get_post_meta( $post->ID, '_booking_requests', true );
	$status     = get_post_meta( $post->ID, '_booking_status', true );

	$tour_title = '';
	$tour_link  = '';
	if ( $tour_id ) {
		$tour_post = get_post( $tour_id );
		if ( $tour_post ) {
			$tour_title = $tour_post->post_title;
			$tour_link  = get_edit_post_link( $tour_id );
		}
	}

	$status_options = array(
		''          => __( '-- Select --', 'tourvice' ),
		'pending'   => __( 'Pending', 'tourvice' ),
		'confirmed' => __( 'Confirmed', 'tourvice' ),
		'cancelled' => __( 'Cancelled', 'tourvice' ),
	);
	?>

	<style>
		.tourvice-booking-table { width: 100%; border-collapse: collapse; }
		.tourvice-booking-table th { text-align: left; padding: 8px 12px; background: #f9f9f9; border-bottom: 1px solid #eee; width: 160px; }
		.tourvice-booking-table td { padding: 8px 12px; border-bottom: 1px solid #eee; }
	</style>

	<table class="tourvice-booking-table">
		<tr>
			<th><?php esc_html_e( 'Tour', 'tourvice' ); ?></th>
			<td>
				<input type="number" name="_booking_tour_id" value="<?php echo esc_attr( $tour_id ); ?>" min="0" style="width:80px;" />
				<?php if ( $tour_link ) : ?>
					&mdash; <a href="<?php echo esc_url( $tour_link ); ?>"><?php echo esc_html( $tour_title ); ?></a>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label for="tourvice-booking-name"><?php esc_html_e( 'Customer Name', 'tourvice' ); ?></label></th>
			<td><input type="text" id="tourvice-booking-name" name="_booking_name" value="<?php echo esc_attr( $name ); ?>" style="width:100%;" /></td>
		</tr>
		<tr>
			<th><label for="tourvice-booking-email"><?php esc_html_e( 'Customer Email', 'tourvice' ); ?></label></th>
			<td><input type="email" id="tourvice-booking-email" name="_booking_email" value="<?php echo esc_attr( $email ); ?>" style="width:100%;" /></td>
		</tr>
		<tr>
			<th><label for="tourvice-booking-phone"><?php esc_html_e( 'Customer Phone', 'tourvice' ); ?></label></th>
			<td><input type="text" id="tourvice-booking-phone" name="_booking_phone" value="<?php echo esc_attr( $phone ); ?>" style="width:100%;" /></td>
		</tr>
		<tr>
			<th><label for="tourvice-booking-date"><?php esc_html_e( 'Tour Date', 'tourvice' ); ?></label></th>
			<td><input type="date" id="tourvice-booking-date" name="_booking_date" value="<?php echo esc_attr( $date ); ?>" /></td>
		</tr>
		<tr>
			<th><label for="tourvice-booking-group-size"><?php esc_html_e( 'Group Size', 'tourvice' ); ?></label></th>
			<td><input type="number" id="tourvice-booking-group-size" name="_booking_group_size" value="<?php echo esc_attr( $group_size ); ?>" min="1" /></td>
		</tr>
		<tr>
			<th><label for="tourvice-booking-total"><?php esc_html_e( 'Total (USD)', 'tourvice' ); ?></label></th>
			<td><input type="number" id="tourvice-booking-total" name="_booking_total" value="<?php echo esc_attr( $total ); ?>" min="0" step="0.01" /></td>
		</tr>
		<tr>
			<th><label for="tourvice-booking-requests"><?php esc_html_e( 'Special Requests', 'tourvice' ); ?></label></th>
			<td><textarea id="tourvice-booking-requests" name="_booking_requests" rows="3" style="width:100%;"><?php echo esc_textarea( $requests ); ?></textarea></td>
		</tr>
		<tr>
			<th><label for="tourvice-booking-status"><?php esc_html_e( 'Status', 'tourvice' ); ?></label></th>
			<td>
				<select id="tourvice-booking-status" name="_booking_status">
					<?php foreach ( $status_options as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $status, $value ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
	</table>
	<?php
}

/* ==================================================================
 * Save Meta Handlers
 * ================================================================*/

/**
 * Save tour meta box data.
 *
 * @param int $post_id Post ID.
 */
function tourvice_save_tour_meta( $post_id ) {
	if ( ! isset( $_POST['tourvice_tour_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tourvice_tour_nonce'] ) ), 'tourvice_tour_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Number fields.
	$number_fields = array( '_tour_price', '_tour_rating', '_tour_group_min', '_tour_group_max', '_tour_discount' );
	foreach ( $number_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, (float) $_POST[ $key ] );
		}
	}

	// Text field.
	if ( isset( $_POST['_tour_duration'] ) ) {
		update_post_meta( $post_id, '_tour_duration', sanitize_text_field( wp_unslash( $_POST['_tour_duration'] ) ) );
	}

	// Textarea fields.
	$textarea_fields = array( '_tour_highlights', '_tour_itinerary' );
	foreach ( $textarea_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}

	// Gallery — comma-separated IDs stored as text.
	if ( isset( $_POST['_tour_gallery'] ) ) {
		update_post_meta( $post_id, '_tour_gallery', sanitize_text_field( wp_unslash( $_POST['_tour_gallery'] ) ) );
	}
}

/**
 * Save booking meta box data.
 *
 * @param int $post_id Post ID.
 */
function tourvice_save_booking_meta( $post_id ) {
	if ( ! isset( $_POST['tourvice_booking_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tourvice_booking_nonce'] ) ), 'tourvice_booking_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Number fields.
	if ( isset( $_POST['_booking_tour_id'] ) ) {
		update_post_meta( $post_id, '_booking_tour_id', absint( $_POST['_booking_tour_id'] ) );
	}
	if ( isset( $_POST['_booking_group_size'] ) ) {
		update_post_meta( $post_id, '_booking_group_size', absint( $_POST['_booking_group_size'] ) );
	}
	if ( isset( $_POST['_booking_total'] ) ) {
		update_post_meta( $post_id, '_booking_total', (float) $_POST['_booking_total'] );
	}

	// Text fields.
	if ( isset( $_POST['_booking_name'] ) ) {
		update_post_meta( $post_id, '_booking_name', sanitize_text_field( wp_unslash( $_POST['_booking_name'] ) ) );
	}
	if ( isset( $_POST['_booking_phone'] ) ) {
		update_post_meta( $post_id, '_booking_phone', sanitize_text_field( wp_unslash( $_POST['_booking_phone'] ) ) );
	}

	// Email field.
	if ( isset( $_POST['_booking_email'] ) ) {
		update_post_meta( $post_id, '_booking_email', sanitize_email( wp_unslash( $_POST['_booking_email'] ) ) );
	}

	// Date field.
	if ( isset( $_POST['_booking_date'] ) ) {
		update_post_meta( $post_id, '_booking_date', sanitize_text_field( wp_unslash( $_POST['_booking_date'] ) ) );
	}

	// Textarea field.
	if ( isset( $_POST['_booking_requests'] ) ) {
		update_post_meta( $post_id, '_booking_requests', sanitize_textarea_field( wp_unslash( $_POST['_booking_requests'] ) ) );
	}

	// Status select.
	if ( isset( $_POST['_booking_status'] ) ) {
		$allowed = array( 'pending', 'confirmed', 'cancelled' );
		$status  = sanitize_text_field( wp_unslash( $_POST['_booking_status'] ) );
		if ( in_array( $status, $allowed, true ) ) {
			update_post_meta( $post_id, '_booking_status', $status );
		}
	}
}

/* ==================================================================
 * Admin Columns — Tours
 * ================================================================*/

/**
 * Define custom columns for the Tours list table.
 *
 * @param array $columns Default columns.
 * @return array
 */
function tourvice_tour_columns( $columns ) {
	$new = array();
	$new['cb']             = $columns['cb'];
	$new['title']          = $columns['title'];
	$new['tour_price']     = esc_html__( 'Price', 'tourvice' );
	$new['tour_rating']    = esc_html__( 'Rating', 'tourvice' );
	$new['tour_duration']  = esc_html__( 'Duration', 'tourvice' );
	$new['tour_discount']  = esc_html__( 'Discount', 'tourvice' );
	$new['date']           = $columns['date'];
	return $new;
}

/**
 * Render custom column content for Tours.
 *
 * @param string $column  Column name.
 * @param int    $post_id Post ID.
 */
function tourvice_tour_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'tour_price':
			$price = get_post_meta( $post_id, '_tour_price', true );
			echo $price ? '$' . esc_html( number_format( (float) $price, 2 ) ) : '&mdash;';
			break;

		case 'tour_rating':
			$rating = get_post_meta( $post_id, '_tour_rating', true );
			echo $rating ? esc_html( $rating ) . '/5' : '&mdash;';
			break;

		case 'tour_duration':
			$duration = get_post_meta( $post_id, '_tour_duration', true );
			echo $duration ? esc_html( $duration ) : '&mdash;';
			break;

		case 'tour_discount':
			$discount = get_post_meta( $post_id, '_tour_discount', true );
			if ( $discount ) {
				printf(
					'<span style="display:inline-block;padding:3px 10px;border-radius:3px;color:#fff;background:#5cb85c;font-size:12px;">%s%%</span>',
					esc_html( $discount )
				);
			} else {
				echo '&mdash;';
			}
			break;
	}
}

/* ==================================================================
 * Admin Columns — Bookings
 * ================================================================*/

/**
 * Define custom columns for the Bookings list table.
 *
 * @param array $columns Default columns.
 * @return array
 */
function tourvice_booking_columns( $columns ) {
	$new = array();
	$new['cb']                  = $columns['cb'];
	$new['title']               = $columns['title'];
	$new['booking_tour']        = esc_html__( 'Tour', 'tourvice' );
	$new['booking_date']        = esc_html__( 'Date', 'tourvice' );
	$new['booking_group_size']  = esc_html__( 'Group Size', 'tourvice' );
	$new['booking_status']      = esc_html__( 'Status', 'tourvice' );
	return $new;
}

/**
 * Render custom column content for Bookings.
 *
 * @param string $column  Column name.
 * @param int    $post_id Post ID.
 */
function tourvice_booking_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'booking_tour':
			$tour_id = (int) get_post_meta( $post_id, '_booking_tour_id', true );
			if ( $tour_id ) {
				$tour = get_post( $tour_id );
				if ( $tour ) {
					printf(
						'<a href="%s">%s</a>',
						esc_url( get_edit_post_link( $tour_id ) ),
						esc_html( $tour->post_title )
					);
				} else {
					echo esc_html( '#' . $tour_id );
				}
			} else {
				echo '&mdash;';
			}
			break;

		case 'booking_date':
			$date = get_post_meta( $post_id, '_booking_date', true );
			echo $date ? esc_html( $date ) : '&mdash;';
			break;

		case 'booking_group_size':
			$size = get_post_meta( $post_id, '_booking_group_size', true );
			echo $size ? esc_html( $size ) : '&mdash;';
			break;

		case 'booking_status':
			$status = get_post_meta( $post_id, '_booking_status', true );
			$colors = array(
				'pending'   => '#f0ad4e',
				'confirmed' => '#5cb85c',
				'cancelled' => '#d9534f',
			);
			$color = isset( $colors[ $status ] ) ? $colors[ $status ] : '#999';
			$label = ucfirst( $status );
			printf(
				'<span style="display:inline-block;padding:3px 10px;border-radius:3px;color:#fff;background:%s;font-size:12px;">%s</span>',
				esc_attr( $color ),
				esc_html( $label )
			);
			break;
	}
}
