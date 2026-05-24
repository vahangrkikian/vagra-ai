<?php
/**
 * Polylang Multilingual Integration.
 *
 * Registers translatable strings and provides a language switcher helper.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register translatable strings with Polylang.
 */
function meridian_polylang_register_strings() {
    if ( ! function_exists( 'pll_register_string' ) ) {
        return;
    }

    pll_register_string( 'meridian_hotel_name', 'The Meridian', 'Meridian Theme' );
    pll_register_string( 'meridian_hotel_subtitle', get_theme_mod( 'meridian_hotel_subtitle', 'New York' ), 'Meridian Theme' );
    pll_register_string( 'meridian_hotel_phone', get_theme_mod( 'meridian_hotel_phone', '+1 (212) 555-0199' ), 'Meridian Theme' );
    pll_register_string( 'meridian_hotel_email', get_theme_mod( 'meridian_hotel_email', 'stay@themeridian.example' ), 'Meridian Theme' );
    pll_register_string( 'meridian_hotel_address', get_theme_mod( 'meridian_hotel_address', '432 West 41st Street, New York, NY 10036' ), 'Meridian Theme' );
    pll_register_string( 'meridian_hero_eyebrow', get_theme_mod( 'meridian_hero_eyebrow', '' ), 'Meridian Theme' );
    pll_register_string( 'meridian_hero_heading', get_theme_mod( 'meridian_hero_heading', '' ), 'Meridian Theme' );
    pll_register_string( 'meridian_hero_subheading', get_theme_mod( 'meridian_hero_subheading', '' ), 'Meridian Theme' );
}
add_action( 'init', 'meridian_polylang_register_strings' );

/**
 * Output a language switcher list.
 *
 * Renders an unordered list of available languages with links.
 * Requires Polylang to be active; outputs nothing otherwise.
 *
 * @param array $args {
 *     Optional. Switcher arguments.
 *
 *     @type bool $show_flags      Show language flags. Default true.
 *     @type bool $show_names      Show language names. Default true.
 *     @type bool $hide_current    Hide the current language. Default false.
 *     @type string $class         CSS class for the <ul>. Default 'meridian-lang-switcher'.
 * }
 */
function meridian_polylang_switcher( $args = array() ) {
    if ( ! function_exists( 'pll_the_languages' ) ) {
        return;
    }

    $defaults = array(
        'show_flags'   => true,
        'show_names'   => true,
        'hide_current' => false,
        'class'        => 'meridian-lang-switcher',
    );

    $args = wp_parse_args( $args, $defaults );

    echo '<ul class="' . esc_attr( $args['class'] ) . '">';

    pll_the_languages( array(
        'show_flags'           => $args['show_flags'] ? 1 : 0,
        'show_names'           => $args['show_names'] ? 1 : 0,
        'hide_current'         => $args['hide_current'] ? 1 : 0,
        'hide_if_no_translation' => 0,
    ) );

    echo '</ul>';
}
