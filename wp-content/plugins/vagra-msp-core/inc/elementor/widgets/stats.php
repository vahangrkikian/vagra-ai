<?php
namespace VagraMSP\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Stats extends MSP_Widget_Base {

    public function get_name()  { return 'vagra_msp_stats'; }
    public function get_title() { return __( 'MSP Stats Bar', 'vagra-msp' ); }
    public function get_icon()  { return 'eicon-counter'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-msp' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'value', [
            'label' => __( 'Value', 'vagra-msp' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'label', [
            'label' => __( 'Label', 'vagra-msp' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $this->add_control( 'stats', [
            'label'   => __( 'Stats', 'vagra-msp' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'value' => '200+', 'label' => 'Clients Protected' ],
                [ 'value' => '99.9%', 'label' => 'Uptime Guarantee' ],
                [ 'value' => '24/7', 'label' => 'Security Monitoring' ],
                [ 'value' => '<15min', 'label' => 'Avg. Response Time' ],
            ],
            'title_field' => '{{{ label }}}',
        ] );

        $this->end_controls_section();

        /* ── Style ─────────────────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'vagra-msp' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'vagra-msp' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .vagra-social-proof' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'vagra-msp' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-stat__number' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-msp' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-msp' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-msp' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-msp' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .vagra-social-proof' => 'text-align: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'vagra-msp' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '4',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [ '{{WRAPPER}} .vagra-social-proof__stats' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'vagra-msp' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-social-proof__stats' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="vagra-social-proof">
            <div class="vagra-container">
                <div class="vagra-social-proof__stats">
                    <?php foreach ( $s['stats'] as $stat ) : ?>
                    <div class="vagra-stat">
                        <span class="vagra-stat__number"><?php echo esc_html( $stat['value'] ); ?></span>
                        <span class="vagra-stat__label"><?php echo esc_html( $stat['label'] ); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
