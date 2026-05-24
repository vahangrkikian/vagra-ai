<?php
/**
 * Meridian Chat — REST API endpoint and Customizer settings.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Meridian_Chat {

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
		register_rest_route( 'meridian/v1', '/chat', array(
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
		$key  = 'meridian_chat_' . md5( $ip );
		$hits = (int) get_transient( $key );

		if ( $hits >= self::RATE_LIMIT ) {
			return new WP_Error(
				'rate_limited',
				__( 'Too many requests. Please wait a moment and try again.', 'meridian' ),
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
				__( 'Message cannot be empty.', 'meridian' ),
				array( 'status' => 400 )
			);
		}

		// API key check.
		$api_key = get_option( 'meridian_chat_api_key', '' );

		if ( empty( $api_key ) ) {
			return rest_ensure_response( array(
				'reply' => $this->mock_response( $message ),
			) );
		}

		// Build messages array.
		$messages = array();

		// System prompt.
		$system_prompt = get_theme_mod(
			'meridian_chat_system_prompt',
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
				__( 'Could not reach the AI service. Please try again.', 'meridian' ),
				array( 'status' => 502 )
			);
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $body['content'][0]['text'] ) ) {
			return new WP_Error(
				'api_error',
				__( 'Unexpected response from the AI service.', 'meridian' ),
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
		$wp_customize->add_section( 'meridian_chat_section', array(
			'title'    => __( 'AI Chat Settings', 'meridian' ),
			'priority' => 200,
		) );

		// API Key.
		$wp_customize->add_setting( 'meridian_chat_api_key', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'meridian_chat_api_key', array(
			'label'   => __( 'Claude API Key', 'meridian' ),
			'section' => 'meridian_chat_section',
			'type'    => 'password',
		) );

		// System Prompt.
		$wp_customize->add_setting( 'meridian_chat_system_prompt', array(
			'default'           => $this->default_system_prompt(),
			'sanitize_callback' => 'sanitize_textarea_field',
		) );
		$wp_customize->add_control( 'meridian_chat_system_prompt', array(
			'label'   => __( 'System Prompt', 'meridian' ),
			'section' => 'meridian_chat_section',
			'type'    => 'textarea',
		) );
	}

	/* ------------------------------------------------------------------
	 * Helpers
	 * ----------------------------------------------------------------*/

	private function default_system_prompt() {
		return "You are The Meridian Concierge, a sophisticated and warm luxury hotel AI assistant. You help guests with room inquiries, booking assistance, amenities information, dining recommendations, and local attractions. You embody elegance, attentiveness, and genuine hospitality.\n\nRules:\n- Maintain a refined yet approachable tone befitting a luxury hotel concierge\n- Help guests choose the perfect room, understand amenities, and plan their stay\n- If asked about specific pricing, provide the listed rates and recommend booking directly\n- Keep responses concise: 2-3 sentences for simple questions, more for detailed inquiries\n- Never fabricate room details, availability, or services that do not exist on the site\n- You may assist in English, Armenian, Russian, or other languages as needed";
	}

	private function mock_response( $message ) {
		$lower = mb_strtolower( $message );

		if ( false !== strpos( $lower, 'room' ) || false !== strpos( $lower, 'suite' ) ) {
			return __( 'We offer a curated selection of rooms and suites, each designed for ultimate comfort. Browse our Rooms page to find the perfect accommodation for your stay, or let me know your preferences and I can recommend one.', 'meridian' );
		}

		if ( false !== strpos( $lower, 'book' ) || false !== strpos( $lower, 'reserv' ) ) {
			return __( 'I would be delighted to help you with your reservation. Simply select your preferred room, choose your dates, and complete the booking form. You will receive an instant confirmation with all the details.', 'meridian' );
		}

		if ( false !== strpos( $lower, 'amenit' ) || false !== strpos( $lower, 'spa' ) || false !== strpos( $lower, 'pool' ) ) {
			return __( 'The Meridian features world-class amenities including our signature spa, infinity pool, fitness center, and fine dining restaurant. Each room also comes with premium in-room amenities for your comfort.', 'meridian' );
		}

		if ( false !== strpos( $lower, 'price' ) || false !== strpos( $lower, 'cost' ) || false !== strpos( $lower, 'rate' ) ) {
			return __( 'Our room rates vary by category and season. Visit our Rooms page to see current pricing, or tell me your preferred room type and travel dates for a personalized quote.', 'meridian' );
		}

		return __( 'Welcome to The Meridian. I am your personal concierge and I am here to make your experience exceptional. How may I assist you today? Whether it is room selection, dining, spa services, or local recommendations, I am at your service.', 'meridian' );
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
