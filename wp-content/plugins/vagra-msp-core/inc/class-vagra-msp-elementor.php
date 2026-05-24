<?php
/**
 * Elementor integration for Vagra MSP theme.
 *
 * @package VagraMSP
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Vagra_MSP_Elementor {

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
        $elements_manager->add_category( 'vagra-msp', [
            'title' => __( 'Vagra MSP', 'vagra-msp' ),
            'icon'  => 'eicon-site-logo',
        ] );
    }

    public function register_widgets( $widgets_manager ) {
        require_once VAGRA_MSP_CORE_DIR . 'inc/elementor/class-widget-base.php';

        $widgets = [
            'hero',
            'services',
            'stats',
            'cta',
        ];

        foreach ( $widgets as $widget ) {
            require_once VAGRA_MSP_CORE_DIR . 'inc/elementor/widgets/' . $widget . '.php';
        }

        $widgets_manager->register( new \VagraMSP\Widgets\Hero() );
        $widgets_manager->register( new \VagraMSP\Widgets\Services() );
        $widgets_manager->register( new \VagraMSP\Widgets\Stats() );
        $widgets_manager->register( new \VagraMSP\Widgets\CTA() );
    }

    public function editor_styles() {
        wp_enqueue_style(
            'vagra-msp-elementor-editor',
            VAGRA_MSP_CORE_URL . 'assets/css/elementor-editor.css',
            [],
            '1.0.0'
        );
    }
}
