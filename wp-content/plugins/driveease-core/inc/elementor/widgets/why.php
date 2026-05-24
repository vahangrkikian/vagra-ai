<?php
namespace DriveEase\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Why extends DriveEase_Widget_Base {

    public function get_name()  { return 'driveease_why'; }
    public function get_title() { return __( 'Why DriveEase', 'driveease' ); }
    public function get_icon()  { return 'eicon-info-circle'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'driveease' ),
        ] );

        $this->add_control( 'label', [
            'label'   => __( 'Section Label', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Why DriveEase', 'driveease' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'driveease' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => "Everything You Need,\nNothing You Don't",
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'icon', [
            'label'   => __( 'FontAwesome Icon Class', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => 'fa-solid fa-star',
        ] );

        $repeater->add_control( 'title', [
            'label' => __( 'Title', 'driveease' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'description', [
            'label' => __( 'Description', 'driveease' ),
            'type'  => Controls_Manager::TEXTAREA,
        ] );

        $this->add_control( 'items', [
            'label'   => __( 'Features', 'driveease' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'icon' => 'fa-solid fa-rotate-left', 'title' => 'Free Cancellation', 'description' => 'Plans change. Cancel up to 24 hours before pick-up at no cost, no questions asked.' ],
                [ 'icon' => 'fa-solid fa-headset', 'title' => '24/7 Support', 'description' => 'Our team is available around the clock via phone, chat, or email whenever you need us.' ],
                [ 'icon' => 'fa-solid fa-location-crosshairs', 'title' => 'GPS Included', 'description' => 'Every vehicle comes equipped with a built-in GPS navigation system at no extra charge.' ],
                [ 'icon' => 'fa-solid fa-shield-halved', 'title' => 'Full Insurance', 'description' => 'Comprehensive insurance coverage included with every rental — drive with complete peace of mind.' ],
            ],
            'title_field' => '{{{ title }}}',
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
                '{{WRAPPER}} #why' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'driveease' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .section-title' => 'font-size: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} #why' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'driveease' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '4',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [
                '{{WRAPPER}} .why-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'driveease' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [
                '{{WRAPPER}} .why-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section id="why">
            <div class="container">
                <div class="section-label"><?php echo esc_html( $s['label'] ); ?></div>
                <h2 class="section-title"><?php echo nl2br( esc_html( $s['heading'] ) ); ?></h2>
                <div class="why-grid">
                    <?php foreach ( $s['items'] as $item ) : ?>
                    <div class="why-card">
                        <div class="why-icon"><i class="<?php echo esc_attr( $item['icon'] ); ?>"></i></div>
                        <h3><?php echo esc_html( $item['title'] ); ?></h3>
                        <p><?php echo esc_html( $item['description'] ); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
