<?php
namespace VagraLegal\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Stats extends Legal_Widget_Base {

    public function get_name()  { return 'vagra_legal_stats'; }
    public function get_title() { return __( 'Stats Bar', 'vagra-legal' ); }
    public function get_icon()  { return 'eicon-counter'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-legal' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'value', [
            'label' => __( 'Value', 'vagra-legal' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'label', [
            'label' => __( 'Label', 'vagra-legal' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $this->add_control( 'stats', [
            'label'   => __( 'Stats', 'vagra-legal' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'value' => '500+', 'label' => 'Cases Won' ],
                [ 'value' => '25+', 'label' => 'Years Experience' ],
                [ 'value' => '98%', 'label' => 'Client Satisfaction' ],
                [ 'value' => '$50M+', 'label' => 'Recovered' ],
            ],
            'title_field' => '{{{ label }}}',
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
            'selectors'  => [ '{{WRAPPER}} .vagra-stats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Value Font Size', 'vagra-legal' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-stat__value' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-legal' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-legal' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-legal' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-legal' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .vagra-stats' => 'text-align: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'vagra-legal' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '4',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [ '{{WRAPPER}} .vagra-stats__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'vagra-legal' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-stats__grid' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="vagra-stats">
            <div class="vagra-container">
                <div class="vagra-stats__grid">
                    <?php foreach ( $s['stats'] as $stat ) : ?>
                    <div class="vagra-stat">
                        <div class="vagra-stat__value"><?php echo esc_html( $stat['value'] ); ?></div>
                        <div class="vagra-stat__label"><?php echo esc_html( $stat['label'] ); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
