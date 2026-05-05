<?php
/**
 * Vagra MSP Customizer Settings
 *
 * @package Vagra_MSP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 */
function vagra_msp_customize_register( $wp_customize ) {

    // --- Panel: Theme Options ---
    $wp_customize->add_panel( 'vagra_msp_panel', array(
        'title'    => __( 'Vagra MSP Options', 'vagra-msp' ),
        'priority' => 30,
    ) );

    // --- Section: Colors ---
    $wp_customize->add_section( 'vagra_msp_colors', array(
        'title' => __( 'Brand Colors', 'vagra-msp' ),
        'panel' => 'vagra_msp_panel',
    ) );

    $wp_customize->add_setting( 'vagra_msp_primary_color', array(
        'default'           => '#3366FF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vagra_msp_primary_color', array(
        'label'   => __( 'Primary Color', 'vagra-msp' ),
        'section' => 'vagra_msp_colors',
    ) ) );

    $wp_customize->add_setting( 'vagra_msp_dark_color', array(
        'default'           => '#2B3674',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vagra_msp_dark_color', array(
        'label'   => __( 'Dark Color', 'vagra-msp' ),
        'section' => 'vagra_msp_colors',
    ) ) );

    $wp_customize->add_setting( 'vagra_msp_muted_color', array(
        'default'           => '#68769F',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vagra_msp_muted_color', array(
        'label'   => __( 'Muted Color', 'vagra-msp' ),
        'section' => 'vagra_msp_colors',
    ) ) );

    // --- Section: Typography ---
    $wp_customize->add_section( 'vagra_msp_typography', array(
        'title' => __( 'Typography', 'vagra-msp' ),
        'panel' => 'vagra_msp_panel',
    ) );

    $wp_customize->add_setting( 'vagra_msp_heading_font', array(
        'default'           => 'Poppins',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'vagra_msp_heading_font', array(
        'label'   => __( 'Heading Font Family', 'vagra-msp' ),
        'section' => 'vagra_msp_typography',
        'type'    => 'select',
        'choices' => array(
            'Poppins'   => 'Poppins',
            'Roboto'    => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Lato'      => 'Lato',
            'Inter'     => 'Inter',
        ),
    ) );

    $wp_customize->add_setting( 'vagra_msp_body_font', array(
        'default'           => 'Roboto',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'vagra_msp_body_font', array(
        'label'   => __( 'Body Font Family', 'vagra-msp' ),
        'section' => 'vagra_msp_typography',
        'type'    => 'select',
        'choices' => array(
            'Roboto'    => 'Roboto',
            'Poppins'   => 'Poppins',
            'Open Sans' => 'Open Sans',
            'Lato'      => 'Lato',
            'Inter'     => 'Inter',
        ),
    ) );

    // --- Section: AI Chat ---
    $wp_customize->add_section( 'vagra_msp_chat', array(
        'title' => __( 'AI Chat', 'vagra-msp' ),
        'panel' => 'vagra_msp_panel',
    ) );

    $wp_customize->add_setting( 'vagra_msp_chat_enabled', array(
        'default'           => true,
        'sanitize_callback' => 'vagra_msp_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'vagra_msp_chat_enabled', array(
        'label'   => __( 'Enable AI Chat Widget', 'vagra-msp' ),
        'section' => 'vagra_msp_chat',
        'type'    => 'checkbox',
    ) );

    $wp_customize->add_setting( 'vagra_msp_chat_api_key_display', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'vagra_msp_chat_api_key_display', array(
        'label'       => __( 'Claude API Key', 'vagra-msp' ),
        'description' => __( 'Enter your Anthropic API key.', 'vagra-msp' ),
        'section'     => 'vagra_msp_chat',
        'type'        => 'password',
    ) );

    $wp_customize->add_setting( 'vagra_msp_chat_title', array(
        'default'           => __( 'Ask us anything', 'vagra-msp' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'vagra_msp_chat_title', array(
        'label'   => __( 'Chat Window Title', 'vagra-msp' ),
        'section' => 'vagra_msp_chat',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'vagra_msp_chat_system_prompt', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'vagra_msp_chat_system_prompt', array(
        'label'       => __( 'System Prompt Override', 'vagra-msp' ),
        'description' => __( 'Leave empty to use the built-in MSP cybersecurity prompt.', 'vagra-msp' ),
        'section'     => 'vagra_msp_chat',
        'type'        => 'textarea',
    ) );

    // --- Section: Footer ---
    $wp_customize->add_section( 'vagra_msp_footer', array(
        'title' => __( 'Footer', 'vagra-msp' ),
        'panel' => 'vagra_msp_panel',
    ) );

    $wp_customize->add_setting( 'vagra_msp_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'vagra_msp_footer_text', array(
        'label'   => __( 'Footer Copyright Text', 'vagra-msp' ),
        'section' => 'vagra_msp_footer',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'vagra_msp_customize_register' );

/**
 * Output Customizer CSS variables.
 */
function vagra_msp_customizer_css() {
    $primary = get_theme_mod( 'vagra_msp_primary_color', '#3366FF' );
    $dark    = get_theme_mod( 'vagra_msp_dark_color', '#2B3674' );
    $muted   = get_theme_mod( 'vagra_msp_muted_color', '#68769F' );
    $h_font  = get_theme_mod( 'vagra_msp_heading_font', 'Poppins' );
    $b_font  = get_theme_mod( 'vagra_msp_body_font', 'Roboto' );

    printf(
        '<style>:root{--vagra-primary:%s;--vagra-dark:%s;--vagra-muted:%s;--vagra-font-heading:"%s",sans-serif;--vagra-font-body:"%s",sans-serif;}</style>',
        esc_attr( $primary ),
        esc_attr( $dark ),
        esc_attr( $muted ),
        esc_attr( $h_font ),
        esc_attr( $b_font )
    );
}
add_action( 'wp_head', 'vagra_msp_customizer_css', 25 );

/**
 * Sanitize checkbox value.
 *
 * @param mixed $value The value.
 * @return bool
 */
function vagra_msp_sanitize_checkbox( $value ) {
    return (bool) $value;
}

/**
 * Save API key to wp_options when Customizer saves.
 */
function vagra_msp_save_api_key() {
    if ( isset( $_POST['customized'] ) ) {
        $customized = json_decode( wp_unslash( $_POST['customized'] ), true );
        if ( isset( $customized['vagra_msp_chat_api_key_display'] ) ) {
            $key = sanitize_text_field( $customized['vagra_msp_chat_api_key_display'] );
            if ( ! empty( $key ) ) {
                update_option( 'vagra_msp_chat_api_key', $key );
            }
        }
    }
}
add_action( 'customize_save_after', 'vagra_msp_save_api_key' );
