<?php
/**
 * Elementor integration for DriveEase theme.
 *
 * @package DriveEase
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class DriveEase_Elementor {

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
        $elements_manager->add_category( 'driveease', [
            'title' => __( 'DriveEase', 'driveease' ),
            'icon'  => 'eicon-car',
        ] );
    }

    public function register_widgets( $widgets_manager ) {
        require_once DRIVEEASE_CORE_DIR . 'inc/elementor/class-widget-base.php';

        $widgets = [
            'hero',
            'fleet',
            'why',
            'how-it-works',
            'testimonials',
            'cta',
        ];

        foreach ( $widgets as $widget ) {
            require_once DRIVEEASE_CORE_DIR . 'inc/elementor/widgets/' . $widget . '.php';
        }

        $widgets_manager->register( new \DriveEase\Widgets\Hero() );
        $widgets_manager->register( new \DriveEase\Widgets\Fleet() );
        $widgets_manager->register( new \DriveEase\Widgets\Why() );
        $widgets_manager->register( new \DriveEase\Widgets\How_It_Works() );
        $widgets_manager->register( new \DriveEase\Widgets\Testimonials() );
        $widgets_manager->register( new \DriveEase\Widgets\CTA() );
    }

    public function editor_styles() {
        wp_enqueue_style(
            'driveease-elementor-editor',
            DRIVEEASE_CORE_URL . 'assets/css/elementor-editor.css',
            [],
            DRIVEEASE_CORE_VERSION
        );
    }
}
