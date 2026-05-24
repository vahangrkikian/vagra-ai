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
