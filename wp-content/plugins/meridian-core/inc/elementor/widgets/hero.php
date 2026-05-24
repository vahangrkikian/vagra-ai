<?php
namespace Meridian\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hero extends Meridian_Widget_Base {

    public function get_name()  { return 'meridian_hero'; }
    public function get_title() { return __( 'Meridian Hero', 'meridian' ); }
    public function get_icon()  { return 'eicon-header'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'meridian' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Midtown Manhattan · Est. 1928', 'meridian' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'meridian' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Where comfort meets the city.', 'meridian' ),
        ] );

        $this->add_control( 'subtitle', [
            'label'   => __( 'Subtitle', 'meridian' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'A 5-star urban retreat above the streets of Midtown — quiet rooms, considered service, and a view that has not gotten old in ninety-eight years.', 'meridian' ),
        ] );

        $this->add_control( 'bg_image', [
            'label' => __( 'Background Image', 'meridian' ),
            'type'  => Controls_Manager::MEDIA,
        ] );

        $this->add_control( 'show_booking', [
            'label'        => __( 'Show Booking Widget', 'meridian' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'meridian' ),
            'label_off'    => __( 'No', 'meridian' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $bg_style = '';
        if ( ! empty( $s['bg_image']['url'] ) ) {
            $bg_style = 'style="background-image:url(' . esc_url( $s['bg_image']['url'] ) . ');background-size:cover;background-position:center;"';
        }
        ?>
        <section class="hero" <?php echo $bg_style; ?>>
            <?php if ( empty( $s['bg_image']['url'] ) ) : ?>
            <div class="hero__bg">
                <svg class="ph-skyline" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                    <defs>
                        <linearGradient id="sky" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0" stop-color="#0b1530"/><stop offset="0.25" stop-color="#1a365d"/><stop offset="0.5" stop-color="#3d2a52"/><stop offset="0.75" stop-color="#9a5c3f"/><stop offset="1" stop-color="#d4af37"/>
                        </linearGradient>
                    </defs>
                    <rect width="1600" height="900" fill="url(#sky)"/>
                </svg>
                <div class="hero__overlay"></div>
            </div>
            <?php endif; ?>
            <div class="hero__content">
                <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                <div class="hero__eyebrow"><span></span><?php echo esc_html( $s['eyebrow'] ); ?></div>
                <?php endif; ?>
                <h1 class="hero__title"><?php echo esc_html( $s['title'] ); ?></h1>
                <p class="hero__sub"><?php echo esc_html( $s['subtitle'] ); ?></p>
            </div>
            <?php if ( 'yes' === $s['show_booking'] && function_exists( 'get_template_part' ) ) : ?>
            <div class="hero__booking">
                <?php get_template_part( 'template-parts/booking-widget' ); ?>
            </div>
            <?php endif; ?>
        </section>
        <?php
    }
}
