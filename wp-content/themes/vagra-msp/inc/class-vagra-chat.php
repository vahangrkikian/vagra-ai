<?php
/**
 * Vagra Chat Handler
 *
 * Handles chat configuration, REST API proxy, and rate limiting.
 *
 * @package Vagra_MSP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Vagra_MSP_Chat {

    /**
     * Theme slug for prefixing.
     *
     * @var string
     */
    private $slug = 'vagra_msp';

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    /**
     * Register REST API route.
     */
    public function register_routes() {
        register_rest_route( 'vagra/v1', '/chat', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handle_chat' ),
            'permission_callback' => '__return_true',
        ) );
    }

    /**
     * Enqueue chat assets if enabled.
     */
    public function enqueue_assets() {
        if ( ! $this->is_enabled() ) {
            return;
        }

        wp_enqueue_style(
            $this->slug . '-chat',
            get_template_directory_uri() . '/assets/css/vagra-chat.css',
            array(),
            defined( 'VAGRA_MSP_VERSION' ) ? VAGRA_MSP_VERSION : '1.0.0'
        );

        wp_enqueue_script(
            $this->slug . '-chat',
            get_template_directory_uri() . '/assets/js/vagra-chat.js',
            array(),
            defined( 'VAGRA_MSP_VERSION' ) ? VAGRA_MSP_VERSION : '1.0.0',
            true
        );
    }

    /**
     * Check if chat is enabled.
     *
     * @return bool
     */
    public function is_enabled() {
        return (bool) get_theme_mod( $this->slug . '_chat_enabled', true );
    }

    /**
     * Get the API key.
     *
     * @return string
     */
    private function get_api_key() {
        $key = get_option( $this->slug . '_chat_api_key', '' );
        return is_string( $key ) ? $key : '';
    }

    /**
     * Get the system prompt.
     *
     * @return string
     */
    private function get_system_prompt() {
        $custom = get_theme_mod( $this->slug . '_chat_system_prompt', '' );
        if ( ! empty( $custom ) ) {
            return sanitize_textarea_field( $custom );
        }

        global $wp_filesystem;
        if ( empty( $wp_filesystem ) ) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $file = get_template_directory() . '/inc/chat-prompts/vagra-msp.txt';
        if ( $wp_filesystem && $wp_filesystem->exists( $file ) ) {
            return $wp_filesystem->get_contents( $file );
        }

        return 'You are a helpful assistant.';
    }

    /**
     * Get the chat title.
     *
     * @return string
     */
    public function get_chat_title() {
        $title = get_theme_mod( $this->slug . '_chat_title', '' );
        return ! empty( $title ) ? $title : __( 'Ask us anything', 'vagra-msp' );
    }

    /**
     * Get the disclaimer text.
     *
     * @return string
     */
    public function get_disclaimer() {
        return get_theme_mod( $this->slug . '_chat_disclaimer', '' );
    }

    /**
     * Check rate limiting.
     *
     * @return bool True if within limits.
     */
    private function check_rate_limit() {
        $ip_hash   = md5( sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? 'unknown' ) ) );
        $key       = $this->slug . '_chat_rate_' . $ip_hash;
        $count     = (int) get_transient( $key );

        if ( $count >= 20 ) {
            return false;
        }

        set_transient( $key, $count + 1, HOUR_IN_SECONDS );
        return true;
    }

    /**
     * Handle chat API request.
     *
     * @param WP_REST_Request $request The request.
     * @return WP_REST_Response|WP_Error
     */
    public function handle_chat( $request ) {
        if ( ! $this->is_enabled() ) {
            return new WP_Error( 'chat_disabled', __( 'Chat is currently disabled.', 'vagra-msp' ), array( 'status' => 403 ) );
        }

        $api_key = $this->get_api_key();
        if ( empty( $api_key ) ) {
            return new WP_Error( 'no_api_key', __( 'Chat is not configured. Please add an API key in the Customizer.', 'vagra-msp' ), array( 'status' => 503 ) );
        }

        if ( ! $this->check_rate_limit() ) {
            return new WP_Error( 'rate_limited', __( 'Too many requests. Please try again later.', 'vagra-msp' ), array( 'status' => 429 ) );
        }

        $message = sanitize_text_field( $request->get_param( 'message' ) );
        $history = $request->get_param( 'history' );

        if ( empty( $message ) ) {
            return new WP_Error( 'empty_message', __( 'Message cannot be empty.', 'vagra-msp' ), array( 'status' => 400 ) );
        }

        // Build messages array for Claude API
        $system_prompt = $this->get_system_prompt();
        $api_messages  = array();

        // Add history
        if ( is_array( $history ) ) {
            foreach ( $history as $entry ) {
                if ( isset( $entry['role'], $entry['content'] ) ) {
                    $role = ( $entry['role'] === 'user' ) ? 'user' : 'assistant';
                    $api_messages[] = array(
                        'role'    => $role,
                        'content' => sanitize_text_field( $entry['content'] ),
                    );
                }
            }
        }

        // Add current message
        $api_messages[] = array(
            'role'    => 'user',
            'content' => $message,
        );

        // Call Claude API
        $response = wp_remote_post( 'https://api.anthropic.com/v1/messages', array(
            'timeout' => 30,
            'headers' => array(
                'Content-Type'      => 'application/json',
                'x-api-key'         => $api_key,
                'anthropic-version' => '2023-06-01',
            ),
            'body' => wp_json_encode( array(
                'model'      => 'claude-sonnet-4-5-20250514',
                'max_tokens' => 512,
                'system'     => $system_prompt,
                'messages'   => $api_messages,
            ) ),
        ) );

        if ( is_wp_error( $response ) ) {
            return new WP_Error( 'api_error', __( 'Could not connect to the AI service.', 'vagra-msp' ), array( 'status' => 502 ) );
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( empty( $body['content'][0]['text'] ) ) {
            return new WP_Error( 'api_error', __( 'Received an unexpected response from the AI service.', 'vagra-msp' ), array( 'status' => 502 ) );
        }

        return rest_ensure_response( array(
            'reply' => $body['content'][0]['text'],
        ) );
    }
}
