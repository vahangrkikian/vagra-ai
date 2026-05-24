<?php
/**
 * DriveEase Theme Functions
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DRIVEEASE_VERSION', '1.0.1' );
define( 'DRIVEEASE_DIR', get_template_directory() );
define( 'DRIVEEASE_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function driveease_setup() {
	load_theme_textdomain( 'driveease', get_template_directory() . '/languages' );

	// Set content width for oEmbed and image sizing.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 1200;
	}

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'driveease' ),
			'footer'  => esc_html__( 'Footer Menu', 'driveease' ),
		)
	);
}
add_action( 'after_setup_theme', 'driveease_setup' );

/**
 * Fallback callback for the primary menu when no menu is assigned.
 */
function driveease_primary_menu_fallback() {
	$items = array(
		array( 'url' => home_url( '/' ), 'label' => __( 'Home', 'driveease' ) ),
		array( 'url' => home_url( '/fleet/' ), 'label' => __( 'Fleet', 'driveease' ) ),
		array( 'url' => home_url( '/blog/' ), 'label' => __( 'Blog', 'driveease' ) ),
		array( 'url' => home_url( '/about/' ), 'label' => __( 'About', 'driveease' ) ),
		array( 'url' => home_url( '/contact/' ), 'label' => __( 'Contact', 'driveease' ) ),
		array( 'url' => home_url( '/my-bookings/' ), 'label' => __( 'My Bookings', 'driveease' ) ),
	);
	echo '<ul class="nav-links">';
	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item"><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Fallback callback for the mobile primary menu when no menu is assigned.
 */
function driveease_mobile_menu_fallback() {
	$items = array(
		array( 'url' => home_url( '/' ), 'label' => __( 'Home', 'driveease' ) ),
		array( 'url' => home_url( '/fleet/' ), 'label' => __( 'Fleet', 'driveease' ) ),
		array( 'url' => home_url( '/blog/' ), 'label' => __( 'Blog', 'driveease' ) ),
		array( 'url' => home_url( '/about/' ), 'label' => __( 'About', 'driveease' ) ),
		array( 'url' => home_url( '/contact/' ), 'label' => __( 'Contact', 'driveease' ) ),
		array( 'url' => home_url( '/my-bookings/' ), 'label' => __( 'My Bookings', 'driveease' ) ),
	);
	foreach ( $items as $item ) {
		printf(
			'<a href="%s">%s</a>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
}

/**
 * Fallback callback for the footer menu when no menu is assigned.
 */
function driveease_footer_menu_fallback() {
	$items = array(
		array( 'url' => home_url( '/about/' ), 'label' => __( 'About', 'driveease' ) ),
		array( 'url' => home_url( '/fleet/' ), 'label' => __( 'Fleet', 'driveease' ) ),
		array( 'url' => home_url( '/blog/' ), 'label' => __( 'Blog', 'driveease' ) ),
		array( 'url' => home_url( '/faq/' ), 'label' => __( 'FAQ', 'driveease' ) ),
		array( 'url' => home_url( '/contact/' ), 'label' => __( 'Contact', 'driveease' ) ),
	);
	echo '<ul>';
	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item"><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Add preconnect for external font/icon CDNs.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type.
 * @return array Modified URLs.
 */
function driveease_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.googleapis.com',
			'crossorigin',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin',
		);
		$urls[] = array(
			'href'        => 'https://cdnjs.cloudflare.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'driveease_resource_hints', 10, 2 );

/**
 * Enqueue scripts and styles.
 */
function driveease_scripts() {
	// Google Fonts: Inter 300-800.
	wp_enqueue_style(
		'driveease-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Font Awesome 6.5.0.
	wp_enqueue_style(
		'driveease-font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
		array(),
		'6.5.0'
	);

	// Main stylesheet.
	wp_enqueue_style(
		'driveease-main',
		DRIVEEASE_URI . '/assets/css/main.css',
		array( 'driveease-google-fonts', 'driveease-font-awesome' ),
		DRIVEEASE_VERSION
	);

	// Theme stylesheet (style.css — WP header only).
	wp_enqueue_style(
		'driveease-style',
		get_stylesheet_uri(),
		array( 'driveease-main' ),
		DRIVEEASE_VERSION
	);

	// Fleet archive page or fleet page template.
	if ( is_post_type_archive( 'driveease_car' ) || is_page( 'fleet' ) ) {
		wp_enqueue_style(
			'driveease-archive-fleet',
			DRIVEEASE_URI . '/assets/css/archive-fleet.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// Branch archive page.
	if ( is_post_type_archive( 'driveease_branch' ) ) {
		wp_enqueue_style(
			'driveease-archive-branches',
			DRIVEEASE_URI . '/assets/css/archive-branches.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// Single branch detail page.
	if ( is_singular( 'driveease_branch' ) ) {
		wp_enqueue_style(
			'driveease-archive-branches',
			DRIVEEASE_URI . '/assets/css/archive-branches.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
		wp_enqueue_style(
			'driveease-single-branch',
			DRIVEEASE_URI . '/assets/css/single-branch.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// Single car detail page.
	if ( is_singular( 'driveease_car' ) ) {
		wp_enqueue_style(
			'driveease-single-car',
			DRIVEEASE_URI . '/assets/css/single-car.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
		wp_enqueue_style(
			'driveease-reviews',
			DRIVEEASE_URI . '/assets/css/reviews.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
		wp_enqueue_script(
			'driveease-reviews',
			DRIVEEASE_URI . '/assets/js/reviews.js',
			array(),
			DRIVEEASE_VERSION,
			true
		);
	}

	// Reviews CSS on fleet archive for star ratings on cards.
	if ( is_post_type_archive( 'driveease_car' ) || is_page( 'fleet' ) ) {
		wp_enqueue_style(
			'driveease-reviews',
			DRIVEEASE_URI . '/assets/css/reviews.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// Contact page.
	if ( is_page_template( 'page-contact.php' ) ) {
		wp_enqueue_style(
			'driveease-contact',
			DRIVEEASE_URI . '/assets/css/contact.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
		wp_enqueue_script(
			'driveease-contact-js',
			DRIVEEASE_URI . '/assets/js/contact.js',
			array(),
			DRIVEEASE_VERSION,
			true
		);
		wp_localize_script(
			'driveease-contact-js',
			'driveease_contact',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'driveease_contact_nonce' ),
			)
		);
	}

	// About page.
	if ( is_page_template( 'page-about.php' ) ) {
		wp_enqueue_style(
			'driveease-about',
			DRIVEEASE_URI . '/assets/css/about.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// FAQ page.
	if ( is_page_template( 'page-faq.php' ) ) {
		wp_enqueue_style(
			'driveease-faq',
			DRIVEEASE_URI . '/assets/css/faq.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// Legal pages (Terms of Service, Privacy Policy).
	if ( is_page_template( 'page-terms.php' ) || is_page_template( 'page-privacy.php' ) ) {
		wp_enqueue_style(
			'driveease-legal',
			DRIVEEASE_URI . '/assets/css/legal.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// My Bookings page.
	if ( is_page_template( 'page-my-bookings.php' ) ) {
		wp_enqueue_style(
			'driveease-my-bookings',
			DRIVEEASE_URI . '/assets/css/my-bookings.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// Search results.
	if ( is_search() ) {
		wp_enqueue_style(
			'driveease-search',
			DRIVEEASE_URI . '/assets/css/search.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// Blog pages: home (blog index), single posts, archives, categories, tags.
	if ( is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_author() || is_date() ) {
		wp_enqueue_style(
			'driveease-blog',
			DRIVEEASE_URI . '/assets/css/blog.css',
			array( 'driveease-main' ),
			DRIVEEASE_VERSION
		);
	}

	// i18n — translation dictionary & setLang().
	wp_enqueue_script(
		'driveease-i18n',
		DRIVEEASE_URI . '/assets/js/i18n.js',
		array(),
		DRIVEEASE_VERSION,
		true
	);

	// Currency — fmtP(), setCurrency().
	wp_enqueue_script(
		'driveease-currency',
		DRIVEEASE_URI . '/assets/js/currency.js',
		array( 'driveease-i18n' ),
		DRIVEEASE_VERSION,
		true
	);

	// Main JavaScript — nav, filtering, gallery, sidebar calc.
	wp_enqueue_script(
		'driveease-main',
		DRIVEEASE_URI . '/assets/js/main.js',
		array( 'driveease-i18n', 'driveease-currency' ),
		DRIVEEASE_VERSION,
		true
	);

	// Booking modal wizard — 3-step form, AJAX submit.
	wp_enqueue_script(
		'driveease-booking',
		DRIVEEASE_URI . '/assets/js/booking.js',
		array( 'driveease-i18n', 'driveease-currency' ),
		DRIVEEASE_VERSION,
		true
	);

	// Pass car data on single car pages so the modal can pre-fill.
	if ( is_singular( 'driveease_car' ) ) {
		$car_id = get_the_ID();
		wp_localize_script(
			'driveease-booking',
			'driveease_car_data',
			array(
				'id'       => $car_id,
				'name'     => get_the_title( $car_id ),
				'price'    => get_post_meta( $car_id, '_car_price_per_day', true ),
				'category' => ( ( $terms = get_the_terms( $car_id, 'car_category' ) ) && ! is_wp_error( $terms ) ) ? $terms[0]->slug : '',
				'image'    => get_the_post_thumbnail_url( $car_id, 'medium' ),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'driveease_scripts' );

/**
 * Register widget areas.
 */
function driveease_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'driveease' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'driveease' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array(
				/* translators: %d: footer widget area number */
				'name'          => sprintf( esc_html__( 'Footer %d', 'driveease' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => sprintf(
					/* translators: %d: footer widget area number */
					esc_html__( 'Footer widget area %d.', 'driveease' ),
					$i
				),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'driveease_widgets_init' );

// Nav Walkers.
require_once DRIVEEASE_DIR . '/inc/class-driveease-nav-walker.php';

// Demo Import.
require_once DRIVEEASE_DIR . '/inc/demo-import.php';

// TGM Plugin Activation — recommended plugins (including DriveEase Core).
require_once DRIVEEASE_DIR . '/inc/tgm-init.php';

// Polylang multilingual integration.
require_once DRIVEEASE_DIR . '/inc/polylang-integration.php';
