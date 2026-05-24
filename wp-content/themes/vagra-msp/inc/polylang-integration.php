<?php
/**
 * Polylang integration for Vagra MSP.
 *
 * @package Vagra_MSP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register theme strings for translation via Polylang.
 */
function vagra_msp_polylang_register_strings() {
    if ( ! function_exists( 'pll_register_string' ) ) {
        return;
    }

    pll_register_string( 'vagra_check_dns', 'Check DNS', 'Vagra MSP Theme' );
    pll_register_string( 'vagra_skip_to_content', 'Skip to content', 'Vagra MSP Theme' );
    pll_register_string( 'vagra_toggle_menu', 'Toggle menu', 'Vagra MSP Theme' );
    pll_register_string( 'vagra_all_rights', 'All rights reserved.', 'Vagra MSP Theme' );
    pll_register_string( 'vagra_min_read', '%d min read', 'Vagra MSP Theme' );
}
add_action( 'init', 'vagra_msp_polylang_register_strings' );

/**
 * Output the Polylang language switcher markup.
 *
 * @param string $class Extra CSS class for the wrapper.
 */
function vagra_msp_polylang_switcher( $class = '' ) {
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
    echo '<div class="' . esc_attr( trim( $class ) ) . '" style="display:flex;align-items:center;gap:4px">';
    $i = 0;
    foreach ( $languages as $lang ) {
        if ( $i > 0 ) {
            echo '<span style="color:rgba(255,255,255,.25);font-size:.8rem">|</span>';
        }
        $bold = ! empty( $lang['current_lang'] ) ? 'color:#fff;' : 'color:rgba(255,255,255,.55);';
        printf(
            '<a href="%s" hreflang="%s" style="text-decoration:none;font-size:.8rem;font-weight:700;padding:4px 6px;%s">%s</a>',
            esc_url( $lang['url'] ),
            esc_attr( $lang['slug'] ),
            $bold,
            esc_html( strtoupper( $lang['slug'] ) )
        );
        $i++;
    }
    echo '</div>';
}
