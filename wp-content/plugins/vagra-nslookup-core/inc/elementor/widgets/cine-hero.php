<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Cine_Hero extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_cine_hero';
    }

    public function get_title() {
        return __( 'Cine Hero', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-header';
    }

    protected function register_controls() {

        /* ── Content ── */
        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Free, open-source DNS toolkit', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Check any DNS record, anywhere, instantly.', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading_accent', [
            'label'       => __( 'Accent word(s)', 'vagra-nslookup' ),
            'description' => __( 'Words that get the gradient color.', 'vagra-nslookup' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'instantly.', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'lede', [
            'label'   => __( 'Lead text', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Query thirteen DNS record types across thirty public resolvers on six continents. Watch propagation roll out in real time. Free, instant, zero signup.', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'primary_cta_text', [
            'label'   => __( 'Primary CTA text', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Start lookup', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'primary_cta_url', [
            'label'   => __( 'Primary CTA URL', 'vagra-nslookup' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#tool' ],
        ] );

        $this->add_control( 'secondary_cta_text', [
            'label'   => __( 'Secondary CTA text', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'How it works', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'secondary_cta_url', [
            'label'   => __( 'Secondary CTA URL', 'vagra-nslookup' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#how' ],
        ] );

        $trust = new Repeater();
        $trust->add_control( 'text', [
            'label'   => __( 'Text', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'No signup', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'trust_items', [
            'label'       => __( 'Trust items', 'vagra-nslookup' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $trust->get_controls(),
            'default'     => [
                [ 'text' => __( 'No signup', 'vagra-nslookup' ) ],
                [ 'text' => __( 'No rate limits', 'vagra-nslookup' ) ],
                [ 'text' => __( '13 record types', 'vagra-nslookup' ) ],
            ],
            'title_field' => '{{{ text }}}',
        ] );

        $this->add_control( 'show_tool_demo', [
            'label'        => __( 'Show tool demo', 'vagra-nslookup' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => __( 'Yes', 'vagra-nslookup' ),
            'label_off'    => __( 'No', 'vagra-nslookup' ),
            'return_value' => 'yes',
        ] );

        $this->add_control( 'background_style', [
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
        $this->start_controls_section( 'section_style_general', [
            'label' => __( 'General', 'vagra-nslookup' ),
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
            'selectors' => [ '{{WRAPPER}} .cine-accent' => 'color: {{VALUE}}; background: linear-gradient(135deg, {{VALUE}}, var(--nsl-primary-400)); -webkit-background-clip: text; background-clip: text; color: transparent;' ],
        ] );

        $this->add_control( 'lede_color', [
            'label'     => __( 'Lead Text Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.65)',
            'selectors' => [ '{{WRAPPER}} .cine-lede' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'eyebrow_color', [
            'label'     => __( 'Eyebrow Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.55)',
            'selectors' => [ '{{WRAPPER}} .cine-eyebrow' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'btn_primary_bg', [
            'label'     => __( 'Primary Button BG', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#4F46E5',
            'selectors' => [ '{{WRAPPER}} .cine-btn-primary' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'vagra-nslookup' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [ 'top' => '120', 'right' => '0', 'bottom' => '80', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cine-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_control( 'hero_image', [
            'label' => __( 'Background Image', 'vagra-nslookup' ),
            'type'  => Controls_Manager::MEDIA,
            'selectors' => [ '{{WRAPPER}} .cine-hero' => 'background-image: url({{URL}});background-size:cover;background-position:center;' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $heading      = $s['heading'];
        $accent       = $s['heading_accent'];
        $accent_lower = mb_strtolower( $accent );

        // Split heading into words for animation
        $heading_plain = str_ireplace( $accent, '', $heading );
        $heading_plain = trim( $heading_plain );
        $words         = preg_split( '/\s+/', $heading_plain );
        $accent_words  = preg_split( '/\s+/', $accent );

        $primary_url   = ! empty( $s['primary_cta_url']['url'] ) ? $s['primary_cta_url']['url'] : '#';
        $secondary_url = ! empty( $s['secondary_cta_url']['url'] ) ? $s['secondary_cta_url']['url'] : '#';
        ?>
        <section class="cine-hero" data-reveal>
            <div class="container cine-hero-inner">
                <div>
                    <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                        <span class="cine-eyebrow"><span class="dot"></span> <?php echo esc_html( $s['eyebrow'] ); ?></span>
                    <?php endif; ?>

                    <h1 class="cine-h1" style="margin-top:22px">
                        <?php
                        $wi = 0;
                        foreach ( $words as $word ) :
                            if ( empty( $word ) ) continue;
                            $delay = $wi * 110;
                        ?>
                            <span class="cine-h1-word" style="margin-right:0.22em"><span style="animation-delay:<?php echo esc_attr( $delay ); ?>ms"><?php echo esc_html( $word ); ?></span></span>
                        <?php
                            $wi++;
                        endforeach;
                        ?>
                        <br/>
                        <?php foreach ( $accent_words as $aw ) :
                            if ( empty( $aw ) ) continue;
                            $delay = $wi * 110;
                        ?>
                            <span class="cine-h1-word"><span class="cine-accent" style="animation-delay:<?php echo esc_attr( $delay ); ?>ms"><?php echo esc_html( $aw ); ?></span></span>
                        <?php
                            $wi++;
                        endforeach; ?>
                    </h1>

                    <?php if ( ! empty( $s['lede'] ) ) : ?>
                        <p class="cine-lede reveal reveal-delay-3"><?php echo esc_html( $s['lede'] ); ?></p>
                    <?php endif; ?>

                    <div class="cine-cta-row reveal reveal-delay-4">
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

                    <?php if ( ! empty( $s['trust_items'] ) ) : ?>
                        <div class="cine-trust reveal reveal-delay-4">
                            <?php foreach ( $s['trust_items'] as $i => $item ) : ?>
                                <?php if ( $i > 0 ) : ?><span class="cine-sep"></span><?php endif; ?>
                                <span><?php echo esc_html( $item['text'] ); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( 'yes' === $s['show_tool_demo'] ) : ?>
                <div style="position:relative">
                    <div class="cine-chip-float tl"><span class="dot" style="display:inline-block;width:6px;height:6px;border-radius:50%;margin-right:8px"></span><?php esc_html_e( 'propagated · ashburn · 24ms', 'vagra-nslookup' ); ?></div>
                    <div class="cine-chip-float br"><span class="dot" style="display:inline-block;width:6px;height:6px;border-radius:50%;margin-right:8px"></span><?php esc_html_e( 'ttl 3600s · cloudflare', 'vagra-nslookup' ); ?></div>

                    <div class="cine-tool reveal-scale in">
                        <div class="cine-tool-inner">
                            <div class="cine-tool-head">
                                <div class="cine-tool-dots"><span></span><span></span><span></span></div>
                                <span style="margin-left:12px"><?php esc_html_e( 'nslookup.am — live query', 'vagra-nslookup' ); ?></span>
                            </div>
                            <div class="cine-tool-form">
                                <input class="cine-tool-input" value="nslookup.am" readonly aria-label="<?php esc_attr_e( 'Domain', 'vagra-nslookup' ); ?>"/>
                                <span class="cine-tool-select">A</span>
                                <span class="cine-tool-go"><?php esc_html_e( 'Lookup', 'vagra-nslookup' ); ?> &rarr;</span>
                            </div>
                            <div class="cine-pills">
                                <?php
                                $pill_types = array( 'A', 'AAAA', 'CNAME', 'MX', 'NS', 'TXT', 'SPF', 'DKIM', 'DMARC', 'SOA', 'CAA', 'SRV', 'PTR' );
                                foreach ( $pill_types as $pi => $type ) :
                                    $class = 0 === $pi ? 'cine-pill on' : 'cine-pill';
                                ?>
                                    <span class="<?php echo esc_attr( $class ); ?>"><?php echo esc_html( $type ); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="cine-results">
                                <?php
                                $demo_rows = array(
                                    array( 'loc' => 'Ashburn · US',   'ip' => '173.245.58.100', 'ms' => '24ms',  's' => 'ok' ),
                                    array( 'loc' => 'Frankfurt · DE', 'ip' => '173.245.58.100', 'ms' => '61ms',  's' => 'ok' ),
                                    array( 'loc' => 'Tokyo · JP',     'ip' => '173.245.58.100', 'ms' => '148ms', 's' => 'ok' ),
                                    array( 'loc' => 'Mumbai · IN',    'ip' => 'old.198.51.100', 'ms' => '191ms', 's' => 'err' ),
                                    array( 'loc' => 'Sydney · AU',    'ip' => '173.245.58.100', 'ms' => '203ms', 's' => 'ok' ),
                                );
                                foreach ( $demo_rows as $ri => $row ) :
                                    $delay = 800 + $ri * 120;
                                ?>
                                    <div class="cine-result-row" style="animation-delay:<?php echo esc_attr( $delay ); ?>ms">
                                        <span class="cine-result-dot <?php echo esc_attr( $row['s'] ); ?>"></span>
                                        <span class="cine-result-loc"><?php echo esc_html( $row['loc'] ); ?></span>
                                        <span class="cine-result-ip"><?php echo esc_html( $row['ip'] ); ?></span>
                                        <span class="cine-result-ms"><?php echo esc_html( $row['ms'] ); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
