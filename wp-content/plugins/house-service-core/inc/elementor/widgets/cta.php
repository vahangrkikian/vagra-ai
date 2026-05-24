<?php
namespace HouseService\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class CTA extends HS_Widget_Base {

    public function get_name()  { return 'hs_cta'; }
    public function get_title() { return __( 'HS Call to Action', 'house-service' ); }
    public function get_icon()  { return 'eicon-call-to-action'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'house-service' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Ready to find your pro?', 'house-service' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'house-service' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Browse verified providers, compare quotes, and book the right team for your home project — all in one place.', 'house-service' ),
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'Button Text', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Browse providers', 'house-service' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'Button URL', 'house-service' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : ( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) );
        ?>
        <section class="cta-strip">
            <div class="shell">
                <div class="cta-strip__card">
                    <h2 class="cta-strip__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <p class="cta-strip__desc"><?php echo esc_html( $s['description'] ); ?></p>
                    <a href="<?php echo esc_url( $url ); ?>" class="btn btn-white btn-lg">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                        <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'arrow', 18 ) : ''; ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
