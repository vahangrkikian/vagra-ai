<?php
/**
 * Meridian Admin — editor styles and admin CSS.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Meridian_Admin
 *
 * Handles editor style loading and admin stylesheet enqueuing.
 */
class Meridian_Admin {

    /**
     * Initialize hooks.
     */
    public static function init() {
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_styles' ) );
        add_action( 'after_setup_theme', array( __CLASS__, 'add_editor_styles' ) );
    }

    /**
     * Enqueue admin CSS for meta box styling.
     *
     * @param string $hook Current admin page hook.
     */
    public static function enqueue_admin_styles( $hook ) {
        if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
            wp_enqueue_style(
                'meridian-admin',
                get_template_directory_uri() . '/assets/css/admin.css',
                array(),
                MERIDIAN_VERSION
            );
        }
    }

    /**
     * Add editor stylesheet so the block editor matches front-end typography.
     */
    public static function add_editor_styles() {
        add_editor_style( 'assets/css/editor-style.css' );
    }
}

Meridian_Admin::init();
