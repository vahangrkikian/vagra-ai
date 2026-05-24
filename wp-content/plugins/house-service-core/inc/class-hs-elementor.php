<?php
/**
 * Elementor integration for House Service theme.
 *
 * @package HouseService
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class HS_Elementor {

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
        $elements_manager->add_category( 'house-service', [
            'title' => __( 'House Service', 'house-service' ),
            'icon'  => 'eicon-site-logo',
        ] );
    }

    public function register_widgets( $widgets_manager ) {
        require_once HS_CORE_PATH . 'inc/elementor/class-widget-base.php';

        $widgets = [
            'hero',
            'categories',
            'providers',
            'how-it-works',
            'cta',
        ];

        foreach ( $widgets as $widget ) {
            require_once HS_CORE_PATH . 'inc/elementor/widgets/' . $widget . '.php';
        }

        $widgets_manager->register( new \HouseService\Widgets\Hero() );
        $widgets_manager->register( new \HouseService\Widgets\Categories() );
        $widgets_manager->register( new \HouseService\Widgets\Providers() );
        $widgets_manager->register( new \HouseService\Widgets\How_It_Works() );
        $widgets_manager->register( new \HouseService\Widgets\CTA() );
    }

    public function editor_styles() {
        wp_enqueue_style(
            'hs-elementor-editor',
            HS_CORE_URL . 'assets/css/elementor-editor.css',
            [],
            HS_CORE_VERSION
        );
    }
}
