<?php
namespace VagraMSP\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Services extends MSP_Widget_Base {

    public function get_name()  { return 'vagra_msp_services'; }
    public function get_title() { return __( 'MSP Services', 'vagra-msp' ); }
    public function get_icon()  { return 'eicon-gallery-grid'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-msp' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Our Security Services', 'vagra-msp' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Comprehensive managed security solutions to protect every layer of your business.', 'vagra-msp' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Service', 'vagra-msp' ),
        ] );

        $repeater->add_control( 'desc', [
            'label'   => __( 'Description', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => '',
        ] );

        $repeater->add_control( 'icon_name', [
            'label'   => __( 'Icon', 'vagra-msp' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'dmarc'      => __( 'DMARC / DKIM / SPF', 'vagra-msp' ),
                'email'      => __( 'Email Security', 'vagra-msp' ),
                'endpoint'   => __( 'Endpoint Protection', 'vagra-msp' ),
                'network'    => __( 'Network Monitoring', 'vagra-msp' ),
                'incident'   => __( 'Incident Response', 'vagra-msp' ),
                'training'   => __( 'Security Training', 'vagra-msp' ),
            ],
            'default' => 'dmarc',
        ] );

        $this->add_control( 'services', [
            'label'   => __( 'Services', 'vagra-msp' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'title' => 'DMARC / DKIM / SPF', 'desc' => 'Stop email spoofing and phishing attacks with properly configured email authentication protocols.', 'icon_name' => 'dmarc' ],
                [ 'title' => 'Email Security', 'desc' => 'Advanced email filtering, encryption, and threat detection to safeguard your business communications.', 'icon_name' => 'email' ],
                [ 'title' => 'Endpoint Protection', 'desc' => 'Next-gen antivirus and EDR solutions protecting every device on your network from malware and ransomware.', 'icon_name' => 'endpoint' ],
                [ 'title' => 'Network Monitoring', 'desc' => '24/7 network surveillance and real-time alerting to detect and respond to threats before they cause damage.', 'icon_name' => 'network' ],
                [ 'title' => 'Incident Response', 'desc' => 'Rapid response plans and expert remediation when security incidents occur. Minimize downtime and data loss.', 'icon_name' => 'incident' ],
                [ 'title' => 'Security Awareness Training', 'desc' => 'Empower your team to recognize and prevent cyber threats with engaging, up-to-date security training programs.', 'icon_name' => 'training' ],
            ],
            'title_field' => '{{{ title }}}',
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
            'selectors'  => [ '{{WRAPPER}} .vagra-services' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'vagra-msp' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-section-header__title' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-msp' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-msp' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-msp' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-msp' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .vagra-services' => 'text-align: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'vagra-msp' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [ '{{WRAPPER}} .vagra-services__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'vagra-msp' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-services__grid' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="vagra-services" id="services">
            <div class="vagra-container">
                <div class="vagra-section-header">
                    <h2 class="vagra-section-header__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <p class="vagra-section-header__desc"><?php echo esc_html( $s['description'] ); ?></p>
                </div>
                <div class="vagra-services__grid">
                    <?php foreach ( $s['services'] as $service ) : ?>
                    <div class="vagra-card vagra-service-card">
                        <div class="vagra-service-card__icon">
                            <?php echo $this->get_service_icon( $service['icon_name'] ); ?>
                        </div>
                        <h3 class="vagra-service-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
                        <p class="vagra-service-card__desc"><?php echo esc_html( $service['desc'] ); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    private function get_service_icon( $name ) {
        $icons = [
            'dmarc'    => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true"><rect x="4" y="12" width="40" height="28" rx="4" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><path d="M4 20H44" stroke="var(--vagra-primary)" stroke-width="2.5"/><circle cx="24" cy="32" r="4" stroke="var(--vagra-success)" stroke-width="2.5" fill="none"/><path d="M16 8L24 12L32 8" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/></svg>',
            'email'    => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true"><rect x="8" y="8" width="32" height="24" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><path d="M8 16H40" stroke="var(--vagra-primary)" stroke-width="2.5"/><path d="M18 36H30" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/><path d="M24 32V36" stroke="var(--vagra-primary)" stroke-width="2.5"/><path d="M20 22L23 25L28 19" stroke="var(--vagra-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'endpoint' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M24 6L40 14V26C40 36 33 43 24 46C15 43 8 36 8 26V14L24 6Z" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><path d="M18 26L22 30L30 20" stroke="var(--vagra-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'network'  => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="18" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><circle cx="24" cy="24" r="6" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><path d="M24 6V12M24 36V42M6 24H12M36 24H42" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/><circle cx="24" cy="24" r="2" fill="var(--vagra-success)"/></svg>',
            'incident' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M24 8L28 16H36L30 22L32 30L24 26L16 30L18 22L12 16H20L24 8Z" stroke="var(--vagra-warning)" stroke-width="2.5" fill="none"/><path d="M10 38H38" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/><path d="M14 42H34" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/></svg>',
            'training' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="16" r="8" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><path d="M10 40C10 32 16 28 24 28C32 28 38 32 38 40" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/><path d="M32 12L36 8M36 8H32M36 8V12" stroke="var(--vagra-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        ];
        return $icons[ $name ] ?? '';
    }
}
