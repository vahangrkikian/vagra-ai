<?php
namespace TourVice\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class CTA extends TourVice_Widget_Base {

    public function get_name()  { return 'tourvice_cta'; }
    public function get_title() { return __( 'Call to Action', 'tourvice' ); }
    public function get_icon()  { return 'eicon-call-to-action'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'tourvice' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'tourvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Ready for Your Armenian Adventure?', 'tourvice' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'tourvice' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Book your luxury tour today and experience the magic of Armenia with expert local guides.', 'tourvice' ),
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'Button Text', 'tourvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Book Your Tour', 'tourvice' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'Button URL', 'tourvice' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/contact/' ],
        ] );

        $this->end_controls_section();

        /* ── Style Tab ─────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'tourvice' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'tourvice' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .tourvice-cta__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'tourvice' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .tourvice-cta__title' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'tourvice' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'tourvice' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'tourvice' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'tourvice' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [
                '{{WRAPPER}} .tourvice-cta__inner' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '/contact/';
        ?>
        <section class="tourvice-cta" id="book">
            <div class="container">
                <div class="tourvice-cta__inner">
                    <h2 class="tourvice-cta__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <p class="tourvice-cta__desc"><?php echo esc_html( $s['description'] ); ?></p>
                    <a href="<?php echo esc_url( $url ); ?>" class="tourvice-btn tourvice-btn--primary">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
