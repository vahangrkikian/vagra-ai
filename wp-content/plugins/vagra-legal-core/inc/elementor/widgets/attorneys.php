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

        /* ── Style ─────────────────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'vagra-legal' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'vagra-legal' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .vagra-attorneys' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'vagra-legal' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-section-header__title' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-legal' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-legal' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-legal' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-legal' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .vagra-attorneys' => 'text-align: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'vagra-legal' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '4',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [ '{{WRAPPER}} .vagra-attorneys__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'vagra-legal' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-attorneys__grid' => 'gap: {{SIZE}}{{UNIT}};' ],
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
