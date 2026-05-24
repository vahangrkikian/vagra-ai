<?php
/**
 * Elementor integration for Vagra NSLookup theme.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class Vagra_NSL_Elementor {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Check Elementor is active
        if ( ! did_action( 'elementor/loaded' ) ) {
            return;
        }
        add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_categories' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );
        add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'frontend_styles' ) );
    }

    public function register_categories( $elements_manager ) {
        $elements_manager->add_category( 'vagra-nslookup', [
            'title' => __( 'NSLookup', 'vagra-nslookup' ),
            'icon'  => 'eicon-globe',
        ] );
    }

    public function register_widgets( $widgets_manager ) {
        // Load base class
        require_once VAGRA_NSL_CORE_DIR . 'inc/elementor/class-widget-base.php';

        // Load all widgets
        $widgets = array(
            'cine-hero',
            'feature-grid',
            'stats-strip',
            'record-types',
            'faq-accordion',
            'blog-teaser',
            'final-cta',
            'sub-hero',
            'sister-tools',
            'why-use',
        );
        foreach ( $widgets as $widget ) {
            require_once VAGRA_NSL_CORE_DIR . 'inc/elementor/widgets/' . $widget . '.php';
        }

        $widgets_manager->register( new \VagraNSL\Widgets\Cine_Hero() );
        $widgets_manager->register( new \VagraNSL\Widgets\Feature_Grid() );
        $widgets_manager->register( new \VagraNSL\Widgets\Stats_Strip() );
        $widgets_manager->register( new \VagraNSL\Widgets\Record_Types() );
        $widgets_manager->register( new \VagraNSL\Widgets\FAQ_Accordion() );
        $widgets_manager->register( new \VagraNSL\Widgets\Blog_Teaser() );
        $widgets_manager->register( new \VagraNSL\Widgets\Final_CTA() );
        $widgets_manager->register( new \VagraNSL\Widgets\Sub_Hero() );
        $widgets_manager->register( new \VagraNSL\Widgets\Sister_Tools() );
        $widgets_manager->register( new \VagraNSL\Widgets\Why_Use() );
    }

    public function editor_styles() {
        wp_enqueue_style(
            'vagra-nsl-elementor-editor',
            VAGRA_NSL_CORE_URL . 'assets/css/elementor-editor.css',
            array(),
            '1.0.0'
        );
    }

    public function frontend_styles() {
        // Theme's main CSS is already enqueued
    }
}
