<?php
/**
 * Elementor integration for TourVice theme.
 *
 * @package TourVice
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class TourVice_Elementor {

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
        $elements_manager->add_category( 'tourvice', [
            'title' => __( 'TourVice', 'tourvice' ),
            'icon'  => 'eicon-site-logo',
        ] );
    }

    public function register_widgets( $widgets_manager ) {
        require_once TOURVICE_CORE_DIR . 'inc/elementor/class-widget-base.php';

        $widgets = [
            'hero',
            'featured-tours',
            'why',
            'testimonials',
            'cta',
        ];

        foreach ( $widgets as $widget ) {
            require_once TOURVICE_CORE_DIR . 'inc/elementor/widgets/' . $widget . '.php';
        }

        $widgets_manager->register( new \TourVice\Widgets\Hero() );
        $widgets_manager->register( new \TourVice\Widgets\Featured_Tours() );
        $widgets_manager->register( new \TourVice\Widgets\Why() );
        $widgets_manager->register( new \TourVice\Widgets\Testimonials() );
        $widgets_manager->register( new \TourVice\Widgets\CTA() );
    }

    public function editor_styles() {
        wp_enqueue_style(
            'tourvice-elementor-editor',
            TOURVICE_CORE_URL . 'assets/css/elementor-editor.css',
            [],
            TOURVICE_CORE_VERSION
        );
    }
}
