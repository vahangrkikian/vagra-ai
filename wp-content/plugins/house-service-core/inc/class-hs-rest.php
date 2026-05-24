<?php
/**
 * REST API endpoints for House Service Core.
 *
 * @package House_Service_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class HS_Rest
 *
 * Registers and handles REST API routes for the house-service/v1 namespace.
 */
class HS_Rest {

	/**
	 * REST namespace.
	 *
	 * @var string
	 */
	const NAMESPACE = 'house-service/v1';

	/**
	 * Register REST routes.
	 */
	public function register_routes() {
		register_rest_route(
			self::NAMESPACE,
			'/providers',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_providers' ),
				'permission_callback' => '__return_true',
				'args'                => $this->get_providers_args(),
			)
		);

		register_rest_route(
			self::NAMESPACE,
			'/quote',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'create_quote' ),
				'permission_callback' => '__return_true',
				'args'                => $this->get_quote_args(),
			)
		);
	}

	/**
	 * Get argument schema for the providers endpoint.
	 *
	 * @return array
	 */
	private function get_providers_args() {
		return array(
			'service_cat' => array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'sort'        => array(
				'type'              => 'string',
				'enum'              => array( 'rating', 'reviews', 'price-low', 'price-high' ),
				'sanitize_callback' => 'sanitize_text_field',
			),
			'price'       => array(
				'type'              => 'string',
				'enum'              => array( '1', '2', '3' ),
				'sanitize_callback' => 'sanitize_text_field',
			),
			'search'      => array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'per_page'    => array(
				'type'              => 'integer',
				'default'           => 12,
				'minimum'           => 1,
				'maximum'           => 100,
				'sanitize_callback' => 'absint',
			),
		);
	}

	/**
	 * Get argument schema for the quote endpoint.
	 *
	 * @return array
	 */
	private function get_quote_args() {
		return array(
			'provider_id' => array(
				'type'              => 'integer',
				'required'          => true,
				'sanitize_callback' => 'absint',
			),
			'name'        => array(
				'type'              => 'string',
				'required'          => true,
				'sanitize_callback' => 'sanitize_text_field',
			),
			'email'       => array(
				'type'              => 'string',
				'required'          => true,
				'format'            => 'email',
				'sanitize_callback' => 'sanitize_email',
			),
			'phone'       => array(
				'type'              => 'string',
				'required'          => true,
				'sanitize_callback' => 'sanitize_text_field',
			),
			'service'     => array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'date'        => array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'notes'       => array(
				'type'              => 'string',
				'required'          => true,
				'sanitize_callback' => 'sanitize_textarea_field',
			),
		);
	}

	/**
	 * Handle GET /providers.
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response
	 */
	public function get_providers( $request ) {
		$query_args = array(
			'post_type'      => 'hs_provider',
			'post_status'    => 'publish',
			'posts_per_page' => $request->get_param( 'per_page' ) ? $request->get_param( 'per_page' ) : 12,
		);

		// Filter by service category.
		$service_cat = $request->get_param( 'service_cat' );
		if ( $service_cat ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'hs_service_cat',
					'field'    => 'slug',
					'terms'    => $service_cat,
				),
			);
		}

		// Filter by price level.
		$price = $request->get_param( 'price' );
		if ( $price ) {
			$query_args['meta_query'][] = array(
				'key'   => '_hs_price_level',
				'value' => $price,
			);
		}

		// Search.
		$search = $request->get_param( 'search' );
		if ( $search ) {
			$query_args['s'] = $search;
		}

		// Sort.
		$sort = $request->get_param( 'sort' );
		switch ( $sort ) {
			case 'rating':
				$query_args['meta_key'] = '_hs_rating';
				$query_args['orderby']  = 'meta_value_num';
				$query_args['order']    = 'DESC';
				break;

			case 'reviews':
				$query_args['meta_key'] = '_hs_reviews';
				$query_args['orderby']  = 'meta_value_num';
				$query_args['order']    = 'DESC';
				break;

			case 'price-low':
				$query_args['meta_key'] = '_hs_price_level';
				$query_args['orderby']  = 'meta_value_num';
				$query_args['order']    = 'ASC';
				break;

			case 'price-high':
				$query_args['meta_key'] = '_hs_price_level';
				$query_args['orderby']  = 'meta_value_num';
				$query_args['order']    = 'DESC';
				break;
		}

		$query     = new WP_Query( $query_args );
		$providers = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$providers[] = $this->format_provider( get_the_ID() );
			}
			wp_reset_postdata();
		}

		return rest_ensure_response( $providers );
	}

	/**
	 * Format a single provider for the REST response.
	 *
	 * @param int $post_id Post ID.
	 * @return array
	 */
	private function format_provider( $post_id ) {
		$terms      = get_the_terms( $post_id, 'hs_service_cat' );
		$categories = array();

		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$categories[] = array(
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug,
				);
			}
		}

		return array(
			'id'             => $post_id,
			'title'          => get_the_title( $post_id ),
			'excerpt'        => get_the_excerpt( $post_id ),
			'content'        => apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) ),
			'thumbnail'      => get_the_post_thumbnail_url( $post_id, 'medium' ),
			'permalink'      => get_permalink( $post_id ),
			'categories'     => $categories,
			'rating'         => (float) get_post_meta( $post_id, '_hs_rating', true ),
			'reviews'        => (int) get_post_meta( $post_id, '_hs_reviews', true ),
			'price_level'    => (int) get_post_meta( $post_id, '_hs_price_level', true ),
			'badge'          => get_post_meta( $post_id, '_hs_badge', true ),
			'response_time'  => get_post_meta( $post_id, '_hs_response_time', true ),
			'completed_jobs' => get_post_meta( $post_id, '_hs_completed_jobs', true ),
			'serving_area'   => get_post_meta( $post_id, '_hs_serving_area', true ),
			'founded'        => get_post_meta( $post_id, '_hs_founded', true ),
			'tags'           => get_post_meta( $post_id, '_hs_tags', true ),
			'initial'        => get_post_meta( $post_id, '_hs_initial', true ),
			'bg_color_a'     => get_post_meta( $post_id, '_hs_bg_color_a', true ),
			'bg_color_b'     => get_post_meta( $post_id, '_hs_bg_color_b', true ),
		);
	}

	/**
	 * Handle POST /quote.
	 *
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response|WP_Error
	 */
	public function create_quote( $request ) {
		$provider_id = $request->get_param( 'provider_id' );
		$name        = $request->get_param( 'name' );
		$email       = $request->get_param( 'email' );
		$phone       = $request->get_param( 'phone' );
		$service     = $request->get_param( 'service' );
		$date        = $request->get_param( 'date' );
		$notes       = $request->get_param( 'notes' );

		// Validate provider exists.
		if ( 'hs_provider' !== get_post_type( $provider_id ) ) {
			return new WP_Error(
				'invalid_provider',
				__( 'Invalid provider ID.', 'house-service' ),
				array( 'status' => 400 )
			);
		}

		// Validate notes minimum length.
		if ( strlen( $notes ) < 12 ) {
			return new WP_Error(
				'notes_too_short',
				__( 'Notes must be at least 12 characters.', 'house-service' ),
				array( 'status' => 400 )
			);
		}

		// Validate email.
		if ( ! is_email( $email ) ) {
			return new WP_Error(
				'invalid_email',
				__( 'Invalid email address.', 'house-service' ),
				array( 'status' => 400 )
			);
		}

		// Generate quote code.
		$code = 'SM-' . str_pad( wp_rand( 0, 99999 ), 5, '0', STR_PAD_LEFT );

		// Create quote post.
		$quote_id = wp_insert_post(
			array(
				'post_type'   => 'hs_quote',
				'post_status' => 'publish',
				'post_title'  => sprintf(
					/* translators: 1: quote code, 2: customer name */
					__( 'Quote %1$s — %2$s', 'house-service' ),
					$code,
					$name
				),
			)
		);

		if ( is_wp_error( $quote_id ) ) {
			return new WP_Error(
				'quote_failed',
				__( 'Failed to create quote request.', 'house-service' ),
				array( 'status' => 500 )
			);
		}

		// Save meta.
		update_post_meta( $quote_id, '_hs_quote_code', $code );
		update_post_meta( $quote_id, '_hs_quote_provider_id', $provider_id );
		update_post_meta( $quote_id, '_hs_quote_name', $name );
		update_post_meta( $quote_id, '_hs_quote_email', $email );
		update_post_meta( $quote_id, '_hs_quote_phone', $phone );
		update_post_meta( $quote_id, '_hs_quote_service', $service ? $service : '' );
		update_post_meta( $quote_id, '_hs_quote_date', $date ? $date : '' );
		update_post_meta( $quote_id, '_hs_quote_notes', $notes );

		return rest_ensure_response(
			array(
				'success' => true,
				'code'    => $code,
			)
		);
	}
}
