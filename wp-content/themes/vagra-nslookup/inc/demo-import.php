<?php
/**
 * Demo Import Handler
 *
 * Provides one-click demo content import functionality.
 * Recommends One Click Demo Import (OCDI) plugin for full import,
 * but includes a basic fallback for customizer settings.
 *
 * @package Vagra_NSLookup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register OCDI import files if the plugin is active.
 *
 * @return array Import file configuration.
 */
function vagra_nsl_ocdi_import_files() {
	$demos = array(
		array(
			'import_file_name'             => __( 'Classic — PHP Templates', 'vagra-nslookup' ),
			'local_import_file'            => get_template_directory() . '/demo-content/demo-content.xml',
			'local_import_widget_file'     => get_template_directory() . '/demo-content/widgets.json',
			'local_import_customizer_file' => get_template_directory() . '/demo-content/customizer.json',
			'import_notice'                => __( 'Standard import using theme PHP templates. Works without any page builder. Recommended for most users.', 'vagra-nslookup' ),
		),
	);

	// Add Elementor demo only when Elementor is active.
	if ( did_action( 'elementor/loaded' ) ) {
		$demos[] = array(
			'import_file_name'             => __( 'Elementor — Visual Builder', 'vagra-nslookup' ),
			'local_import_file'            => get_template_directory() . '/demo-content/demo-content.xml',
			'local_import_widget_file'     => get_template_directory() . '/demo-content/widgets.json',
			'local_import_customizer_file' => get_template_directory() . '/demo-content/customizer.json',
			'import_notice'                => __( 'Imports the same pages, then converts Home, NS Lookup, and Propagation to Elementor with custom NSLookup widgets. All sections become editable in the visual builder.', 'vagra-nslookup' ),
		);
	}

	return $demos;
}
add_filter( 'ocdi/import_files', 'vagra_nsl_ocdi_import_files' );

/**
 * After OCDI import: set up front page, menus, etc.
 */
function vagra_nsl_ocdi_after_import_setup( $selected_import ) {
	// Set front page.
	$front_page = get_page_by_title( 'Home' );
	if ( $front_page ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page->ID );
	}

	// Set blog page.
	$blog_page = get_page_by_title( 'Blog' );
	if ( $blog_page ) {
		update_option( 'page_for_posts', $blog_page->ID );
	}

	// Assign menus to locations.
	$primary_menu = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
	$footer_menu  = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

	$locations = get_theme_mod( 'nav_menu_locations', array() );

	if ( $primary_menu ) {
		$locations['primary'] = $primary_menu->term_id;
	}
	if ( $footer_menu ) {
		$locations['footer'] = $footer_menu->term_id;
	}

	set_theme_mod( 'nav_menu_locations', $locations );

	// Handle Elementor import: inject Elementor data from JSON files.
	$import_name = isset( $selected_import['import_file_name'] ) ? $selected_import['import_file_name'] : '';
	if ( stripos( $import_name, 'Elementor' ) !== false && did_action( 'elementor/loaded' ) ) {
		$elementor_dir = get_template_directory() . '/demo-content/elementor/';
		$elementor_pages = array(
			'Home'                     => 'home.json',
			'NS Lookup'                => 'ns-lookup.json',
			'DNS Propagation Checker'  => 'propagation.json',
		);
		$elementor_ver = defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.0.0';
		foreach ( $elementor_pages as $title => $json_file ) {
			$page = get_page_by_title( $title );
			$file = $elementor_dir . $json_file;
			if ( $page && file_exists( $file ) ) {
				$raw  = file_get_contents( $file );
				$decoded = json_decode( $raw, true );
				if ( is_array( $decoded ) ) {
					$compact = wp_json_encode( $decoded );
					update_post_meta( $page->ID, '_elementor_data', wp_slash( $compact ) );
					update_post_meta( $page->ID, '_elementor_edit_mode', 'builder' );
					update_post_meta( $page->ID, '_wp_page_template', 'elementor_header_footer' );
					update_post_meta( $page->ID, '_elementor_version', $elementor_ver );
					update_post_meta( $page->ID, '_elementor_css', '' );
				}
			}
		}
		// Clear Elementor CSS cache.
		if ( class_exists( '\Elementor\Plugin' ) ) {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}
	}

	flush_rewrite_rules();
}
add_action( 'ocdi/after_import', 'vagra_nsl_ocdi_after_import_setup' );

/**
 * Add admin notice recommending OCDI if not installed.
 */
function vagra_nsl_demo_import_notice() {
	if ( class_exists( 'OCDI_Plugin' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'themes' !== $screen->id ) {
		return;
	}

	printf(
		'<div class="notice notice-info is-dismissible"><p>%s <a href="%s">%s</a></p></div>',
		esc_html__( 'To import nslookup.am demo content, install the "One Click Demo Import" plugin.', 'vagra-nslookup' ),
		esc_url( admin_url( 'plugin-install.php?s=one+click+demo+import&tab=search&type=term' ) ),
		esc_html__( 'Install now', 'vagra-nslookup' )
	);
}
add_action( 'admin_notices', 'vagra_nsl_demo_import_notice' );

/**
 * Seed essential demo content on theme activation.
 *
 * Creates: Home page, FAQ page (with FAQ template), Blog page,
 * reading settings, categories, and sample blog posts.
 * Skips any content that already exists.
 */
function vagra_nsl_seed_demo_content() {
	// --- Pages ---
	$pages = array(
		'Home' => array( 'slug' => 'home', 'template' => '' ),
		'FAQ'  => array( 'slug' => 'faq', 'template' => 'page-faq.php' ),
		'Blog' => array( 'slug' => 'blog', 'template' => '' ),
	);

	$page_ids = array();
	foreach ( $pages as $title => $meta ) {
		$existing = get_page_by_path( $meta['slug'] );
		if ( $existing ) {
			$page_ids[ $title ] = $existing->ID;
			continue;
		}

		$id = wp_insert_post( array(
			'post_type'   => 'page',
			'post_title'  => $title,
			'post_name'   => $meta['slug'],
			'post_status' => 'publish',
		) );

		if ( ! is_wp_error( $id ) ) {
			if ( ! empty( $meta['template'] ) ) {
				update_post_meta( $id, '_wp_page_template', $meta['template'] );
			}
			$page_ids[ $title ] = $id;
		}
	}

	// --- Reading settings ---
	if ( ! empty( $page_ids['Home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_ids['Home'] );
	}
	if ( ! empty( $page_ids['Blog'] ) ) {
		update_option( 'page_for_posts', $page_ids['Blog'] );
	}

	// --- Categories ---
	$categories = array(
		'DNS Fundamentals' => 'dns-fundamentals',
		'Security'         => 'security',
	);
	foreach ( $categories as $name => $slug ) {
		if ( ! term_exists( $slug, 'category' ) ) {
			wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		}
	}

	// --- Blog posts (only if no posts beyond the default "Hello world!") ---
	$post_count = wp_count_posts();
	if ( $post_count->publish <= 1 ) {
		$demo_posts = array(
			array(
				'title'    => 'Understanding DNS Propagation: Why Your Changes Take Time',
				'category' => 'dns-fundamentals',
				'content'  => '<p>When you update a DNS record, the change doesn\'t happen instantly across the internet. DNS propagation — the time it takes for DNS changes to spread across all nameservers worldwide — can range from a few minutes to 48 hours.</p><h2>What Happens During Propagation</h2><p>Every DNS record has a TTL (Time to Live) value measured in seconds. When a recursive resolver caches your record, it holds onto that cached version until the TTL expires. Only then does it query the authoritative nameserver for a fresh copy.</p><h2>Why TTL Matters</h2><p>If your record had a 24-hour TTL before you made changes, some resolvers may serve the old record for up to 24 hours. The fix? Lower your TTL well before making changes — set it to 300 seconds (5 minutes) at least 48 hours in advance.</p><h2>How to Check Propagation</h2><p>Use a propagation checker to query resolvers in different geographic locations simultaneously. This shows you exactly which resolvers have picked up your new records and which are still serving cached data.</p>',
			),
			array(
				'title'    => 'MX Records Explained: How Email Finds Your Server',
				'category' => 'dns-fundamentals',
				'content'  => '<p>MX (Mail Exchange) records are the unsung heroes of email delivery. Without them, the internet wouldn\'t know where to send your mail.</p><h2>The MX Lookup Chain</h2><p>When someone sends an email to you@example.com, their mail server performs an MX lookup on example.com. The response contains one or more mail servers, each with a priority number. Lower numbers mean higher priority.</p><h2>Priority and Failover</h2><p>A typical MX setup looks like this: priority 10 pointing to your primary mail server, priority 20 pointing to a backup. If the primary is down, mail automatically routes to the backup.</p><h2>Common MX Mistakes</h2><p>The most frequent MX misconfiguration is pointing an MX record at a CNAME. Per RFC 2181, MX records must point to an A or AAAA record, never a CNAME.</p>',
			),
			array(
				'title'    => 'DNSSEC: What It Is and Why You Should Care',
				'category' => 'security',
				'content'  => '<p>DNSSEC (Domain Name System Security Extensions) adds a layer of authentication to DNS responses, preventing attackers from poisoning DNS caches with forged records.</p><h2>The Problem DNSSEC Solves</h2><p>Standard DNS has no built-in way to verify that a response actually came from the authoritative nameserver. An attacker can inject false DNS responses, redirecting users to malicious servers — known as DNS cache poisoning.</p><h2>How DNSSEC Works</h2><p>DNSSEC uses public-key cryptography to sign DNS records. Each zone has a key pair: a private key that signs records, and a public key (published as a DNSKEY record) that resolvers use to verify signatures.</p>',
			),
			array(
				'title'    => 'CAA Records: Controlling Who Can Issue Your SSL Certificates',
				'category' => 'security',
				'content'  => '<p>CAA (Certification Authority Authorization) records let domain owners specify which Certificate Authorities are allowed to issue certificates for their domain.</p><h2>Why CAA Matters</h2><p>Without CAA records, any CA can issue a certificate for your domain. CAA records add a policy layer: CAs are required to check CAA before issuance and refuse if they\'re not listed.</p><h2>Setting Up CAA</h2><p>A basic CAA record looks like: example.com CAA 0 issue "letsencrypt.org". You can add "issuewild" to separately control wildcard certificates.</p>',
			),
			array(
				'title'    => 'IPv6 and AAAA Records: The Transition You Cannot Ignore',
				'category' => 'dns-fundamentals',
				'content'  => '<p>IPv4 addresses ran out years ago. IPv6 adoption is accelerating, and if your domain doesn\'t have AAAA records, you\'re invisible to a growing segment of the internet.</p><h2>AAAA vs A Records</h2><p>A records map domains to IPv4 addresses (32-bit). AAAA records map to IPv6 addresses (128-bit). The name "AAAA" comes from being four times the size of an A record.</p><h2>Dual-Stack Best Practice</h2><p>The recommended approach is dual-stack: publish both A and AAAA records. Clients that support IPv6 will prefer it, while IPv4-only clients fall back gracefully.</p>',
			),
			array(
				'title'    => 'TXT Records: More Than Just SPF and DKIM',
				'category' => 'dns-fundamentals',
				'content'  => '<p>TXT records are the Swiss Army knife of DNS. Originally designed for human-readable notes, they now carry machine-readable data for email authentication, domain verification, and security policies.</p><h2>Email Authentication Trio</h2><p>SPF, DKIM, and DMARC all live in TXT records. SPF declares which IPs can send mail for your domain. DKIM provides cryptographic signatures. DMARC ties them together with a policy for handling failures.</p><h2>The 255-Character Limit</h2><p>Individual TXT strings are limited to 255 characters, but a single TXT record can contain multiple strings that get concatenated.</p>',
			),
		);

		foreach ( $demo_posts as $post_data ) {
			$post_id = wp_insert_post( array(
				'post_type'    => 'post',
				'post_title'   => $post_data['title'],
				'post_content' => $post_data['content'],
				'post_status'  => 'publish',
			) );

			if ( ! is_wp_error( $post_id ) && ! empty( $post_data['category'] ) ) {
				wp_set_object_terms( $post_id, $post_data['category'], 'category' );
			}
		}
	}
}
add_action( 'after_switch_theme', 'vagra_nsl_seed_demo_content' );
