<?php
namespace DriveEase\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Testimonials extends DriveEase_Widget_Base {

    public function get_name()  { return 'driveease_testimonials'; }
    public function get_title() { return __( 'Testimonials', 'driveease' ); }
    public function get_icon()  { return 'eicon-testimonial'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'driveease' ),
        ] );

        $this->add_control( 'label', [
            'label'   => __( 'Section Label', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Customer Reviews', 'driveease' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'What Our Customers Say', 'driveease' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'quote', [
            'label' => __( 'Quote', 'driveease' ),
            'type'  => Controls_Manager::TEXTAREA,
        ] );

        $repeater->add_control( 'name', [
            'label' => __( 'Name', 'driveease' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'role', [
            'label' => __( 'Role / Title', 'driveease' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'stars', [
            'label'   => __( 'Stars', 'driveease' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 5,
            'min'     => 1,
            'max'     => 5,
        ] );

        $this->add_control( 'testimonials', [
            'label'   => __( 'Testimonials', 'driveease' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'quote' => 'Booking was seamless and the car was in perfect condition. Pick-up at the airport branch took less than five minutes. Will definitely use again on my next trip.', 'name' => 'A. Johnson', 'role' => 'Business Traveller', 'stars' => 5 ],
                [ 'quote' => 'We rented an SUV for a family road trip. Spacious, clean, and the GPS saved us countless times. The free cancellation policy gave us peace of mind.', 'name' => 'M. Fernandez', 'role' => 'Family Traveller', 'stars' => 5 ],
                [ 'quote' => 'Great selection of vehicles and very transparent pricing. The 24/7 support team helped me sort out a minor issue within minutes. Highly recommend.', 'name' => 'S. Nakamura', 'role' => 'Frequent Renter', 'stars' => 4 ],
            ],
            'title_field' => '{{{ name }}}',
        ] );

        $this->end_controls_section();

        /* ── Style Tab ─────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'driveease' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'driveease' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
                '{{WRAPPER}} #testimonials' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'driveease' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .section-title' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'driveease' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'driveease' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'driveease' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'driveease' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [
                '{{WRAPPER}} #testimonials' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'driveease' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [
                '{{WRAPPER}} .test-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'driveease' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [
                '{{WRAPPER}} .test-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section id="testimonials">
            <div class="container">
                <div class="test-header">
                    <div class="section-label"><?php echo esc_html( $s['label'] ); ?></div>
                    <h2 class="section-title"><?php echo esc_html( $s['heading'] ); ?></h2>
                </div>
                <div class="test-grid">
                    <?php foreach ( $s['testimonials'] as $t ) :
                        $initials = '';
                        $parts = explode( ' ', trim( $t['name'] ) );
                        foreach ( $parts as $part ) {
                            $initials .= mb_strtoupper( mb_substr( $part, 0, 1 ) );
                        }
                        $full_stars  = (int) $t['stars'];
                        $empty_stars = 5 - $full_stars;
                        ?>
                    <div class="test-card">
                        <div class="stars"><?php echo str_repeat( '&#9733;', $full_stars ) . str_repeat( '&#9734;', $empty_stars ); ?></div>
                        <blockquote>&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</blockquote>
                        <div class="reviewer">
                            <span class="avatar avatar--initials" aria-hidden="true"><?php echo esc_html( $initials ); ?></span>
                            <div class="reviewer-info">
                                <strong><?php echo esc_html( $t['name'] ); ?></strong>
                                <span><?php echo esc_html( $t['role'] ); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
