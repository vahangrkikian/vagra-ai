<?php
/**
 * DNS Propagation REST API
 *
 * Registers /vagra-msp/v1/propagation endpoint for the DNS Propagation Checker tool.
 *
 * @package Vagra_MSP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vagra_DNS_Propagation {

	/**
	 * Allowed record types for propagation checks.
	 */
	const RECORD_TYPES = array( 'A', 'AAAA', 'CNAME', 'MX', 'NS', 'TXT', 'SOA', 'CAA', 'SRV' );

	/**
	 * Public DNS resolvers — 12 resolvers across 6 regions.
	 */
	private static $resolvers = array(
		array( 'name' => 'Google',       'ip' => '8.8.8.8',         'location' => 'Mountain View, US',  'country' => 'US' ),
		array( 'name' => 'Cloudflare',   'ip' => '1.1.1.1',         'location' => 'San Francisco, US',  'country' => 'US' ),
		array( 'name' => 'Quad9',        'ip' => '9.9.9.9',         'location' => 'Zurich, CH',         'country' => 'CH' ),
		array( 'name' => 'OpenDNS',      'ip' => '208.67.222.222',  'location' => 'San Francisco, US',  'country' => 'US' ),
		array( 'name' => 'CleanBrowsing','ip' => '185.228.168.9',   'location' => 'London, UK',         'country' => 'GB' ),
		array( 'name' => 'AdGuard',      'ip' => '94.140.14.14',    'location' => 'Limassol, CY',       'country' => 'CY' ),
		array( 'name' => 'Comodo',       'ip' => '8.26.56.26',      'location' => 'Clifton, US',        'country' => 'US' ),
		array( 'name' => 'Neustar',      'ip' => '64.6.64.6',       'location' => 'Sterling, US',       'country' => 'US' ),
		array( 'name' => 'Yandex',       'ip' => '77.88.8.8',       'location' => 'Moscow, RU',         'country' => 'RU' ),
		array( 'name' => 'Level3',       'ip' => '209.244.0.3',     'location' => 'Monroe, US',         'country' => 'US' ),
		array( 'name' => 'DNS.Watch',    'ip' => '84.200.69.80',    'location' => 'Düsseldorf, DE',     'country' => 'DE' ),
		array( 'name' => 'AliDNS',       'ip' => '223.5.5.5',       'location' => 'Hangzhou, CN',       'country' => 'CN' ),
	);

	/**
	 * Boot: register REST routes.
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
	}

	/**
	 * Register REST routes.
	 */
	public static function register_routes() {
		register_rest_route( 'vagra-msp/v1', '/propagation', array(
			'methods'             => 'POST',
			'callback'            => array( __CLASS__, 'handle_propagation' ),
			'permission_callback' => '__return_true',
			'args'                => array(
				'domain' => array(
					'required'          => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_domain' ),
				),
				'type'   => array(
					'required'          => false,
					'default'           => 'A',
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
		) );
	}

	/**
	 * Sanitize domain input.
	 */
	public static function sanitize_domain( $domain ) {
		$domain = strtolower( trim( $domain ) );
		$domain = preg_replace( '/^https?:\/\//', '', $domain );
		$domain = preg_replace( '/\/.*$/', '', $domain );
		$domain = preg_replace( '/[^a-z0-9.\-]/', '', $domain );
		return $domain;
	}

	/**
	 * Rate limiting check.
	 */
	private static function check_rate_limit() {
		$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '0.0.0.0';
		$key = 'vagra_prop_rate_' . md5( $ip );
		$count = (int) get_transient( $key );

		if ( $count >= 30 ) {
			return new WP_Error(
				'rate_limited',
				__( 'Rate limit exceeded. Please try again later.', 'vagra-msp' ),
				array( 'status' => 429 )
			);
		}

		set_transient( $key, $count + 1, HOUR_IN_SECONDS );
		return true;
	}

	/**
	 * Handle propagation check.
	 */
	public static function handle_propagation( $request ) {
		$rate = self::check_rate_limit();
		if ( is_wp_error( $rate ) ) {
			return $rate;
		}

		$domain = $request->get_param( 'domain' );
		$type   = strtoupper( $request->get_param( 'type' ) );

		if ( ! $domain ) {
			return new WP_Error( 'invalid_domain', __( 'A valid domain is required.', 'vagra-msp' ), array( 'status' => 400 ) );
		}

		if ( ! in_array( $type, self::RECORD_TYPES, true ) ) {
			return new WP_Error( 'invalid_type', __( 'Unsupported record type.', 'vagra-msp' ), array( 'status' => 400 ) );
		}

		$results = array();

		foreach ( self::$resolvers as $res ) {
			$start   = microtime( true );
			$records = self::query_dns( $domain, $type, $res['ip'] );
			$elapsed = round( ( microtime( true ) - $start ) * 1000, 1 );

			$value = '';
			if ( ! empty( $records ) && isset( $records[0]['value'] ) ) {
				$value = $records[0]['value'];
			}

			$results[] = array(
				'resolver' => $res['name'],
				'ip'       => $res['ip'],
				'location' => $res['location'],
				'country'  => $res['country'],
				'status'   => empty( $records ) ? 'fail' : 'ok',
				'value'    => $value,
				'ttl'      => ! empty( $records ) && isset( $records[0]['ttl'] ) ? $records[0]['ttl'] : 0,
				'time'     => $elapsed,
				'records'  => $records,
			);
		}

		return rest_ensure_response( array(
			'domain'    => $domain,
			'type'      => $type,
			'resolvers' => $results,
		) );
	}

	/**
	 * Query DNS via dig for a specific resolver.
	 */
	private static function query_dns( $domain, $type, $resolver_ip ) {
		$dig_type = $type;
		$cmd = sprintf(
			'dig @%s %s %s +short +time=3 +tries=1 2>/dev/null',
			escapeshellarg( $resolver_ip ),
			escapeshellarg( $domain ),
			escapeshellarg( $dig_type )
		);

		$output = array();
		$code   = 0;
		exec( $cmd, $output, $code ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.system_calls_exec

		if ( 0 !== $code || empty( $output ) ) {
			return array();
		}

		$records = array();
		foreach ( $output as $line ) {
			$line = trim( $line );
			if ( '' === $line ) {
				continue;
			}
			$records[] = array(
				'value' => $line,
				'ttl'   => self::get_ttl( $domain, $type, $resolver_ip ),
			);
		}

		return $records;
	}

	/**
	 * Get TTL for a record via dig.
	 */
	private static function get_ttl( $domain, $type, $resolver_ip ) {
		$cmd = sprintf(
			'dig @%s %s %s +noall +answer +time=2 +tries=1 2>/dev/null | head -1',
			escapeshellarg( $resolver_ip ),
			escapeshellarg( $domain ),
			escapeshellarg( $type )
		);

		$output = array();
		exec( $cmd, $output ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.system_calls_exec

		if ( ! empty( $output[0] ) && preg_match( '/\s+(\d+)\s+IN\s+/', $output[0], $m ) ) {
			return (int) $m[1];
		}

		return 0;
	}
}
