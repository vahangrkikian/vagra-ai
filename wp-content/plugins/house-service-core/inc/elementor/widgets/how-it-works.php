<?php
namespace HouseService\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class How_It_Works extends HS_Widget_Base {

    public function get_name()  { return 'hs_how_it_works'; }
    public function get_title() { return __( 'HS How It Works', 'house-service' ); }
    public function get_icon()  { return 'eicon-number-field'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'house-service' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Simple process', 'house-service' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'How it works', 'house-service' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'house-service' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Get matched with the right pro in three easy steps.', 'house-service' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'step_number', [
            'label'   => __( 'Step Number', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => '1',
        ] );

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Step', 'house-service' ),
        ] );

        $repeater->add_control( 'desc', [
            'label'   => __( 'Description', 'house-service' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => '',
        ] );

        $this->add_control( 'steps', [
            'label'   => __( 'Steps', 'house-service' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'step_number' => '1', 'title' => 'Describe your project', 'desc' => 'Tell us what you need — cleaning, moving, repair, or assembly — and your location.' ],
                [ 'step_number' => '2', 'title' => 'Compare providers', 'desc' => 'Browse verified pros, read real reviews, and compare quotes side by side.' ],
                [ 'step_number' => '3', 'title' => 'Book & relax', 'desc' => 'Pick the best match, confirm the schedule, and let the pros handle the rest.' ],
            ],
            'title_field' => 'Step {{{ step_number }}}: {{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section section--alt" id="how-it-works">
            <div class="shell">
                <div class="section__head">
                    <div>
                        <div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div>
                        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
                        <p class="lead"><?php echo esc_html( $s['description'] ); ?></p>
                    </div>
                </div>

                <div class="steps-grid">
                    <?php foreach ( $s['steps'] as $step ) : ?>
                    <div class="step-card">
                        <div class="step-card__number"><?php echo esc_html( $step['step_number'] ); ?></div>
                        <h3 class="step-card__title"><?php echo esc_html( $step['title'] ); ?></h3>
                        <p class="step-card__desc"><?php echo esc_html( $step['desc'] ); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
