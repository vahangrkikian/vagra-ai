<?php
namespace VagraLegal\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hero extends Legal_Widget_Base {

    public function get_name()  { return 'vagra_legal_hero'; }
    public function get_title() { return __( 'Legal Hero', 'vagra-legal' ); }
    public function get_icon()  { return 'eicon-header'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-legal' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Experienced Legal Counsel You Can Trust', 'vagra-legal' ),
        ] );

        $this->add_control( 'subtitle', [
            'label'   => __( 'Subtitle', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Dedicated attorneys fighting for your rights. From personal injury to business law, we provide the skilled representation you deserve.', 'vagra-legal' ),
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'CTA Text', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Schedule a Free Consultation', 'vagra-legal' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'CTA URL', 'vagra-legal' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#contact' ],
        ] );

        $this->end_controls_section();

        /* ── Style ─────────────────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'vagra-legal' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'vagra-legal' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .vagra-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'vagra-legal' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-hero__title' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-legal' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-legal' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-legal' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-legal' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .vagra-hero' => 'text-align: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '#contact';
        ?>
        <section class="vagra-hero">
            <div class="vagra-container">
                <div class="vagra-hero__content">
                    <h1 class="vagra-hero__title"><?php echo esc_html( $s['title'] ); ?></h1>
                    <p class="vagra-hero__subtitle"><?php echo esc_html( $s['subtitle'] ); ?></p>
                    <a href="<?php echo esc_url( $url ); ?>" class="vagra-btn vagra-hero__cta">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
