<?php
/**
 * Carvice REST API endpoints.
 *
 * @package Carvice
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Carvice_REST {

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
        register_rest_route( 'carvice/v1', '/providers', array(
            'methods'             => 'GET',
            'callback'            => array( __CLASS__, 'get_providers' ),
            'permission_callback' => '__return_true',
            'args'                => array(
                'service_type' => array(
                    'type'              => 'integer',
                    'sanitize_callback' => 'absint',
                ),
                'service_cat' => array(
                    'type'              => 'integer',
                    'sanitize_callback' => 'absint',
                ),
                'brand' => array(
                    'type'              => 'integer',
                    'sanitize_callback' => 'absint',
                ),
                'per_page' => array(
                    'type'              => 'integer',
                    'default'           => 10,
                    'sanitize_callback' => 'absint',
                ),
            ),
        ) );
    }

    /**
     * Get filtered providers.
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public static function get_providers( $request ) {
        $args = array(
            'post_type'      => 'carvice_provider',
            'posts_per_page' => $request->get_param( 'per_page' ) ?: 10,
            'orderby'        => 'meta_value_num',
            'meta_key'       => '_carvice_rating',
            'order'          => 'DESC',
        );

        $tax_query = array();

        if ( $request->get_param( 'service_type' ) ) {
            $tax_query[] = array(
                'taxonomy' => 'carvice_service_type',
                'field'    => 'term_id',
                'terms'    => $request->get_param( 'service_type' ),
            );
        }

        if ( $request->get_param( 'service_cat' ) ) {
            $tax_query[] = array(
                'taxonomy' => 'carvice_service_cat',
                'field'    => 'term_id',
                'terms'    => $request->get_param( 'service_cat' ),
            );
        }

        if ( $request->get_param( 'brand' ) ) {
            $tax_query[] = array(
                'taxonomy' => 'carvice_brand',
                'field'    => 'term_id',
                'terms'    => $request->get_param( 'brand' ),
            );
        }

        if ( ! empty( $tax_query ) ) {
            $args['tax_query'] = $tax_query;
        }

        $query     = new WP_Query( $args );
        $providers = array();

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $post_id    = get_the_ID();
                $categories = wp_get_post_terms( $post_id, 'carvice_service_cat', array( 'fields' => 'slugs' ) );

                $providers[] = array(
                    'id'           => $post_id,
                    'title'        => get_the_title(),
                    'permalink'    => get_permalink(),
                    'thumbnail'    => get_the_post_thumbnail_url( $post_id, 'carvice-card' ),
                    'address'      => get_post_meta( $post_id, '_carvice_address', true ),
                    'rating'       => (float) get_post_meta( $post_id, '_carvice_rating', true ),
                    'review_count' => (int) get_post_meta( $post_id, '_carvice_review_count', true ),
                    'is_verified'  => (bool) get_post_meta( $post_id, '_carvice_is_verified', true ),
                    'categories'   => is_wp_error( $categories ) ? array() : $categories,
                );
            }
            wp_reset_postdata();
        }

        return rest_ensure_response( $providers );
    }
}

Carvice_REST::init();
