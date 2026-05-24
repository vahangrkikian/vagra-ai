<?php
/**
 * Plugin Name: Meridian Core
 * Plugin URI:  https://vagra.ai/meridian
 * Description: Core functionality for The Meridian hotel theme — Room CPT, booking system, meta boxes, REST API, and AI chat.
 * Version:     1.0.0
 * Author:      vagra.ai
 * Author URI:  https://vagra.ai
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: meridian
 * Network:     true
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MERIDIAN_CORE_VERSION', '1.0.0' );
define( 'MERIDIAN_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'MERIDIAN_CORE_URL', plugin_dir_url( __FILE__ ) );

/* ------------------------------------------------------------------
 * REST API endpoints
 * ----------------------------------------------------------------*/
require_once MERIDIAN_CORE_DIR . 'inc/class-meridian-rest.php';

/* ------------------------------------------------------------------
 * Booking handler
 * ----------------------------------------------------------------*/
require_once MERIDIAN_CORE_DIR . 'inc/class-meridian-booking.php';

/* ------------------------------------------------------------------
 * AI Chat REST endpoint
 * ----------------------------------------------------------------*/
require_once MERIDIAN_CORE_DIR . 'inc/class-meridian-chat.php';
new Meridian_Chat();

/* ------------------------------------------------------------------
 * Elementor integration
 * ----------------------------------------------------------------*/
require_once MERIDIAN_CORE_DIR . 'inc/class-meridian-elementor.php';
add_action( 'plugins_loaded', function () {
	if ( did_action( 'elementor/loaded' ) ) {
		Meridian_Elementor::instance();
	}
} );

/* ------------------------------------------------------------------
 * Custom Post Type: meridian_room
 * ----------------------------------------------------------------*/

function meridian_register_room_cpt() {
	$labels = array(
		'name'               => __( 'Rooms', 'meridian' ),
		'singular_name'      => __( 'Room', 'meridian' ),
		'menu_name'          => __( 'Rooms', 'meridian' ),
		'add_new'            => __( 'Add Room', 'meridian' ),
		'add_new_item'       => __( 'Add New Room', 'meridian' ),
		'edit_item'          => __( 'Edit Room', 'meridian' ),
		'new_item'           => __( 'New Room', 'meridian' ),
		'view_item'          => __( 'View Room', 'meridian' ),
		'search_items'       => __( 'Search Rooms', 'meridian' ),
		'not_found'          => __( 'No rooms found', 'meridian' ),
		'not_found_in_trash' => __( 'No rooms found in Trash', 'meridian' ),
		'all_items'          => __( 'All Rooms', 'meridian' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-building',
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'room' ),
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'taxonomies'         => array( 'meridian_room_cat' ),
	);

	register_post_type( 'meridian_room', $args );
}
add_action( 'init', 'meridian_register_room_cpt' );

/* ------------------------------------------------------------------
 * Custom Post Type: meridian_booking
 * ----------------------------------------------------------------*/

function meridian_register_booking_cpt() {
	$labels = array(
		'name'               => __( 'Bookings', 'meridian' ),
		'singular_name'      => __( 'Booking', 'meridian' ),
		'menu_name'          => __( 'Bookings', 'meridian' ),
		'add_new'            => __( 'Add Booking', 'meridian' ),
		'add_new_item'       => __( 'Add New Booking', 'meridian' ),
		'edit_item'          => __( 'Edit Booking', 'meridian' ),
		'new_item'           => __( 'New Booking', 'meridian' ),
		'view_item'          => __( 'View Booking', 'meridian' ),
		'search_items'       => __( 'Search Bookings', 'meridian' ),
		'not_found'          => __( 'No bookings found', 'meridian' ),
		'not_found_in_trash' => __( 'No bookings found in Trash', 'meridian' ),
		'all_items'          => __( 'All Bookings', 'meridian' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-calendar-alt',
		'supports'           => array( 'title' ),
	);

	register_post_type( 'meridian_booking', $args );
}
add_action( 'init', 'meridian_register_booking_cpt' );

/* ------------------------------------------------------------------
 * Taxonomy: meridian_room_cat
 * ----------------------------------------------------------------*/

function meridian_register_taxonomies() {
	register_taxonomy( 'meridian_room_cat', 'meridian_room', array(
		'labels'            => array(
			'name'          => __( 'Room Categories', 'meridian' ),
			'singular_name' => __( 'Room Category', 'meridian' ),
			'add_new_item'  => __( 'Add Room Category', 'meridian' ),
			'search_items'  => __( 'Search Room Categories', 'meridian' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'room-category' ),
	) );
}
add_action( 'init', 'meridian_register_taxonomies' );

/* ------------------------------------------------------------------
 * Meta Boxes
 * ----------------------------------------------------------------*/

function meridian_add_room_meta_boxes() {
	add_meta_box( 'meridian_room_details', __( 'Room Details', 'meridian' ), 'meridian_room_details_callback', 'meridian_room', 'normal', 'high' );
	add_meta_box( 'meridian_room_amenities', __( 'Room Amenities', 'meridian' ), 'meridian_room_amenities_callback', 'meridian_room', 'normal', 'default' );
	add_meta_box( 'meridian_room_gallery', __( 'Room Gallery', 'meridian' ), 'meridian_room_gallery_callback', 'meridian_room', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'meridian_add_room_meta_boxes' );

function meridian_room_details_callback( $post ) {
	wp_nonce_field( 'meridian_room_meta', 'meridian_room_nonce' );
	$price         = get_post_meta( $post->ID, '_meridian_price', true );
	$guests        = get_post_meta( $post->ID, '_meridian_guests', true );
	$size_sqm      = get_post_meta( $post->ID, '_meridian_size_sqm', true );
	$bed_type      = get_post_meta( $post->ID, '_meridian_bed_type', true );
	$view          = get_post_meta( $post->ID, '_meridian_view', true );
	$badge         = get_post_meta( $post->ID, '_meridian_badge', true );
	$tagline       = get_post_meta( $post->ID, '_meridian_tagline', true );
	$color_palette = get_post_meta( $post->ID, '_meridian_color_palette', true );
	?>
	<table class="form-table">
		<tr><th><label for="meridian_price"><?php esc_html_e( 'Price per Night ($)', 'meridian' ); ?></label></th><td><input type="number" name="meridian_price" id="meridian_price" value="<?php echo esc_attr( $price ); ?>" min="0" step="1" style="width:120px;" /></td></tr>
		<tr><th><label for="meridian_guests"><?php esc_html_e( 'Max Guests', 'meridian' ); ?></label></th><td><input type="number" name="meridian_guests" id="meridian_guests" value="<?php echo esc_attr( $guests ); ?>" min="1" step="1" style="width:80px;" /></td></tr>
		<tr><th><label for="meridian_size_sqm"><?php esc_html_e( 'Size (sqm)', 'meridian' ); ?></label></th><td><input type="number" name="meridian_size_sqm" id="meridian_size_sqm" value="<?php echo esc_attr( $size_sqm ); ?>" min="0" step="1" style="width:100px;" /></td></tr>
		<tr><th><label for="meridian_bed_type"><?php esc_html_e( 'Bed Type', 'meridian' ); ?></label></th><td><input type="text" name="meridian_bed_type" id="meridian_bed_type" value="<?php echo esc_attr( $bed_type ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g. King, Twin, Queen', 'meridian' ); ?>" /></td></tr>
		<tr><th><label for="meridian_view"><?php esc_html_e( 'View', 'meridian' ); ?></label></th><td><input type="text" name="meridian_view" id="meridian_view" value="<?php echo esc_attr( $view ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g. Ocean, Garden, City', 'meridian' ); ?>" /></td></tr>
		<tr><th><label for="meridian_badge"><?php esc_html_e( 'Badge', 'meridian' ); ?></label></th><td><input type="text" name="meridian_badge" id="meridian_badge" value="<?php echo esc_attr( $badge ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g. Best Seller, New, Premium', 'meridian' ); ?>" /></td></tr>
		<tr><th><label for="meridian_tagline"><?php esc_html_e( 'Tagline', 'meridian' ); ?></label></th><td><input type="text" name="meridian_tagline" id="meridian_tagline" value="<?php echo esc_attr( $tagline ); ?>" class="large-text" placeholder="<?php esc_attr_e( 'Short description for the room card', 'meridian' ); ?>" /></td></tr>
		<tr><th><label for="meridian_color_palette"><?php esc_html_e( 'Color Palette', 'meridian' ); ?></label></th><td><input type="text" name="meridian_color_palette" id="meridian_color_palette" value="<?php echo esc_attr( $color_palette ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g. navy, gold, warm', 'meridian' ); ?>" /></td></tr>
	</table>
	<?php
}

function meridian_room_amenities_callback( $post ) {
	$amenities = get_post_meta( $post->ID, '_meridian_amenities', true );
	?>
	<p><?php esc_html_e( 'Enter one amenity per line.', 'meridian' ); ?></p>
	<textarea name="meridian_amenities" id="meridian_amenities" rows="8" class="large-text"><?php echo esc_textarea( $amenities ); ?></textarea>
	<p class="description"><?php esc_html_e( 'e.g. Free Wi-Fi, Mini Bar, Room Service, Ocean View Balcony', 'meridian' ); ?></p>
	<?php
}

function meridian_room_gallery_callback( $post ) {
	$gallery = get_post_meta( $post->ID, '_meridian_gallery', true );
	?>
	<p><?php esc_html_e( 'Enter image IDs separated by commas, or use the media library.', 'meridian' ); ?></p>
	<input type="text" name="meridian_gallery" id="meridian_gallery" value="<?php echo esc_attr( $gallery ); ?>" class="large-text" />
	<p class="description"><?php esc_html_e( 'Comma-separated attachment IDs for the room photo gallery.', 'meridian' ); ?></p>
	<?php
}

/* ------------------------------------------------------------------
 * Save Meta
 * ----------------------------------------------------------------*/

function meridian_save_room_meta( $post_id ) {
	if ( ! isset( $_POST['meridian_room_nonce'] ) || ! wp_verify_nonce( $_POST['meridian_room_nonce'], 'meridian_room_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Number fields.
	$number_fields = array(
		'meridian_price'    => '_meridian_price',
		'meridian_guests'   => '_meridian_guests',
		'meridian_size_sqm' => '_meridian_size_sqm',
	);
	foreach ( $number_fields as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, absint( $_POST[ $field ] ) );
		}
	}

	// Text fields.
	$text_fields = array(
		'meridian_bed_type'      => '_meridian_bed_type',
		'meridian_view'          => '_meridian_view',
		'meridian_badge'         => '_meridian_badge',
		'meridian_tagline'       => '_meridian_tagline',
		'meridian_color_palette' => '_meridian_color_palette',
		'meridian_gallery'       => '_meridian_gallery',
	);
	foreach ( $text_fields as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $field ] ) );
		}
	}

	// Textarea field.
	if ( isset( $_POST['meridian_amenities'] ) ) {
		update_post_meta( $post_id, '_meridian_amenities', sanitize_textarea_field( $_POST['meridian_amenities'] ) );
	}
}
add_action( 'save_post_meridian_room', 'meridian_save_room_meta' );

/* ------------------------------------------------------------------
 * Admin columns
 * ----------------------------------------------------------------*/

function meridian_room_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $title ) {
		$new[ $key ] = $title;
		if ( 'title' === $key ) {
			$new['meridian_price']  = __( 'Price', 'meridian' );
			$new['meridian_guests'] = __( 'Guests', 'meridian' );
		}
	}
	return $new;
}
add_filter( 'manage_meridian_room_posts_columns', 'meridian_room_admin_columns' );

function meridian_room_admin_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'meridian_price':
			$price = get_post_meta( $post_id, '_meridian_price', true );
			echo $price ? '$' . esc_html( number_format( (int) $price ) ) : '—';
			break;
		case 'meridian_guests':
			$guests = get_post_meta( $post_id, '_meridian_guests', true );
			echo $guests ? esc_html( $guests ) : '—';
			break;
	}
}
add_action( 'manage_meridian_room_posts_custom_column', 'meridian_room_admin_column_content', 10, 2 );

/* ------------------------------------------------------------------
 * Activation / Deactivation
 * ----------------------------------------------------------------*/

register_activation_hook( __FILE__, function () {
	meridian_register_room_cpt();
	meridian_register_booking_cpt();
	meridian_register_taxonomies();
	flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function () {
	flush_rewrite_rules();
} );
