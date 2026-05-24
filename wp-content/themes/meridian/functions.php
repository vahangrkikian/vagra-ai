<?php
/**
 * Meridian Theme Functions
 *
 * A luxury hotel WordPress theme — rooms, reservations, gallery, and concierge.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'MERIDIAN_VERSION', '1.0.0' );
define( 'MERIDIAN_DIR', get_template_directory() );
define( 'MERIDIAN_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function meridian_setup() {
    load_theme_textdomain( 'meridian', get_template_directory() . '/languages' );

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

    // Image sizes for room cards, gallery, hero, and thumbnails.
    add_image_size( 'meridian-card', 400, 300, true );
    add_image_size( 'meridian-gallery', 800, 600, true );
    add_image_size( 'meridian-hero', 1440, 600, true );
    add_image_size( 'meridian-thumb', 200, 150, true );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'meridian' ),
        'footer'  => __( 'Footer Menu', 'meridian' ),
    ) );
}
add_action( 'after_setup_theme', 'meridian_setup' );

/**
 * Fallback callback for the primary menu when no menu is assigned.
 */
function meridian_primary_menu_fallback() {
    $items = array(
        array( 'url' => home_url( '/' ),           'label' => __( 'Home', 'meridian' ) ),
        array( 'url' => home_url( '/rooms/' ),      'label' => __( 'Rooms', 'meridian' ) ),
        array( 'url' => home_url( '/about/' ),      'label' => __( 'About', 'meridian' ) ),
        array( 'url' => home_url( '/gallery/' ),    'label' => __( 'Gallery', 'meridian' ) ),
        array( 'url' => home_url( '/location/' ),   'label' => __( 'Location', 'meridian' ) ),
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

/**
 * Fallback callback for the footer menu when no menu is assigned.
 */
function meridian_footer_menu_fallback() {
    $items = array(
        array( 'url' => home_url( '/about/' ),    'label' => __( 'About', 'meridian' ) ),
        array( 'url' => home_url( '/gallery/' ),   'label' => __( 'Gallery', 'meridian' ) ),
        array( 'url' => home_url( '/location/' ),  'label' => __( 'Location', 'meridian' ) ),
        array( 'url' => home_url( '/careers/' ),   'label' => __( 'Careers', 'meridian' ) ),
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

/**
 * Enqueue styles and scripts.
 */
function meridian_enqueue_assets() {
    // Google Fonts: Playfair Display + Inter.
    wp_enqueue_style(
        'meridian-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Main stylesheet.
    wp_enqueue_style(
        'meridian-style',
        get_stylesheet_uri(),
        array( 'meridian-google-fonts' ),
        MERIDIAN_VERSION
    );

    // Site-wide: main.js for scroll reveal, nav toggle, gallery lightbox.
    wp_enqueue_script(
        'meridian-main',
        MERIDIAN_URI . '/assets/js/main.js',
        array(),
        MERIDIAN_VERSION,
        true
    );

    // Room archive / room category taxonomy: room-filters.js with localized data.
    if ( is_post_type_archive( 'meridian_room' ) || is_tax( 'meridian_room_cat' ) ) {
        wp_enqueue_script(
            'meridian-room-filters',
            MERIDIAN_URI . '/assets/js/room-filters.js',
            array(),
            MERIDIAN_VERSION,
            true
        );
        wp_localize_script( 'meridian-room-filters', 'meridianFilters', array(
            'restUrl' => esc_url_raw( rest_url( 'meridian/v1/' ) ),
            'nonce'   => wp_create_nonce( 'wp_rest' ),
        ) );
    }

    // Single room: booking.js with localized data.
    if ( is_singular( 'meridian_room' ) ) {
        wp_enqueue_script(
            'meridian-booking',
            MERIDIAN_URI . '/assets/js/booking.js',
            array(),
            MERIDIAN_VERSION,
            true
        );
        wp_localize_script( 'meridian-booking', 'meridianBooking', array(
            'restUrl'   => esc_url_raw( rest_url( 'meridian/v1/' ) ),
            'nonce'     => wp_create_nonce( 'wp_rest' ),
            'resortFee' => 35,
            'taxRate'   => 0.1475,
        ) );
    }

    // Site-wide: AI chat widget.
    wp_enqueue_style(
        'vagra-chat',
        MERIDIAN_URI . '/assets/css/vagra-chat.css',
        array( 'meridian-style' ),
        MERIDIAN_VERSION
    );

    wp_enqueue_script(
        'vagra-chat',
        MERIDIAN_URI . '/assets/js/vagra-chat.js',
        array(),
        MERIDIAN_VERSION,
        true
    );
    wp_localize_script( 'vagra-chat', 'vagraChat', array(
        'restUrl' => esc_url_raw( rest_url( 'meridian/v1/chat' ) ),
        'nonce'   => wp_create_nonce( 'wp_rest' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'meridian_enqueue_assets' );

/**
 * Return an inline SVG icon string.
 *
 * @param string $name   Icon name.
 * @param int    $size   Width/height in px (default 22).
 * @param float  $stroke Stroke width (default 1.6).
 * @return string SVG markup.
 */
function meridian_icon( $name, $size = 22, $stroke = 1.6 ) {
    $attr = sprintf(
        'width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="%2$s" stroke-linecap="round" stroke-linejoin="round"',
        (int) $size,
        esc_attr( $stroke )
    );

    $icons = array(
        'pin'           => '<svg ' . $attr . '><path d="M12 22s-7-7.5-7-13a7 7 0 1 1 14 0c0 5.5-7 13-7 13Z"/><circle cx="12" cy="9" r="2.5"/></svg>',
        'bell'          => '<svg ' . $attr . '><path d="M6 8a6 6 0 0 1 12 0v5l1.5 3h-15L6 13Z"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>',
        'bed'           => '<svg ' . $attr . '><path d="M3 18V8m18 10v-5a3 3 0 0 0-3-3H3"/><path d="M3 18h18"/><circle cx="7.5" cy="12.5" r="1.5"/></svg>',
        'wifi'          => '<svg ' . $attr . '><path d="M2 9a16 16 0 0 1 20 0"/><path d="M5 13a11 11 0 0 1 14 0"/><path d="M8.5 16.5a6 6 0 0 1 7 0"/><circle cx="12" cy="20" r="0.6" fill="currentColor"/></svg>',
        'pool'          => '<svg ' . $attr . '><path d="M2 17c2 0 2-1.5 4-1.5S8 17 10 17s2-1.5 4-1.5S16 17 18 17s2-1.5 4-1.5"/><path d="M2 20c2 0 2-1.5 4-1.5S8 20 10 20s2-1.5 4-1.5S16 20 18 20s2-1.5 4-1.5"/><path d="M7 14V6a2 2 0 0 1 4 0"/><path d="M17 14V6a2 2 0 0 0-4 0"/></svg>',
        'spa'           => '<svg ' . $attr . '><path d="M12 22c-1-5-5-7-9-7 0-5 4-9 9-9s9 4 9 9c-4 0-8 2-9 7Z"/><path d="M12 22V11"/></svg>',
        'arrow-right'   => '<svg ' . $attr . '><path d="M5 12h14m-5-6 6 6-6 6"/></svg>',
        'arrow-down'    => '<svg ' . $attr . '><path d="M12 5v14m-6-5 6 6 6-6"/></svg>',
        'menu'          => '<svg ' . $attr . '><path d="M4 7h16M4 12h16M4 17h16"/></svg>',
        'close'         => '<svg ' . $attr . '><path d="M6 6l12 12M18 6 6 18"/></svg>',
        'star'          => sprintf(
            '<svg width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="m12 17.3-6.2 3.7 1.6-7L2 9.3l7.1-.6L12 2l2.9 6.7 7.1.6-5.4 4.7 1.6 7Z"/></svg>',
            (int) $size
        ),
        'check'         => '<svg ' . $attr . '><path d="m5 13 4 4L19 7"/></svg>',
        'guests'        => '<svg ' . $attr . '><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16 11a3 3 0 1 0 0-6"/><path d="M22 20a5 5 0 0 0-5-5"/></svg>',
        'ruler'         => '<svg ' . $attr . '><path d="M3 14 14 3l7 7L10 21Z"/><path d="m7 12 2 2m1-5 2 2m2-5 2 2"/></svg>',
        'eye'           => '<svg ' . $attr . '><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>',
        'phone'         => '<svg ' . $attr . '><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.1-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .3 2 .6 2.9a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.9.5 2.9.6a2 2 0 0 1 1.8 2.1Z"/></svg>',
        'instagram'     => '<svg ' . $attr . '><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.6" fill="currentColor"/></svg>',
        'facebook'      => '<svg ' . $attr . '><path d="M16 8h-2.5A1.5 1.5 0 0 0 12 9.5V12h4l-.5 3H12v7"/></svg>',
        'x'             => '<svg ' . $attr . '><path d="M4 4l16 16M20 4 4 20"/></svg>',
        'plus'          => '<svg ' . $attr . '><path d="M12 5v14M5 12h14"/></svg>',
        'minus'         => '<svg ' . $attr . '><path d="M5 12h14"/></svg>',
        'chevron-down'  => '<svg ' . $attr . '><path d="m6 9 6 6 6-6"/></svg>',
        'chevron-left'  => '<svg ' . $attr . '><path d="m15 18-6-6 6-6"/></svg>',
        'chevron-right' => '<svg ' . $attr . '><path d="m9 6 6 6-6 6"/></svg>',
    );

    if ( isset( $icons[ $name ] ) ) {
        return $icons[ $name ];
    }

    return '';
}

// Demo import (OCDI).
require_once get_template_directory() . '/inc/demo-import.php';

// TGM Plugin Activation — recommended plugins (including Meridian Core).
require_once get_template_directory() . '/inc/tgm-init.php';

// Polylang multilingual integration.
require_once get_template_directory() . '/inc/polylang-integration.php';

// Customizer settings.
require_once get_template_directory() . '/inc/customizer.php';

// Admin editor styles and meta box CSS.
require_once get_template_directory() . '/inc/class-meridian-admin.php';

/**
 * Flush rewrite rules on theme switch so CPT archives resolve.
 */
function meridian_flush_rewrites_on_switch() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'meridian_flush_rewrites_on_switch' );

/**
 * Auto-create essential pages if they do not exist.
 * Runs once and sets an option flag so it does not repeat.
 */
function meridian_maybe_create_pages() {
    if ( get_option( 'meridian_pages_created' ) === 'v2' ) {
        return;
    }

    $pages = array(
        'home'           => array( 'title' => 'Home',                    'template' => '' ),
        'about'          => array( 'title' => 'About',                   'template' => 'page-about.php' ),
        'gallery'        => array( 'title' => 'Gallery',                 'template' => 'page-gallery.php' ),
        'location'       => array( 'title' => 'Location',               'template' => 'page-location.php' ),
        'long-stays'     => array( 'title' => 'Long Stays',              'template' => '', 'content' => '<h2>Extended Stay Program</h2><p>For stays of 14 nights or more, The Meridian offers a dedicated long-stay program with preferential rates, weekly housekeeping customization, and access to our resident lounge on the 18th floor.</p><h3>What\'s included</h3><ul><li>15% discount on published room rates</li><li>Complimentary laundry service (weekly)</li><li>Access to the resident lounge and pantry kitchen</li><li>Dedicated point of contact on the front desk</li><li>Flexible housekeeping schedule</li></ul><p>Contact our reservations team to discuss availability and rates for your dates.</p>' ),
        'offers'         => array( 'title' => 'Offers',                 'template' => '', 'content' => '<h2>Current Offers</h2><h3>Weekend Escape</h3><p>Book a Friday and Saturday night and receive Sunday complimentary. Includes breakfast for two at The Grill Room.</p><h3>Early Bird Rate</h3><p>Reserve 30 days in advance and save 20% on any room category. Non-refundable, but the savings are substantial.</p><h3>Suite Upgrade</h3><p>Book any Deluxe room for three or more nights and receive a complimentary upgrade to a Suite, subject to availability at check-in.</p>' ),
        'gift-cards'     => array( 'title' => 'Gift Cards',             'template' => '', 'content' => '<h2>Meridian Gift Cards</h2><p>Give the gift of a stay at The Meridian. Our gift cards are available in any denomination from $100 to $5,000 and can be applied to room reservations, dining, spa treatments, or any hotel service.</p><h3>How it works</h3><ul><li>Choose your amount</li><li>Add a personal message</li><li>Receive a beautifully designed digital or physical card</li><li>Cards never expire</li></ul><p>To purchase, please contact our front desk at +1 (212) 555-0199.</p>' ),
        'careers'        => array( 'title' => 'Careers',                'template' => '', 'content' => '<h2>Work at The Meridian</h2><p>We are a team of 220 people who believe that hospitality is a craft, not a script. Most of our staff have been with us for more than five years.</p><h3>Current Openings</h3><ul><li><strong>Front Desk Associate</strong> — Full-time, rotating shifts</li><li><strong>Housekeeping Supervisor</strong> — Full-time, mornings</li><li><strong>Line Cook, The Grill Room</strong> — Full-time, evenings</li><li><strong>Spa Therapist</strong> — Part-time, flexible hours</li></ul><p>To apply, send your CV to careers@themeridian.example.</p>' ),
        'privacy'        => array( 'title' => 'Privacy Policy',         'template' => '', 'content' => '<h2>Privacy Policy</h2><p>The Meridian Hotel respects the privacy of our guests and website visitors. We collect personal information when you make a reservation or inquiry. We use your data to process reservations and improve our services. We do not sell personal data to third parties.</p><p>For privacy-related inquiries, contact privacy@themeridian.example.</p>' ),
        'terms'          => array( 'title' => 'Terms & Conditions',     'template' => '', 'content' => '<h2>Terms &amp; Conditions</h2><h3>Reservations</h3><p>All reservations are subject to availability. Cancellations must be made at least 48 hours before check-in.</p><h3>Check-in / Check-out</h3><p>Check-in: 3:00 PM. Check-out: 11:00 AM.</p><h3>Resort Fee</h3><p>A daily resort fee of $35 applies to all reservations, covering Wi-Fi, fitness center access, and local phone calls.</p>' ),
        'accessibility'  => array( 'title' => 'Accessibility',          'template' => '', 'content' => '<h2>Accessibility</h2><p>The Meridian is committed to providing an accessible experience for all guests.</p><ul><li>Wheelchair-accessible entrance and lobby</li><li>Elevators to all floors with braille signage</li><li>Accessible rooms with roll-in showers and grab bars</li><li>Service animals welcome throughout the property</li></ul><p>Contact accessibility@themeridian.example for questions.</p>' ),
        'modern-slavery' => array( 'title' => 'Modern Slavery Statement','template' => '', 'content' => '<h2>Modern Slavery Statement</h2><p>The Meridian Hotel is committed to preventing modern slavery and human trafficking in our business and supply chains. We conduct due diligence on all suppliers and ensure fair wages and working conditions for all staff.</p>' ),
    );

    foreach ( $pages as $slug => $data ) {
        $existing = get_page_by_path( $slug );
        if ( $existing ) {
            continue;
        }
        $page_id = wp_insert_post( array(
            'post_title'   => $data['title'],
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => isset( $data['content'] ) ? $data['content'] : '',
        ) );
        if ( $page_id && ! is_wp_error( $page_id ) && $data['template'] ) {
            update_post_meta( $page_id, '_wp_page_template', $data['template'] );
        }
    }

    // Create demo rooms if none exist.
    $room_count = wp_count_posts( 'meridian_room' );
    if ( ! $room_count || $room_count->publish < 1 ) {
        // Ensure taxonomy exists.
        $cats = array( 'Standard', 'Deluxe', 'Suite', 'Family', 'Penthouse' );
        foreach ( $cats as $cat_name ) {
            if ( ! term_exists( $cat_name, 'meridian_room_cat' ) ) {
                wp_insert_term( $cat_name, 'meridian_room_cat' );
            }
        }

        $rooms = array(
            array(
                'title'    => 'Classic City Room',
                'slug'     => 'classic-city-room',
                'content'  => 'Our signature entry-level room balances quiet comfort with thoughtful design. Custom millwork, a hand-tufted headboard and curated lighting give the room a residential feel — every detail considered.',
                'order'    => 1,
                'cat'      => 'Standard',
                'meta'     => array(
                    '_meridian_price'    => '149',
                    '_meridian_guests'   => '2',
                    '_meridian_size_sqm' => '28',
                    '_meridian_bed_type' => 'King',
                    '_meridian_view'     => 'City View',
                    '_meridian_badge'    => '',
                    '_meridian_tagline'  => 'A refined urban retreat with floor-to-ceiling views of the Midtown skyline.',
                    '_meridian_amenities' => "600-thread Egyptian cotton\nNespresso bar\n55\" 4K television\nMarble rain shower\nSmart climate control\nBlack-out drapery",
                ),
            ),
            array(
                'title'    => 'Deluxe Panorama Suite',
                'slug'     => 'deluxe-panorama-suite',
                'content'  => 'A wraparound view, a curved velvet lounge, and a soaking tub set against the city — the Deluxe Panorama is a study in calm. Best at golden hour.',
                'order'    => 2,
                'cat'      => 'Suite',
                'meta'     => array(
                    '_meridian_price'    => '249',
                    '_meridian_guests'   => '2',
                    '_meridian_size_sqm' => '45',
                    '_meridian_bed_type' => 'King',
                    '_meridian_view'     => 'Skyline Panorama',
                    '_meridian_badge'    => 'Most Popular',
                    '_meridian_tagline'  => 'Corner suite with two walls of glass overlooking Bryant Park and beyond.',
                    '_meridian_amenities' => "Soaking tub with view\nSeparate lounge\nWalk-in closet\nBose surround\nWelcome champagne\nDaily turndown",
                ),
            ),
            array(
                'title'    => 'Executive Studio',
                'slug'     => 'executive-studio',
                'content'  => 'A dedicated workspace with a leather-topped desk, ergonomic chair, and acoustic paneling. Sliding doors separate work from sleep so you can close the laptop and the day in one motion.',
                'order'    => 3,
                'cat'      => 'Standard',
                'meta'     => array(
                    '_meridian_price'    => '199',
                    '_meridian_guests'   => '2',
                    '_meridian_size_sqm' => '38',
                    '_meridian_bed_type' => 'King',
                    '_meridian_view'     => 'City View',
                    '_meridian_badge'    => 'For Business',
                    '_meridian_tagline'  => 'A working studio designed for the focused traveler — without sacrificing rest.',
                    '_meridian_amenities' => "Dedicated workspace\nErgonomic seating\n1Gbps wired ethernet\nPrinter access\nAcoustic paneling\nEspresso bar",
                ),
            ),
            array(
                'title'    => 'Premium Family Suite',
                'slug'     => 'premium-family-suite',
                'content'  => 'A genuinely livable suite for families and small groups. The primary bedroom is fully partitioned from the children\'s room; both share a generous central lounge and a kitchenette stocked on request.',
                'order'    => 4,
                'cat'      => 'Family',
                'meta'     => array(
                    '_meridian_price'    => '329',
                    '_meridian_guests'   => '4',
                    '_meridian_size_sqm' => '68',
                    '_meridian_bed_type' => '1 King + 2 Twin',
                    '_meridian_view'     => 'Park View',
                    '_meridian_badge'    => 'Family',
                    '_meridian_tagline'  => 'Two bedrooms, one living room, and quiet for everyone — even the parents.',
                    '_meridian_amenities' => "Two bedrooms\nKitchenette\nConnecting doors\nFamily welcome kit\nCribs available\nChildproofing on request",
                ),
            ),
            array(
                'title'    => 'Meridian Penthouse',
                'slug'     => 'meridian-penthouse',
                'content'  => 'Our flagship: a duplex penthouse with a private elevator entrance, two bedrooms, a dining room for ten, and a terrace that wraps the entire crown of the building.',
                'order'    => 5,
                'cat'      => 'Penthouse',
                'meta'     => array(
                    '_meridian_price'    => '1290',
                    '_meridian_guests'   => '4',
                    '_meridian_size_sqm' => '180',
                    '_meridian_bed_type' => '2 King',
                    '_meridian_view'     => 'Private Terrace, 360°',
                    '_meridian_badge'    => 'Penthouse',
                    '_meridian_tagline'  => 'The top floor. A private terrace. The city, arranged around you.',
                    '_meridian_amenities' => "Private elevator\nTerrace with firepit\nButler service\nDining for 10\nSteinway piano\nOutdoor soaking tub",
                ),
            ),
            array(
                'title'    => 'Deluxe King Room',
                'slug'     => 'deluxe-king-room',
                'content'  => 'A step up from the Classic City Room — larger footprint, sitting area, and an enhanced bath with double vanity and separate rain shower.',
                'order'    => 6,
                'cat'      => 'Deluxe',
                'meta'     => array(
                    '_meridian_price'    => '219',
                    '_meridian_guests'   => '2',
                    '_meridian_size_sqm' => '36',
                    '_meridian_bed_type' => 'King',
                    '_meridian_view'     => 'City View',
                    '_meridian_badge'    => '',
                    '_meridian_tagline'  => 'Generously sized king room with a sitting area and the full Meridian comfort kit.',
                    '_meridian_amenities' => "Sitting area\nDouble vanity\nSeparate rain shower\nPillow menu\nWelcome amenity\nDaily turndown",
                ),
            ),
        );

        foreach ( $rooms as $room ) {
            $room_id = wp_insert_post( array(
                'post_title'   => $room['title'],
                'post_name'    => $room['slug'],
                'post_status'  => 'publish',
                'post_type'    => 'meridian_room',
                'post_content' => $room['content'],
                'menu_order'   => $room['order'],
            ) );
            if ( $room_id && ! is_wp_error( $room_id ) ) {
                foreach ( $room['meta'] as $key => $value ) {
                    update_post_meta( $room_id, $key, $value );
                }
                $term = get_term_by( 'name', $room['cat'], 'meridian_room_cat' );
                if ( $term ) {
                    wp_set_object_terms( $room_id, $term->term_id, 'meridian_room_cat' );
                }
            }
        }
    }

    // Set "Home" as static front page.
    $home_page = get_page_by_path( 'home' );
    if ( $home_page ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $home_page->ID );
    }

    // Create and assign primary menu if none exists.
    if ( ! has_nav_menu( 'primary' ) ) {
        $existing_menu = wp_get_nav_menu_object( 'Primary' );
        $menu_id       = $existing_menu ? $existing_menu->term_id : wp_create_nav_menu( 'Primary' );
        if ( $menu_id && ! is_wp_error( $menu_id ) ) {
            $existing_items = wp_get_nav_menu_items( $menu_id );
            if ( empty( $existing_items ) ) {
                $room_archive = get_post_type_archive_link( 'meridian_room' );
                $menu_items   = array(
                    array( 'title' => 'Home',     'url' => home_url( '/' ) ),
                    array( 'title' => 'Rooms',    'url' => $room_archive ? $room_archive : home_url( '/room/' ) ),
                    array( 'title' => 'About',    'url' => home_url( '/about/' ) ),
                    array( 'title' => 'Gallery',  'url' => home_url( '/gallery/' ) ),
                    array( 'title' => 'Location', 'url' => home_url( '/location/' ) ),
                );
                foreach ( $menu_items as $i => $item ) {
                    wp_update_nav_menu_item( $menu_id, 0, array(
                        'menu-item-title'   => $item['title'],
                        'menu-item-url'     => $item['url'],
                        'menu-item-status'  => 'publish',
                        'menu-item-type'    => 'custom',
                        'menu-item-position' => $i + 1,
                    ) );
                }
            }
            $locations            = get_theme_mod( 'nav_menu_locations', array() );
            $locations['primary'] = $menu_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }

    // Create and assign footer menu if none exists.
    if ( ! has_nav_menu( 'footer' ) ) {
        $existing_footer = wp_get_nav_menu_object( 'Footer' );
        $footer_id       = $existing_footer ? $existing_footer->term_id : wp_create_nav_menu( 'Footer' );
        if ( $footer_id && ! is_wp_error( $footer_id ) ) {
            $existing_footer_items = wp_get_nav_menu_items( $footer_id );
            if ( empty( $existing_footer_items ) ) {
                $footer_items = array(
                    array( 'title' => 'About',    'url' => home_url( '/about/' ) ),
                    array( 'title' => 'Gallery',  'url' => home_url( '/gallery/' ) ),
                    array( 'title' => 'Location', 'url' => home_url( '/location/' ) ),
                    array( 'title' => 'Careers',  'url' => home_url( '/careers/' ) ),
                );
                foreach ( $footer_items as $i => $item ) {
                    wp_update_nav_menu_item( $footer_id, 0, array(
                        'menu-item-title'   => $item['title'],
                        'menu-item-url'     => $item['url'],
                        'menu-item-status'  => 'publish',
                        'menu-item-type'    => 'custom',
                        'menu-item-position' => $i + 1,
                    ) );
                }
            }
            $locations           = get_theme_mod( 'nav_menu_locations', array() );
            $locations['footer'] = $footer_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }

    update_option( 'meridian_pages_created', 'v2' );
    flush_rewrite_rules();
}
add_action( 'init', 'meridian_maybe_create_pages', 20 );
