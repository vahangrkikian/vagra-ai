<?php
namespace VagraLegal\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Attorneys extends Legal_Widget_Base {

    public function get_name()  { return 'vagra_legal_attorneys'; }
    public function get_title() { return __( 'Attorneys', 'vagra-legal' ); }
    public function get_icon()  { return 'eicon-person'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-legal' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Meet Our Attorneys', 'vagra-legal' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Our team of experienced attorneys is dedicated to providing exceptional legal representation.', 'vagra-legal' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'name', [
            'label'   => __( 'Name', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'role', [
            'label'   => __( 'Role', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'initials', [
            'label'   => __( 'Initials', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'specialty', [
            'label'   => __( 'Specialty', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
        ] );

        $this->add_control( 'attorneys', [
            'label'   => __( 'Attorneys', 'vagra-legal' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'name' => 'Robert Morrison', 'role' => 'Senior Partner', 'initials' => 'RM', 'specialty' => 'Personal Injury' ],
                [ 'name' => 'Sarah Chen', 'role' => 'Partner', 'initials' => 'SC', 'specialty' => 'Family Law' ],
                [ 'name' => 'James Okafor', 'role' => 'Senior Associate', 'initials' => 'JO', 'specialty' => 'Criminal Defense' ],
                [ 'name' => 'Elena Vasquez', 'role' => 'Associate', 'initials' => 'EV', 'specialty' => 'Immigration' ],
            ],
            'title_field' => '{{{ name }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="vagra-attorneys" id="team">
            <div class="vagra-container">
                <div class="vagra-section-header">
                    <h2 class="vagra-section-header__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <span class="vagra-section-header__accent"></span>
                    <p class="vagra-section-header__desc"><?php echo esc_html( $s['description'] ); ?></p>
                </div>
                <div class="vagra-attorneys__grid">
                    <?php foreach ( $s['attorneys'] as $att ) : ?>
                    <div class="vagra-card vagra-attorney-card">
                        <div class="vagra-attorney-card__photo">
                            <span class="vagra-attorney-card__initials"><?php echo esc_html( $att['initials'] ); ?></span>
                        </div>
                        <h3 class="vagra-attorney-card__name"><?php echo esc_html( $att['name'] ); ?></h3>
                        <p class="vagra-attorney-card__role"><?php echo esc_html( $att['role'] ); ?></p>
                        <span class="vagra-attorney-card__specialty"><?php echo esc_html( $att['specialty'] ); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
