<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Sub_Hero extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_sub_hero';
    }

    public function get_title() {
        return __( 'Sub Hero', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-banner';
    }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'DNS Tools', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading', [
            'label'       => __( 'Heading (HTML allowed)', 'vagra-nslookup' ),
            'type'        => Controls_Manager::TEXTAREA,
            'default'     => __( 'Check <span class="cine-accent">A records</span> globally', 'vagra-nslookup' ),
            'description' => __( 'Use &lt;span class="cine-accent"&gt;word&lt;/span&gt; for gradient text.', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'lede', [
            'label'   => __( 'Lead text', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Query A records across 30+ global resolvers instantly.', 'vagra-nslookup' ),
        ] );

        $breadcrumbs = new Repeater();

        $breadcrumbs->add_control( 'label', [
            'label'   => __( 'Label', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Home', 'vagra-nslookup' ),
        ] );

        $breadcrumbs->add_control( 'url', [
            'label' => __( 'URL', 'vagra-nslookup' ),
            'type'  => Controls_Manager::URL,
        ] );

        $this->add_control( 'breadcrumbs', [
            'label'       => __( 'Breadcrumbs', 'vagra-nslookup' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $breadcrumbs->get_controls(),
            'default'     => [
                [ 'label' => __( 'Home', 'vagra-nslookup' ), 'url' => [ 'url' => '/' ] ],
                [ 'label' => __( 'Tools', 'vagra-nslookup' ), 'url' => [ 'url' => '/tools/' ] ],
                [ 'label' => __( 'A Record', 'vagra-nslookup' ), 'url' => [ 'url' => '' ] ],
            ],
            'title_field' => '{{{ label }}}',
        ] );

        $this->add_control( 'background', [
            'label'   => __( 'Background', 'vagra-nslookup' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'dark',
            'options' => [
                'dark'     => __( 'Dark', 'vagra-nslookup' ),
                'gradient' => __( 'Gradient', 'vagra-nslookup' ),
            ],
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
            'default'   => '#0B0D14',
            'selectors' => [ '{{WRAPPER}} .cine-hero' => 'background-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'heading_color', [
            'label'     => __( 'Heading Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cine-h1' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'accent_color', [
            'label'     => __( 'Accent Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#22D3EE',
            'selectors' => [ '{{WRAPPER}} .cine-accent' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'lede_color', [
            'label'     => __( 'Lead Text Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .cine-lede' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'crumb_color', [
            'label'     => __( 'Breadcrumb Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-crumb, {{WRAPPER}} .nsl-crumb a' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'hero_padding', [
            'label'      => __( 'Section Padding', 'vagra-nslookup' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [ 'top' => '120', 'right' => '0', 'bottom' => '72', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cine-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $bg_style = ( 'gradient' === $s['background'] )
            ? 'background:linear-gradient(135deg,#0B0D14 0%,#141828 100%)'
            : '';

        $allowed_html = array(
            'span' => array( 'class' => array(), 'style' => array() ),
            'br'   => array(),
            'em'   => array(),
            'strong' => array(),
        );
        ?>
        <section class="cine-hero" style="min-height:auto;padding:56px 0 48px;<?php echo esc_attr( $bg_style ); ?>" data-reveal>
            <div class="container" style="position:relative;z-index:2">
                <?php if ( ! empty( $s['breadcrumbs'] ) ) : ?>
                    <nav class="nsl-crumb reveal" aria-label="<?php esc_attr_e( 'Breadcrumb', 'vagra-nslookup' ); ?>">
                        <?php foreach ( $s['breadcrumbs'] as $i => $crumb ) :
                            $is_last = ( $i === count( $s['breadcrumbs'] ) - 1 );
                            $has_url = ! empty( $crumb['url']['url'] );
                        ?>
                            <?php if ( $i > 0 ) : ?>
                                <span class="nsl-crumb-sep">/</span>
                            <?php endif; ?>
                            <?php if ( $is_last || ! $has_url ) : ?>
                                <span class="nsl-crumb-current"><?php echo esc_html( $crumb['label'] ); ?></span>
                            <?php else : ?>
                                <a href="<?php echo esc_url( $crumb['url']['url'] ); ?>"><?php echo esc_html( $crumb['label'] ); ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>
                <?php endif; ?>

                <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                    <span class="cine-eyebrow reveal reveal-delay-1" style="margin-top:24px;display:inline-flex"><span class="dot"></span> <?php echo esc_html( $s['eyebrow'] ); ?></span>
                <?php endif; ?>

                <?php if ( ! empty( $s['heading'] ) ) : ?>
                    <h1 class="cine-h1 reveal reveal-delay-2" style="margin-top:20px;font-size:clamp(32px,5vw,64px)"><?php echo wp_kses( $s['heading'], $allowed_html ); ?></h1>
                <?php endif; ?>

                <?php if ( ! empty( $s['lede'] ) ) : ?>
                    <p class="cine-lede reveal reveal-delay-3"><?php echo esc_html( $s['lede'] ); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
