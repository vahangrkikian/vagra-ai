<?php
/**
 * Elementor integration for Vagra Legal theme.
 *
 * @package VagraLegal
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Vagra_Legal_Elementor {

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
        $elements_manager->add_category( 'vagra-legal', [
            'title' => __( 'Vagra Legal', 'vagra-legal' ),
            'icon'  => 'eicon-site-logo',
        ] );
    }

    public function register_widgets( $widgets_manager ) {
        require_once VAGRA_LEGAL_CORE_DIR . 'inc/elementor/class-widget-base.php';

        $widgets = [
            'hero',
            'practice-areas',
            'attorneys',
            'testimonials',
            'stats',
            'cta',
        ];

        foreach ( $widgets as $widget ) {
            require_once VAGRA_LEGAL_CORE_DIR . 'inc/elementor/widgets/' . $widget . '.php';
        }

        $widgets_manager->register( new \VagraLegal\Widgets\Hero() );
        $widgets_manager->register( new \VagraLegal\Widgets\Practice_Areas() );
        $widgets_manager->register( new \VagraLegal\Widgets\Attorneys() );
        $widgets_manager->register( new \VagraLegal\Widgets\Testimonials() );
        $widgets_manager->register( new \VagraLegal\Widgets\Stats() );
        $widgets_manager->register( new \VagraLegal\Widgets\CTA() );
    }

    public function editor_styles() {
        wp_enqueue_style(
            'vagra-legal-elementor-editor',
            VAGRA_LEGAL_CORE_URL . 'assets/css/elementor-editor.css',
            [],
            '1.0.0'
        );
    }
}
