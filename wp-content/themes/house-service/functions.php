<?php
/**
 * House Service Theme Functions
 *
 * A home services marketplace WordPress theme — find cleaners, movers,
 * repair pros, and assembly teams.
 *
 * @package House_Service
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'HS_VERSION', '1.0.0' );
define( 'HS_DIR', get_template_directory() );
define( 'HS_URI', get_template_directory_uri() );

/* --------------------------------------------------------------------------
   Theme Setup
   -------------------------------------------------------------------------- */

function hs_setup() {
    load_theme_textdomain( 'house-service', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );

    // Custom image sizes.
    add_image_size( 'hs-card', 400, 300, true );
    add_image_size( 'hs-hero', 1440, 600, true );
    add_image_size( 'hs-cover', 800, 400, true );

    // Navigation menus.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'house-service' ),
        'footer'  => __( 'Footer Menu', 'house-service' ),
    ) );
}
add_action( 'after_setup_theme', 'hs_setup' );

/* --------------------------------------------------------------------------
   Enqueue Assets
   -------------------------------------------------------------------------- */

function hs_enqueue_assets() {
    // Google Fonts — Inter 400-800.
    wp_enqueue_style(
        'hs-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Main stylesheet.
    wp_enqueue_style(
        'hs-style',
        get_stylesheet_uri(),
        array( 'hs-google-fonts' ),
        HS_VERSION
    );

    // AI Chat styles.
    wp_enqueue_style(
        'vagra-chat',
        HS_URI . '/assets/css/vagra-chat.css',
        array( 'hs-style' ),
        HS_VERSION
    );

    // Front-page script.
    if ( is_front_page() ) {
        wp_enqueue_script(
            'hs-main',
            HS_URI . '/assets/js/main.js',
            array(),
            HS_VERSION,
            true
        );
    }

    // Archive filters script.
    if ( is_post_type_archive( 'hs_provider' ) ) {
        wp_enqueue_script(
            'hs-provider-filters',
            HS_URI . '/assets/js/provider-filters.js',
            array(),
            HS_VERSION,
            true
        );
        wp_localize_script( 'hs-provider-filters', 'hsFilters', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'hs_filter_nonce' ),
        ) );
    }

    // AI Chat script.
    wp_enqueue_script(
        'vagra-chat',
        HS_URI . '/assets/js/vagra-chat.js',
        array(),
        HS_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'hs_enqueue_assets' );

/* --------------------------------------------------------------------------
   SVG Icon System
   -------------------------------------------------------------------------- */

function hs_icon( $name, $size = 24 ) {
    $icons = array(
        'search'   => '<path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>',
        'pin'      => '<path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" stroke-width="2" fill="none"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" stroke="currentColor" stroke-width="2" fill="none"/>',
        'calendar' => '<path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>',
        'shield'   => '<path d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'check'    => '<path d="M4.5 12.75l6 6 9-13.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'star'     => '<path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" fill="currentColor"/>',
        'arrow'    => '<path d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'chevron'  => '<path d="M8.25 4.5l7.5 7.5-7.5 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'clock'    => '<path d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>',
        'x'        => '<path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'alert'    => '<path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'phone'    => '<path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" stroke="currentColor" stroke-width="2" fill="none"/>',
        'house'    => '<path d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'menu'     => '<path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'close'    => '<path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
    );

    if ( ! isset( $icons[ $name ] ) ) {
        return '';
    }

    return sprintf(
        '<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%1$d" viewBox="0 0 24 24" aria-hidden="true">%2$s</svg>',
        absint( $size ),
        $icons[ $name ]
    );
}

/* --------------------------------------------------------------------------
   Primary Menu Fallback
   -------------------------------------------------------------------------- */

function hs_primary_menu_fallback() {
    $items = array(
        array( 'url' => home_url( '/' ),              'label' => __( 'Home', 'house-service' ) ),
        array( 'url' => get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ), 'label' => __( 'Browse', 'house-service' ) ),
        array( 'url' => home_url( '/categories/' ),    'label' => __( 'Categories', 'house-service' ) ),
        array( 'url' => home_url( '/#how-it-works' ),  'label' => __( 'How it works', 'house-service' ) ),
    );
    echo '<ul class="nav__links">';
    foreach ( $items as $item ) {
        printf(
            '<li class="menu-item"><a href="%s">%s</a></li>',
            esc_url( $item['url'] ),
            esc_html( $item['label'] )
        );
    }
    echo '</ul>';
}

function hs_footer_menu_fallback() {
    $items = array(
        array( 'url' => home_url( '/' ),          'label' => __( 'Home', 'house-service' ) ),
        array( 'url' => home_url( '/about/' ),     'label' => __( 'About', 'house-service' ) ),
        array( 'url' => home_url( '/categories/' ),'label' => __( 'Categories', 'house-service' ) ),
    );
    echo '<ul class="footer__menu">';
    foreach ( $items as $item ) {
        printf(
            '<li class="menu-item"><a href="%s">%s</a></li>',
            esc_url( $item['url'] ),
            esc_html( $item['label'] )
        );
    }
    echo '</ul>';
}

/* --------------------------------------------------------------------------
   Include additional files
   -------------------------------------------------------------------------- */

$hs_includes = array(
    '/inc/demo-import.php',
    '/inc/tgm-init.php',
    '/inc/customizer.php',
);

foreach ( $hs_includes as $file ) {
    $filepath = HS_DIR . $file;
    if ( file_exists( $filepath ) ) {
        require_once $filepath;
    }
}

/* --------------------------------------------------------------------------
   Auto-create pages on theme activation
   -------------------------------------------------------------------------- */

function hs_create_pages() {
    $pages = array(
        'home'       => array(
            'title'    => __( 'Home', 'house-service' ),
            'template' => '',
        ),
        'about'      => array(
            'title'    => __( 'About', 'house-service' ),
            'content'  => __( 'House Service connects homeowners with verified local service providers. From deep cleaning to furniture assembly, we make it easy to find reliable help.', 'house-service' ),
        ),
        'categories' => array(
            'title'    => __( 'Categories', 'house-service' ),
            'content'  => __( 'Browse our service categories to find the right professional for your needs.', 'house-service' ),
        ),
        'contact'    => array(
            'title'    => __( 'Contact', 'house-service' ),
            'content'  => __( 'Have a question? Get in touch with our support team.', 'house-service' ),
        ),
    );

    foreach ( $pages as $slug => $page_data ) {
        $existing = get_page_by_path( $slug );
        if ( ! $existing ) {
            $args = array(
                'post_title'   => $page_data['title'],
                'post_name'    => $slug,
                'post_content' => isset( $page_data['content'] ) ? $page_data['content'] : '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            );
            $page_id = wp_insert_post( $args );

            if ( ! empty( $page_data['template'] ) && ! is_wp_error( $page_id ) ) {
                update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
            }

            // Set the home page as front page.
            if ( 'home' === $slug && ! is_wp_error( $page_id ) ) {
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $page_id );
            }
        }
    }
}
add_action( 'after_switch_theme', 'hs_create_pages' );

/* --------------------------------------------------------------------------
   Demo Providers (auto-create on init)
   -------------------------------------------------------------------------- */

function hs_create_demo_providers() {
    if ( get_option( 'hs_demo_providers_created' ) ) {
        return;
    }

    // Only run if the CPT is registered (plugin active).
    if ( ! post_type_exists( 'hs_provider' ) ) {
        return;
    }

    $providers = array(
        array(
            'title'   => 'SparkleClean Co.',
            'tagline' => 'Premium residential & commercial cleaning',
            'desc'    => 'SparkleClean has been delivering top-quality cleaning services for over 8 years. Our bonded and insured team handles everything from deep cleans to regular maintenance with eco-friendly products.',
            'cat'     => 'Cleaning',
            'price'   => '89',
            'price_level' => '2',
            'rating'  => '4.9',
            'reviews' => '127',
            'location'=> 'Los Angeles, CA',
            'verified'=> '1',
            'tags'    => 'Deep Clean, Move-out, Office, Eco-friendly',
            'jobs'    => '340',
            'years'   => '8',
        ),
        array(
            'title'   => 'SwiftMove Logistics',
            'tagline' => 'Local & long-distance moving specialists',
            'desc'    => 'SwiftMove makes relocating stress-free. Full-service packing, furniture disassembly/reassembly, and climate-controlled storage. Licensed and insured with a perfect safety record.',
            'cat'     => 'Moving',
            'price'   => '129',
            'price_level' => '3',
            'rating'  => '4.8',
            'reviews' => '89',
            'location'=> 'San Francisco, CA',
            'verified'=> '1',
            'tags'    => 'Local, Long-distance, Packing, Storage',
            'jobs'    => '210',
            'years'   => '12',
        ),
        array(
            'title'   => 'FixRight Repairs',
            'tagline' => 'Plumbing, electrical & general handyman',
            'desc'    => 'From leaky faucets to full bathroom remodels, FixRight handles it all. Our certified technicians arrive on time with fully stocked vans so most repairs are completed in a single visit.',
            'cat'     => 'Repair',
            'price'   => '95',
            'price_level' => '2',
            'rating'  => '4.7',
            'reviews' => '203',
            'location'=> 'Austin, TX',
            'verified'=> '1',
            'tags'    => 'Plumbing, Electrical, Drywall, Painting',
            'jobs'    => '580',
            'years'   => '15',
        ),
        array(
            'title'   => 'BuildIt Assembly',
            'tagline' => 'Furniture assembly & mounting pros',
            'desc'    => 'We assemble everything from IKEA to custom shelving. TV mounting, art hanging, and playground installation too. Fast, clean, and backed by a satisfaction guarantee.',
            'cat'     => 'Assembly',
            'price'   => '65',
            'price_level' => '1',
            'rating'  => '4.9',
            'reviews' => '156',
            'location'=> 'Chicago, IL',
            'verified'=> '1',
            'tags'    => 'IKEA, Shelving, TV Mount, Playground',
            'jobs'    => '420',
            'years'   => '6',
        ),
        array(
            'title'   => 'GreenScape Gardens',
            'tagline' => 'Lawn care, landscaping & tree services',
            'desc'    => 'GreenScape transforms outdoor spaces. Weekly mowing, seasonal cleanup, irrigation, and custom landscape design. Free on-site estimates for new clients.',
            'cat'     => 'Cleaning',
            'price'   => '75',
            'price_level' => '2',
            'rating'  => '4.6',
            'reviews' => '98',
            'location'=> 'Portland, OR',
            'verified'=> '1',
            'tags'    => 'Lawn Care, Landscaping, Tree Trim, Irrigation',
            'jobs'    => '280',
            'years'   => '10',
        ),
        array(
            'title'   => 'QuickFix Appliances',
            'tagline' => 'Same-day appliance repair & maintenance',
            'desc'    => 'QuickFix specializes in all major appliance brands. Same-day service available for most repairs. Certified technicians with manufacturer-approved parts.',
            'cat'     => 'Repair',
            'price'   => '110',
            'price_level' => '2',
            'rating'  => '4.8',
            'reviews' => '167',
            'location'=> 'Denver, CO',
            'verified'=> '1',
            'tags'    => 'Washer, Dryer, Fridge, Dishwasher',
            'jobs'    => '490',
            'years'   => '9',
        ),
    );

    foreach ( $providers as $p ) {
        $post_id = wp_insert_post( array(
            'post_title'   => $p['title'],
            'post_content' => $p['desc'],
            'post_status'  => 'publish',
            'post_type'    => 'hs_provider',
        ) );

        if ( ! is_wp_error( $post_id ) ) {
            update_post_meta( $post_id, '_hs_tagline',    $p['tagline'] );
            update_post_meta( $post_id, '_hs_category',   $p['cat'] );
            update_post_meta( $post_id, '_hs_price',      $p['price'] );
            update_post_meta( $post_id, '_hs_price_level', $p['price_level'] );
            update_post_meta( $post_id, '_hs_rating',     $p['rating'] );
            update_post_meta( $post_id, '_hs_reviews',    $p['reviews'] );
            update_post_meta( $post_id, '_hs_location',   $p['location'] );
            update_post_meta( $post_id, '_hs_verified',   $p['verified'] );
            update_post_meta( $post_id, '_hs_tags',       $p['tags'] );
            update_post_meta( $post_id, '_hs_jobs',       $p['jobs'] );
            update_post_meta( $post_id, '_hs_years',      $p['years'] );

            // Assign taxonomy term if it exists.
            if ( taxonomy_exists( 'hs_service_cat' ) ) {
                wp_set_object_terms( $post_id, $p['cat'], 'hs_service_cat' );
            }
        }
    }

    update_option( 'hs_demo_providers_created', true );
}
add_action( 'init', 'hs_create_demo_providers', 20 );

/* --------------------------------------------------------------------------
   Flush rewrite rules on theme switch
   -------------------------------------------------------------------------- */

function hs_flush_rewrites() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'hs_flush_rewrites' );

/**
 * Fix corrupted rewrite rules (C:/Program prefix on Windows/OSPanel).
 */
function hs_fix_rewrite_rules( $rules ) {
    if ( ! is_array( $rules ) ) {
        return $rules;
    }
    $fixed = array();
    foreach ( $rules as $pattern => $query ) {
        $clean = preg_replace( '#^[A-Z]:/[^/]+#', '', $pattern );
        $fixed[ $clean ] = $query;
    }
    return $fixed;
}
add_filter( 'rewrite_rules_array', 'hs_fix_rewrite_rules' );

/* --------------------------------------------------------------------------
   Helper: Render star rating
   -------------------------------------------------------------------------- */

function hs_render_stars( $rating = 5, $size = 16 ) {
    $output = '<span class="stars">';
    $full   = floor( $rating );
    for ( $i = 0; $i < 5; $i++ ) {
        if ( $i < $full ) {
            $output .= hs_icon( 'star', $size );
        } else {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="' . absint( $size ) . '" height="' . absint( $size ) . '" viewBox="0 0 24 24" aria-hidden="true" style="opacity:0.25">' .
                '<path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" fill="currentColor"/></svg>';
        }
    }
    $output .= '</span>';
    return $output;
}

/* --------------------------------------------------------------------------
   Helper: Price level dots
   -------------------------------------------------------------------------- */

function hs_render_price_level( $level = 2 ) {
    $level  = max( 1, min( 3, intval( $level ) ) );
    $output = '<span class="price-dots">';
    for ( $i = 1; $i <= 3; $i++ ) {
        $class = $i <= $level ? '' : ' class="off"';
        $output .= '<span' . $class . '>$</span>';
    }
    $output .= '</span>';
    return $output;
}

/* --------------------------------------------------------------------------
   Quote form REST endpoint
   -------------------------------------------------------------------------- */

function hs_register_quote_endpoint() {
    register_rest_route( 'house-service/v1', '/quote', array(
        'methods'             => 'POST',
        'callback'            => 'hs_handle_quote_submission',
        'permission_callback' => '__return_true',
    ) );
}
add_action( 'rest_api_init', 'hs_register_quote_endpoint' );

function hs_handle_quote_submission( $request ) {
    $nonce = $request->get_header( 'X-WP-Nonce' );
    if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
        return new WP_Error( 'invalid_nonce', __( 'Security check failed.', 'house-service' ), array( 'status' => 403 ) );
    }

    $name    = sanitize_text_field( $request->get_param( 'name' ) );
    $email   = sanitize_email( $request->get_param( 'email' ) );
    $phone   = sanitize_text_field( $request->get_param( 'phone' ) );
    $service = sanitize_text_field( $request->get_param( 'service' ) );
    $date    = sanitize_text_field( $request->get_param( 'date' ) );
    $notes   = sanitize_textarea_field( $request->get_param( 'notes' ) );
    $provider_id = absint( $request->get_param( 'provider_id' ) );

    if ( empty( $name ) || empty( $email ) ) {
        return new WP_Error( 'missing_fields', __( 'Name and email are required.', 'house-service' ), array( 'status' => 400 ) );
    }

    if ( ! is_email( $email ) ) {
        return new WP_Error( 'invalid_email', __( 'Please provide a valid email.', 'house-service' ), array( 'status' => 400 ) );
    }

    // Store as a private CPT or option — for demo, just return success.
    do_action( 'hs_quote_submitted', compact( 'name', 'email', 'phone', 'service', 'date', 'notes', 'provider_id' ) );

    return rest_ensure_response( array(
        'success' => true,
        'message' => __( 'Quote request sent! The provider will respond shortly.', 'house-service' ),
    ) );
}
