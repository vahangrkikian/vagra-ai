<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Feature_Grid extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_feature_grid';
    }

    public function get_title() {
        return __( 'Feature Grid', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Features', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Everything you need for DNS diagnostics', 'vagra-nslookup' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'icon_svg', [
            'label'       => __( 'Icon SVG', 'vagra-nslookup' ),
            'type'        => Controls_Manager::TEXTAREA,
            'default'     => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>',
            'rows'        => 3,
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

        $repeater->add_control( 'step_number', [
            'label'   => __( 'Step number', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => '01',
        ] );

        $this->add_control( 'features', [
            'label'       => __( 'Features', 'vagra-nslookup' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                    'icon_svg'    => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
                    'title'       => __( 'Global resolvers', 'vagra-nslookup' ),
                    'description' => __( '30+ public DNS servers across 6 continents queried in parallel.', 'vagra-nslookup' ),
                    'step_number' => '01',
                ],
                [
                    'icon_svg'    => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>',
                    'title'       => __( 'Instant results', 'vagra-nslookup' ),
                    'description' => __( 'Parallel queries return complete results in under 2 seconds.', 'vagra-nslookup' ),
                    'step_number' => '02',
                ],
                [
                    'icon_svg'    => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>',
                    'title'       => __( '13 record types', 'vagra-nslookup' ),
                    'description' => __( 'A, AAAA, CNAME, MX, NS, TXT, SPF, DKIM, DMARC, SOA, PTR, CAA, SRV.', 'vagra-nslookup' ),
                    'step_number' => '03',
                ],
                [
                    'icon_svg'    => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                    'title'       => __( 'Privacy first', 'vagra-nslookup' ),
                    'description' => __( 'No tracking, no cookies, no accounts. Your queries stay yours.', 'vagra-nslookup' ),
                    'step_number' => '04',
                ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->add_control( 'columns', [
            'label'   => __( 'Columns', 'vagra-nslookup' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 4,
            'min'     => 1,
            'max'     => 6,
        ] );

        $this->add_control( 'enable_mouse_glow', [
            'label'        => __( 'Mouse glow effect', 'vagra-nslookup' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => __( 'Yes', 'vagra-nslookup' ),
            'label_off'    => __( 'No', 'vagra-nslookup' ),
            'return_value' => 'yes',
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
            'default'   => 'rgba(255,255,255,0.04)',
            'selectors' => [ '{{WRAPPER}} .cine-feature' => 'background-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'card_border_color', [
            'label'     => __( 'Card Border', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.08)',
            'selectors' => [ '{{WRAPPER}} .cine-feature' => 'border-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'icon_color', [
            'label'     => __( 'Icon Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#4F46E5',
            'selectors' => [ '{{WRAPPER}} .cine-feature-icon' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'title_color', [
            'label'     => __( 'Title Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cine-feature h3' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'text_color', [
            'label'     => __( 'Text Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.6)',
            'selectors' => [ '{{WRAPPER}} .cine-feature p' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'number_color', [
            'label'     => __( 'Step Number Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#4F46E5',
            'selectors' => [ '{{WRAPPER}} .cine-feature-num' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'section_bg', [
            'label'     => __( 'Section Background', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .cine-features' => 'background-color: {{VALUE}}' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <div class="cine-section cine-section-dark" data-reveal>
            <div class="cine-head-wrap">
                <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                    <span class="cine-section-eyebrow reveal"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $s['heading'] ) ) : ?>
                    <h2 class="cine-big-head reveal reveal-delay-1"><?php echo esc_html( $s['heading'] ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $s['features'] ) ) : ?>
                    <div class="cine-features" style="grid-template-columns:repeat(<?php echo absint( $s['columns'] ); ?>,1fr)">
                        <?php foreach ( $s['features'] as $i => $f ) :
                            $glow = ( 'yes' === $s['enable_mouse_glow'] ) ? ' data-mouse-glow' : '';
                        ?>
                            <div class="cine-feature reveal" style="transition-delay:<?php echo esc_attr( $i * 80 ); ?>ms"<?php echo $glow; ?>>
                                <?php if ( ! empty( $f['icon_svg'] ) ) : ?>
                                    <div class="cine-feature-icon"><?php echo wp_kses_post( $f['icon_svg'] ); ?></div>
                                <?php endif; ?>
                                <?php if ( ! empty( $f['step_number'] ) ) : ?>
                                    <span class="cine-feature-num"><?php echo esc_html( $f['step_number'] ); ?></span>
                                <?php endif; ?>
                                <h3><?php echo esc_html( $f['title'] ); ?></h3>
                                <p><?php echo esc_html( $f['description'] ); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
