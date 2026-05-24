<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Final_CTA extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_final_cta';
    }

    public function get_title() {
        return __( 'Final CTA', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-call-to-action';
    }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Start a lookup. It takes ten seconds.', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'subtitle', [
            'label'   => __( 'Subtitle', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Free. Instant. Worldwide. The DNS diagnostic tool built for the ones shipping at 2am.', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'primary_cta_text', [
            'label'   => __( 'Primary CTA text', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Open tool', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'primary_cta_url', [
            'label'   => __( 'Primary CTA URL', 'vagra-nslookup' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#tool' ],
        ] );

        $this->add_control( 'secondary_cta_text', [
            'label'   => __( 'Secondary CTA text', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Read the field notes', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'secondary_cta_url', [
            'label'   => __( 'Secondary CTA URL', 'vagra-nslookup' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/blog/' ],
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
            'selectors' => [ '{{WRAPPER}} .cine-final' => 'background-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'heading_color', [
            'label'     => __( 'Heading Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cine-final-h' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'subtitle_color', [
            'label'     => __( 'Subtitle Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .cine-final p' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'btn_bg', [
            'label'     => __( 'Button Background', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#4F46E5',
            'selectors' => [ '{{WRAPPER}} .cine-btn-primary' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'cta_padding', [
            'label'      => __( 'Section Padding', 'vagra-nslookup' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '96', 'right' => '24', 'bottom' => '96', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cine-final' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_control( 'bg_image', [
            'label' => __( 'Background Image', 'vagra-nslookup' ),
            'type'  => Controls_Manager::MEDIA,
            'selectors' => [ '{{WRAPPER}} .cine-final' => 'background-image: url({{URL}});background-size:cover;background-position:center;' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $primary_url   = ! empty( $s['primary_cta_url']['url'] ) ? $s['primary_cta_url']['url'] : '#';
        $secondary_url = ! empty( $s['secondary_cta_url']['url'] ) ? $s['secondary_cta_url']['url'] : '#';
        ?>
        <section class="cine-final" data-reveal>
            <div class="container" style="text-align:center">
                <?php if ( ! empty( $s['heading'] ) ) : ?>
                    <h2 class="cine-final-h reveal"><?php echo wp_kses_post( $s['heading'] ); ?></h2>
                <?php endif; ?>
                <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                    <p class="reveal reveal-delay-1" style="position:relative;z-index:1;margin-top:28px;font-size:20px;color:rgba(255,255,255,0.6);max-width:580px;margin-inline:auto"><?php echo esc_html( $s['subtitle'] ); ?></p>
                <?php endif; ?>

                <div class="cine-cta-row reveal reveal-delay-2" style="justify-content:center;position:relative;z-index:1;margin-top:48px">
                    <?php if ( ! empty( $s['primary_cta_text'] ) ) : ?>
                        <a href="<?php echo esc_url( $primary_url ); ?>" class="cine-btn cine-btn-primary">
                            <?php echo esc_html( $s['primary_cta_text'] ); ?>
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10m-4-4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ( ! empty( $s['secondary_cta_text'] ) ) : ?>
                        <a href="<?php echo esc_url( $secondary_url ); ?>" class="cine-btn cine-btn-ghost"><?php echo esc_html( $s['secondary_cta_text'] ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
