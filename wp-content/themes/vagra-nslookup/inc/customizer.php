<?php
/**
 * Vagra NSLookup Customizer Settings
 *
 * @package Vagra_NSLookup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 */
function vagra_nsl_customize_register( $wp_customize ) {

	// --- Panel ---
	$wp_customize->add_panel( 'vagra_nsl_panel', array(
		'title'    => __( 'nslookup.am Settings', 'vagra-nslookup' ),
		'priority' => 30,
	) );

	// ── Section: Brand Colors ────────────────────────────────────────────
	$wp_customize->add_section( 'vagra_nsl_colors', array(
		'title' => __( 'Brand Colors', 'vagra-nslookup' ),
		'panel' => 'vagra_nsl_panel',
	) );

	$wp_customize->add_setting( 'vagra_nsl_primary_color', array(
		'default'           => '#6366f1',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vagra_nsl_primary_color', array(
		'label'   => __( 'Primary Color (Indigo)', 'vagra-nslookup' ),
		'section' => 'vagra_nsl_colors',
	) ) );

	$wp_customize->add_setting( 'vagra_nsl_accent_color', array(
		'default'           => '#22d3ee',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vagra_nsl_accent_color', array(
		'label'   => __( 'Accent Color (Cyan)', 'vagra-nslookup' ),
		'section' => 'vagra_nsl_colors',
	) ) );

	// ── Section: Typography ──────────────────────────────────────────────
	$wp_customize->add_section( 'vagra_nsl_typography', array(
		'title' => __( 'Typography', 'vagra-nslookup' ),
		'panel' => 'vagra_nsl_panel',
	) );

	$wp_customize->add_setting( 'vagra_nsl_heading_font', array(
		'default'           => 'Inter',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'vagra_nsl_heading_font', array(
		'label'   => __( 'Heading Font Family', 'vagra-nslookup' ),
		'section' => 'vagra_nsl_typography',
		'type'    => 'select',
		'choices' => array(
			'Inter'     => 'Inter',
			'Poppins'   => 'Poppins',
			'Roboto'    => 'Roboto',
			'Open Sans' => 'Open Sans',
			'Lato'      => 'Lato',
		),
	) );

	$wp_customize->add_setting( 'vagra_nsl_body_font', array(
		'default'           => 'Inter',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'vagra_nsl_body_font', array(
		'label'   => __( 'Body Font Family', 'vagra-nslookup' ),
		'section' => 'vagra_nsl_typography',
		'type'    => 'select',
		'choices' => array(
			'Inter'     => 'Inter',
			'Roboto'    => 'Roboto',
			'Poppins'   => 'Poppins',
			'Open Sans' => 'Open Sans',
			'Lato'      => 'Lato',
		),
	) );

	$wp_customize->add_setting( 'vagra_nsl_mono_font', array(
		'default'           => 'JetBrains Mono',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'vagra_nsl_mono_font', array(
		'label'   => __( 'Monospace Font Family', 'vagra-nslookup' ),
		'section' => 'vagra_nsl_typography',
		'type'    => 'select',
		'choices' => array(
			'JetBrains Mono' => 'JetBrains Mono',
			'Fira Code'      => 'Fira Code',
			'Source Code Pro' => 'Source Code Pro',
			'IBM Plex Mono'  => 'IBM Plex Mono',
		),
	) );

	// ── Section: AI Chat ─────────────────────────────────────────────────
	$wp_customize->add_section( 'vagra_nsl_chat', array(
		'title' => __( 'AI Chat', 'vagra-nslookup' ),
		'panel' => 'vagra_nsl_panel',
	) );

	$wp_customize->add_setting( 'vagra_nsl_chat_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'vagra_nsl_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'vagra_nsl_chat_enabled', array(
		'label'   => __( 'Enable AI Chat Widget', 'vagra-nslookup' ),
		'section' => 'vagra_nsl_chat',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'vagra_nsl_chat_api_key_display', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'vagra_nsl_chat_api_key_display', array(
		'label'       => __( 'Claude API Key', 'vagra-nslookup' ),
		'description' => __( 'Enter your Anthropic API key.', 'vagra-nslookup' ),
		'section'     => 'vagra_nsl_chat',
		'type'        => 'password',
	) );

	$wp_customize->add_setting( 'vagra_nsl_chat_title', array(
		'default'           => __( 'Ask the DNS Assistant', 'vagra-nslookup' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'vagra_nsl_chat_title', array(
		'label'   => __( 'Chat Window Title', 'vagra-nslookup' ),
		'section' => 'vagra_nsl_chat',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'vagra_nsl_chat_system_prompt', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'vagra_nsl_chat_system_prompt', array(
		'label'       => __( 'System Prompt Override', 'vagra-nslookup' ),
		'description' => __( 'Leave empty to use the built-in DNS assistant prompt.', 'vagra-nslookup' ),
		'section'     => 'vagra_nsl_chat',
		'type'        => 'textarea',
	) );

	// ── Section: DNS Tool ────────────────────────────────────────────────
	$wp_customize->add_section( 'vagra_nsl_dns_tool', array(
		'title' => __( 'DNS Tool', 'vagra-nslookup' ),
		'panel' => 'vagra_nsl_panel',
	) );

	$wp_customize->add_setting( 'vagra_nsl_default_resolver', array(
		'default'           => 'authoritative',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'vagra_nsl_default_resolver', array(
		'label'   => __( 'Default Resolver', 'vagra-nslookup' ),
		'section' => 'vagra_nsl_dns_tool',
		'type'    => 'select',
		'choices' => array(
			'authoritative' => __( 'Authoritative', 'vagra-nslookup' ),
			'google'        => __( 'Google (8.8.8.8)', 'vagra-nslookup' ),
			'cloudflare'    => __( 'Cloudflare (1.1.1.1)', 'vagra-nslookup' ),
			'quad9'         => __( 'Quad9 (9.9.9.9)', 'vagra-nslookup' ),
			'opendns'       => __( 'OpenDNS (208.67.222.222)', 'vagra-nslookup' ),
		),
	) );

	$wp_customize->add_setting( 'vagra_nsl_max_concurrent', array(
		'default'           => true,
		'sanitize_callback' => 'vagra_nsl_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'vagra_nsl_max_concurrent', array(
		'label'       => __( 'Enable Parallel Queries', 'vagra-nslookup' ),
		'description' => __( 'Use parallel DNS queries for propagation checks (faster but uses more server resources).', 'vagra-nslookup' ),
		'section'     => 'vagra_nsl_dns_tool',
		'type'        => 'checkbox',
	) );
}
add_action( 'customize_register', 'vagra_nsl_customize_register' );

/**
 * Output Customizer CSS variables.
 */
function vagra_nsl_customizer_css() {
	$primary = get_theme_mod( 'vagra_nsl_primary_color', '#6366f1' );
	$accent  = get_theme_mod( 'vagra_nsl_accent_color', '#22d3ee' );
	$h_font  = get_theme_mod( 'vagra_nsl_heading_font', 'Inter' );
	$b_font  = get_theme_mod( 'vagra_nsl_body_font', 'Inter' );
	$m_font  = get_theme_mod( 'vagra_nsl_mono_font', 'JetBrains Mono' );

	printf(
		'<style>:root{--nsl-primary:%s;--nsl-accent:%s;--nsl-font-heading:"%s",sans-serif;--nsl-font-body:"%s",sans-serif;--nsl-font-mono:"%s",monospace;}</style>',
		esc_attr( $primary ),
		esc_attr( $accent ),
		esc_attr( $h_font ),
		esc_attr( $b_font ),
		esc_attr( $m_font )
	);
}
add_action( 'wp_head', 'vagra_nsl_customizer_css', 25 );

/**
 * Sanitize checkbox value.
 *
 * @param mixed $value The value.
 * @return bool
 */
function vagra_nsl_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Save API key to wp_options when Customizer saves.
 */
function vagra_nsl_save_api_key() {
	if ( isset( $_POST['customized'] ) ) {
		$customized = json_decode( wp_unslash( $_POST['customized'] ), true );
		if ( isset( $customized['vagra_nsl_chat_api_key_display'] ) ) {
			$key = sanitize_text_field( $customized['vagra_nsl_chat_api_key_display'] );
			if ( ! empty( $key ) ) {
				update_option( 'vagra_nsl_chat_api_key', $key );
			}
		}
	}
}
add_action( 'customize_save_after', 'vagra_nsl_save_api_key' );
