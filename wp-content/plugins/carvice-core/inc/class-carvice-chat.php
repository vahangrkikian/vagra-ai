<?php
/**
 * Carvice Chat — REST API endpoint and Customizer settings.
 *
 * @package Carvice
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Carvice_Chat {

    /**
     * Rate limit: max requests per minute per IP.
     */
    const RATE_LIMIT = 10;

    /**
     * Boot hooks.
     */
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
        add_action( 'customize_register', array( $this, 'customizer' ) );
    }

    /* ------------------------------------------------------------------
     * REST API
     * ----------------------------------------------------------------*/

    public function register_routes() {
        register_rest_route( 'carvice/v1', '/chat', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handle_chat' ),
            'permission_callback' => '__return_true',
        ) );
    }

    /**
     * Handle a chat request.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function handle_chat( WP_REST_Request $request ) {
        // Rate limiting.
        $ip   = $this->get_client_ip();
        $key  = 'carvice_chat_' . md5( $ip );
        $hits = (int) get_transient( $key );

        if ( $hits >= self::RATE_LIMIT ) {
            return new WP_Error(
                'rate_limited',
                __( 'Too many requests. Please wait a moment and try again.', 'carvice' ),
                array( 'status' => 429 )
            );
        }

        set_transient( $key, $hits + 1, 60 );

        // Input.
        $message = sanitize_text_field( $request->get_param( 'message' ) );
        $history = $request->get_param( 'history' );

        if ( empty( $message ) ) {
            return new WP_Error(
                'empty_message',
                __( 'Message cannot be empty.', 'carvice' ),
                array( 'status' => 400 )
            );
        }

        // API key check.
        $api_key = get_option( 'carvice_chat_api_key', '' );

        if ( empty( $api_key ) ) {
            return rest_ensure_response( array(
                'reply' => $this->mock_response( $message ),
            ) );
        }

        // Build messages array.
        $messages = array();

        // System prompt.
        $system_prompt = get_theme_mod(
            'carvice_chat_system_prompt',
            $this->default_system_prompt()
        );

        // History.
        if ( is_array( $history ) ) {
            foreach ( array_slice( $history, -20 ) as $entry ) {
                if ( isset( $entry['role'], $entry['content'] ) ) {
                    $messages[] = array(
                        'role'    => sanitize_text_field( $entry['role'] ),
                        'content' => sanitize_text_field( $entry['content'] ),
                    );
                }
            }
        }

        $messages[] = array(
            'role'    => 'user',
            'content' => $message,
        );

        // Call Claude API.
        $response = wp_remote_post( 'https://api.anthropic.com/v1/messages', array(
            'timeout' => 30,
            'headers' => array(
                'Content-Type'      => 'application/json',
                'x-api-key'         => $api_key,
                'anthropic-version' => '2023-06-01',
            ),
            'body'    => wp_json_encode( array(
                'model'      => 'claude-haiku-4-5-20251001',
                'max_tokens' => 512,
                'system'     => $system_prompt,
                'messages'   => $messages,
            ) ),
        ) );

        if ( is_wp_error( $response ) ) {
            return new WP_Error(
                'api_error',
                __( 'Could not reach the AI service. Please try again.', 'carvice' ),
                array( 'status' => 502 )
            );
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( empty( $body['content'][0]['text'] ) ) {
            return new WP_Error(
                'api_error',
                __( 'Unexpected response from the AI service.', 'carvice' ),
                array( 'status' => 502 )
            );
        }

        return rest_ensure_response( array(
            'reply' => $body['content'][0]['text'],
        ) );
    }

    /* ------------------------------------------------------------------
     * Customizer
     * ----------------------------------------------------------------*/

    public function customizer( WP_Customize_Manager $wp_customize ) {
        $wp_customize->add_section( 'carvice_chat_section', array(
            'title'    => __( 'AI Chat Settings', 'carvice' ),
            'priority' => 200,
        ) );

        // API Key.
        $wp_customize->add_setting( 'carvice_chat_api_key', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'option',
        ) );
        $wp_customize->add_control( 'carvice_chat_api_key', array(
            'label'   => __( 'Claude API Key', 'carvice' ),
            'section' => 'carvice_chat_section',
            'type'    => 'password',
        ) );

        // System Prompt.
        $wp_customize->add_setting( 'carvice_chat_system_prompt', array(
            'default'           => $this->default_system_prompt(),
            'sanitize_callback' => 'sanitize_textarea_field',
        ) );
        $wp_customize->add_control( 'carvice_chat_system_prompt', array(
            'label'   => __( 'System Prompt', 'carvice' ),
            'section' => 'carvice_chat_section',
            'type'    => 'textarea',
        ) );
    }

    /* ------------------------------------------------------------------
     * Helpers
     * ----------------------------------------------------------------*/

    private function default_system_prompt() {
        return "You are Carvice AI, a friendly car service concierge for Armenia. You help users find the right auto service providers, explain car services, and answer car-related questions. You can respond in Armenian, Russian, or English depending on the user's language.\n\nRules:\n- Answer car service questions clearly and helpfully\n- Help users find service centers, individual mechanics, or dealers\n- If asked about pricing, say approximate ranges and recommend contacting the provider directly\n- Keep responses concise: 2-3 sentences for simple questions\n- Never make up specific provider names or phone numbers unless they exist on the site";
    }

    private function mock_response( $message ) {
        $lower = mb_strtolower( $message );

        if ( false !== strpos( $lower, 'oil' ) || false !== strpos( $lower, 'change' ) ) {
            return __( 'Oil change prices typically range from 5,000-15,000 AMD depending on the oil type and your vehicle. Check our service center listings for providers near you!', 'carvice' );
        }

        if ( false !== strpos( $lower, 'service' ) || false !== strpos( $lower, 'find' ) ) {
            return __( 'You can browse our service categories above to find the right specialist. Filter by service type or car brand to narrow your search.', 'carvice' );
        }

        if ( false !== strpos( $lower, 'specialist' ) || false !== strpos( $lower, 'call' ) ) {
            return __( 'I can help you find a specialist! What kind of service does your car need? For example: engine repair, body work, electrical diagnostics, etc.', 'carvice' );
        }

        return __( 'Thanks for your question! I can help you find car service providers, check approximate prices, or explain different car services. What would you like to know?', 'carvice' );
    }

    private function get_client_ip() {
        $keys = array( 'HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR' );
        foreach ( $keys as $key ) {
            if ( ! empty( $_SERVER[ $key ] ) ) {
                $ip = explode( ',', sanitize_text_field( wp_unslash( $_SERVER[ $key ] ) ) );
                return trim( $ip[0] );
            }
        }
        return '127.0.0.1';
    }
}
