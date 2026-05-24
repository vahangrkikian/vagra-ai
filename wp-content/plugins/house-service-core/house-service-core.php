<?php
/**
 * Plugin Name: House Service Core
 * Plugin URI:  https://vagra.ai
 * Description: Core functionality plugin for the House Service home services marketplace theme.
 * Version:     1.0.0
 * Author:      vagra.ai
 * Author URI:  https://vagra.ai
 * Text Domain: house-service
 * Domain Path: /languages
 * Network:     true
 * License:     GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HS_CORE_VERSION', '1.0.0' );
define( 'HS_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'HS_CORE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Register Custom Post Type: hs_provider (Service Provider).
 */
function hs_register_provider_cpt() {
	// Only register on sites using the house-service theme (avoid slug conflicts on multisite).
	$theme = get_option( 'stylesheet' );
	if ( $theme && 'house-service' !== $theme ) {
		return;
	}
	$labels = array(
		'name'                  => esc_html__( 'Providers', 'house-service' ),
		'singular_name'         => esc_html__( 'Provider', 'house-service' ),
		'menu_name'             => esc_html__( 'Providers', 'house-service' ),
		'add_new'               => esc_html__( 'Add New', 'house-service' ),
		'add_new_item'          => esc_html__( 'Add New Provider', 'house-service' ),
		'edit_item'             => esc_html__( 'Edit Provider', 'house-service' ),
		'new_item'              => esc_html__( 'New Provider', 'house-service' ),
		'view_item'             => esc_html__( 'View Provider', 'house-service' ),
		'search_items'          => esc_html__( 'Search Providers', 'house-service' ),
		'not_found'             => esc_html__( 'No providers found', 'house-service' ),
		'not_found_in_trash'    => esc_html__( 'No providers found in Trash', 'house-service' ),
		'all_items'             => esc_html__( 'All Providers', 'house-service' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'provider' ),
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-store',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'taxonomies'         => array( 'hs_service_cat' ),
		'menu_position'      => 6,
	);

	register_post_type( 'hs_provider', $args );
}
add_action( 'init', 'hs_register_provider_cpt' );

/**
 * Register Taxonomy: hs_service_cat (Service Category).
 */
function hs_register_service_cat_taxonomy() {
	if ( 'house-service' !== get_option( 'stylesheet' ) ) { return; }
	$labels = array(
		'name'              => esc_html__( 'Service Categories', 'house-service' ),
		'singular_name'     => esc_html__( 'Service Category', 'house-service' ),
		'search_items'      => esc_html__( 'Search Categories', 'house-service' ),
		'all_items'         => esc_html__( 'All Categories', 'house-service' ),
		'parent_item'       => esc_html__( 'Parent Category', 'house-service' ),
		'parent_item_colon' => esc_html__( 'Parent Category:', 'house-service' ),
		'edit_item'         => esc_html__( 'Edit Category', 'house-service' ),
		'update_item'       => esc_html__( 'Update Category', 'house-service' ),
		'add_new_item'      => esc_html__( 'Add New Category', 'house-service' ),
		'new_item_name'     => esc_html__( 'New Category Name', 'house-service' ),
		'menu_name'         => esc_html__( 'Service Categories', 'house-service' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'service-category' ),
	);

	register_taxonomy( 'hs_service_cat', 'hs_provider', $args );
}
add_action( 'init', 'hs_register_service_cat_taxonomy' );

/**
 * Insert default terms for hs_service_cat on init.
 */
function hs_insert_default_terms() {
	if ( 'house-service' !== get_option( 'stylesheet' ) ) { return; }
	$defaults = array( 'Cleaning', 'Moving', 'Repair', 'Assembly' );

	foreach ( $defaults as $term ) {
		if ( ! term_exists( $term, 'hs_service_cat' ) ) {
			wp_insert_term( $term, 'hs_service_cat' );
		}
	}
}
add_action( 'init', 'hs_insert_default_terms', 20 );

/**
 * Register Custom Post Type: hs_quote (Quote Request — private).
 */
function hs_register_quote_cpt() {
	if ( 'house-service' !== get_option( 'stylesheet' ) ) { return; }
	$labels = array(
		'name'               => esc_html__( 'Quote Requests', 'house-service' ),
		'singular_name'      => esc_html__( 'Quote Request', 'house-service' ),
		'menu_name'          => esc_html__( 'Quotes', 'house-service' ),
		'add_new'            => esc_html__( 'Add New', 'house-service' ),
		'add_new_item'       => esc_html__( 'Add New Quote', 'house-service' ),
		'edit_item'          => esc_html__( 'Edit Quote', 'house-service' ),
		'new_item'           => esc_html__( 'New Quote', 'house-service' ),
		'view_item'          => esc_html__( 'View Quote', 'house-service' ),
		'search_items'       => esc_html__( 'Search Quotes', 'house-service' ),
		'not_found'          => esc_html__( 'No quotes found', 'house-service' ),
		'not_found_in_trash' => esc_html__( 'No quotes found in Trash', 'house-service' ),
		'all_items'          => esc_html__( 'All Quotes', 'house-service' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'supports'           => array( 'title' ),
		'menu_icon'          => 'dashicons-email-alt',
		'menu_position'      => 7,
	);

	register_post_type( 'hs_quote', $args );
}
add_action( 'init', 'hs_register_quote_cpt' );

/* -----------------------------------------------------------------------
 * Meta Boxes for hs_provider
 * --------------------------------------------------------------------- */

/**
 * Add provider details meta box.
 */
function hs_add_provider_meta_boxes() {
	add_meta_box(
		'hs_provider_details',
		esc_html__( 'Provider Details', 'house-service' ),
		'hs_render_provider_meta_box',
		'hs_provider',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'hs_add_provider_meta_boxes' );

/**
 * Render provider details meta box.
 *
 * @param WP_Post $post Current post object.
 */
function hs_render_provider_meta_box( $post ) {
	wp_nonce_field( 'hs_provider_meta_nonce_action', 'hs_provider_meta_nonce' );

	$fields = array(
		'_hs_rating'         => array(
			'label' => __( 'Rating', 'house-service' ),
			'type'  => 'text',
			'desc'  => __( 'Decimal, e.g. 4.8', 'house-service' ),
		),
		'_hs_reviews'        => array(
			'label' => __( 'Reviews', 'house-service' ),
			'type'  => 'number',
			'desc'  => __( 'Integer, e.g. 612', 'house-service' ),
		),
		'_hs_price_level'    => array(
			'label'   => __( 'Price Level', 'house-service' ),
			'type'    => 'select',
			'options' => array(
				'1' => __( 'Budget', 'house-service' ),
				'2' => __( 'Standard', 'house-service' ),
				'3' => __( 'Premium', 'house-service' ),
			),
		),
		'_hs_badge'          => array(
			'label'   => __( 'Badge', 'house-service' ),
			'type'    => 'select',
			'options' => array(
				''            => __( '-- None --', 'house-service' ),
				'Top rated'   => __( 'Top rated', 'house-service' ),
				'Insured'     => __( 'Insured', 'house-service' ),
				'Licensed'    => __( 'Licensed', 'house-service' ),
				'Premium'     => __( 'Premium', 'house-service' ),
				'Budget pick' => __( 'Budget pick', 'house-service' ),
				'New'         => __( 'New', 'house-service' ),
				'Affordable'  => __( 'Affordable', 'house-service' ),
				'Specialist'  => __( 'Specialist', 'house-service' ),
			),
		),
		'_hs_response_time'  => array(
			'label' => __( 'Response Time', 'house-service' ),
			'type'  => 'text',
			'desc'  => __( 'e.g. ~1 hr, ~2 hrs', 'house-service' ),
		),
		'_hs_completed_jobs' => array(
			'label' => __( 'Completed Jobs', 'house-service' ),
			'type'  => 'text',
			'desc'  => __( 'e.g. 1,840 jobs', 'house-service' ),
		),
		'_hs_serving_area'   => array(
			'label' => __( 'Serving Area', 'house-service' ),
			'type'  => 'text',
			'desc'  => __( 'e.g. Brooklyn &middot; Queens &middot; Manhattan', 'house-service' ),
		),
		'_hs_founded'        => array(
			'label' => __( 'Founded', 'house-service' ),
			'type'  => 'text',
			'desc'  => __( 'e.g. 2014', 'house-service' ),
		),
		'_hs_tags'           => array(
			'label' => __( 'Tags', 'house-service' ),
			'type'  => 'text',
			'desc'  => __( 'Comma-separated, e.g. Eco-friendly, Insured, Same-day', 'house-service' ),
		),
		'_hs_initial'        => array(
			'label' => __( 'Initial', 'house-service' ),
			'type'  => 'text',
			'desc'  => __( '2 characters for avatar, e.g. CC', 'house-service' ),
		),
		'_hs_bg_color_a'     => array(
			'label' => __( 'Background Color A', 'house-service' ),
			'type'  => 'text',
			'desc'  => __( 'Hex color, e.g. #cfe0f4', 'house-service' ),
		),
		'_hs_bg_color_b'     => array(
			'label' => __( 'Background Color B', 'house-service' ),
			'type'  => 'text',
			'desc'  => __( 'Hex color, e.g. #dde9f8', 'house-service' ),
		),
	);

	echo '<table class="form-table">';

	foreach ( $fields as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<tr>';
		echo '<th><label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th>';
		echo '<td>';

		if ( 'select' === $field['type'] ) {
			echo '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '">';
			foreach ( $field['options'] as $opt_val => $opt_label ) {
				printf(
					'<option value="%s" %s>%s</option>',
					esc_attr( $opt_val ),
					selected( $value, $opt_val, false ),
					esc_html( $opt_label )
				);
			}
			echo '</select>';
		} else {
			printf(
				'<input type="%s" name="%s" id="%s" value="%s" class="regular-text" />',
				esc_attr( $field['type'] ),
				esc_attr( $key ),
				esc_attr( $key ),
				esc_attr( $value )
			);
		}

		if ( ! empty( $field['desc'] ) ) {
			echo '<p class="description">' . esc_html( $field['desc'] ) . '</p>';
		}

		echo '</td>';
		echo '</tr>';
	}

	echo '</table>';
}

/**
 * Save provider meta box data.
 *
 * @param int $post_id Post ID.
 */
function hs_save_provider_meta( $post_id ) {
	// Verify nonce.
	if ( ! isset( $_POST['hs_provider_meta_nonce'] ) ||
		! wp_verify_nonce( $_POST['hs_provider_meta_nonce'], 'hs_provider_meta_nonce_action' ) ) {
		return;
	}

	// Check autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array(
		'_hs_rating',
		'_hs_badge',
		'_hs_response_time',
		'_hs_completed_jobs',
		'_hs_serving_area',
		'_hs_founded',
		'_hs_tags',
		'_hs_initial',
		'_hs_bg_color_a',
		'_hs_bg_color_b',
	);

	foreach ( $text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	// Integer fields.
	if ( isset( $_POST['_hs_reviews'] ) ) {
		update_post_meta( $post_id, '_hs_reviews', absint( $_POST['_hs_reviews'] ) );
	}

	if ( isset( $_POST['_hs_price_level'] ) ) {
		$price = absint( $_POST['_hs_price_level'] );
		if ( $price >= 1 && $price <= 3 ) {
			update_post_meta( $post_id, '_hs_price_level', $price );
		}
	}
}
add_action( 'save_post_hs_provider', 'hs_save_provider_meta' );

/* -----------------------------------------------------------------------
 * Admin Columns for hs_provider
 * --------------------------------------------------------------------- */

/**
 * Set custom columns for hs_provider list table.
 *
 * @param array $columns Existing columns.
 * @return array Modified columns.
 */
function hs_provider_admin_columns( $columns ) {
	$new_columns = array();
	$new_columns['cb']             = $columns['cb'];
	$new_columns['title']          = $columns['title'];
	$new_columns['hs_rating']      = esc_html__( 'Rating', 'house-service' );
	$new_columns['hs_reviews']     = esc_html__( 'Reviews', 'house-service' );
	$new_columns['hs_price_level'] = esc_html__( 'Price Level', 'house-service' );
	$new_columns['hs_category']    = esc_html__( 'Category', 'house-service' );
	$new_columns['date']           = $columns['date'];

	return $new_columns;
}
add_filter( 'manage_hs_provider_posts_columns', 'hs_provider_admin_columns' );

/**
 * Render custom column content for hs_provider.
 *
 * @param string $column  Column name.
 * @param int    $post_id Post ID.
 */
function hs_provider_admin_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'hs_rating':
			$rating = get_post_meta( $post_id, '_hs_rating', true );
			echo esc_html( $rating ? $rating : '—' );
			break;

		case 'hs_reviews':
			$reviews = get_post_meta( $post_id, '_hs_reviews', true );
			echo esc_html( $reviews ? $reviews : '0' );
			break;

		case 'hs_price_level':
			$level  = get_post_meta( $post_id, '_hs_price_level', true );
			$labels = array(
				'1' => __( 'Budget', 'house-service' ),
				'2' => __( 'Standard', 'house-service' ),
				'3' => __( 'Premium', 'house-service' ),
			);
			echo esc_html( isset( $labels[ $level ] ) ? $labels[ $level ] : '—' );
			break;

		case 'hs_category':
			$terms = get_the_terms( $post_id, 'hs_service_cat' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$names = wp_list_pluck( $terms, 'name' );
				echo esc_html( implode( ', ', $names ) );
			} else {
				echo '—';
			}
			break;
	}
}
add_action( 'manage_hs_provider_posts_custom_column', 'hs_provider_admin_column_content', 10, 2 );

/**
 * Make custom columns sortable.
 *
 * @param array $columns Sortable columns.
 * @return array Modified sortable columns.
 */
function hs_provider_sortable_columns( $columns ) {
	$columns['hs_rating']      = '_hs_rating';
	$columns['hs_reviews']     = '_hs_reviews';
	$columns['hs_price_level'] = '_hs_price_level';
	return $columns;
}
add_filter( 'manage_edit-hs_provider_sortable_columns', 'hs_provider_sortable_columns' );

/* -----------------------------------------------------------------------
 * REST API
 * --------------------------------------------------------------------- */

require_once HS_CORE_PATH . 'inc/class-hs-rest.php';

/* -----------------------------------------------------------------------
 * Elementor Integration
 * --------------------------------------------------------------------- */

require_once HS_CORE_PATH . 'inc/class-hs-elementor.php';
HS_Elementor::instance();

/**
 * Register REST API routes.
 */
function hs_register_rest_routes() {
	$rest = new HS_Rest();
	$rest->register_routes();
}
add_action( 'rest_api_init', 'hs_register_rest_routes' );

/* -----------------------------------------------------------------------
 * Activation / Deactivation
 * --------------------------------------------------------------------- */

/**
 * Plugin activation callback.
 */
function hs_activate() {
	hs_register_provider_cpt();
	hs_register_service_cat_taxonomy();
	hs_register_quote_cpt();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'hs_activate' );

/**
 * Plugin deactivation callback.
 */
function hs_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'hs_deactivate' );
