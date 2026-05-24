<?php
/**
 * TourVice AI Chat — REST API endpoint, rate limiting, and Customizer settings.
 *
 * @package TourVice
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TourVice_Chat
 */
class TourVice_Chat {

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
			'tourvice/v1',
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
		$transient = 'tourvice_chat_' . md5( $ip );
		$count     = (int) get_transient( $transient );

		if ( $count >= self::RATE_LIMIT ) {
			return new \WP_Error(
				'rate_limit',
				__( 'Too many requests. Please wait a moment and try again.', 'tourvice' ),
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

		$api_key = get_option( 'tourvice_chat_api_key', '' );
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
				__( 'Unable to reach the AI service. Please try again later.', 'tourvice' ),
				array( 'status' => 502 )
			);
		}

		$code = wp_remote_retrieve_response_code( $response );
		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( $code !== 200 || empty( $data['content'][0]['text'] ) ) {
			return new \WP_Error(
				'api_error',
				__( 'Unable to process your request. Please try again.', 'tourvice' ),
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
		$reply = __( 'Welcome to TourVice! I can help you discover luxury tours across Armenia — from ancient monasteries to wine country adventures. What interests you?', 'tourvice' );

		if ( preg_match( '/book|reserv/', $lower ) ) {
			$reply = __( 'To book a tour, browse our Tours page and click "Book Now" on any tour that catches your eye. You\'ll need to select your preferred date and group size. Free cancellation up to 48 hours before departure!', 'tourvice' );
		} elseif ( preg_match( '/price|cost|how much|rate|budget/', $lower ) ) {
			$reply = __( 'Our tours range from $150 for day trips to $3,000+ for multi-day luxury experiences. Visit our Tours page for current pricing. Group discounts are available for parties of 6 or more!', 'tourvice' );
		} elseif ( preg_match( '/location|where|region|yerevan|ararat|sevan|dilijan|tatev|garni|geghard/', $lower ) ) {
			$reply = __( 'We offer tours across all of Armenia — Yerevan city walks, Ararat valley wine tours, Lake Sevan retreats, Dilijan forest hikes, Tatev aerial tramway adventures, and Garni-Geghard temple visits. Use our location filter to find tours near your interests!', 'tourvice' );
		} elseif ( preg_match( '/cancel|refund/', $lower ) ) {
			$reply = __( 'You can cancel for free up to 48 hours before your tour departure. After that, a 50% cancellation fee applies. Contact us directly for special circumstances.', 'tourvice' );
		} elseif ( preg_match( '/group|private|custom/', $lower ) ) {
			$reply = __( 'We offer both group tours (2-15 people) and private luxury experiences. Private tours include a dedicated guide, luxury vehicle, and fully customizable itinerary. Contact us for a personalized quote!', 'tourvice' );
		} elseif ( preg_match( '/food|wine|cuisine|dinner|lunch|tasting/', $lower ) ) {
			$reply = __( 'Armenian cuisine is a highlight of our tours! We offer dedicated wine tours in the Areni region, cooking classes in Yerevan, and all multi-day tours include authentic local dining experiences with traditional lavash, khorovats, and more.', 'tourvice' );
		} elseif ( preg_match( '/season|weather|best time|when/', $lower ) ) {
			$reply = __( 'Armenia is beautiful year-round! Spring (April-May) and autumn (September-October) are ideal for hiking and sightseeing. Summer is perfect for Lake Sevan. Winter offers unique ski resort experiences in Tsaghkadzor. We have tours for every season!', 'tourvice' );
		}

		return rest_ensure_response( array( 'reply' => $reply ) );
	}

	/* ------------------------------------------------------------------
	 * SYSTEM PROMPT
	 * ----------------------------------------------------------------*/

	/**
	 * Get the system prompt — Customizer override or default.
	 *
	 * @return string
	 */
	private static function get_system_prompt() {
		$custom = get_theme_mod( 'tourvice_chat_system_prompt', '' );
		if ( ! empty( $custom ) ) {
			return $custom;
		}

		return 'You are TourVice Assistant, a knowledgeable and warm AI concierge for TourVice — a luxury Armenian tourism service. You help visitors discover and book premium tours across Armenia, from ancient monastery visits and wine country experiences to adventure treks and cultural immersions. You know Armenian geography, history, cuisine, and culture deeply. Keep answers concise, enthusiastic, and helpful. Guide users to the booking form for reservations. Always highlight the unique luxury aspects of the experience. Respond in the language the user writes in.';
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
		$wp_customize->add_section( 'tourvice_chat_section', array(
			'title'    => __( 'AI Chat Widget', 'tourvice' ),
			'priority' => 200,
		) );

		// Enable / disable.
		$wp_customize->add_setting( 'tourvice_chat_enabled', array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		) );
		$wp_customize->add_control( 'tourvice_chat_enabled', array(
			'label'   => __( 'Enable Chat Widget', 'tourvice' ),
			'section' => 'tourvice_chat_section',
			'type'    => 'checkbox',
		) );

		// API key.
		$wp_customize->add_setting( 'tourvice_chat_api_key', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'tourvice_chat_api_key', array(
			'label'       => __( 'Anthropic API Key', 'tourvice' ),
			'description' => __( 'Leave empty for demo mode (mock responses).', 'tourvice' ),
			'section'     => 'tourvice_chat_section',
			'type'        => 'password',
		) );

		// Chat title.
		$wp_customize->add_setting( 'tourvice_chat_title', array(
			'default'           => __( 'TourVice Concierge', 'tourvice' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'tourvice_chat_title', array(
			'label'   => __( 'Chat Window Title', 'tourvice' ),
			'section' => 'tourvice_chat_section',
			'type'    => 'text',
		) );

		// System prompt override.
		$wp_customize->add_setting( 'tourvice_chat_system_prompt', array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		) );
		$wp_customize->add_control( 'tourvice_chat_system_prompt', array(
			'label'       => __( 'System Prompt Override', 'tourvice' ),
			'description' => __( 'Leave empty to use the default Armenian luxury tourism prompt.', 'tourvice' ),
			'section'     => 'tourvice_chat_section',
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

		$enabled = get_theme_mod( 'tourvice_chat_enabled', true );
		if ( ! $enabled ) {
			return;
		}

		$theme_uri     = get_template_directory_uri();
		$theme_version = defined( 'TOURVICE_VERSION' ) ? TOURVICE_VERSION : TOURVICE_CORE_VERSION;

		wp_enqueue_style(
			'tourvice-chat',
			$theme_uri . '/assets/css/tourvice-chat.css',
			array(),
			$theme_version
		);

		wp_enqueue_script(
			'tourvice-chat',
			$theme_uri . '/assets/js/tourvice-chat.js',
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
		return (bool) get_theme_mod( 'tourvice_chat_enabled', true );
	}

	/**
	 * Get the chat window title.
	 *
	 * @return string
	 */
	public static function get_title() {
		return get_theme_mod( 'tourvice_chat_title', __( 'TourVice Concierge', 'tourvice' ) );
	}
}

TourVice_Chat::init();
