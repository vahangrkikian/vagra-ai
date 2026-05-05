<?php
/**
 * Vagra Legal Customizer Settings
 *
 * @package Vagra_Legal
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 */
function vagra_legal_customize_register( $wp_customize ) {

    // --- Panel: Theme Options ---
    $wp_customize->add_panel( 'vagra_legal_panel', array(
        'title'    => __( 'Vagra Legal Options', 'vagra-legal' ),
        'priority' => 30,
    ) );

    // --- Section: Colors ---
    $wp_customize->add_section( 'vagra_legal_colors', array(
        'title' => __( 'Brand Colors', 'vagra-legal' ),
        'panel' => 'vagra_legal_panel',
    ) );

    $wp_customize->add_setting( 'vagra_legal_primary_color', array(
        'default'           => '#1B3A5C',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vagra_legal_primary_color', array(
        'label'   => __( 'Primary Color (Navy)', 'vagra-legal' ),
        'section' => 'vagra_legal_colors',
    ) ) );

    $wp_customize->add_setting( 'vagra_legal_accent_color', array(
        'default'           => '#C9A84C',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vagra_legal_accent_color', array(
        'label'   => __( 'Accent Color (Gold)', 'vagra-legal' ),
        'section' => 'vagra_legal_colors',
    ) ) );

    $wp_customize->add_setting( 'vagra_legal_dark_color', array(
        'default'           => '#1A1A2E',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vagra_legal_dark_color', array(
        'label'   => __( 'Dark Color', 'vagra-legal' ),
        'section' => 'vagra_legal_colors',
    ) ) );

    // --- Section: AI Chat ---
    $wp_customize->add_section( 'vagra_legal_chat', array(
        'title' => __( 'AI Chat', 'vagra-legal' ),
        'panel' => 'vagra_legal_panel',
    ) );

    $wp_customize->add_setting( 'vagra_legal_chat_enabled', array(
        'default'           => true,
        'sanitize_callback' => 'vagra_legal_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'vagra_legal_chat_enabled', array(
        'label'   => __( 'Enable AI Chat Widget', 'vagra-legal' ),
        'section' => 'vagra_legal_chat',
        'type'    => 'checkbox',
    ) );

    $wp_customize->add_setting( 'vagra_legal_chat_api_key_display', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'vagra_legal_chat_api_key_display', array(
        'label'       => __( 'Claude API Key', 'vagra-legal' ),
        'description' => __( 'Enter your Anthropic API key.', 'vagra-legal' ),
        'section'     => 'vagra_legal_chat',
        'type'        => 'password',
    ) );

    $wp_customize->add_setting( 'vagra_legal_chat_title', array(
        'default'           => __( 'Ask us anything', 'vagra-legal' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'vagra_legal_chat_title', array(
        'label'   => __( 'Chat Window Title', 'vagra-legal' ),
        'section' => 'vagra_legal_chat',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'vagra_legal_chat_system_prompt', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'vagra_legal_chat_system_prompt', array(
        'label'       => __( 'System Prompt Override', 'vagra-legal' ),
        'description' => __( 'Leave empty to use the built-in legal intake prompt.', 'vagra-legal' ),
        'section'     => 'vagra_legal_chat',
        'type'        => 'textarea',
    ) );

    $wp_customize->add_setting( 'vagra_legal_chat_disclaimer', array(
        'default'           => __( 'This is not legal advice. For legal counsel, please schedule a consultation.', 'vagra-legal' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'vagra_legal_chat_disclaimer', array(
        'label'   => __( 'Chat Disclaimer Text', 'vagra-legal' ),
        'section' => 'vagra_legal_chat',
        'type'    => 'textarea',
    ) );

    // --- Section: Footer ---
    $wp_customize->add_section( 'vagra_legal_footer', array(
        'title' => __( 'Footer', 'vagra-legal' ),
        'panel' => 'vagra_legal_panel',
    ) );

    $wp_customize->add_setting( 'vagra_legal_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'vagra_legal_footer_text', array(
        'label'   => __( 'Footer Copyright Text', 'vagra-legal' ),
        'section' => 'vagra_legal_footer',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'vagra_legal_footer_disclaimer', array(
        'default'           => __( 'The information on this website is for general information purposes only. Nothing on this site should be taken as legal advice for any individual case or situation.', 'vagra-legal' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'vagra_legal_footer_disclaimer', array(
        'label'   => __( 'Footer Disclaimer', 'vagra-legal' ),
        'section' => 'vagra_legal_footer',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'vagra_legal_customize_register' );

/**
 * Output Customizer CSS variables.
 */
function vagra_legal_customizer_css() {
    $primary = get_theme_mod( 'vagra_legal_primary_color', '#1B3A5C' );
    $accent  = get_theme_mod( 'vagra_legal_accent_color', '#C9A84C' );
    $dark    = get_theme_mod( 'vagra_legal_dark_color', '#1A1A2E' );

    printf(
        '<style>:root{--vagra-primary:%s;--vagra-accent:%s;--vagra-dark:%s;}</style>',
        esc_attr( $primary ),
        esc_attr( $accent ),
        esc_attr( $dark )
    );
}
add_action( 'wp_head', 'vagra_legal_customizer_css', 25 );

/**
 * Sanitize checkbox value.
 *
 * @param mixed $value The value.
 * @return bool
 */
function vagra_legal_sanitize_checkbox( $value ) {
    return (bool) $value;
}

/**
 * Save API key to wp_options when Customizer saves.
 */
function vagra_legal_save_api_key() {
    if ( isset( $_POST['customized'] ) ) {
        $customized = json_decode( wp_unslash( $_POST['customized'] ), true );
        if ( isset( $customized['vagra_legal_chat_api_key_display'] ) ) {
            $key = sanitize_text_field( $customized['vagra_legal_chat_api_key_display'] );
            if ( ! empty( $key ) ) {
                update_option( 'vagra_legal_chat_api_key', $key );
            }
        }
    }
}
add_action( 'customize_save_after', 'vagra_legal_save_api_key' );
