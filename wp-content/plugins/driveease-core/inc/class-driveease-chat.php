<?php
/**
 * DriveEase AI Chat — REST API endpoint, rate limiting, and Customizer settings.
 *
 * @package DriveEase
 * @since   1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DriveEase_Chat
 */
class DriveEase_Chat {

	/** Maximum requests per window. */
	const RATE_LIMIT = 15;

	/** Rate limit window in seconds (5 minutes). */
	const RATE_WINDOW = 300;

	/**
	 * Boot hooks.
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
		add_action( 'customize_register', array( __CLASS__, 'customizer' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	/* ------------------------------------------------------------------
	 * REST API
	 * ----------------------------------------------------------------*/

	/**
	 * Register the chat REST route.
	 */
	public static function register_routes() {
		register_rest_route(
			'driveease/v1',
			'/chat',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'handle_chat' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'message' => array(
						'required'          => true,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'history' => array(
						'required' => false,
						'default'  => array(),
					),
				),
			)
		);
	}

	/**
	 * Handle a chat message.
	 *
	 * @param \WP_REST_Request $request The request.
	 * @return \WP_REST_Response|\WP_Error
	 */
	public static function handle_chat( $request ) {
		// Rate limiting.
		$ip        = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );
		$transient = 'driveease_chat_' . md5( $ip );
		$count     = (int) get_transient( $transient );

		if ( $count >= self::RATE_LIMIT ) {
			return new \WP_Error(
				'rate_limit',
				__( 'Too many requests. Please wait a moment and try again.', 'driveease' ),
				array( 'status' => 429 )
			);
		}

		set_transient( $transient, $count + 1, self::RATE_WINDOW );

		$message = $request->get_param( 'message' );
		$history = $request->get_param( 'history' );

		// Sanitize history.
		$clean_history = array();
		if ( is_array( $history ) ) {
			foreach ( array_slice( $history, -20 ) as $entry ) {
				if ( isset( $entry['role'], $entry['content'] ) ) {
					$role = in_array( $entry['role'], array( 'user', 'assistant' ), true ) ? $entry['role'] : 'user';
					$clean_history[] = array(
						'role'    => $role,
						'content' => sanitize_text_field( $entry['content'] ),
					);
				}
			}
		}

		$api_key = get_option( 'driveease_chat_api_key', '' );
		if ( empty( $api_key ) ) {
			return self::mock_response( $message );
		}

		// Build messages for Claude API.
		$messages   = $clean_history;
		$messages[] = array(
			'role'    => 'user',
			'content' => $message,
		);

		$system_prompt = self::get_system_prompt();

		$body = wp_json_encode( array(
			'model'      => 'claude-haiku-4-5-20251001',
			'max_tokens' => 512,
			'system'     => $system_prompt,
			'messages'   => $messages,
		) );

		$response = wp_remote_post(
			'https://api.anthropic.com/v1/messages',
			array(
				'timeout' => 30,
				'headers' => array(
					'Content-Type'      => 'application/json',
					'x-api-key'         => $api_key,
					'anthropic-version'  => '2023-06-01',
				),
				'body'    => $body,
			)
		);

		if ( is_wp_error( $response ) ) {
			return new \WP_Error(
				'api_error',
				__( 'Unable to reach the AI service. Please try again later.', 'driveease' ),
				array( 'status' => 502 )
			);
		}

		$code = wp_remote_retrieve_response_code( $response );
		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( $code !== 200 || empty( $data['content'][0]['text'] ) ) {
			return new \WP_Error(
				'api_error',
				__( 'Unable to process your request. Please try again.', 'driveease' ),
				array( 'status' => 502 )
			);
		}

		return rest_ensure_response( array(
			'reply' => $data['content'][0]['text'],
		) );
	}

	/**
	 * Return a mock response when no API key is configured.
	 *
	 * @param string $message User message.
	 * @return \WP_REST_Response
	 */
	private static function mock_response( $message ) {
		$lower = strtolower( $message );
		$reply = __( 'Thanks for reaching out! I can help with fleet info, booking questions, and rental policies. What would you like to know?', 'driveease' );

		if ( preg_match( '/book|reserv|rent/', $lower ) ) {
			$reply = __( 'To make a reservation, browse our Fleet page and click "Book Now" on any car. You\'ll need your driver\'s license and a valid credit card. Free cancellation up to 24h before pick-up!', 'driveease' );
		} elseif ( preg_match( '/price|cost|how much|rate/', $lower ) ) {
			$reply = __( 'Our prices vary by vehicle category. Visit the Fleet page to see current daily rates. We also offer extras like GPS ($8/day), Child Seat ($12/day), and Wi-Fi ($6/day).', 'driveease' );
		} elseif ( preg_match( '/locat|branch|address|where/', $lower ) ) {
			$reply = __( 'We have multiple branches for your convenience. Check our Contact page for addresses, phone numbers, and working hours for each location.', 'driveease' );
		} elseif ( preg_match( '/cancel|refund/', $lower ) ) {
			$reply = __( 'You can cancel for free up to 24 hours before your pick-up time. After that, a cancellation fee may apply. Check your booking confirmation email for details.', 'driveease' );
		} elseif ( preg_match( '/insur|cover|damage/', $lower ) ) {
			$reply = __( 'Basic insurance is included with every rental. You can add Premium Insurance ($18/day) for extra peace of mind. For claims or disputes, please contact our support team directly.', 'driveease' );
		} elseif ( preg_match( '/document|license|require|need|age/', $lower ) ) {
			$reply = __( 'You\'ll need a valid driver\'s license (held for at least 1 year), a credit card in your name, and you must be at least 21 years old. Bring your license to pick-up!', 'driveease' );
		} elseif ( preg_match( '/fuel|gas|petrol/', $lower ) ) {
			$reply = __( 'We use a full-to-full fuel policy. Pick up with a full tank and return it full. If the tank isn\'t full on return, a refueling charge will apply.', 'driveease' );
		}

		return rest_ensure_response( array( 'reply' => $reply ) );
	}

	/* ------------------------------------------------------------------
	 * SYSTEM PROMPT
	 * ----------------------------------------------------------------*/

	/**
	 * Get the system prompt — Customizer override, then file fallback.
	 *
	 * @return string
	 */
	private static function get_system_prompt() {
		$custom = get_theme_mod( 'driveease_chat_system_prompt', '' );
		if ( ! empty( $custom ) ) {
			return $custom;
		}

		$file = DRIVEEASE_CORE_DIR . 'inc/chat-prompts/driveease.txt';
		if ( file_exists( $file ) ) {
			return file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		}

		return 'You are a helpful car rental assistant for DriveEase. Keep answers concise and guide users to the booking form for reservations.';
	}

	/* ------------------------------------------------------------------
	 * CUSTOMIZER
	 * ----------------------------------------------------------------*/

	/**
	 * Register Customizer settings for the chat widget.
	 *
	 * @param \WP_Customize_Manager $wp_customize Customizer manager.
	 */
	public static function customizer( $wp_customize ) {
		$wp_customize->add_section( 'driveease_chat_section', array(
			'title'    => __( 'AI Chat Widget', 'driveease' ),
			'priority' => 200,
		) );

		// Enable / disable.
		$wp_customize->add_setting( 'driveease_chat_enabled', array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		) );
		$wp_customize->add_control( 'driveease_chat_enabled', array(
			'label'   => __( 'Enable Chat Widget', 'driveease' ),
			'section' => 'driveease_chat_section',
			'type'    => 'checkbox',
		) );

		// API key.
		$wp_customize->add_setting( 'driveease_chat_api_key', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'driveease_chat_api_key', array(
			'label'       => __( 'Anthropic API Key', 'driveease' ),
			'description' => __( 'Leave empty for demo mode (mock responses).', 'driveease' ),
			'section'     => 'driveease_chat_section',
			'type'        => 'password',
		) );

		// Chat title.
		$wp_customize->add_setting( 'driveease_chat_title', array(
			'default'           => __( 'DriveEase Assistant', 'driveease' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'driveease_chat_title', array(
			'label'   => __( 'Chat Window Title', 'driveease' ),
			'section' => 'driveease_chat_section',
			'type'    => 'text',
		) );

		// System prompt override.
		$wp_customize->add_setting( 'driveease_chat_system_prompt', array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		) );
		$wp_customize->add_control( 'driveease_chat_system_prompt', array(
			'label'       => __( 'System Prompt Override', 'driveease' ),
			'description' => __( 'Leave empty to use the default prompt from chat-prompts/driveease.txt.', 'driveease' ),
			'section'     => 'driveease_chat_section',
			'type'        => 'textarea',
		) );
	}

	/* ------------------------------------------------------------------
	 * ASSET ENQUEUE
	 * ----------------------------------------------------------------*/

	/**
	 * Enqueue chat widget assets on the frontend.
	 */
	public static function enqueue_assets() {
		if ( is_admin() ) {
			return;
		}

		$enabled = get_theme_mod( 'driveease_chat_enabled', true );
		if ( ! $enabled ) {
			return;
		}

		$theme_uri    = get_template_directory_uri();
		$theme_version = defined( 'DRIVEEASE_VERSION' ) ? DRIVEEASE_VERSION : DRIVEEASE_CORE_VERSION;

		wp_enqueue_style(
			'driveease-chat',
			$theme_uri . '/assets/css/driveease-chat.css',
			array(),
			$theme_version
		);

		wp_enqueue_script(
			'driveease-chat',
			$theme_uri . '/assets/js/driveease-chat.js',
			array(),
			$theme_version,
			true
		);
	}

	/**
	 * Check if the chat widget is enabled.
	 *
	 * @return bool
	 */
	public static function is_enabled() {
		return (bool) get_theme_mod( 'driveease_chat_enabled', true );
	}

	/**
	 * Get the chat window title.
	 *
	 * @return string
	 */
	public static function get_title() {
		return get_theme_mod( 'driveease_chat_title', __( 'DriveEase Assistant', 'driveease' ) );
	}
}

DriveEase_Chat::init();
