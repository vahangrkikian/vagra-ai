<?php
/**
 * DriveEase Cars — CPT, taxonomy, and meta registration.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DriveEase_Cars
 */
class DriveEase_Cars {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
		add_action( 'init', array( __CLASS__, 'register_meta' ) );
		add_action( 'init', array( __CLASS__, 'create_default_terms' ) );
	}

	/**
	 * Register the driveease_car CPT.
	 */
	public static function register_post_type() {
		$labels = array(
			'name'                  => esc_html_x( 'Cars', 'Post type general name', 'driveease' ),
			'singular_name'         => esc_html_x( 'Car', 'Post type singular name', 'driveease' ),
			'menu_name'             => esc_html__( 'Cars', 'driveease' ),
			'name_admin_bar'        => esc_html__( 'Car', 'driveease' ),
			'add_new'               => esc_html__( 'Add New', 'driveease' ),
			'add_new_item'          => esc_html__( 'Add New Car', 'driveease' ),
			'new_item'              => esc_html__( 'New Car', 'driveease' ),
			'edit_item'             => esc_html__( 'Edit Car', 'driveease' ),
			'view_item'             => esc_html__( 'View Car', 'driveease' ),
			'all_items'             => esc_html__( 'All Cars', 'driveease' ),
			'search_items'          => esc_html__( 'Search Cars', 'driveease' ),
			'not_found'             => esc_html__( 'No cars found.', 'driveease' ),
			'not_found_in_trash'    => esc_html__( 'No cars found in Trash.', 'driveease' ),
			'featured_image'        => esc_html__( 'Car Image', 'driveease' ),
			'set_featured_image'    => esc_html__( 'Set car image', 'driveease' ),
			'remove_featured_image' => esc_html__( 'Remove car image', 'driveease' ),
			'use_featured_image'    => esc_html__( 'Use as car image', 'driveease' ),
			'archives'              => esc_html__( 'Fleet', 'driveease' ),
			'filter_items_list'     => esc_html__( 'Filter cars list', 'driveease' ),
			'items_list'            => esc_html__( 'Cars list', 'driveease' ),
			'items_list_navigation' => esc_html__( 'Cars list navigation', 'driveease' ),
		);

		$args = array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'menu_icon'    => 'dashicons-car',
			'rewrite'      => array( 'slug' => 'car' ),
		);

		register_post_type( 'driveease_car', $args );
	}

	/**
	 * Register the car_category taxonomy.
	 */
	public static function register_taxonomy() {
		$labels = array(
			'name'              => esc_html_x( 'Car Categories', 'taxonomy general name', 'driveease' ),
			'singular_name'     => esc_html_x( 'Car Category', 'taxonomy singular name', 'driveease' ),
			'search_items'      => esc_html__( 'Search Car Categories', 'driveease' ),
			'all_items'         => esc_html__( 'All Car Categories', 'driveease' ),
			'parent_item'       => esc_html__( 'Parent Car Category', 'driveease' ),
			'parent_item_colon' => esc_html__( 'Parent Car Category:', 'driveease' ),
			'edit_item'         => esc_html__( 'Edit Car Category', 'driveease' ),
			'update_item'       => esc_html__( 'Update Car Category', 'driveease' ),
			'add_new_item'      => esc_html__( 'Add New Car Category', 'driveease' ),
			'new_item_name'     => esc_html__( 'New Car Category Name', 'driveease' ),
			'menu_name'         => esc_html__( 'Categories', 'driveease' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'car-category' ),
		);

		register_taxonomy( 'car_category', 'driveease_car', $args );
	}

	/**
	 * Register post meta fields for driveease_car.
	 */
	public static function register_meta() {
		$string_fields = array(
			'_car_year',
			'_car_transmission',
			'_car_fuel_type',
			'_car_engine',
			'_car_mileage_limit',
			'_car_trunk_capacity',
			'_car_availability_status',
		);

		foreach ( $string_fields as $key ) {
			register_post_meta(
				'driveease_car',
				$key,
				array(
					'type'              => 'string',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}

		// Number field.
		register_post_meta(
			'driveease_car',
			'_car_price_per_day',
			array(
				'type'              => 'number',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => function ( $value ) {
					return (float) $value;
				},
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		// Integer fields.
		$integer_fields = array( '_car_seats', '_car_doors' );
		foreach ( $integer_fields as $key ) {
			register_post_meta(
				'driveease_car',
				$key,
				array(
					'type'              => 'integer',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => 'absint',
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}

		// Boolean fields.
		$boolean_fields = array(
			'_car_air_conditioning',
			'_car_gps_included',
			'_car_bluetooth',
			'_car_usb_charging',
			'_car_cruise_control',
			'_car_backup_camera',
			'_car_featured',
		);

		foreach ( $boolean_fields as $key ) {
			register_post_meta(
				'driveease_car',
				$key,
				array(
					'type'              => 'boolean',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => 'rest_sanitize_boolean',
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}

		// Gallery — array of attachment IDs.
		register_post_meta(
			'driveease_car',
			'_car_gallery',
			array(
				'type'          => 'array',
				'single'        => true,
				'show_in_rest'  => array(
					'schema' => array(
						'type'  => 'array',
						'items' => array(
							'type' => 'integer',
						),
					),
				),
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}

	/**
	 * Insert default car_category terms if they don't exist yet.
	 */
	public static function create_default_terms() {
		if ( ! taxonomy_exists( 'car_category' ) ) {
			return;
		}

		$defaults = array( 'Economy', 'Sedan', 'SUV', 'Luxury', 'Compact', 'Minivan' );

		foreach ( $defaults as $term ) {
			if ( ! term_exists( $term, 'car_category' ) ) {
				wp_insert_term( $term, 'car_category' );
			}
		}
	}
}

DriveEase_Cars::init();
