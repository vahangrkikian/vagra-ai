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
