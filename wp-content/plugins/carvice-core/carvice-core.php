<?php
/**
 * Plugin Name: Carvice Core
 * Plugin URI:  https://vagra.ai/carvice
 * Description: Core functionality for the Carvice car service theme — Provider CPT, taxonomies, meta boxes, REST API, and AI chat.
 * Version:     1.0.0
 * Author:      vagra.ai
 * Author URI:  https://vagra.ai
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: carvice
 * Network:     true
 *
 * @package Carvice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CARVICE_CORE_VERSION', '1.0.0' );
define( 'CARVICE_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'CARVICE_CORE_URL', plugin_dir_url( __FILE__ ) );

/* ------------------------------------------------------------------
 * Elementor Integration
 * ----------------------------------------------------------------*/
require_once CARVICE_CORE_DIR . 'inc/class-carvice-elementor.php';
add_action( 'plugins_loaded', function () {
	if ( did_action( 'elementor/loaded' ) ) {
		Carvice_Elementor::instance();
	}
} );

/* ------------------------------------------------------------------
 * REST API endpoints
 * ----------------------------------------------------------------*/
require_once CARVICE_CORE_DIR . 'inc/class-carvice-rest.php';

/* ------------------------------------------------------------------
 * AI Chat REST endpoint
 * ----------------------------------------------------------------*/
require_once CARVICE_CORE_DIR . 'inc/class-carvice-chat.php';
new Carvice_Chat();

/* ------------------------------------------------------------------
 * Custom Post Type: carvice_provider
 * ----------------------------------------------------------------*/

function carvice_register_provider_cpt() {
	// Only register on sites using the carvice theme (avoid slug conflicts on multisite).
	$theme = get_option( 'stylesheet' );
	if ( $theme && 'carvice' !== $theme ) {
		return;
	}
	$labels = array(
		'name'               => __( 'Providers', 'carvice' ),
		'singular_name'      => __( 'Provider', 'carvice' ),
		'menu_name'          => __( 'Providers', 'carvice' ),
		'add_new'            => __( 'Add Provider', 'carvice' ),
		'add_new_item'       => __( 'Add New Provider', 'carvice' ),
		'edit_item'          => __( 'Edit Provider', 'carvice' ),
		'new_item'           => __( 'New Provider', 'carvice' ),
		'view_item'          => __( 'View Provider', 'carvice' ),
		'search_items'       => __( 'Search Providers', 'carvice' ),
		'not_found'          => __( 'No providers found', 'carvice' ),
		'not_found_in_trash' => __( 'No providers found in Trash', 'carvice' ),
		'all_items'          => __( 'All Providers', 'carvice' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-car',
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'provider' ),
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'taxonomies'         => array( 'carvice_service_cat', 'carvice_service_type', 'carvice_brand' ),
	);

	register_post_type( 'carvice_provider', $args );
}
add_action( 'init', 'carvice_register_provider_cpt' );

/* ------------------------------------------------------------------
 * Taxonomies
 * ----------------------------------------------------------------*/

function carvice_register_taxonomies() {
	if ( 'carvice' !== get_option( 'stylesheet' ) ) { return; }
	register_taxonomy( 'carvice_service_cat', 'carvice_provider', array(
		'labels'            => array(
			'name'          => __( 'Service Categories', 'carvice' ),
			'singular_name' => __( 'Service Category', 'carvice' ),
			'add_new_item'  => __( 'Add Service Category', 'carvice' ),
			'search_items'  => __( 'Search Service Categories', 'carvice' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'service-category' ),
	) );

	register_taxonomy( 'carvice_service_type', 'carvice_provider', array(
		'labels'            => array(
			'name'          => __( 'Service Types', 'carvice' ),
			'singular_name' => __( 'Service Type', 'carvice' ),
			'add_new_item'  => __( 'Add Service Type', 'carvice' ),
			'search_items'  => __( 'Search Service Types', 'carvice' ),
		),
		'hierarchical'      => false,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'service-type' ),
	) );

	register_taxonomy( 'carvice_brand', 'carvice_provider', array(
		'labels'            => array(
			'name'          => __( 'Car Brands', 'carvice' ),
			'singular_name' => __( 'Car Brand', 'carvice' ),
			'add_new_item'  => __( 'Add Car Brand', 'carvice' ),
			'search_items'  => __( 'Search Car Brands', 'carvice' ),
		),
		'hierarchical'      => false,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'brand' ),
	) );
}
add_action( 'init', 'carvice_register_taxonomies' );

/* ------------------------------------------------------------------
 * Meta Boxes
 * ----------------------------------------------------------------*/

function carvice_add_provider_meta_boxes() {
	add_meta_box( 'carvice_provider_details', __( 'Provider Details', 'carvice' ), 'carvice_provider_details_callback', 'carvice_provider', 'normal', 'high' );
	add_meta_box( 'carvice_provider_social', __( 'Social Links', 'carvice' ), 'carvice_provider_social_callback', 'carvice_provider', 'normal', 'default' );
	add_meta_box( 'carvice_provider_gallery', __( 'Photo Gallery', 'carvice' ), 'carvice_provider_gallery_callback', 'carvice_provider', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'carvice_add_provider_meta_boxes' );

function carvice_provider_details_callback( $post ) {
	wp_nonce_field( 'carvice_provider_meta', 'carvice_provider_nonce' );
	$type        = get_post_meta( $post->ID, '_carvice_provider_type', true );
	$phone       = get_post_meta( $post->ID, '_carvice_phone', true );
	$address     = get_post_meta( $post->ID, '_carvice_address', true );
	$bio         = get_post_meta( $post->ID, '_carvice_bio', true );
	$rating      = get_post_meta( $post->ID, '_carvice_rating', true );
	$reviews     = get_post_meta( $post->ID, '_carvice_review_count', true );
	$promocode   = get_post_meta( $post->ID, '_carvice_promocode', true );
	$rep_brand   = get_post_meta( $post->ID, '_carvice_represented_brand', true );
	$verified    = get_post_meta( $post->ID, '_carvice_is_verified', true );
	$hours       = get_post_meta( $post->ID, '_carvice_working_hours', true );
	$latitude    = get_post_meta( $post->ID, '_carvice_latitude', true );
	$longitude   = get_post_meta( $post->ID, '_carvice_longitude', true );
	$price_range = get_post_meta( $post->ID, '_carvice_price_range', true );
	?>
	<table class="form-table">
		<tr><th><label for="carvice_provider_type"><?php esc_html_e( 'Provider Type', 'carvice' ); ?></label></th><td><select name="carvice_provider_type" id="carvice_provider_type"><option value="center" <?php selected( $type, 'center' ); ?>><?php esc_html_e( 'Service Center', 'carvice' ); ?></option><option value="individual" <?php selected( $type, 'individual' ); ?>><?php esc_html_e( 'Individual Specialist', 'carvice' ); ?></option><option value="dealer" <?php selected( $type, 'dealer' ); ?>><?php esc_html_e( 'Official Dealer', 'carvice' ); ?></option></select></td></tr>
		<tr><th><label for="carvice_phone"><?php esc_html_e( 'Phone', 'carvice' ); ?></label></th><td><input type="text" name="carvice_phone" id="carvice_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text" /></td></tr>
		<tr><th><label for="carvice_address"><?php esc_html_e( 'Address', 'carvice' ); ?></label></th><td><input type="text" name="carvice_address" id="carvice_address" value="<?php echo esc_attr( $address ); ?>" class="large-text" /></td></tr>
		<tr><th><label for="carvice_bio"><?php esc_html_e( 'Bio / Description', 'carvice' ); ?></label></th><td><textarea name="carvice_bio" id="carvice_bio" rows="4" class="large-text"><?php echo esc_textarea( $bio ); ?></textarea></td></tr>
		<tr><th><label for="carvice_rating"><?php esc_html_e( 'Rating (1-5)', 'carvice' ); ?></label></th><td><input type="number" name="carvice_rating" id="carvice_rating" value="<?php echo esc_attr( $rating ); ?>" min="1" max="5" step="0.1" style="width:80px;" /></td></tr>
		<tr><th><label for="carvice_review_count"><?php esc_html_e( 'Review Count', 'carvice' ); ?></label></th><td><input type="number" name="carvice_review_count" id="carvice_review_count" value="<?php echo esc_attr( $reviews ); ?>" min="0" style="width:80px;" /></td></tr>
		<tr><th><label for="carvice_promocode"><?php esc_html_e( 'Promo Code', 'carvice' ); ?></label></th><td><input type="text" name="carvice_promocode" id="carvice_promocode" value="<?php echo esc_attr( $promocode ); ?>" class="regular-text" /></td></tr>
		<tr><th><label for="carvice_represented_brand"><?php esc_html_e( 'Represented Brand (dealers)', 'carvice' ); ?></label></th><td><input type="text" name="carvice_represented_brand" id="carvice_represented_brand" value="<?php echo esc_attr( $rep_brand ); ?>" class="regular-text" /></td></tr>
		<tr><th><label for="carvice_is_verified"><?php esc_html_e( 'Verified', 'carvice' ); ?></label></th><td><input type="checkbox" name="carvice_is_verified" id="carvice_is_verified" value="1" <?php checked( $verified, '1' ); ?> /></td></tr>
		<tr><th><label for="carvice_working_hours"><?php esc_html_e( 'Working Hours', 'carvice' ); ?></label></th><td><input type="text" name="carvice_working_hours" id="carvice_working_hours" value="<?php echo esc_attr( $hours ); ?>" class="large-text" placeholder="<?php esc_attr_e( 'e.g. Mon-Fri 09:00-18:00, Sat 10:00-15:00', 'carvice' ); ?>" /></td></tr>
		<tr><th><label for="carvice_price_range"><?php esc_html_e( 'Price Range', 'carvice' ); ?></label></th><td><select name="carvice_price_range" id="carvice_price_range"><option value=""><?php esc_html_e( '— Select —', 'carvice' ); ?></option><option value="budget" <?php selected( $price_range, 'budget' ); ?>><?php esc_html_e( '$ Budget', 'carvice' ); ?></option><option value="mid" <?php selected( $price_range, 'mid' ); ?>><?php esc_html_e( '$$ Mid-range', 'carvice' ); ?></option><option value="premium" <?php selected( $price_range, 'premium' ); ?>><?php esc_html_e( '$$$ Premium', 'carvice' ); ?></option></select></td></tr>
		<tr><th><label for="carvice_latitude"><?php esc_html_e( 'Latitude', 'carvice' ); ?></label></th><td><input type="text" name="carvice_latitude" id="carvice_latitude" value="<?php echo esc_attr( $latitude ); ?>" class="regular-text" placeholder="40.1792" /></td></tr>
		<tr><th><label for="carvice_longitude"><?php esc_html_e( 'Longitude', 'carvice' ); ?></label></th><td><input type="text" name="carvice_longitude" id="carvice_longitude" value="<?php echo esc_attr( $longitude ); ?>" class="regular-text" placeholder="44.4991" /></td></tr>
	</table>
	<?php
}

function carvice_provider_social_callback( $post ) {
	$socials = array(
		'_carvice_social_website'   => __( 'Website', 'carvice' ),
		'_carvice_social_instagram' => __( 'Instagram', 'carvice' ),
		'_carvice_social_facebook'  => __( 'Facebook', 'carvice' ),
		'_carvice_social_telegram'  => __( 'Telegram', 'carvice' ),
		'_carvice_social_whatsapp'  => __( 'WhatsApp', 'carvice' ),
		'_carvice_social_tiktok'    => __( 'TikTok', 'carvice' ),
	);
	echo '<table class="form-table">';
	foreach ( $socials as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf( '<tr><th><label for="%1$s">%2$s</label></th><td><input type="text" name="%1$s" id="%1$s" value="%3$s" class="large-text" /></td></tr>', esc_attr( $key ), esc_html( $label ), esc_attr( $value ) );
	}
	echo '</table>';
}

function carvice_provider_gallery_callback( $post ) {
	$gallery = get_post_meta( $post->ID, '_carvice_gallery', true );
	?>
	<p><?php esc_html_e( 'Enter image IDs separated by commas, or use the media library.', 'carvice' ); ?></p>
	<input type="text" name="carvice_gallery" id="carvice_gallery" value="<?php echo esc_attr( $gallery ); ?>" class="large-text" />
	<p class="description"><?php esc_html_e( 'Comma-separated attachment IDs for the provider photo gallery.', 'carvice' ); ?></p>
	<?php
}

function carvice_save_provider_meta( $post_id ) {
	if ( ! isset( $_POST['carvice_provider_nonce'] ) || ! wp_verify_nonce( $_POST['carvice_provider_nonce'], 'carvice_provider_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array(
		'carvice_provider_type'     => '_carvice_provider_type',
		'carvice_phone'             => '_carvice_phone',
		'carvice_address'           => '_carvice_address',
		'carvice_promocode'         => '_carvice_promocode',
		'carvice_represented_brand' => '_carvice_represented_brand',
		'carvice_gallery'           => '_carvice_gallery',
		'carvice_working_hours'     => '_carvice_working_hours',
		'carvice_price_range'       => '_carvice_price_range',
	);
	foreach ( $text_fields as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
	if ( isset( $_POST['carvice_bio'] ) ) {
		update_post_meta( $post_id, '_carvice_bio', sanitize_textarea_field( $_POST['carvice_bio'] ) );
	}
	if ( isset( $_POST['carvice_rating'] ) ) {
		update_post_meta( $post_id, '_carvice_rating', max( 1, min( 5, floatval( $_POST['carvice_rating'] ) ) ) );
	}
	if ( isset( $_POST['carvice_review_count'] ) ) {
		update_post_meta( $post_id, '_carvice_review_count', absint( $_POST['carvice_review_count'] ) );
	}
	update_post_meta( $post_id, '_carvice_is_verified', isset( $_POST['carvice_is_verified'] ) ? '1' : '0' );
	if ( isset( $_POST['carvice_latitude'] ) ) {
		update_post_meta( $post_id, '_carvice_latitude', $_POST['carvice_latitude'] !== '' ? floatval( $_POST['carvice_latitude'] ) : '' );
	}
	if ( isset( $_POST['carvice_longitude'] ) ) {
		update_post_meta( $post_id, '_carvice_longitude', $_POST['carvice_longitude'] !== '' ? floatval( $_POST['carvice_longitude'] ) : '' );
	}
	$social_keys = array( '_carvice_social_website', '_carvice_social_instagram', '_carvice_social_facebook', '_carvice_social_telegram', '_carvice_social_whatsapp', '_carvice_social_tiktok' );
	foreach ( $social_keys as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );
		}
	}
}
add_action( 'save_post_carvice_provider', 'carvice_save_provider_meta' );

/* ------------------------------------------------------------------
 * Admin columns
 * ----------------------------------------------------------------*/

function carvice_provider_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $title ) {
		$new[ $key ] = $title;
		if ( 'title' === $key ) {
			$new['carvice_type']   = __( 'Type', 'carvice' );
			$new['carvice_rating'] = __( 'Rating', 'carvice' );
			$new['carvice_phone']  = __( 'Phone', 'carvice' );
		}
	}
	return $new;
}
add_filter( 'manage_carvice_provider_posts_columns', 'carvice_provider_admin_columns' );

function carvice_provider_admin_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'carvice_type':
			$type  = get_post_meta( $post_id, '_carvice_provider_type', true );
			$types = array( 'center' => __( 'Service Center', 'carvice' ), 'individual' => __( 'Individual', 'carvice' ), 'dealer' => __( 'Dealer', 'carvice' ) );
			echo esc_html( isset( $types[ $type ] ) ? $types[ $type ] : '—' );
			break;
		case 'carvice_rating':
			$rating = get_post_meta( $post_id, '_carvice_rating', true );
			echo $rating ? esc_html( number_format( (float) $rating, 1 ) ) : '—';
			break;
		case 'carvice_phone':
			echo esc_html( get_post_meta( $post_id, '_carvice_phone', true ) ?: '—' );
			break;
	}
}
add_action( 'manage_carvice_provider_posts_custom_column', 'carvice_provider_admin_column_content', 10, 2 );

/* ------------------------------------------------------------------
 * Activation / Deactivation
 * ----------------------------------------------------------------*/

register_activation_hook( __FILE__, function () {
	carvice_register_provider_cpt();
	carvice_register_taxonomies();
	flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function () {
	flush_rewrite_rules();
} );
