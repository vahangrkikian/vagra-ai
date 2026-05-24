<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'after_setup_theme', function() {
    load_theme_textdomain( 'tourvice', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', ['search-form','comment-form','comment-list','gallery','caption','style','script'] );
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'editor-styles' );

    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'tourvice' ),
        'footer'  => __( 'Footer Menu', 'tourvice' ),
    ] );

    add_image_size( 'tourvice-card', 800, 500, true );
    add_image_size( 'tourvice-hero', 1920, 1080, true );

    if ( ! isset( $content_width ) ) { $content_width = 1200; }
} );

add_action( 'widgets_init', function() {
    register_sidebar( [
        'name'          => __( 'Sidebar', 'tourvice' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ] );

    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( [
            'name'          => sprintf( __( 'Footer Column %d', 'tourvice' ), $i ),
            'id'            => 'footer-' . $i,
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ] );
    }
} );

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'theme-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Inter:wght@400;500;600&display=swap',
        [], null );

    if ( file_exists( get_template_directory() . '/assets/css/main.css' ) ) {
        wp_enqueue_style( 'theme-tailwind', get_template_directory_uri() . '/assets/css/main.css',
            ['theme-fonts'], TOURVICE_VERSION );
    }

    wp_enqueue_style( 'theme-style', get_stylesheet_uri(),
        ['theme-fonts'], TOURVICE_VERSION );

    // Front page section styles (loaded on all pages since ACF blocks can be used anywhere).
    if ( file_exists( get_template_directory() . '/assets/css/front-page.css' ) ) {
        wp_enqueue_style( 'tourvice-front-page', get_template_directory_uri() . '/assets/css/front-page.css',
            ['theme-style'], TOURVICE_VERSION );
    }

    // Tour archive page.
    if ( is_post_type_archive( 'vagra_tour' ) || is_page( 'tours' ) ) {
        if ( file_exists( get_template_directory() . '/assets/css/archive-tours.css' ) ) {
            wp_enqueue_style( 'tourvice-archive-tours', get_template_directory_uri() . '/assets/css/archive-tours.css',
                ['theme-style'], TOURVICE_VERSION );
        }
    }

    // Single tour detail page.
    if ( is_singular( 'vagra_tour' ) ) {
        if ( file_exists( get_template_directory() . '/assets/css/single-tour.css' ) ) {
            wp_enqueue_style( 'tourvice-single-tour', get_template_directory_uri() . '/assets/css/single-tour.css',
                ['theme-style'], TOURVICE_VERSION );
        }
    }

    // Contact page.
    if ( is_page_template( 'page-contact.php' ) || is_page( 'contact' ) ) {
        if ( file_exists( get_template_directory() . '/assets/css/contact.css' ) ) {
            wp_enqueue_style( 'tourvice-contact', get_template_directory_uri() . '/assets/css/contact.css',
                ['theme-style'], TOURVICE_VERSION );
        }
    }

    // Admin/editor: load front-page CSS for block previews.
    if ( is_admin() ) {
        wp_enqueue_style( 'tourvice-front-page-editor', get_template_directory_uri() . '/assets/css/front-page.css',
            [], TOURVICE_VERSION );
    }

    // i18n & currency scripts.
    if ( file_exists( get_template_directory() . '/assets/js/i18n.js' ) ) {
        wp_enqueue_script( 'tourvice-i18n', get_template_directory_uri() . '/assets/js/i18n.js',
            [], TOURVICE_VERSION, true );
    }
    if ( file_exists( get_template_directory() . '/assets/js/currency.js' ) ) {
        wp_enqueue_script( 'tourvice-currency', get_template_directory_uri() . '/assets/js/currency.js',
            [], TOURVICE_VERSION, true );
    }
    if ( file_exists( get_template_directory() . '/assets/js/main.js' ) ) {
        wp_enqueue_script( 'theme-script', get_template_directory_uri() . '/assets/js/main.js',
            [], TOURVICE_VERSION, true );
        wp_localize_script( 'theme-script', 'tourvice_data', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'tourvice_nonce' ),
            'rest_url' => rest_url( 'tourvice/v1/' ),
        ] );
    }
} );

// Enqueue block editor styles so ACF block previews render correctly.
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style( 'tourvice-editor-main', get_template_directory_uri() . '/assets/css/main.css',
        [], TOURVICE_VERSION );
    wp_enqueue_style( 'tourvice-editor-front', get_template_directory_uri() . '/assets/css/front-page.css',
        [], TOURVICE_VERSION );
    wp_enqueue_style( 'tourvice-editor-theme', get_stylesheet_uri(),
        [], TOURVICE_VERSION );
    wp_enqueue_style( 'tourvice-editor-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Inter:wght@400;500;600&display=swap',
        [], null );
} );

add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = [ 'href' => 'https://fonts.googleapis.com', 'crossorigin' ];
        $urls[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' ];
    }
    return $urls;
}, 10, 2 );

/**
 * Fallback menus.
 */
function tourvice_primary_menu_fallback() {
    $items = [
        [ 'url' => home_url( '/' ), 'label' => __( 'Home', 'tourvice' ) ],
        [ 'url' => home_url( '/tours/' ), 'label' => __( 'Tours', 'tourvice' ) ],
        [ 'url' => home_url( '/destinations/' ), 'label' => __( 'Destinations', 'tourvice' ) ],
        [ 'url' => home_url( '/blog/' ), 'label' => __( 'Blog', 'tourvice' ) ],
        [ 'url' => home_url( '/about/' ), 'label' => __( 'About', 'tourvice' ) ],
        [ 'url' => home_url( '/contact/' ), 'label' => __( 'Contact', 'tourvice' ) ],
    ];
    echo '<ul class="tourvice-header__nav-list">';
    foreach ( $items as $item ) {
        printf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
    }
    echo '</ul>';
}

function tourvice_mobile_menu_fallback() {
    $items = [
        [ 'url' => home_url( '/' ), 'label' => __( 'Home', 'tourvice' ) ],
        [ 'url' => home_url( '/tours/' ), 'label' => __( 'Tours', 'tourvice' ) ],
        [ 'url' => home_url( '/destinations/' ), 'label' => __( 'Destinations', 'tourvice' ) ],
        [ 'url' => home_url( '/blog/' ), 'label' => __( 'Blog', 'tourvice' ) ],
        [ 'url' => home_url( '/about/' ), 'label' => __( 'About', 'tourvice' ) ],
        [ 'url' => home_url( '/contact/' ), 'label' => __( 'Contact', 'tourvice' ) ],
    ];
    foreach ( $items as $item ) {
        printf( '<a href="%s">%s</a>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
    }
}

function tourvice_footer_menu_fallback() {
    $items = [
        [ 'url' => home_url( '/about/' ), 'label' => __( 'About', 'tourvice' ) ],
        [ 'url' => home_url( '/tours/' ), 'label' => __( 'Tours', 'tourvice' ) ],
        [ 'url' => home_url( '/blog/' ), 'label' => __( 'Blog', 'tourvice' ) ],
        [ 'url' => home_url( '/faq/' ), 'label' => __( 'FAQ', 'tourvice' ) ],
        [ 'url' => home_url( '/contact/' ), 'label' => __( 'Contact', 'tourvice' ) ],
    ];
    echo '<ul>';
    foreach ( $items as $item ) {
        printf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
    }
    echo '</ul>';
}
