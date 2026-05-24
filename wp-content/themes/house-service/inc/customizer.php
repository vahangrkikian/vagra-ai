<?php
/**
 * Theme Customizer Settings
 *
 * @package House_Service
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Register customizer sections and settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function hs_customize_register( $wp_customize ) {

    // Section: Theme Options.
    $wp_customize->add_section( 'hs_theme_options', array(
        'title'    => __( 'House Service Options', 'house-service' ),
        'priority' => 30,
    ) );

    // Setting: Hero title.
    $wp_customize->add_setting( 'hs_hero_title', array(
        'default'           => __( 'Find reliable service companies near you.', 'house-service' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'hs_hero_title', array(
        'label'   => __( 'Hero Title', 'house-service' ),
        'section' => 'hs_theme_options',
        'type'    => 'text',
    ) );

    // Setting: Hero subtitle.
    $wp_customize->add_setting( 'hs_hero_subtitle', array(
        'default'           => __( 'Cleaners, movers, repair pros, assembly teams — background-checked, reviewed by real customers, and ready to book this week.', 'house-service' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'hs_hero_subtitle', array(
        'label'   => __( 'Hero Subtitle', 'house-service' ),
        'section' => 'hs_theme_options',
        'type'    => 'textarea',
    ) );

    // Setting: Footer disclaimer.
    $wp_customize->add_setting( 'hs_footer_disclaimer', array(
        'default'           => __( 'This is a demo marketplace theme by vagra.ai. Provider profiles, reviews, and pricing shown are for demonstration purposes only. No real transactions are processed.', 'house-service' ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'hs_footer_disclaimer', array(
        'label'   => __( 'Footer Disclaimer', 'house-service' ),
        'section' => 'hs_theme_options',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'hs_customize_register' );
