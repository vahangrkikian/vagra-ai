<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Sister_Tools extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_sister_tools';
    }

    public function get_title() {
        return __( 'Sister Tools', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-apps';
    }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'More tools', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Related DNS checks', 'vagra-nslookup' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'SPF Checker', 'vagra-nslookup' ),
        ] );

        $repeater->add_control( 'description', [
            'label'   => __( 'Description', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Validate your SPF records and check for common issues.', 'vagra-nslookup' ),
        ] );

        $repeater->add_control( 'url', [
            'label' => __( 'URL', 'vagra-nslookup' ),
            'type'  => Controls_Manager::URL,
        ] );

        $this->add_control( 'tools', [
            'label'       => __( 'Tools', 'vagra-nslookup' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                    'title'       => __( 'SPF Checker', 'vagra-nslookup' ),
                    'description' => __( 'Validate your SPF records and check for common misconfigurations.', 'vagra-nslookup' ),
                    'url'         => [ 'url' => '/tools/spf-checker/' ],
                ],
                [
                    'title'       => __( 'DKIM Checker', 'vagra-nslookup' ),
                    'description' => __( 'Verify DKIM selectors and check key alignment for email auth.', 'vagra-nslookup' ),
                    'url'         => [ 'url' => '/tools/dkim-checker/' ],
                ],
                [
                    'title'       => __( 'DMARC Checker', 'vagra-nslookup' ),
                    'description' => __( 'Parse and validate DMARC policies for your domain.', 'vagra-nslookup' ),
                    'url'         => [ 'url' => '/tools/dmarc-checker/' ],
                ],
                [
                    'title'       => __( 'BIMI Checker', 'vagra-nslookup' ),
                    'description' => __( 'Check BIMI records and verify brand logo display in email clients.', 'vagra-nslookup' ),
                    'url'         => [ 'url' => '/tools/bimi-checker/' ],
                ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Style', 'vagra-nslookup' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_bg', [
            'label'     => __( 'Card Background', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .nsl-related-card' => 'background-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'card_border', [
            'label'     => __( 'Card Border Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-related-card' => 'border-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'title_color', [
            'label'     => __( 'Title Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-related-card h3' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'desc_color', [
            'label'     => __( 'Description Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-related-card p' => 'color: {{VALUE}}' ],
        ] );

        $this->end_controls_section();

        /* ── Responsive ── */
        $this->start_controls_section( 'section_responsive', [
            'label' => __( 'Responsive', 'vagra-nslookup' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'vagra-nslookup' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'vagra-nslookup' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} h2' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-nslookup' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-nslookup' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-nslookup' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-nslookup' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .section' => 'text-align: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'grid_columns', [
            'label'   => __( 'Columns', 'vagra-nslookup' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '4',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [ '{{WRAPPER}} .nsl-related' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'vagra-nslookup' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [ '{{WRAPPER}} .nsl-related' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section" data-reveal>
            <div class="container">
                <div class="nsl-section-head">
                    <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                        <span class="eyebrow reveal"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $s['heading'] ) ) : ?>
                        <h2 class="reveal reveal-delay-1"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <?php endif; ?>
                </div>

                <?php if ( ! empty( $s['tools'] ) ) : ?>
                    <div class="nsl-related">
                        <?php foreach ( $s['tools'] as $i => $tool ) :
                            $has_url = ! empty( $tool['url']['url'] );
                            $tag     = $has_url ? 'a' : 'div';
                            $href    = $has_url ? ' href="' . esc_url( $tool['url']['url'] ) . '"' : '';
                        ?>
                            <<?php echo $tag; ?> class="nsl-related-card reveal" style="transition-delay:<?php echo esc_attr( $i * 60 ); ?>ms"<?php echo $href; ?>>
                                <span class="nsl-related-tag"><?php echo esc_html( $tool['title'] ); ?></span>
                                <h3><?php echo esc_html( $tool['title'] ); ?></h3>
                                <p><?php echo esc_html( $tool['description'] ); ?></p>
                                <?php if ( $has_url ) : ?>
                                    <span class="nsl-related-arrow">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M3 8h10m-4-4l4 4-4 4"/></svg>
                                    </span>
                                <?php endif; ?>
                            </<?php echo $tag; ?>>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
