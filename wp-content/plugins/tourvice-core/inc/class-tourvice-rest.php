<?php
/**
 * TourVice REST API — Public endpoints for tours listing and detail.
 *
 * @package TourVice
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TourVice_REST
 */
class TourVice_REST {

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
	}

	/**
	 * Register REST API routes.
	 */
	public static function register_routes() {
		// GET /tourvice/v1/tours
		register_rest_route(
			'tourvice/v1',
			'/tours',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_tours' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'location' => array(
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
						'description'       => __( 'Filter by tour_location taxonomy slug.', 'tourvice' ),
					),
					'type' => array(
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
						'description'       => __( 'Filter by tour_type taxonomy slug.', 'tourvice' ),
					),
					'per_page' => array(
						'required'          => false,
						'default'           => 12,
						'sanitize_callback' => 'absint',
					),
					'page' => array(
						'required'          => false,
						'default'           => 1,
						'sanitize_callback' => 'absint',
					),
				),
			)
		);

		// GET /tourvice/v1/tours/{id}
		register_rest_route(
			'tourvice/v1',
			'/tours/(?P<id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_tour' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'id' => array(
						'required'          => true,
						'validate_callback' => function ( $param ) {
							return is_numeric( $param ) && (int) $param > 0;
						},
						'sanitize_callback' => 'absint',
					),
				),
			)
		);
	}

	/**
	 * GET /tourvice/v1/tours — list tours with optional filters.
	 *
	 * @param \WP_REST_Request $request The request.
	 * @return \WP_REST_Response|\WP_Error
	 */
	public static function get_tours( $request ) {
		$per_page = $request->get_param( 'per_page' );
		$page     = $request->get_param( 'page' );
		$location = $request->get_param( 'location' );
		$type     = $request->get_param( 'type' );

		$args = array(
			'post_type'      => 'vagra_tour',
			'post_status'    => 'publish',
			'posts_per_page' => min( $per_page, 100 ),
			'paged'          => $page,
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		// Taxonomy filters.
		$tax_query = array();

		if ( ! empty( $location ) ) {
			$tax_query[] = array(
				'taxonomy' => 'tour_location',
				'field'    => 'slug',
				'terms'    => $location,
			);
		}

		if ( ! empty( $type ) ) {
			$tax_query[] = array(
				'taxonomy' => 'tour_type',
				'field'    => 'slug',
				'terms'    => $type,
			);
		}

		if ( ! empty( $tax_query ) ) {
			if ( count( $tax_query ) > 1 ) {
				$tax_query['relation'] = 'AND';
			}
			$args['tax_query'] = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		}

		$query = new \WP_Query( $args );
		$tours = array();

		foreach ( $query->posts as $post ) {
			$tours[] = self::format_tour( $post );
		}

		$response = rest_ensure_response( array(
			'tours'       => $tours,
			'total'       => (int) $query->found_posts,
			'total_pages' => (int) $query->max_num_pages,
			'page'        => $page,
		) );

		$response->header( 'X-WP-Total', $query->found_posts );
		$response->header( 'X-WP-TotalPages', $query->max_num_pages );

		return $response;
	}

	/**
	 * GET /tourvice/v1/tours/{id} — single tour with all meta.
	 *
	 * @param \WP_REST_Request $request The request.
	 * @return \WP_REST_Response|\WP_Error
	 */
	public static function get_tour( $request ) {
		$id   = $request->get_param( 'id' );
		$post = get_post( $id );

		if ( ! $post || 'vagra_tour' !== $post->post_type || 'publish' !== $post->post_status ) {
			return new \WP_Error(
				'tourvice_not_found',
				__( 'Tour not found.', 'tourvice' ),
				array( 'status' => 404 )
			);
		}

		return rest_ensure_response( self::format_tour( $post ) );
	}

	/**
	 * Format a tour post into a REST-friendly array.
	 *
	 * @param \WP_Post $post Tour post object.
	 * @return array
	 */
	private static function format_tour( $post ) {
		$thumbnail_id  = get_post_thumbnail_id( $post->ID );
		$thumbnail_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : '';

		// Parse highlights into array.
		$highlights_raw = get_post_meta( $post->ID, '_tour_highlights', true );
		$highlights     = array();
		if ( ! empty( $highlights_raw ) ) {
			$highlights = array_filter( array_map( 'trim', explode( "\n", $highlights_raw ) ) );
		}

		// Parse itinerary into structured array.
		$itinerary_raw = get_post_meta( $post->ID, '_tour_itinerary', true );
		$itinerary     = array();
		if ( ! empty( $itinerary_raw ) ) {
			$lines = array_filter( array_map( 'trim', explode( "\n", $itinerary_raw ) ) );
			foreach ( $lines as $line ) {
				if ( preg_match( '/^Day\s*(\d+)\s*:\s*(.+)$/i', $line, $matches ) ) {
					$itinerary[] = array(
						'day'   => (int) $matches[1],
						'title' => trim( $matches[2] ),
					);
				} else {
					$itinerary[] = array(
						'day'   => null,
						'title' => $line,
					);
				}
			}
		}

		// Parse gallery IDs.
		$gallery_raw = get_post_meta( $post->ID, '_tour_gallery', true );
		$gallery     = array();
		if ( ! empty( $gallery_raw ) ) {
			$ids = array_filter( array_map( 'absint', explode( ',', $gallery_raw ) ) );
			foreach ( $ids as $att_id ) {
				$url = wp_get_attachment_url( $att_id );
				if ( $url ) {
					$gallery[] = array(
						'id'  => $att_id,
						'url' => $url,
					);
				}
			}
		}

		// Taxonomies.
		$locations = wp_get_post_terms( $post->ID, 'tour_location', array( 'fields' => 'all' ) );
		$types     = wp_get_post_terms( $post->ID, 'tour_type', array( 'fields' => 'all' ) );

		$location_data = array();
		if ( ! is_wp_error( $locations ) ) {
			foreach ( $locations as $term ) {
				$location_data[] = array(
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug,
				);
			}
		}

		$type_data = array();
		if ( ! is_wp_error( $types ) ) {
			foreach ( $types as $term ) {
				$type_data[] = array(
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug,
				);
			}
		}

		$price    = (float) get_post_meta( $post->ID, '_tour_price', true );
		$discount = (float) get_post_meta( $post->ID, '_tour_discount', true );

		$discounted_price = null;
		if ( $discount > 0 && $discount <= 100 ) {
			$discounted_price = round( $price * ( 1 - $discount / 100 ), 2 );
		}

		return array(
			'id'               => $post->ID,
			'title'            => $post->post_title,
			'slug'             => $post->post_name,
			'excerpt'          => get_the_excerpt( $post ),
			'content'          => apply_filters( 'the_content', $post->post_content ),
			'url'              => get_permalink( $post->ID ),
			'thumbnail'        => $thumbnail_url,
			'price'            => $price,
			'discount'         => $discount,
			'discounted_price' => $discounted_price,
			'rating'           => (float) get_post_meta( $post->ID, '_tour_rating', true ),
			'duration'         => get_post_meta( $post->ID, '_tour_duration', true ),
			'group_min'        => (int) get_post_meta( $post->ID, '_tour_group_min', true ),
			'group_max'        => (int) get_post_meta( $post->ID, '_tour_group_max', true ),
			'highlights'       => $highlights,
			'itinerary'        => $itinerary,
			'gallery'          => $gallery,
			'locations'        => $location_data,
			'types'            => $type_data,
			'date'             => $post->post_date,
		);
	}
}

TourVice_REST::init();
