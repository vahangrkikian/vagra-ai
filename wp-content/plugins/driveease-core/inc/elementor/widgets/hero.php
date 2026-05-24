<?php
namespace DriveEase\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hero extends DriveEase_Widget_Base {

    public function get_name()  { return 'driveease_hero'; }
    public function get_title() { return __( 'DriveEase Hero', 'driveease' ); }
    public function get_icon()  { return 'eicon-header'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'driveease' ),
        ] );

        $this->add_control( 'badge', [
            'label'   => __( 'Badge Text', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( '#1 Rated Car Rental Service', 'driveease' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'driveease' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Find Your Perfect Ride for Any Journey', 'driveease' ),
        ] );

        $this->add_control( 'subtitle', [
            'label'   => __( 'Subtitle', 'driveease' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Premium vehicles, unbeatable rates, and seamless booking — wherever your destination takes you.', 'driveease' ),
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'CTA Text', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Browse Fleet', 'driveease' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'CTA URL', 'driveease' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#fleet' ],
        ] );

        $this->add_control( 'bg_image', [
            'label' => __( 'Background Image', 'driveease' ),
            'type'  => Controls_Manager::MEDIA,
        ] );

        $this->end_controls_section();

        /* ── Style Tab ─────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'driveease' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'driveease' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .hero-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'driveease' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .hero-title' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'driveease' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'driveease' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'driveease' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'driveease' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hero-content' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '#fleet';
        $bg  = ! empty( $s['bg_image']['url'] ) ? ' style="background-image:url(' . esc_url( $s['bg_image']['url'] ) . ')"' : '';
        ?>
        <section id="hero" role="main"<?php echo $bg; ?>>
            <span id="main-content"></span>
            <div class="container hero-content">
                <?php if ( ! empty( $s['badge'] ) ) : ?>
                <div class="hero-badge"><i class="fa-solid fa-star"></i> &nbsp;<?php echo esc_html( $s['badge'] ); ?></div>
                <?php endif; ?>
                <h1 class="hero-title"><?php echo esc_html( $s['title'] ); ?></h1>
                <p class="hero-sub"><?php echo esc_html( $s['subtitle'] ); ?></p>
                <a href="<?php echo esc_url( $url ); ?>" class="btn btn-primary">
                    <?php echo esc_html( $s['cta_text'] ); ?>
                </a>
            </div>
        </section>
        <?php
    }
}
