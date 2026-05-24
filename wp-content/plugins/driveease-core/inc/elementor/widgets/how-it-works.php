<?php
namespace DriveEase\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class How_It_Works extends DriveEase_Widget_Base {

    public function get_name()  { return 'driveease_how_it_works'; }
    public function get_title() { return __( 'How It Works', 'driveease' ); }
    public function get_icon()  { return 'eicon-number-field'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'driveease' ),
        ] );

        $this->add_control( 'label', [
            'label'   => __( 'Section Label', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Simple Process', 'driveease' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'On the Road in 3 Steps', 'driveease' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'icon', [
            'label'   => __( 'FontAwesome Icon Class', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => 'fa-solid fa-star',
        ] );

        $repeater->add_control( 'title', [
            'label' => __( 'Title', 'driveease' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'description', [
            'label' => __( 'Description', 'driveease' ),
            'type'  => Controls_Manager::TEXTAREA,
        ] );

        $this->add_control( 'steps', [
            'label'   => __( 'Steps', 'driveease' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'icon' => 'fa-solid fa-magnifying-glass', 'title' => 'Search', 'description' => 'Enter your pick-up location, dates, and preferred vehicle class to browse availability.' ],
                [ 'icon' => 'fa-regular fa-credit-card', 'title' => 'Book', 'description' => 'Select your car, add any extras, and confirm your booking in under two minutes.' ],
                [ 'icon' => 'fa-solid fa-car-side', 'title' => 'Drive', 'description' => "Pick up the keys at your chosen branch and hit the road — it's that simple." ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section id="how">
            <div class="container">
                <div class="how-header">
                    <div class="section-label"><?php echo esc_html( $s['label'] ); ?></div>
                    <h2 class="section-title"><?php echo esc_html( $s['heading'] ); ?></h2>
                </div>
                <div class="steps">
                    <?php foreach ( $s['steps'] as $step ) : ?>
                    <div class="step">
                        <div class="step-num"><i class="<?php echo esc_attr( $step['icon'] ); ?>"></i></div>
                        <h3><?php echo esc_html( $step['title'] ); ?></h3>
                        <p><?php echo esc_html( $step['description'] ); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
