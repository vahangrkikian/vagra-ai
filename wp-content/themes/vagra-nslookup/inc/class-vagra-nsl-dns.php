<?php
/**
 * DNS Lookup REST API
 *
 * Registers /vagra-nsl/v1/lookup, /vagra-nsl/v1/propagation, and /vagra-nsl/v1/contact endpoints.
 *
 * @package Vagra_NSLookup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vagra_NSL_DNS {

	/**
	 * Allowed record types.
	 */
	const RECORD_TYPES = array(
		'A', 'AAAA', 'CNAME', 'MX', 'NS', 'TXT',
		'SOA', 'SRV', 'CAA', 'PTR', 'NAPTR', 'DNSKEY', 'DS',
	);

	/**
	 * Public DNS resolvers registry.
	 */
	private static $resolvers = array(
		array( 'name' => 'Google',          'ip' => '8.8.8.8',         'location' => 'Mountain View, US',   'country' => 'US', 'x' => 15, 'y' => 38 ),
		array( 'name' => 'Google 2',        'ip' => '8.8.4.4',         'location' => 'Mountain View, US',   'country' => 'US', 'x' => 15, 'y' => 39 ),
		array( 'name' => 'Cloudflare',      'ip' => '1.1.1.1',         'location' => 'San Francisco, US',   'country' => 'US', 'x' => 13, 'y' => 38 ),
		array( 'name' => 'Cloudflare 2',    'ip' => '1.0.0.1',         'location' => 'San Francisco, US',   'country' => 'US', 'x' => 13, 'y' => 39 ),
		array( 'name' => 'Quad9',           'ip' => '9.9.9.9',         'location' => 'Zurich, CH',          'country' => 'CH', 'x' => 51, 'y' => 30 ),
		array( 'name' => 'Quad9 2',         'ip' => '149.112.112.112', 'location' => 'Zurich, CH',          'country' => 'CH', 'x' => 51, 'y' => 31 ),
		array( 'name' => 'OpenDNS',         'ip' => '208.67.222.222',  'location' => 'San Francisco, US',   'country' => 'US', 'x' => 14, 'y' => 37 ),
		array( 'name' => 'OpenDNS 2',       'ip' => '208.67.220.220',  'location' => 'San Francisco, US',   'country' => 'US', 'x' => 14, 'y' => 38 ),
		array( 'name' => 'Comodo',          'ip' => '8.26.56.26',      'location' => 'Clifton, US',         'country' => 'US', 'x' => 25, 'y' => 36 ),
		array( 'name' => 'Comodo 2',        'ip' => '8.20.247.20',     'location' => 'Clifton, US',         'country' => 'US', 'x' => 25, 'y' => 37 ),
		array( 'name' => 'CleanBrowsing',   'ip' => '185.228.168.9',   'location' => 'London, UK',          'country' => 'GB', 'x' => 49, 'y' => 28 ),
		array( 'name' => 'AdGuard',         'ip' => '94.140.14.14',    'location' => 'Limassol, CY',        'country' => 'CY', 'x' => 55, 'y' => 34 ),
		array( 'name' => 'AdGuard 2',       'ip' => '94.140.15.15',    'location' => 'Limassol, CY',        'country' => 'CY', 'x' => 55, 'y' => 35 ),
		array( 'name' => 'Neustar',         'ip' => '64.6.64.6',       'location' => 'Sterling, US',        'country' => 'US', 'x' => 24, 'y' => 35 ),
		array( 'name' => 'Neustar 2',       'ip' => '64.6.65.6',       'location' => 'Sterling, US',        'country' => 'US', 'x' => 24, 'y' => 36 ),
		array( 'name' => 'Yandex',          'ip' => '77.88.8.8',       'location' => 'Moscow, RU',          'country' => 'RU', 'x' => 58, 'y' => 25 ),
		array( 'name' => 'Yandex 2',        'ip' => '77.88.8.1',       'location' => 'Moscow, RU',          'country' => 'RU', 'x' => 58, 'y' => 26 ),
		array( 'name' => 'Level3',          'ip' => '209.244.0.3',     'location' => 'Monroe, US',          'country' => 'US', 'x' => 22, 'y' => 37 ),
		array( 'name' => 'Level3 2',        'ip' => '209.244.0.4',     'location' => 'Monroe, US',          'country' => 'US', 'x' => 22, 'y' => 38 ),
		array( 'name' => 'DNS.Watch',       'ip' => '84.200.69.80',    'location' => 'Dusseldorf, DE',      'country' => 'DE', 'x' => 50, 'y' => 28 ),
		array( 'name' => 'DNS.Watch 2',     'ip' => '84.200.70.40',    'location' => 'Dusseldorf, DE',      'country' => 'DE', 'x' => 50, 'y' => 29 ),
		array( 'name' => 'Freenom',         'ip' => '80.80.80.80',     'location' => 'Amsterdam, NL',       'country' => 'NL', 'x' => 50, 'y' => 27 ),
		array( 'name' => 'Freenom 2',       'ip' => '80.80.81.81',     'location' => 'Amsterdam, NL',       'country' => 'NL', 'x' => 50, 'y' => 28 ),
		array( 'name' => 'SafeDNS',         'ip' => '195.46.39.39',    'location' => 'St Petersburg, RU',   'country' => 'RU', 'x' => 56, 'y' => 24 ),
		array( 'name' => 'SafeDNS 2',       'ip' => '195.46.39.40',    'location' => 'St Petersburg, RU',   'country' => 'RU', 'x' => 56, 'y' => 25 ),
		array( 'name' => 'CNNIC',           'ip' => '1.2.4.8',         'location' => 'Beijing, CN',         'country' => 'CN', 'x' => 76, 'y' => 36 ),
		array( 'name' => 'CNNIC 2',         'ip' => '210.2.4.8',       'location' => 'Beijing, CN',         'country' => 'CN', 'x' => 76, 'y' => 37 ),
		array( 'name' => 'AliDNS',          'ip' => '223.5.5.5',       'location' => 'Hangzhou, CN',        'country' => 'CN', 'x' => 78, 'y' => 38 ),
		array( 'name' => 'AliDNS 2',        'ip' => '223.6.6.6',       'location' => 'Hangzhou, CN',        'country' => 'CN', 'x' => 78, 'y' => 39 ),
		array( 'name' => 'Hurricane',       'ip' => '74.82.42.42',     'location' => 'Fremont, US',         'country' => 'US', 'x' => 13, 'y' => 37 ),
		array( 'name' => 'puntCAT',         'ip' => '109.69.8.51',     'location' => 'Barcelona, ES',       'country' => 'ES', 'x' => 48, 'y' => 33 ),
		array( 'name' => 'Telia',           'ip' => '193.239.0.70',    'location' => 'Stockholm, SE',       'country' => 'SE', 'x' => 52, 'y' => 23 ),
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
		register_rest_route( 'vagra-nsl/v1', '/lookup', array(
			'methods'             => 'POST',
			'callback'            => array( __CLASS__, 'handle_lookup' ),
			'permission_callback' => '__return_true',
			'args'                => array(
				'domain'   => array(
					'required'          => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_domain' ),
				),
				'type'     => array(
					'required'          => false,
					'default'           => 'A',
					'sanitize_callback' => 'sanitize_text_field',
				),
				'resolver' => array(
					'required'          => false,
					'default'           => 'auth',
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
		) );

		register_rest_route( 'vagra-nsl/v1', '/propagation', array(
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

		register_rest_route( 'vagra-nsl/v1', '/ns-lookup', array(
			'methods'             => 'POST',
			'callback'            => array( __CLASS__, 'handle_ns_lookup' ),
			'permission_callback' => '__return_true',
			'args'                => array(
				'domain'   => array(
					'required'          => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_domain' ),
				),
				'resolver' => array(
					'required'          => false,
					'default'           => 'auth',
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
		) );

		register_rest_route( 'vagra-nsl/v1', '/contact', array(
			'methods'             => 'POST',
			'callback'            => array( __CLASS__, 'handle_contact' ),
			'permission_callback' => '__return_true',
			'args'                => array(
				'name'    => array( 'required' => true, 'sanitize_callback' => 'sanitize_text_field' ),
				'email'   => array( 'required' => true, 'sanitize_callback' => 'sanitize_email' ),
				'topic'   => array( 'required' => false, 'default' => 'general', 'sanitize_callback' => 'sanitize_text_field' ),
				'subject' => array( 'required' => false, 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ),
				'message' => array( 'required' => true, 'sanitize_callback' => 'sanitize_textarea_field' ),
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
	 *
	 * @return bool|WP_Error True if allowed, WP_Error if rate limited.
	 */
	private static function check_rate_limit() {
		$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '0.0.0.0';
		$key = 'vagra_nsl_rate_' . md5( $ip );
		$count = (int) get_transient( $key );

		if ( $count >= 60 ) {
			return new WP_Error(
				'rate_limited',
				__( 'Rate limit exceeded. Please try again later.', 'vagra-nslookup' ),
				array( 'status' => 429 )
			);
		}

		set_transient( $key, $count + 1, HOUR_IN_SECONDS );
		return true;
	}

	/**
	 * Handle DNS lookup request.
	 */
	public static function handle_lookup( $request ) {
		$rate = self::check_rate_limit();
		if ( is_wp_error( $rate ) ) {
			return $rate;
		}

		$domain   = $request->get_param( 'domain' );
		$type     = strtoupper( $request->get_param( 'type' ) );
		$resolver = $request->get_param( 'resolver' );

		if ( ! $domain ) {
			return new WP_Error( 'invalid_domain', __( 'A valid domain is required.', 'vagra-nslookup' ), array( 'status' => 400 ) );
		}

		if ( ! in_array( $type, self::RECORD_TYPES, true ) ) {
			return new WP_Error( 'invalid_type', __( 'Unsupported record type.', 'vagra-nslookup' ), array( 'status' => 400 ) );
		}

		if ( 'auth' === $resolver ) {
			$results = self::query_dns( $domain, $type );
		} else {
			$resolver_ip = self::get_resolver_ip( $resolver );
			$results     = self::query_dns_via_dig( $domain, $type, $resolver_ip );
		}

		return rest_ensure_response( array(
			'domain'   => $domain,
			'type'     => $type,
			'resolver' => $resolver,
			'records'  => $results,
			'results'  => $results,
		) );
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
			return new WP_Error( 'invalid_domain', __( 'A valid domain is required.', 'vagra-nslookup' ), array( 'status' => 400 ) );
		}

		if ( ! in_array( $type, self::RECORD_TYPES, true ) ) {
			return new WP_Error( 'invalid_type', __( 'Unsupported record type.', 'vagra-nslookup' ), array( 'status' => 400 ) );
		}

		$results = array();

		foreach ( self::$resolvers as $res ) {
			$start   = microtime( true );
			$records = self::query_dns_via_dig( $domain, $type, $res['ip'] );
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
				'x'        => $res['x'],
				'y'        => $res['y'],
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
			'results'   => $results,
		) );
	}

	/**
	 * Handle NS lookup request — returns NS records with glue IPs.
	 */
	public static function handle_ns_lookup( $request ) {
		$rate = self::check_rate_limit();
		if ( is_wp_error( $rate ) ) {
			return $rate;
		}

		$domain   = $request->get_param( 'domain' );
		$resolver = $request->get_param( 'resolver' );

		if ( ! $domain ) {
			return new WP_Error( 'invalid_domain', __( 'A valid domain is required.', 'vagra-nslookup' ), array( 'status' => 400 ) );
		}

		// Get NS records.
		if ( 'auth' === $resolver ) {
			$ns_raw = self::query_dns( $domain, 'NS' );
		} else {
			$resolver_ip = self::get_resolver_ip( $resolver );
			$ns_raw      = self::query_dns_via_dig( $domain, 'NS', $resolver_ip );
		}

		$results = array();
		foreach ( $ns_raw as $ns ) {
			$hostname = rtrim( $ns['value'], '.' );
			if ( empty( $hostname ) ) {
				continue;
			}

			// Resolve glue IPs (A + AAAA) for each nameserver.
			$glue_a    = @dns_get_record( $hostname, DNS_A );
			$glue_aaaa = @dns_get_record( $hostname, DNS_AAAA );
			$glue_ips  = array();

			if ( ! empty( $glue_a ) ) {
				foreach ( $glue_a as $g ) {
					if ( isset( $g['ip'] ) ) {
						$glue_ips[] = $g['ip'];
					}
				}
			}
			if ( ! empty( $glue_aaaa ) ) {
				foreach ( $glue_aaaa as $g ) {
					if ( isset( $g['ipv6'] ) ) {
						$glue_ips[] = $g['ipv6'];
					}
				}
			}

			$results[] = array(
				'ns'     => $hostname,
				'value'  => $hostname,
				'ip'     => ! empty( $glue_ips ) ? $glue_ips[0] : '',
				'glue'   => $glue_ips,
				'ttl'    => isset( $ns['ttl'] ) ? (int) $ns['ttl'] : 0,
				'time'   => isset( $ns['time'] ) ? $ns['time'] : 0,
				'status' => 'ok',
			);
		}

		return rest_ensure_response( array(
			'domain'   => $domain,
			'type'     => 'NS',
			'resolver' => $resolver,
			'results'  => $results,
			'records'  => $results,
		) );
	}

	/**
	 * Handle contact form submission.
	 */
	public static function handle_contact( $request ) {
		$rate = self::check_rate_limit();
		if ( is_wp_error( $rate ) ) {
			return $rate;
		}

		$name    = $request->get_param( 'name' );
		$email   = $request->get_param( 'email' );
		$topic   = $request->get_param( 'topic' );
		$subject = $request->get_param( 'subject' );
		$message = $request->get_param( 'message' );

		if ( ! is_email( $email ) ) {
			return new WP_Error( 'invalid_email', __( 'A valid email address is required.', 'vagra-nslookup' ), array( 'status' => 400 ) );
		}

		$admin_email = get_option( 'admin_email' );
		$mail_subject = sprintf(
			/* translators: 1: topic, 2: subject */
			'[nslookup.am] %1$s: %2$s',
			ucfirst( $topic ),
			$subject ? $subject : __( 'Contact Form', 'vagra-nslookup' )
		);
		$mail_body = sprintf(
			"Name: %s\nEmail: %s\nTopic: %s\nSubject: %s\n\nMessage:\n%s",
			$name,
			$email,
			$topic,
			$subject,
			$message
		);
		$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

		wp_mail( $admin_email, $mail_subject, $mail_body, $headers );

		return rest_ensure_response( array(
			'success' => true,
			'message' => __( 'Message sent successfully.', 'vagra-nslookup' ),
		) );
	}

	/**
	 * Get resolver IP by key.
	 */
	private static function get_resolver_ip( $key ) {
		$map = array(
			'google'     => '8.8.8.8',
			'cloudflare' => '1.1.1.1',
			'quad9'      => '9.9.9.9',
			'opendns'    => '208.67.222.222',
		);
		return isset( $map[ $key ] ) ? $map[ $key ] : '8.8.8.8';
	}

	/**
	 * Query DNS using php dns_get_record().
	 */
	private static function query_dns( $domain, $type ) {
		$php_type = self::php_dns_type( $type );
		if ( ! $php_type ) {
			return array();
		}

		$start   = microtime( true );
		$records = @dns_get_record( $domain, $php_type );
		$elapsed = round( ( microtime( true ) - $start ) * 1000, 1 );

		if ( false === $records || empty( $records ) ) {
			return array();
		}

		$results = array();
		foreach ( $records as $rec ) {
			$results[] = self::normalize_record( $rec, $type, $elapsed );
		}
		return $results;
	}

	/**
	 * DNS-over-HTTPS endpoint map for known resolvers.
	 */
	private static $doh_endpoints = array(
		'8.8.8.8'         => 'https://dns.google/resolve',
		'8.8.4.4'         => 'https://dns.google/resolve',
		'1.1.1.1'         => 'https://cloudflare-dns.com/dns-query',
		'1.0.0.1'         => 'https://cloudflare-dns.com/dns-query',
		'9.9.9.9'         => 'https://dns.quad9.net:5053/dns-query',
		'149.112.112.112' => 'https://dns.quad9.net:5053/dns-query',
		'208.67.222.222'  => 'https://doh.opendns.com/dns-query',
		'208.67.220.220'  => 'https://doh.opendns.com/dns-query',
		'94.140.14.14'    => 'https://dns.adguard-dns.com/dns-query',
		'94.140.15.15'    => 'https://dns.adguard-dns.com/dns-query',
		'185.228.168.9'   => 'https://doh.cleanbrowsing.org/doh/security-filter',
	);

	/**
	 * Map DNS record type string to wire-format type number.
	 */
	private static function dns_type_number( $type ) {
		$map = array(
			'A' => 1, 'NS' => 2, 'CNAME' => 5, 'SOA' => 6, 'PTR' => 12,
			'MX' => 15, 'TXT' => 16, 'AAAA' => 28, 'SRV' => 33, 'NAPTR' => 35,
			'DS' => 43, 'DNSKEY' => 48, 'CAA' => 257,
		);
		return isset( $map[ $type ] ) ? $map[ $type ] : 1;
	}

	/**
	 * Query DNS via DNS-over-HTTPS, dig command, or fallback to php dns_get_record.
	 */
	private static function query_dns_via_dig( $domain, $type, $resolver_ip ) {
		// Try DNS-over-HTTPS first (works on all platforms).
		if ( isset( self::$doh_endpoints[ $resolver_ip ] ) ) {
			$result = self::query_dns_via_doh( $domain, $type, self::$doh_endpoints[ $resolver_ip ] );
			if ( ! empty( $result ) ) {
				return $result;
			}
		}

		// Try Google DoH as generic fallback for any resolver.
		$result = self::query_dns_via_doh( $domain, $type, 'https://dns.google/resolve' );
		if ( ! empty( $result ) ) {
			return $result;
		}

		// Final fallback to system dns_get_record.
		return self::query_dns( $domain, $type );
	}

	/**
	 * Query DNS via DNS-over-HTTPS (JSON API).
	 */
	private static function query_dns_via_doh( $domain, $type, $endpoint ) {
		$type_num = self::dns_type_number( $type );
		$is_google = ( false !== strpos( $endpoint, 'dns.google' ) );

		if ( $is_google ) {
			$url = $endpoint . '?' . http_build_query( array( 'name' => $domain, 'type' => $type_num ) );
			$accept = 'application/dns-json';
		} else {
			$url = $endpoint . '?' . http_build_query( array( 'name' => $domain, 'type' => $type ) );
			$accept = 'application/dns-json';
		}

		$start = microtime( true );
		$response = wp_remote_get( $url, array(
			'timeout' => 5,
			'headers' => array( 'Accept' => $accept ),
		) );
		$elapsed = round( ( microtime( true ) - $start ) * 1000, 1 );

		if ( is_wp_error( $response ) ) {
			return array();
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( empty( $data ) || ! isset( $data['Answer'] ) || empty( $data['Answer'] ) ) {
			return array();
		}

		$results = array();
		foreach ( $data['Answer'] as $answer ) {
			if ( (int) $answer['type'] !== $type_num ) {
				continue;
			}
			$value = isset( $answer['data'] ) ? rtrim( $answer['data'], '.' ) : '';
			// Remove surrounding quotes from TXT records.
			if ( 'TXT' === $type && strlen( $value ) >= 2 && '"' === $value[0] ) {
				$value = trim( $value, '"' );
			}
			$results[] = array(
				'value'  => $value,
				'ttl'    => isset( $answer['TTL'] ) ? (int) $answer['TTL'] : 0,
				'time'   => $elapsed,
				'status' => 'ok',
			);
		}

		return $results;
	}

	/**
	 * Map record type string to PHP DNS_* constant.
	 */
	private static function php_dns_type( $type ) {
		$map = array(
			'A'      => DNS_A,
			'AAAA'   => DNS_AAAA,
			'CNAME'  => DNS_CNAME,
			'MX'     => DNS_MX,
			'NS'     => DNS_NS,
			'TXT'    => DNS_TXT,
			'SOA'    => DNS_SOA,
			'SRV'    => DNS_SRV,
			'CAA'    => defined( 'DNS_CAA' ) ? DNS_CAA : DNS_ANY,
			'PTR'    => DNS_PTR,
			'NAPTR'  => DNS_NAPTR,
		);
		return isset( $map[ $type ] ) ? $map[ $type ] : null;
	}

	/**
	 * Normalize a dns_get_record result to a standard format.
	 */
	private static function normalize_record( $rec, $type, $elapsed ) {
		$value = '';
		switch ( $type ) {
			case 'A':
				$value = isset( $rec['ip'] ) ? $rec['ip'] : '';
				break;
			case 'AAAA':
				$value = isset( $rec['ipv6'] ) ? $rec['ipv6'] : '';
				break;
			case 'CNAME':
				$value = isset( $rec['target'] ) ? $rec['target'] : '';
				break;
			case 'MX':
				$value = isset( $rec['target'] ) ? $rec['pri'] . ' ' . $rec['target'] : '';
				break;
			case 'NS':
				$value = isset( $rec['target'] ) ? $rec['target'] : '';
				break;
			case 'TXT':
				$value = isset( $rec['txt'] ) ? $rec['txt'] : '';
				break;
			case 'SOA':
				$value = isset( $rec['mname'] ) ? $rec['mname'] . ' ' . $rec['rname'] : '';
				break;
			case 'SRV':
				$value = isset( $rec['target'] ) ? $rec['pri'] . ' ' . $rec['weight'] . ' ' . $rec['port'] . ' ' . $rec['target'] : '';
				break;
			case 'CAA':
				$value = isset( $rec['value'] ) ? $rec['value'] : '';
				break;
			case 'PTR':
				$value = isset( $rec['target'] ) ? $rec['target'] : '';
				break;
			default:
				$value = wp_json_encode( $rec );
		}

		return array(
			'value'  => $value,
			'ttl'    => isset( $rec['ttl'] ) ? (int) $rec['ttl'] : 0,
			'time'   => $elapsed,
			'status' => 'ok',
		);
	}
}

Vagra_NSL_DNS::init();
