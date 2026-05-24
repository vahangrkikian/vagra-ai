<?php
/**
 * DriveEase Branches — CPT and meta registration.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DriveEase_Branches
 */
class DriveEase_Branches {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'init', array( __CLASS__, 'register_meta' ) );
	}

	/**
	 * Register the driveease_branch CPT.
	 */
	public static function register_post_type() {
		$labels = array(
			'name'                  => esc_html_x( 'Branches', 'Post type general name', 'driveease' ),
			'singular_name'         => esc_html_x( 'Branch', 'Post type singular name', 'driveease' ),
			'menu_name'             => esc_html__( 'Branches', 'driveease' ),
			'name_admin_bar'        => esc_html__( 'Branch', 'driveease' ),
			'add_new'               => esc_html__( 'Add New', 'driveease' ),
			'add_new_item'          => esc_html__( 'Add New Branch', 'driveease' ),
			'new_item'              => esc_html__( 'New Branch', 'driveease' ),
			'edit_item'             => esc_html__( 'Edit Branch', 'driveease' ),
			'view_item'             => esc_html__( 'View Branch', 'driveease' ),
			'all_items'             => esc_html__( 'All Branches', 'driveease' ),
			'search_items'          => esc_html__( 'Search Branches', 'driveease' ),
			'not_found'             => esc_html__( 'No branches found.', 'driveease' ),
			'not_found_in_trash'    => esc_html__( 'No branches found in Trash.', 'driveease' ),
			'featured_image'        => esc_html__( 'Branch Image', 'driveease' ),
			'set_featured_image'    => esc_html__( 'Set branch image', 'driveease' ),
			'remove_featured_image' => esc_html__( 'Remove branch image', 'driveease' ),
			'use_featured_image'    => esc_html__( 'Use as branch image', 'driveease' ),
			'filter_items_list'     => esc_html__( 'Filter branches list', 'driveease' ),
			'items_list'            => esc_html__( 'Branches list', 'driveease' ),
			'items_list_navigation' => esc_html__( 'Branches list navigation', 'driveease' ),
		);

		$args = array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => true, // Flush rewrite rules after changing: visit Settings > Permalinks and click Save.
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'menu_icon'    => 'dashicons-location',
			'rewrite'      => array( 'slug' => 'branch' ),
		);

		register_post_type( 'driveease_branch', $args );
	}

	/**
	 * Register post meta fields for driveease_branch.
	 */
	public static function register_meta() {
		$string_fields = array(
			'_branch_address',
			'_branch_phone',
			'_branch_email',
			'_branch_hours_weekday',
			'_branch_hours_weekend',
			'_branch_latitude',
			'_branch_longitude',
		);

		foreach ( $string_fields as $key ) {
			register_post_meta(
				'driveease_branch',
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

		// Boolean field.
		register_post_meta(
			'driveease_branch',
			'_branch_is_24h',
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
}

DriveEase_Branches::init();
