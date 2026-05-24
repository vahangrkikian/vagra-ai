<?php
namespace Meridian\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Amenities extends Meridian_Widget_Base {

    public function get_name()  { return 'meridian_amenities'; }
    public function get_title() { return __( 'Meridian Amenities', 'meridian' ); }
    public function get_icon()  { return 'eicon-info-box'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'meridian' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'The essentials', 'meridian' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'What you can expect, every time.', 'meridian' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'meridian' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'No upsells. No surprises. Everything below is included with every reservation, in every room.', 'meridian' ),
        ] );

        $this->add_control( 'dark_section', [
            'label'        => __( 'Dark Background', 'meridian' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'meridian' ),
            'label_off'    => __( 'No', 'meridian' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'icon_name', [
            'label'   => __( 'Icon', 'meridian' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'pin'  => __( 'Location Pin', 'meridian' ),
                'bell' => __( 'Concierge Bell', 'meridian' ),
                'bed'  => __( 'Bed', 'meridian' ),
                'wifi' => __( 'Wi-Fi', 'meridian' ),
                'pool' => __( 'Pool', 'meridian' ),
                'spa'  => __( 'Spa', 'meridian' ),
                'star' => __( 'Star', 'meridian' ),
            ],
            'default' => 'bell',
        ] );

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Amenity', 'meridian' ),
        ] );

        $repeater->add_control( 'desc', [
            'label'   => __( 'Description', 'meridian' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => '',
        ] );

        $this->add_control( 'amenities', [
            'label'   => __( 'Amenities', 'meridian' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'icon_name' => 'pin',  'title' => 'Prime Midtown Location', 'desc' => 'Two blocks from Bryant Park, six from Times Square, a short walk to Central Park.' ],
                [ 'icon_name' => 'bell', 'title' => '24/7 Concierge',         'desc' => 'Reservations, theater, transportation — handled before you think to ask.' ],
                [ 'icon_name' => 'bed',  'title' => 'Egyptian Cotton Linens',  'desc' => '600-thread-count sheets, down pillows, and a curated pillow menu in every room.' ],
                [ 'icon_name' => 'wifi', 'title' => '1 Gbps Wi-Fi',           'desc' => 'Symmetric fiber across the property — fast enough for the largest team call.' ],
                [ 'icon_name' => 'pool', 'title' => 'Rooftop Lounge & Pool',  'desc' => 'A heated infinity pool, a quiet bar, and the best view of the skyline at sunset.' ],
                [ 'icon_name' => 'spa',  'title' => 'Spa & Fitness',           'desc' => 'A full Technogym floor, two studios, and a six-treatment spa one level below.' ],
            ],
            'title_field' => '{{{ title }}}',
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
                '{{WRAPPER}} .section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                '{{WRAPPER}} .section' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'meridian' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [
                '{{WRAPPER}} .amenities' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'meridian' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [
                '{{WRAPPER}} .amenities' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $dark = 'yes' === $s['dark_section'];
        $section_class = $dark ? 'section section--dark' : 'section';
        $eyebrow_class = $dark ? 'eyebrow eyebrow--light' : 'eyebrow';
        $display_class = $dark ? 'display display--light' : 'display';
        ?>
        <section class="<?php echo esc_attr( $section_class ); ?>">
            <div class="container">
                <div class="section__head" data-reveal>
                    <div>
                        <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                        <div class="<?php echo esc_attr( $eyebrow_class ); ?>"><?php echo esc_html( $s['eyebrow'] ); ?></div>
                        <?php endif; ?>
                        <h2 class="<?php echo esc_attr( $display_class ); ?>"><?php echo esc_html( $s['heading'] ); ?></h2>
                    </div>
                    <?php if ( ! empty( $s['description'] ) ) : ?>
                    <p class="section__lede"><?php echo esc_html( $s['description'] ); ?></p>
                    <?php endif; ?>
                </div>
                <div class="amenities">
                    <?php foreach ( $s['amenities'] as $i => $a ) : ?>
                    <div class="amenity" data-reveal style="--d: <?php echo $i * 60; ?>ms">
                        <div class="amenity__icon">
                            <?php if ( function_exists( 'meridian_icon' ) ) echo meridian_icon( $a['icon_name'], 26, 1.4 ); ?>
                        </div>
                        <h3 class="amenity__title"><?php echo esc_html( $a['title'] ); ?></h3>
                        <p class="amenity__body"><?php echo esc_html( $a['desc'] ); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
