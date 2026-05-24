<?php
namespace Meridian\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Testimonials extends Meridian_Widget_Base {

    public function get_name()  { return 'meridian_testimonials'; }
    public function get_title() { return __( 'Meridian Testimonials', 'meridian' ); }
    public function get_icon()  { return 'eicon-testimonial'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'meridian' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Guests', 'meridian' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'What people say.', 'meridian' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'quote', [
            'label' => __( 'Quote', 'meridian' ),
            'type'  => Controls_Manager::TEXTAREA,
        ] );

        $repeater->add_control( 'name', [
            'label' => __( 'Guest Name', 'meridian' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'role', [
            'label' => __( 'Role / Origin', 'meridian' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'rating', [
            'label'   => __( 'Rating', 'meridian' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 5,
            'min'     => 1,
            'max'     => 5,
        ] );

        $this->add_control( 'testimonials', [
            'label'   => __( 'Testimonials', 'meridian' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'quote' => 'The Meridian is the only hotel in Manhattan that gets the small things right. Quiet rooms, real coffee, and a front desk that remembers your name on the second visit.', 'name' => 'Eleanor Whitfield', 'role' => 'Returning guest, London', 'rating' => 5 ],
                [ 'quote' => 'Booked the Executive Studio for a four-night sprint. The desk is real, the chair is real, and the wifi is faster than my office. I extended by two days.', 'name' => 'Marcus Tan', 'role' => 'Business traveler, Singapore', 'rating' => 5 ],
                [ 'quote' => "We travel with three kids under ten. The Family Suite was the first hotel room that didn't feel like a compromise. The kids had their own door. We had ours.", 'name' => 'The Alvarez Family', 'role' => 'Family suite guests, Madrid', 'rating' => 5 ],
            ],
            'title_field' => '{{{ name }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section section--cream">
            <div class="container">
                <div class="section__head section__head--centered" data-reveal>
                    <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                    <div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div>
                    <?php endif; ?>
                    <h2 class="display"><?php echo esc_html( $s['heading'] ); ?></h2>
                </div>
                <div class="testimonials">
                    <?php foreach ( $s['testimonials'] as $i => $t ) :
                        $initials = implode( '', array_map( function( $w ) { return mb_substr( $w, 0, 1 ); }, array_slice( explode( ' ', $t['name'] ), 0, 2 ) ) );
                    ?>
                    <figure class="t-card" data-reveal style="--d: <?php echo $i * 100; ?>ms">
                        <div class="t-card__rating">
                            <?php
                            $stars = isset( $t['rating'] ) ? (int) $t['rating'] : 5;
                            for ( $star = 0; $star < $stars; $star++ ) :
                                if ( function_exists( 'meridian_icon' ) ) echo meridian_icon( 'star', 14 );
                                else echo '&#9733;';
                            endfor;
                            ?>
                        </div>
                        <blockquote class="t-card__quote"><?php echo esc_html( $t['quote'] ); ?></blockquote>
                        <figcaption class="t-card__who">
                            <div class="t-card__avatar" aria-hidden="true"><?php echo esc_html( $initials ); ?></div>
                            <div>
                                <div class="t-card__name"><?php echo esc_html( $t['name'] ); ?></div>
                                <div class="t-card__role"><?php echo esc_html( $t['role'] ); ?></div>
                            </div>
                        </figcaption>
                    </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
