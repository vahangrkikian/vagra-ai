<?php
namespace VagraLegal\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Practice_Areas extends Legal_Widget_Base {

    public function get_name()  { return 'vagra_legal_practice_areas'; }
    public function get_title() { return __( 'Practice Areas', 'vagra-legal' ); }
    public function get_icon()  { return 'eicon-gallery-grid'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-legal' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Our Practice Areas', 'vagra-legal' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'We offer comprehensive legal services across multiple practice areas to meet your needs.', 'vagra-legal' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Practice Area', 'vagra-legal' ),
        ] );

        $repeater->add_control( 'desc', [
            'label'   => __( 'Description', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => '',
        ] );

        $repeater->add_control( 'icon_name', [
            'label'   => __( 'Icon', 'vagra-legal' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'injury'     => __( 'Personal Injury', 'vagra-legal' ),
                'family'     => __( 'Family', 'vagra-legal' ),
                'criminal'   => __( 'Criminal', 'vagra-legal' ),
                'business'   => __( 'Business', 'vagra-legal' ),
                'immigration'=> __( 'Immigration', 'vagra-legal' ),
                'estate'     => __( 'Estate', 'vagra-legal' ),
            ],
            'default' => 'injury',
        ] );

        $this->add_control( 'areas', [
            'label'   => __( 'Areas', 'vagra-legal' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'title' => 'Personal Injury', 'desc' => 'Aggressive representation for accident victims.', 'icon_name' => 'injury' ],
                [ 'title' => 'Family Law', 'desc' => 'Compassionate guidance through family matters.', 'icon_name' => 'family' ],
                [ 'title' => 'Criminal Defense', 'desc' => 'Protecting your rights and your future.', 'icon_name' => 'criminal' ],
                [ 'title' => 'Business Law', 'desc' => 'Strategic counsel for businesses of all sizes.', 'icon_name' => 'business' ],
                [ 'title' => 'Immigration', 'desc' => 'Navigating the path to a new beginning.', 'icon_name' => 'immigration' ],
                [ 'title' => 'Estate Planning', 'desc' => 'Securing your legacy and your family\'s future.', 'icon_name' => 'estate' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();

        /* ── Style ─────────────────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'vagra-legal' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'vagra-legal' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [ '{{WRAPPER}} .vagra-practice-areas' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'vagra-legal' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-section-header__title' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'vagra-legal' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'vagra-legal' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'vagra-legal' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'vagra-legal' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .vagra-practice-areas' => 'text-align: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'vagra-legal' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [ '{{WRAPPER}} .vagra-practice-areas__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'vagra-legal' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [ '{{WRAPPER}} .vagra-practice-areas__grid' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="vagra-practice-areas" id="practice-areas">
            <div class="vagra-container">
                <div class="vagra-section-header">
                    <h2 class="vagra-section-header__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <span class="vagra-section-header__accent"></span>
                    <p class="vagra-section-header__desc"><?php echo esc_html( $s['description'] ); ?></p>
                </div>
                <div class="vagra-practice-areas__grid">
                    <?php foreach ( $s['areas'] as $area ) : ?>
                    <div class="vagra-card vagra-practice-card">
                        <div class="vagra-practice-card__icon">
                            <?php echo $this->get_area_icon( $area['icon_name'] ); ?>
                        </div>
                        <h3 class="vagra-practice-card__title"><?php echo esc_html( $area['title'] ); ?></h3>
                        <p class="vagra-practice-card__desc"><?php echo esc_html( $area['desc'] ); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    private function get_area_icon( $name ) {
        $icons = [
            'injury'      => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="20" r="10" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><path d="M14 38C14 32 18 28 24 28C30 28 34 32 34 38" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/><path d="M30 18L36 12" stroke="var(--vagra-danger)" stroke-width="2.5" stroke-linecap="round"/></svg>',
            'family'      => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="16" cy="18" r="6" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><circle cx="32" cy="18" r="6" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><circle cx="24" cy="30" r="5" stroke="var(--vagra-accent)" stroke-width="2" fill="none"/><path d="M8 38c0-5 3-8 8-8M40 38c0-5-3-8-8-8" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/></svg>',
            'criminal'    => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect x="10" y="8" width="28" height="32" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><path d="M18 16h12M18 22h12M18 28h8" stroke="var(--vagra-primary)" stroke-width="2" stroke-linecap="round"/><circle cx="36" cy="34" r="8" stroke="var(--vagra-accent)" stroke-width="2.5" fill="none"/><path d="M33 34l2 2 4-4" stroke="var(--vagra-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'business'    => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect x="8" y="16" width="32" height="24" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><path d="M18 16V12a4 4 0 014-4h4a4 4 0 014 4v4" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><path d="M8 26h32" stroke="var(--vagra-primary)" stroke-width="2" opacity="0.4"/><circle cx="24" cy="26" r="3" fill="var(--vagra-accent)"/></svg>',
            'immigration' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="16" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><ellipse cx="24" cy="24" rx="8" ry="16" stroke="var(--vagra-primary)" stroke-width="1.5" opacity="0.5" fill="none"/><path d="M8 20h32M8 28h32" stroke="var(--vagra-primary)" stroke-width="1.5" opacity="0.3"/><path d="M20 10l4 4 4-4" stroke="var(--vagra-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'estate'      => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M24 8L8 22v18h32V22L24 8z" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/><rect x="18" y="28" width="12" height="12" rx="1" stroke="var(--vagra-primary)" stroke-width="2" fill="none"/><path d="M24 28v12" stroke="var(--vagra-primary)" stroke-width="1.5"/><circle cx="36" cy="14" r="6" stroke="var(--vagra-accent)" stroke-width="2" fill="none"/><path d="M36 11v6M33 14h6" stroke="var(--vagra-accent)" stroke-width="1.5" stroke-linecap="round"/></svg>',
        ];
        return $icons[ $name ] ?? '';
    }
}
