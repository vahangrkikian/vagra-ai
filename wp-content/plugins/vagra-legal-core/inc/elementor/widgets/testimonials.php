<?php
namespace VagraLegal\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Testimonials extends Legal_Widget_Base {

    public function get_name()  { return 'vagra_legal_testimonials'; }
    public function get_title() { return __( 'Testimonials', 'vagra-legal' ); }
    public function get_icon()  { return 'eicon-testimonial'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-legal' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'What Our Clients Say', 'vagra-legal' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'quote', [
            'label' => __( 'Quote', 'vagra-legal' ),
            'type'  => Controls_Manager::TEXTAREA,
        ] );

        $repeater->add_control( 'name', [
            'label' => __( 'Client Name', 'vagra-legal' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'case_type', [
            'label' => __( 'Case Type', 'vagra-legal' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'stars', [
            'label'   => __( 'Stars', 'vagra-legal' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 5,
            'min'     => 1,
            'max'     => 5,
        ] );

        $this->add_control( 'testimonials', [
            'label'   => __( 'Testimonials', 'vagra-legal' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'quote' => 'Morrison & Associates fought tirelessly for my case. They secured a settlement that covered all my medical bills and more.', 'name' => 'Michael R.', 'case_type' => 'Personal Injury', 'stars' => 5 ],
                [ 'quote' => 'Professional, compassionate, and effective. They guided us through a difficult custody case with genuine care.', 'name' => 'Jennifer T.', 'case_type' => 'Family Law', 'stars' => 5 ],
                [ 'quote' => 'Their business law team helped us structure our LLC perfectly. Clear advice, no unnecessary jargon.', 'name' => 'David K.', 'case_type' => 'Business Law', 'stars' => 5 ],
            ],
            'title_field' => '{{{ name }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="vagra-testimonials" id="testimonials">
            <div class="vagra-container">
                <div class="vagra-section-header">
                    <h2 class="vagra-section-header__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <span class="vagra-section-header__accent"></span>
                </div>
                <div class="vagra-testimonials__grid">
                    <?php foreach ( $s['testimonials'] as $t ) : ?>
                    <div class="vagra-card vagra-testimonial-card">
                        <div class="vagra-testimonial-card__stars">
                            <?php echo str_repeat( '&#9733;', (int) $t['stars'] ); ?>
                        </div>
                        <blockquote class="vagra-testimonial-card__quote">&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</blockquote>
                        <div class="vagra-testimonial-card__author">
                            <strong><?php echo esc_html( $t['name'] ); ?></strong>
                            <span><?php echo esc_html( $t['case_type'] ); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
