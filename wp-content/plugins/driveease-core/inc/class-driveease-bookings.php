<?php
/**
 * DriveEase Bookings — CPT and meta registration.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DriveEase_Bookings
 */
class DriveEase_Bookings {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'init', array( __CLASS__, 'register_meta' ) );
		add_action( 'save_post_driveease_booking', array( __CLASS__, 'auto_generate_title' ), 10, 3 );
	}

	/**
	 * Register the driveease_booking CPT.
	 */
	public static function register_post_type() {
		$labels = array(
			'name'                  => esc_html_x( 'Bookings', 'Post type general name', 'driveease' ),
			'singular_name'         => esc_html_x( 'Booking', 'Post type singular name', 'driveease' ),
			'menu_name'             => esc_html__( 'Bookings', 'driveease' ),
			'name_admin_bar'        => esc_html__( 'Booking', 'driveease' ),
			'add_new'               => esc_html__( 'Add New', 'driveease' ),
			'add_new_item'          => esc_html__( 'Add New Booking', 'driveease' ),
			'new_item'              => esc_html__( 'New Booking', 'driveease' ),
			'edit_item'             => esc_html__( 'Edit Booking', 'driveease' ),
			'view_item'             => esc_html__( 'View Booking', 'driveease' ),
			'all_items'             => esc_html__( 'All Bookings', 'driveease' ),
			'search_items'          => esc_html__( 'Search Bookings', 'driveease' ),
			'not_found'             => esc_html__( 'No bookings found.', 'driveease' ),
			'not_found_in_trash'    => esc_html__( 'No bookings found in Trash.', 'driveease' ),
			'filter_items_list'     => esc_html__( 'Filter bookings list', 'driveease' ),
			'items_list'            => esc_html__( 'Bookings list', 'driveease' ),
			'items_list_navigation' => esc_html__( 'Bookings list navigation', 'driveease' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => true,
			'capability_type' => 'post',
			'supports'        => array( 'title' ),
			'menu_icon'       => 'dashicons-calendar-alt',
		);

		register_post_type( 'driveease_booking', $args );
	}

	/**
	 * Register post meta fields for driveease_booking.
	 */
	public static function register_meta() {
		$string_fields = array(
			'_booking_reference',
			'_booking_pickup_location',
			'_booking_dropoff_location',
			'_booking_pickup_date',
			'_booking_dropoff_date',
			'_booking_customer_name',
			'_booking_customer_email',
			'_booking_customer_phone',
			'_booking_driver_license',
			'_booking_extras',
			'_booking_currency',
			'_booking_status',
			'_booking_payment_status',
		);

		foreach ( $string_fields as $key ) {
			register_post_meta(
				'driveease_booking',
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

		// Integer field — car ID.
		register_post_meta(
			'driveease_booking',
			'_booking_car_id',
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

		// Number field — total price.
		register_post_meta(
			'driveease_booking',
			'_booking_total_price',
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
	}

	/**
	 * Auto-generate booking title on save: "DE-XXXXXX — Customer Name".
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    Post object.
	 * @param bool     $update  Whether this is an update.
	 */
	public static function auto_generate_title( $post_id, $post, $update ) {
		// Prevent infinite loop.
		remove_action( 'save_post_driveease_booking', array( __CLASS__, 'auto_generate_title' ), 10 );

		$reference = get_post_meta( $post_id, '_booking_reference', true );
		if ( empty( $reference ) ) {
			$reference = 'DE-' . str_pad( $post_id, 6, '0', STR_PAD_LEFT );
			update_post_meta( $post_id, '_booking_reference', $reference );
		}

		$customer_name = get_post_meta( $post_id, '_booking_customer_name', true );
		if ( empty( $customer_name ) ) {
			$customer_name = esc_html__( 'Guest', 'driveease' );
		}

		$title = $reference . ' — ' . $customer_name;

		wp_update_post(
			array(
				'ID'         => $post_id,
				'post_title' => $title,
				'post_name'  => sanitize_title( $title ),
			)
		);

		// Re-add the action.
		add_action( 'save_post_driveease_booking', array( __CLASS__, 'auto_generate_title' ), 10, 3 );
	}
}

DriveEase_Bookings::init();
