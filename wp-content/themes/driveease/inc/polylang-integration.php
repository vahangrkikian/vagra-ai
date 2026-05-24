<?php
/**
 * Polylang integration for DriveEase.
 *
 * Registers translatable strings and enables CPT translation support.
 *
 * @package DriveEase
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register theme strings for translation via Polylang.
 */
function driveease_polylang_register_strings() {
    if ( ! function_exists( 'pll_register_string' ) ) {
        return;
    }

    pll_register_string( 'driveease_site_name', 'DriveEase', 'DriveEase Theme' );
    pll_register_string( 'driveease_book_now', 'Book Now', 'DriveEase Theme' );
    pll_register_string( 'driveease_skip_to_content', 'Skip to content', 'DriveEase Theme' );
    pll_register_string( 'driveease_search_placeholder', 'Search cars...', 'DriveEase Theme' );
    pll_register_string( 'driveease_no_cars_found', 'No cars found.', 'DriveEase Theme' );
    pll_register_string( 'driveease_per_day', 'per day', 'DriveEase Theme' );
    pll_register_string( 'driveease_view_details', 'View Details', 'DriveEase Theme' );
    pll_register_string( 'driveease_our_fleet', 'Our Fleet', 'DriveEase Theme' );
    pll_register_string( 'driveease_all_rights', 'All rights reserved.', 'DriveEase Theme' );
}
add_action( 'init', 'driveease_polylang_register_strings' );

/**
 * Enable Polylang translation for DriveEase CPTs.
 */
function driveease_polylang_post_types( $post_types, $is_settings ) {
    if ( $is_settings ) {
        $post_types['driveease_car']     = 'driveease_car';
        $post_types['driveease_booking'] = 'driveease_booking';
        $post_types['driveease_branch']  = 'driveease_branch';
    }
    return $post_types;
}
add_filter( 'pll_get_post_types', 'driveease_polylang_post_types', 10, 2 );

/**
 * Enable Polylang translation for DriveEase taxonomies.
 */
function driveease_polylang_taxonomies( $taxonomies, $is_settings ) {
    if ( $is_settings ) {
        $taxonomies['car_category'] = 'car_category';
        $taxonomies['car_feature']  = 'car_feature';
    }
    return $taxonomies;
}
add_filter( 'pll_get_taxonomies', 'driveease_polylang_taxonomies', 10, 2 );

/**
 * Output the Polylang language switcher markup.
 *
 * @param string $class Extra CSS class for the wrapper.
 */
function driveease_polylang_switcher( $class = '' ) {
    if ( ! function_exists( 'pll_the_languages' ) ) {
        return;
    }
    $languages = pll_the_languages( array(
        'raw'                    => 1,
        'hide_if_no_translation' => 0,
    ) );
    if ( empty( $languages ) ) {
        return;
    }
    echo '<div class="' . esc_attr( trim( $class ) ) . '">';
    $i = 0;
    foreach ( $languages as $lang ) {
        if ( $i > 0 ) {
            echo '<span class="lang-sep">|</span>';
        }
        $active = ! empty( $lang['current_lang'] ) ? ' active' : '';
        printf(
            '<a href="%s" class="lang-btn%s" hreflang="%s">%s</a>',
            esc_url( $lang['url'] ),
            esc_attr( $active ),
            esc_attr( $lang['slug'] ),
            esc_html( strtoupper( $lang['slug'] ) )
        );
        $i++;
    }
    echo '</div>';
}
