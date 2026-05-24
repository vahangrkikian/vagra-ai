<?php
/**
 * Meridian REST API endpoints.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Meridian_REST {

	/**
	 * Register REST routes.
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
	}

	/**
	 * Register custom REST routes.
	 */
	public static function register_routes() {
		register_rest_route( 'meridian/v1', '/rooms', array(
			'methods'             => 'GET',
			'callback'            => array( __CLASS__, 'get_rooms' ),
			'permission_callback' => '__return_true',
			'args'                => array(
				'room_cat' => array(
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
				),
				'sort' => array(
					'type'              => 'string',
					'default'           => 'featured',
					'sanitize_callback' => 'sanitize_text_field',
				),
				'per_page' => array(
					'type'              => 'integer',
					'default'           => 10,
					'sanitize_callback' => 'absint',
				),
			),
		) );

		register_rest_route( 'meridian/v1', '/booking', array(
			'methods'             => 'POST',
			'callback'            => array( __CLASS__, 'create_booking' ),
			'permission_callback' => '__return_true',
		) );
	}

	/**
	 * Get filtered rooms.
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response
	 */
	public static function get_rooms( $request ) {
		$sort = $request->get_param( 'sort' ) ?: 'featured';

		$args = array(
			'post_type'      => 'meridian_room',
			'posts_per_page' => $request->get_param( 'per_page' ) ?: 10,
			'post_status'    => 'publish',
		);

		// Sorting.
		switch ( $sort ) {
			case 'price-asc':
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = '_meridian_price';
				$args['order']    = 'ASC';
				break;
			case 'price-desc':
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = '_meridian_price';
				$args['order']    = 'DESC';
				break;
			case 'size':
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = '_meridian_size_sqm';
				$args['order']    = 'DESC';
				break;
			case 'featured':
			default:
				$args['orderby'] = 'menu_order date';
				$args['order']   = 'ASC';
				break;
		}

		// Filter by room category slug.
		if ( $request->get_param( 'room_cat' ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'meridian_room_cat',
					'field'    => 'slug',
					'terms'    => $request->get_param( 'room_cat' ),
				),
			);
		}

		$query = new WP_Query( $args );
		$rooms = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$post_id    = get_the_ID();
				$categories = wp_get_post_terms( $post_id, 'meridian_room_cat', array( 'fields' => 'names' ) );
				$amenities  = get_post_meta( $post_id, '_meridian_amenities', true );

				$rooms[] = array(
					'id'        => $post_id,
					'title'     => get_the_title(),
					'permalink' => get_permalink(),
					'thumbnail' => get_the_post_thumbnail_url( $post_id, 'large' ),
					'price'     => (int) get_post_meta( $post_id, '_meridian_price', true ),
					'guests'    => (int) get_post_meta( $post_id, '_meridian_guests', true ),
					'size'      => (int) get_post_meta( $post_id, '_meridian_size_sqm', true ),
					'bed'       => get_post_meta( $post_id, '_meridian_bed_type', true ),
					'view'      => get_post_meta( $post_id, '_meridian_view', true ),
					'badge'     => get_post_meta( $post_id, '_meridian_badge', true ),
					'tagline'   => get_post_meta( $post_id, '_meridian_tagline', true ),
					'category'  => is_wp_error( $categories ) ? array() : $categories,
					'amenities' => $amenities ? array_filter( array_map( 'trim', explode( "\n", $amenities ) ) ) : array(),
				);
			}
			wp_reset_postdata();
		}

		return rest_ensure_response( $rooms );
	}

	/**
	 * Create a booking.
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response|WP_Error
	 */
	public static function create_booking( $request ) {
		$data = array(
			'room_id'      => absint( $request->get_param( 'room_id' ) ),
			'check_in'     => sanitize_text_field( $request->get_param( 'check_in' ) ),
			'check_out'    => sanitize_text_field( $request->get_param( 'check_out' ) ),
			'adults'       => absint( $request->get_param( 'adults' ) ),
			'children'     => absint( $request->get_param( 'children' ) ),
			'first_name'   => sanitize_text_field( $request->get_param( 'first_name' ) ),
			'last_name'    => sanitize_text_field( $request->get_param( 'last_name' ) ),
			'email'        => sanitize_email( $request->get_param( 'email' ) ),
			'phone'        => sanitize_text_field( $request->get_param( 'phone' ) ),
			'country'      => sanitize_text_field( $request->get_param( 'country' ) ),
			'arrival_time' => sanitize_text_field( $request->get_param( 'arrival_time' ) ),
			'requests'     => sanitize_textarea_field( $request->get_param( 'requests' ) ),
			'newsletter'   => (bool) $request->get_param( 'newsletter' ),
		);

		$booking = new Meridian_Booking();
		$result  = $booking->process_booking( $data );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		return rest_ensure_response( $result );
	}
}

Meridian_REST::init();
