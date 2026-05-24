<?php
/**
 * Polylang integration for Carvice.
 *
 * @package Carvice
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register theme strings for translation via Polylang.
 */
function carvice_polylang_register_strings() {
    if ( ! function_exists( 'pll_register_string' ) ) {
        return;
    }

    pll_register_string( 'carvice_site_name', 'carvice', 'Carvice Theme' );
    pll_register_string( 'carvice_tagline', 'all services for your car', 'Carvice Theme' );
    pll_register_string( 'carvice_your_region', 'Your region:', 'Carvice Theme' );
    pll_register_string( 'carvice_language', 'Language:', 'Carvice Theme' );
    pll_register_string( 'carvice_search', 'Search...', 'Carvice Theme' );
    pll_register_string( 'carvice_sign_in', 'Sign In', 'Carvice Theme' );
    pll_register_string( 'carvice_sign_up', 'Sign Up', 'Carvice Theme' );
    pll_register_string( 'carvice_all_rights', 'All rights reserved.', 'Carvice Theme' );
}
add_action( 'init', 'carvice_polylang_register_strings' );

/**
 * Enable Polylang translation for Carvice CPTs.
 */
function carvice_polylang_post_types( $post_types, $is_settings ) {
    if ( $is_settings ) {
        $post_types['carvice_provider'] = 'carvice_provider';
    }
    return $post_types;
}
add_filter( 'pll_get_post_types', 'carvice_polylang_post_types', 10, 2 );

/**
 * Enable Polylang translation for Carvice taxonomies.
 */
function carvice_polylang_taxonomies( $taxonomies, $is_settings ) {
    if ( $is_settings ) {
        $taxonomies['carvice_service_cat']  = 'carvice_service_cat';
        $taxonomies['carvice_service_type'] = 'carvice_service_type';
        $taxonomies['carvice_brand']        = 'carvice_brand';
    }
    return $taxonomies;
}
add_filter( 'pll_get_taxonomies', 'carvice_polylang_taxonomies', 10, 2 );

/**
 * Output the Polylang language switcher markup.
 *
 * @param string $class Extra CSS class for the wrapper.
 */
function carvice_polylang_switcher( $class = '' ) {
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
    $current = null;
    foreach ( $languages as $lang ) {
        if ( ! empty( $lang['current_lang'] ) ) {
            $current = $lang;
            break;
        }
    }
    if ( ! $current ) {
        $current = reset( $languages );
    }
    $other = array_filter( $languages, function( $l ) { return empty( $l['current_lang'] ); } );
    $other = reset( $other );
    ?>
    <a href="<?php echo $other ? esc_url( $other['url'] ) : '#'; ?>" class="<?php echo esc_attr( trim( $class ) ); ?>" style="text-decoration:none;color:inherit">
        <?php echo esc_html( $current['name'] ); ?>
        <svg class="carvice-icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </a>
    <?php
}
