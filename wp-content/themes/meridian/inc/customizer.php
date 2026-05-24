<?php
/**
 * Meridian Theme Customizer settings.
 *
 * Registers panels, sections, settings, and controls for the WordPress Customizer.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 */
function meridian_customize_register( $wp_customize ) {

    /* ========================================================================
       Panel: Meridian Hotel Options
       ======================================================================== */
    $wp_customize->add_panel( 'meridian_options', array(
        'title'    => __( 'Meridian Hotel Options', 'meridian' ),
        'priority' => 30,
    ) );

    /* -----------------------------------------------------------------------
       Section: Hotel Info
       ----------------------------------------------------------------------- */
    $wp_customize->add_section( 'meridian_hotel_info', array(
        'title' => __( 'Hotel Info', 'meridian' ),
        'panel' => 'meridian_options',
    ) );

    // Phone.
    $wp_customize->add_setting( 'meridian_hotel_phone', array(
        'default'           => '+1 (212) 555-0199',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_hotel_phone', array(
        'label'   => __( 'Phone Number', 'meridian' ),
        'section' => 'meridian_hotel_info',
        'type'    => 'text',
    ) );

    // Email.
    $wp_customize->add_setting( 'meridian_hotel_email', array(
        'default'           => 'stay@themeridian.example',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_hotel_email', array(
        'label'   => __( 'Email Address', 'meridian' ),
        'section' => 'meridian_hotel_info',
        'type'    => 'email',
    ) );

    // Address.
    $wp_customize->add_setting( 'meridian_hotel_address', array(
        'default'           => '432 West 41st Street, New York, NY 10036',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_hotel_address', array(
        'label'   => __( 'Address', 'meridian' ),
        'section' => 'meridian_hotel_info',
        'type'    => 'text',
    ) );

    // Subtitle.
    $wp_customize->add_setting( 'meridian_hotel_subtitle', array(
        'default'           => 'New York',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_hotel_subtitle', array(
        'label'   => __( 'Subtitle', 'meridian' ),
        'section' => 'meridian_hotel_info',
        'type'    => 'text',
    ) );

    /* -----------------------------------------------------------------------
       Section: Social Links
       ----------------------------------------------------------------------- */
    $wp_customize->add_section( 'meridian_social_links', array(
        'title' => __( 'Social Links', 'meridian' ),
        'panel' => 'meridian_options',
    ) );

    // Instagram.
    $wp_customize->add_setting( 'meridian_social_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_social_instagram', array(
        'label'   => __( 'Instagram URL', 'meridian' ),
        'section' => 'meridian_social_links',
        'type'    => 'url',
    ) );

    // Facebook.
    $wp_customize->add_setting( 'meridian_social_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_social_facebook', array(
        'label'   => __( 'Facebook URL', 'meridian' ),
        'section' => 'meridian_social_links',
        'type'    => 'url',
    ) );

    // X (Twitter).
    $wp_customize->add_setting( 'meridian_social_x', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_social_x', array(
        'label'   => __( 'X (Twitter) URL', 'meridian' ),
        'section' => 'meridian_social_links',
        'type'    => 'url',
    ) );

    /* -----------------------------------------------------------------------
       Section: Hero
       ----------------------------------------------------------------------- */
    $wp_customize->add_section( 'meridian_hero', array(
        'title' => __( 'Hero', 'meridian' ),
        'panel' => 'meridian_options',
    ) );

    // Eyebrow.
    $wp_customize->add_setting( 'meridian_hero_eyebrow', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_hero_eyebrow', array(
        'label'   => __( 'Eyebrow Text', 'meridian' ),
        'section' => 'meridian_hero',
        'type'    => 'text',
    ) );

    // Heading.
    $wp_customize->add_setting( 'meridian_hero_heading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_hero_heading', array(
        'label'   => __( 'Heading', 'meridian' ),
        'section' => 'meridian_hero',
        'type'    => 'text',
    ) );

    // Subheading.
    $wp_customize->add_setting( 'meridian_hero_subheading', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'meridian_hero_subheading', array(
        'label'   => __( 'Subheading', 'meridian' ),
        'section' => 'meridian_hero',
        'type'    => 'text',
    ) );

    /* --- Selective Refresh (postMessage partials) --- */
    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'meridian_hotel_phone', array(
            'selector'        => '.meridian-hotel-phone',
            'render_callback' => function () {
                return esc_html( get_theme_mod( 'meridian_hotel_phone', '+1 (212) 555-0199' ) );
            },
        ) );

        $wp_customize->selective_refresh->add_partial( 'meridian_hotel_email', array(
            'selector'        => '.meridian-hotel-email',
            'render_callback' => function () {
                return esc_html( get_theme_mod( 'meridian_hotel_email', 'stay@themeridian.example' ) );
            },
        ) );

        $wp_customize->selective_refresh->add_partial( 'meridian_hotel_address', array(
            'selector'        => '.meridian-hotel-address',
            'render_callback' => function () {
                return esc_html( get_theme_mod( 'meridian_hotel_address', '432 West 41st Street, New York, NY 10036' ) );
            },
        ) );
    }
}
add_action( 'customize_register', 'meridian_customize_register' );
