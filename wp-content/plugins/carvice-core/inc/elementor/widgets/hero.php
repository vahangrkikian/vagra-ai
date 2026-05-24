<?php
namespace Carvice\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hero extends Carvice_Widget_Base {

    public function get_name()  { return 'carvice_hero'; }
    public function get_title() { return __( 'Carvice Hero', 'carvice' ); }
    public function get_icon()  { return 'eicon-header'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'carvice' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'carvice' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( "Don't know who to turn to?", 'carvice' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'carvice' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Describe your car problem and Carvice AI will find the right specialist for you.', 'carvice' ),
        ] );

        $this->add_control( 'search_placeholder', [
            'label'   => __( 'Search Placeholder', 'carvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Ask everything to Carvice AI', 'carvice' ),
        ] );

        $this->add_control( 'background_image', [
            'label'   => __( 'Background Image', 'carvice' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [
                'url' => 'https://images.unsplash.com/photo-1487754180451-c456f719a1fc?w=1440&h=500&fit=crop',
            ],
        ] );

        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'carvice' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'carvice' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .carvice-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'carvice' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .carvice-hero__title' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'carvice' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'carvice' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'carvice' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'carvice' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .carvice-hero' => 'text-align: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $bg  = ! empty( $s['background_image']['url'] ) ? $s['background_image']['url'] : '';
        ?>
        <section class="carvice-hero">
            <?php if ( $bg ) : ?>
            <img src="<?php echo esc_url( $bg ); ?>" alt="" class="carvice-hero__bg" />
            <?php endif; ?>
            <div class="carvice-container carvice-hero__content">
                <div class="carvice-hero__text">
                    <h1 class="carvice-hero__title"><?php echo esc_html( $s['title'] ); ?></h1>
                    <p class="carvice-hero__desc"><?php echo esc_html( $s['description'] ); ?></p>
                </div>
            </div>
        </section>
        <?php
    }
}
