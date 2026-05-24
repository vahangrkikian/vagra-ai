<?php
namespace Meridian\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class CTA extends Meridian_Widget_Base {

    public function get_name()  { return 'meridian_cta'; }
    public function get_title() { return __( 'Meridian CTA', 'meridian' ); }
    public function get_icon()  { return 'eicon-call-to-action'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'meridian' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Ready to book your stay?', 'meridian' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'meridian' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Whether it is one night or one week, every stay at The Meridian begins with a conversation. Reach out — we will take care of the rest.', 'meridian' ),
        ] );

        $this->add_control( 'phone', [
            'label'   => __( 'Phone Number', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => '+1 (212) 555-0199',
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'Button Text', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Book a Room', 'meridian' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'Button URL', 'meridian' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#booking' ],
        ] );

        $this->end_controls_section();

        /* ── Style tab ─────────────────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'meridian' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'meridian' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .section--dark' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'meridian' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .display' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'meridian' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'meridian' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'meridian' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'meridian' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [
                '{{WRAPPER}} .section--dark' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '#booking';
        ?>
        <section class="section section--dark" id="booking-cta">
            <div class="container">
                <div class="section__head section__head--centered" data-reveal>
                    <h2 class="display display--light"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <p class="section__lede" style="color:var(--cream-200,#e8e3d8);"><?php echo esc_html( $s['description'] ); ?></p>
                    <?php if ( ! empty( $s['phone'] ) ) : ?>
                    <p style="margin-top:1rem;">
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $s['phone'] ) ); ?>" style="color:var(--gold-soft,#d4af37);font-size:1.25rem;text-decoration:none;">
                            <?php echo esc_html( $s['phone'] ); ?>
                        </a>
                    </p>
                    <?php endif; ?>
                    <p style="margin-top:1.5rem;">
                        <a href="<?php echo esc_url( $url ); ?>" class="btn btn--gold">
                            <?php echo esc_html( $s['cta_text'] ); ?>
                        </a>
                    </p>
                </div>
            </div>
        </section>
        <?php
    }
}
