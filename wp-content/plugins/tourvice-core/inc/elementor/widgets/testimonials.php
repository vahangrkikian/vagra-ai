<?php
namespace TourVice\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Testimonials extends TourVice_Widget_Base {

    public function get_name()  { return 'tourvice_testimonials'; }
    public function get_title() { return __( 'Testimonials', 'tourvice' ); }
    public function get_icon()  { return 'eicon-testimonial'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'tourvice' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'tourvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'What Our Travelers Say', 'tourvice' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'quote', [
            'label' => __( 'Quote', 'tourvice' ),
            'type'  => Controls_Manager::TEXTAREA,
        ] );

        $repeater->add_control( 'name', [
            'label' => __( 'Name', 'tourvice' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'role', [
            'label' => __( 'Role / Location', 'tourvice' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'avatar', [
            'label' => __( 'Avatar', 'tourvice' ),
            'type'  => Controls_Manager::MEDIA,
        ] );

        $repeater->add_control( 'stars', [
            'label'   => __( 'Stars', 'tourvice' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 5,
            'min'     => 1,
            'max'     => 5,
        ] );

        $this->add_control( 'testimonials', [
            'label'   => __( 'Testimonials', 'tourvice' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'quote' => 'An unforgettable journey through Armenia. The guides were incredibly knowledgeable and every detail was perfectly planned.', 'name' => 'Sarah M.', 'role' => 'New York, USA', 'stars' => 5 ],
                [ 'quote' => 'The luxury accommodations exceeded our expectations. From Yerevan to Lake Sevan, every moment was magical.', 'name' => 'James L.', 'role' => 'London, UK', 'stars' => 5 ],
                [ 'quote' => 'TourVice made our honeymoon in Armenia absolutely perfect. The personalized itinerary was exactly what we wanted.', 'name' => 'Elena & Marco', 'role' => 'Milan, Italy', 'stars' => 5 ],
            ],
            'title_field' => '{{{ name }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="tourvice-testimonials" id="testimonials">
            <div class="container">
                <div class="tourvice-section-header">
                    <h2 class="tourvice-section-header__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                </div>
                <div class="tourvice-testimonials__grid">
                    <?php foreach ( $s['testimonials'] as $t ) : ?>
                    <div class="tourvice-testimonial-card">
                        <div class="tourvice-testimonial-card__stars">
                            <?php echo str_repeat( '&#9733;', (int) $t['stars'] ); ?>
                        </div>
                        <blockquote class="tourvice-testimonial-card__quote">&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</blockquote>
                        <div class="tourvice-testimonial-card__author">
                            <?php if ( ! empty( $t['avatar']['url'] ) ) : ?>
                            <img class="tourvice-testimonial-card__avatar" src="<?php echo esc_url( $t['avatar']['url'] ); ?>" alt="<?php echo esc_attr( $t['name'] ); ?>" width="48" height="48" />
                            <?php endif; ?>
                            <div>
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
