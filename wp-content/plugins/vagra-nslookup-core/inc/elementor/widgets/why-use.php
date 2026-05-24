<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Why_Use extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_why_use';
    }

    public function get_title() {
        return __( 'Why Use', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-info-circle';
    }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Why this tool', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'The DNS tool you wanted the last time you were stuck at 2am.', 'vagra-nslookup' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'icon', [
            'label'       => __( 'Icon (emoji/HTML entity)', 'vagra-nslookup' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '&#9889;',
            'description' => __( 'Use an emoji or HTML entity like &#9889; or &#127758;', 'vagra-nslookup' ),
        ] );

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Feature title', 'vagra-nslookup' ),
        ] );

        $repeater->add_control( 'description', [
            'label'   => __( 'Description', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Feature description goes here.', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'items', [
            'label'       => __( 'Items', 'vagra-nslookup' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                    'icon'        => '&#9889;',
                    'title'       => __( 'Instant results', 'vagra-nslookup' ),
                    'description' => __( 'Parallel queries return in under 2 seconds. No waiting, no polling.', 'vagra-nslookup' ),
                ],
                [
                    'icon'        => '&#127758;',
                    'title'       => __( 'Global coverage', 'vagra-nslookup' ),
                    'description' => __( '30+ public DNS servers across 6 continents, updated continuously.', 'vagra-nslookup' ),
                ],
                [
                    'icon'        => '&#8734;',
                    'title'       => __( 'Free forever', 'vagra-nslookup' ),
                    'description' => __( 'Every record, every region, no paid tier, no account required.', 'vagra-nslookup' ),
                ],
                [
                    'icon'        => '&#9702;',
                    'title'       => __( 'No setup', 'vagra-nslookup' ),
                    'description' => __( 'Browser-only. Paste a domain, hit lookup, see the world answer.', 'vagra-nslookup' ),
                ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->add_control( 'background_color', [
            'label'   => __( 'Background color', 'vagra-nslookup' ),
            'type'    => Controls_Manager::COLOR,
            'default' => '#F7F8FC',
        ] );

        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Style', 'vagra-nslookup' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'bg_color', [
            'label'     => __( 'Background Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#F7F8FC',
            'selectors' => [ '{{WRAPPER}} .nsl-why' => 'background-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'icon_size', [
            'label'      => __( 'Icon Size', 'vagra-nslookup' ),
            'type'       => Controls_Manager::SLIDER,
            'range'      => [ 'px' => [ 'min' => 20, 'max' => 80 ] ],
            'default'    => [ 'size' => 36, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .nsl-why-icon' => 'font-size: {{SIZE}}{{UNIT}}' ],
        ] );

        $this->add_control( 'title_color', [
            'label'     => __( 'Title Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-why-item h3' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'desc_color', [
            'label'     => __( 'Description Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-why-item p' => 'color: {{VALUE}}' ],
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'vagra-nslookup' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .cine-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'vagra-nslookup' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .cine-big-head' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-nslookup' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-nslookup' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-nslookup' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-nslookup' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .cine-section' => 'text-align: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $bg = ! empty( $s['background_color'] ) ? $s['background_color'] : '#F7F8FC';
        ?>
        <section class="cine-section" style="background:<?php echo esc_attr( $bg ); ?>" data-reveal>
            <div class="cine-head-wrap">
                <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                    <span class="cine-section-eyebrow reveal"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $s['heading'] ) ) : ?>
                    <h2 class="cine-big-head reveal reveal-delay-1"><?php echo esc_html( $s['heading'] ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $s['items'] ) ) : ?>
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:32px;margin-top:72px">
                        <?php foreach ( $s['items'] as $i => $item ) : ?>
                            <div class="reveal" style="transition-delay:<?php echo esc_attr( $i * 60 ); ?>ms;padding-top:24px;border-top:1px solid rgba(11,13,20,0.1)">
                                <div style="font-size:28px"><?php echo wp_kses_post( $item['icon'] ); ?></div>
                                <h3 style="margin-top:16px;font-size:22px;font-weight:600;letter-spacing:-0.01em"><?php echo esc_html( $item['title'] ); ?></h3>
                                <p style="margin-top:10px;color:rgba(11,13,20,0.6);font-size:15px;line-height:1.6"><?php echo esc_html( $item['description'] ); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
