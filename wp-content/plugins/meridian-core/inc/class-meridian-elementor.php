<?php
/**
 * Elementor integration for Meridian hotel theme.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Meridian_Elementor {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            return;
        }
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_styles' ] );
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'editor_styles' ] );
    }

    public function register_categories( $elements_manager ) {
        $elements_manager->add_category( 'meridian', [
            'title' => __( 'Meridian Hotel', 'meridian' ),
            'icon'  => 'eicon-site-logo',
        ] );
    }

    public function register_widgets( $widgets_manager ) {
        require_once MERIDIAN_CORE_DIR . 'inc/elementor/class-widget-base.php';

        $widgets = [
            'hero',
            'rooms',
            'amenities',
            'gallery',
            'testimonials',
            'cta',
        ];

        foreach ( $widgets as $widget ) {
            require_once MERIDIAN_CORE_DIR . 'inc/elementor/widgets/' . $widget . '.php';
        }

        $widgets_manager->register( new \Meridian\Widgets\Hero() );
        $widgets_manager->register( new \Meridian\Widgets\Rooms() );
        $widgets_manager->register( new \Meridian\Widgets\Amenities() );
        $widgets_manager->register( new \Meridian\Widgets\Gallery() );
        $widgets_manager->register( new \Meridian\Widgets\Testimonials() );
        $widgets_manager->register( new \Meridian\Widgets\CTA() );
    }

    public function editor_styles() {
        wp_enqueue_style(
            'meridian-elementor-editor',
            MERIDIAN_CORE_URL . 'assets/css/elementor-editor.css',
            [],
            MERIDIAN_CORE_VERSION
        );
    }
}
