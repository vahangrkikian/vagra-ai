<?php
/**
 * vagra.ai Showcase – Theme Functions
 *
 * @package vagra-showcase
 */

// Theme setup
function vagra_showcase_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'vagra-showcase' ),
    ) );
}
add_action( 'after_setup_theme', 'vagra_showcase_setup' );

// Enqueue assets
function vagra_showcase_assets() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap',
        array(),
        null
    );
    wp_enqueue_style( 'vagra-showcase', get_stylesheet_uri(), array( 'google-fonts' ), '1.0.0' );
    wp_enqueue_script( 'vagra-showcase-js', get_template_directory_uri() . '/assets/js/showcase.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'vagra_showcase_assets' );

/**
 * SVG icons helper.
 *
 * @param string $name   Icon name.
 * @param int    $size   Size in px.
 * @param float  $stroke Stroke width.
 * @return string SVG markup.
 */
function vagra_icon( $name, $size = 16, $stroke = 1.6 ) {
    $icons = array(
        'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'download' => '<path d="M12 4v12M6 11l6 6 6-6"/><path d="M4 20h16"/>',
        'spark'    => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M5.6 18.4l2.8-2.8M15.6 8.4l2.8-2.8"/>',
        'key'      => '<circle cx="8" cy="14" r="4"/><path d="M11 14h10M17 14v4M21 14v3"/>',
        'github'   => '<path d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-2c-2.8.6-3.4-1.2-3.4-1.2-.4-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.6 1 1.6 1 .9 1.6 2.4 1.1 3 .9.1-.7.4-1.1.7-1.4-2.2-.2-4.6-1.1-4.6-5 0-1.1.4-2 1-2.7-.1-.3-.5-1.3.1-2.7 0 0 .8-.3 2.8 1a9.6 9.6 0 0 1 5 0c1.9-1.3 2.8-1 2.8-1 .5 1.4.2 2.4.1 2.7.6.7 1 1.6 1 2.7 0 3.9-2.3 4.7-4.6 5 .4.3.7.9.7 1.9v2.8c0 .3.2.6.7.5A10 10 0 0 0 12 2Z"/>',
        'x'        => '<path d="M4 4l16 16M20 4L4 20"/>',
        'linkedin' => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 10v7M8 7v.01M12 17v-4M12 13a3 3 0 0 1 6 0v4"/>',
        'check'    => '<path d="m5 12 5 5L20 7"/>',
        'star'     => '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.27 5.82 21 7 14.14l-5-4.87 6.91-1.01L12 2z"/>',
        'send'     => '<path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>',
    );
    if ( ! isset( $icons[ $name ] ) ) {
        return '';
    }
    return sprintf(
        '<svg width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="%s" stroke-linecap="round" stroke-linejoin="round">%s</svg>',
        (int) $size,
        (int) $size,
        esc_attr( $stroke ),
        $icons[ $name ]
    );
}

// Auto-create front page on first activation.
function vagra_showcase_setup_pages() {
    if ( get_option( 'vagra_showcase_setup_done' ) === 'v1' ) {
        return;
    }
    $home = get_page_by_path( 'home' );
    if ( ! $home ) {
        $home_id = wp_insert_post( array(
            'post_title'   => 'Home',
            'post_name'    => 'home',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ) );
    } else {
        $home_id = $home->ID;
    }
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $home_id );
    update_option( 'vagra_showcase_setup_done', 'v1' );
}
add_action( 'init', 'vagra_showcase_setup_pages', 20 );

// Fix rewrite rules for OSPanel.
function vagra_showcase_fix_rewrites( $rules ) {
    if ( ! is_array( $rules ) ) {
        return $rules;
    }
    $fixed = array();
    foreach ( $rules as $pattern => $query ) {
        $clean           = preg_replace( '#^[A-Z]:/[^/]+#', '', $pattern );
        $fixed[ $clean ] = $query;
    }
    return $fixed;
}
add_filter( 'rewrite_rules_array', 'vagra_showcase_fix_rewrites' );
