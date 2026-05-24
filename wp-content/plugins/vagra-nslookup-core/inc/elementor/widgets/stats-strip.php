<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Stats_Strip extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_stats_strip';
    }

    public function get_title() {
        return __( 'Stats Strip', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-counter';
    }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'value', [
            'label'   => __( 'Value', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => '30+',
        ] );

        $repeater->add_control( 'label', [
            'label'   => __( 'Label', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Resolvers', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'stats', [
            'label'       => __( 'Stats', 'vagra-nslookup' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'value' => '30+',  'label' => __( 'Global resolvers', 'vagra-nslookup' ) ],
                [ 'value' => '13',   'label' => __( 'Record types', 'vagra-nslookup' ) ],
                [ 'value' => '<2s',  'label' => __( 'Average query time', 'vagra-nslookup' ) ],
                [ 'value' => '100%', 'label' => __( 'Free, no signup', 'vagra-nslookup' ) ],
            ],
            'title_field' => '{{{ value }}} — {{{ label }}}',
        ] );

        $this->add_control( 'animate_counters', [
            'label'        => __( 'Animate counters', 'vagra-nslookup' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => __( 'Yes', 'vagra-nslookup' ),
            'label_off'    => __( 'No', 'vagra-nslookup' ),
            'return_value' => 'yes',
        ] );

        $this->add_control( 'background', [
            'label'   => __( 'Background', 'vagra-nslookup' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'dark',
            'options' => [
                'dark'     => __( 'Dark', 'vagra-nslookup' ),
                'light'    => __( 'Light', 'vagra-nslookup' ),
                'gradient' => __( 'Gradient', 'vagra-nslookup' ),
            ],
        ] );

        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Style', 'vagra-nslookup' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'number_color', [
            'label'     => __( 'Number Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cine-stat-num' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'label_color', [
            'label'     => __( 'Label Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.55)',
            'selectors' => [ '{{WRAPPER}} .cine-stat-lbl' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'divider_color', [
            'label'     => __( 'Divider Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.1)',
            'selectors' => [ '{{WRAPPER}} .cine-stat' => 'border-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'strip_bg', [
            'label'     => __( 'Background Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .cine-stats' => 'background-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'strip_padding', [
            'label'      => __( 'Padding', 'vagra-nslookup' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [ '{{WRAPPER}} .cine-stats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $section_class = 'cine-section';
        if ( 'dark' === $s['background'] ) {
            $section_class .= ' cine-section-dark';
        } elseif ( 'gradient' === $s['background'] ) {
            $section_class .= ' cine-section-mid';
        }
        ?>
        <div class="<?php echo esc_attr( $section_class ); ?>" data-reveal>
            <div class="cine-head-wrap">
                <?php if ( ! empty( $s['stats'] ) ) : ?>
                    <div class="cine-stats reveal">
                        <?php foreach ( $s['stats'] as $stat ) :
                            $data_target = ( 'yes' === $s['animate_counters'] ) ? ' data-target="' . esc_attr( $stat['value'] ) . '"' : '';
                        ?>
                            <div class="cine-stat">
                                <div class="cine-stat-num"<?php echo $data_target; ?>><?php echo esc_html( $stat['value'] ); ?></div>
                                <div class="cine-stat-lbl"><?php echo esc_html( $stat['label'] ); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
