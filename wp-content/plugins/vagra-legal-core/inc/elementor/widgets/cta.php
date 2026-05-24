<?php
namespace VagraLegal\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class CTA extends Legal_Widget_Base {

    public function get_name()  { return 'vagra_legal_cta'; }
    public function get_title() { return __( 'Call to Action', 'vagra-legal' ); }
    public function get_icon()  { return 'eicon-call-to-action'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-legal' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Ready to Discuss Your Case?', 'vagra-legal' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Schedule a free, no-obligation consultation with one of our experienced attorneys today.', 'vagra-legal' ),
        ] );

        $this->add_control( 'phone', [
            'label'   => __( 'Phone Number', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
            'default' => '(555) 123-4567',
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'Button Text', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Schedule Consultation', 'vagra-legal' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'Button URL', 'vagra-legal' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/contact/' ],
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
            'selectors'  => [ '{{WRAPPER}} .vagra-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'vagra-legal' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-cta__title' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'desc_size', [
            'label'      => __( 'Description Font Size', 'vagra-legal' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 12, 'max' => 40 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-cta__desc' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-legal' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-legal' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-legal' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-legal' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .vagra-cta' => 'text-align: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'button_padding', [
            'label'      => __( 'Button Padding', 'vagra-legal' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .vagra-btn--primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '/contact/';
        ?>
        <section class="vagra-cta" id="contact">
            <div class="vagra-container">
                <div class="vagra-cta__inner">
                    <h2 class="vagra-cta__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <p class="vagra-cta__desc"><?php echo esc_html( $s['description'] ); ?></p>
                    <?php if ( ! empty( $s['phone'] ) ) : ?>
                    <p class="vagra-cta__phone">
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $s['phone'] ) ); ?>">
                            <?php echo esc_html( $s['phone'] ); ?>
                        </a>
                    </p>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( $url ); ?>" class="vagra-btn vagra-btn--primary">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
