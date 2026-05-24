<?php
/**
 * Vagra MSP Cybersecurity Theme Functions
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'VAGRA_VERSION', '1.0.0' );
define( 'VAGRA_MSP_VERSION', '1.0.0' );
define( 'VAGRA_DIR', get_template_directory() );
define( 'VAGRA_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function vagra_setup() {
    load_theme_textdomain( 'vagra-msp', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails.
    add_theme_support( 'post-thumbnails' );

    // Switch default core markup to output valid HTML5.
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

    // Add support for custom logo.
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 60,
            'width'       => 200,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    // Register navigation menus.
    register_nav_menus(
        array(
            'primary'          => esc_html__( 'Primary Menu', 'vagra-msp' ),
            'footer'           => esc_html__( 'Footer Menu', 'vagra-msp' ),
            'footer-tools'     => esc_html__( 'Footer — Other Tools', 'vagra-msp' ),
            'footer-company'   => esc_html__( 'Footer — Company', 'vagra-msp' ),
            'footer-discover'  => esc_html__( 'Footer — Discover', 'vagra-msp' ),
        )
    );

    // Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );

    // Add support for wide and full alignment.
    add_theme_support( 'align-wide' );

    // Editor color palette matching MLP design tokens.
    add_theme_support(
        'editor-color-palette',
        array(
            array(
                'name'  => esc_html__( 'Primary Blue', 'vagra-msp' ),
                'slug'  => 'primary',
                'color' => '#3366FF',
            ),
            array(
                'name'  => esc_html__( 'Dark Navy', 'vagra-msp' ),
                'slug'  => 'dark',
                'color' => '#2B3674',
            ),
            array(
                'name'  => esc_html__( 'Muted', 'vagra-msp' ),
                'slug'  => 'muted',
                'color' => '#68769F',
            ),
            array(
                'name'  => esc_html__( 'White', 'vagra-msp' ),
                'slug'  => 'white',
                'color' => '#FFFFFF',
            ),
            array(
                'name'  => esc_html__( 'Light Background', 'vagra-msp' ),
                'slug'  => 'light-bg',
                'color' => '#F4F7FE',
            ),
        )
    );
}
add_action( 'after_setup_theme', 'vagra_setup' );

/**
 * Enqueue scripts and styles.
 */
function vagra_scripts() {
    // Google Fonts: Poppins + Roboto.
    wp_enqueue_style(
        'vagra-google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap',
        array(),
        null
    );

    // Main stylesheet.
    wp_enqueue_style(
        'vagra-style',
        get_stylesheet_uri(),
        array( 'vagra-google-fonts' ),
        VAGRA_VERSION
    );

    // Theme JavaScript.
    wp_enqueue_script(
        'vagra-script',
        VAGRA_URI . '/assets/js/main.js',
        array(),
        VAGRA_VERSION,
        true
    );

    // Front page (cinematic homepage) assets.
    if ( is_front_page() ) {
        wp_enqueue_style(
            'vagra-front-page',
            VAGRA_URI . '/assets/css/front-page.css',
            array( 'vagra-style' ),
            VAGRA_VERSION
        );
        wp_enqueue_script(
            'vagra-front-page',
            VAGRA_URI . '/assets/js/front-page.js',
            array(),
            VAGRA_VERSION,
            true
        );
    }

    // DNS Tools Hub page assets.
    if ( is_page_template( 'page-tools.php' ) ) {
        wp_enqueue_style(
            'vagra-page-tools',
            VAGRA_URI . '/assets/css/page-tools.css',
            array( 'vagra-style' ),
            VAGRA_VERSION
        );
        wp_enqueue_script(
            'vagra-page-tools',
            VAGRA_URI . '/assets/js/page-tools.js',
            array(),
            VAGRA_VERSION,
            true
        );
    }

    // Single post assets.
    if ( is_singular( 'post' ) ) {
        wp_enqueue_style(
            'vagra-single-post',
            VAGRA_URI . '/assets/css/single-post.css',
            array( 'vagra-style' ),
            VAGRA_VERSION
        );
        wp_enqueue_script(
            'vagra-single-post',
            VAGRA_URI . '/assets/js/single-post.js',
            array(),
            VAGRA_VERSION,
            true
        );
    }

    // Contact page assets.
    if ( is_page_template( 'page-contact.php' ) ) {
        wp_enqueue_style(
            'vagra-front-page',
            VAGRA_URI . '/assets/css/front-page.css',
            array( 'vagra-style' ),
            VAGRA_VERSION
        );
        wp_enqueue_script(
            'vagra-contact-form',
            VAGRA_URI . '/assets/js/contact-form.js',
            array(),
            VAGRA_VERSION,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'vagra_scripts' );

/**
 * Register widget areas.
 */
function vagra_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'vagra-msp' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'vagra-msp' ),
            'before_widget' => '<section id="%1$s" class="widget vagra-card %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer', 'vagra-msp' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'Footer widget area.', 'vagra-msp' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        )
    );
}
add_action( 'widgets_init', 'vagra_widgets_init' );

/**
 * Estimated reading time for a post.
 *
 * @return string e.g. "4 min read"
 */
function vagra_reading_time() {
    $content    = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    $minutes    = max( 1, (int) ceil( $word_count / 238 ) );
    /* translators: %d: number of minutes */
    return sprintf( _n( '%d min read', '%d min read', $minutes, 'vagra-msp' ), $minutes );
}

/**
 * Fallback: Primary menu (shown when no menu is assigned).
 */
function vagra_primary_menu_fallback() {
    echo '<ul id="primary-menu" class="menu">';
    $links = array(
        'tools'       => __( 'Tools', 'vagra-msp' ),
        'ns-lookup'   => __( 'NS Lookup', 'vagra-msp' ),
        'propagation' => __( 'Propagation', 'vagra-msp' ),
        'blog'        => __( 'Blog', 'vagra-msp' ),
        'about'       => __( 'About', 'vagra-msp' ),
    );
    foreach ( $links as $slug => $label ) {
        printf(
            '<li class="menu-item"><a href="%s">%s</a></li>',
            esc_url( home_url( '/' . $slug . '/' ) ),
            esc_html( $label )
        );
    }
    echo '</ul>';
}

/**
 * Fallback: Footer — Other Tools.
 */
function vagra_footer_tools_fallback() {
    echo '<ul id="footer-tools-menu" class="menu">';
    $links = array(
        'tools/spf-lookup'  => __( 'SPF Lookup', 'vagra-msp' ),
        'tools/dkim-lookup' => __( 'DKIM Lookup', 'vagra-msp' ),
        'tools/dmarc-lookup' => __( 'DMARC Lookup', 'vagra-msp' ),
        'tools/bimi-lookup' => __( 'BIMI Lookup', 'vagra-msp' ),
    );
    foreach ( $links as $slug => $label ) {
        printf(
            '<li class="menu-item"><a href="%s">%s</a></li>',
            esc_url( home_url( '/' . $slug . '/' ) ),
            esc_html( $label )
        );
    }
    echo '</ul>';
}

/**
 * Fallback: Footer — Company.
 */
function vagra_footer_company_fallback() {
    echo '<ul id="footer-company-menu" class="menu">';
    $links = array(
        'privacy' => __( 'Privacy Policy', 'vagra-msp' ),
        'terms'   => __( 'Terms of Service', 'vagra-msp' ),
        'contact' => __( 'Contact', 'vagra-msp' ),
        'about'   => __( 'About', 'vagra-msp' ),
    );
    foreach ( $links as $slug => $label ) {
        printf(
            '<li class="menu-item"><a href="%s">%s</a></li>',
            esc_url( home_url( '/' . $slug . '/' ) ),
            esc_html( $label )
        );
    }
    echo '</ul>';
}

/**
 * Estimated reading time for a given post ID.
 *
 * @param int $post_id Post ID.
 * @return string e.g. "4 min read"
 */
function vagra_reading_time_for( $post_id ) {
    $content    = get_post_field( 'post_content', $post_id );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    $minutes    = max( 1, (int) ceil( $word_count / 238 ) );
    /* translators: %d: number of minutes */
    return sprintf( _n( '%d min read', '%d min read', $minutes, 'vagra-msp' ), $minutes );
}

/**
 * Get related posts by category, then tag, then recency.
 *
 * @param int $post_id Current post ID.
 * @param int $count   Number of posts to return.
 * @return WP_Post[]
 */
function vagra_get_related_posts( $post_id, $count = 3 ) {
    $found = array();

    // Try same-category posts first.
    $cats = wp_get_post_categories( $post_id );
    if ( ! empty( $cats ) ) {
        $q = new WP_Query( array(
            'category__in'        => $cats,
            'post__not_in'        => array( $post_id ),
            'posts_per_page'      => $count,
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        ) );
        $found = $q->posts;
    }

    // Fill remaining slots with same-tag posts.
    if ( count( $found ) < $count ) {
        $tags = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );
        if ( ! empty( $tags ) ) {
            $exclude = array_merge( array( $post_id ), wp_list_pluck( $found, 'ID' ) );
            $q = new WP_Query( array(
                'tag__in'             => $tags,
                'post__not_in'        => $exclude,
                'posts_per_page'      => $count - count( $found ),
                'ignore_sticky_posts' => true,
                'no_found_rows'       => true,
            ) );
            $found = array_merge( $found, $q->posts );
        }
    }

    // Fill any remaining slots with recent posts.
    if ( count( $found ) < $count ) {
        $exclude = array_merge( array( $post_id ), wp_list_pluck( $found, 'ID' ) );
        $q = new WP_Query( array(
            'post__not_in'        => $exclude,
            'posts_per_page'      => $count - count( $found ),
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        ) );
        $found = array_merge( $found, $q->posts );
    }

    return $found;
}

/**
 * Preconnect to Google Fonts for faster font loading.
 *
 * @param array  $urls          Existing resource hints.
 * @param string $relation_type Hint type (dns-prefetch, preconnect, etc.).
 * @return array
 */
function vagra_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href'        => 'https://fonts.googleapis.com',
            'crossorigin' => '',
        );
        $urls[] = array(
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'vagra_resource_hints', 10, 2 );

/**
 * Fallback: Footer — Discover.
 */
function vagra_footer_discover_fallback() {
    echo '<ul id="footer-discover-menu" class="menu">';
    $links = array(
        'blog'  => __( 'Blog', 'vagra-msp' ),
        'faq'   => __( 'FAQ', 'vagra-msp' ),
        'tools' => __( 'Tools', 'vagra-msp' ),
        'rfcs'  => __( 'RFCs', 'vagra-msp' ),
    );
    foreach ( $links as $slug => $label ) {
        printf(
            '<li class="menu-item"><a href="%s">%s</a></li>',
            esc_url( home_url( '/' . $slug . '/' ) ),
            esc_html( $label )
        );
    }
    echo '</ul>';
}

// Admin settings page.
require_once VAGRA_DIR . '/inc/class-vagra-admin.php';
new Vagra_MSP_Admin();

// Customizer settings.
require_once VAGRA_DIR . '/inc/customizer.php';

// TGM Plugin Activation — recommended plugins.
require_once VAGRA_DIR . '/inc/tgm-init.php';

// Polylang multilingual integration.
require_once VAGRA_DIR . '/inc/polylang-integration.php';
