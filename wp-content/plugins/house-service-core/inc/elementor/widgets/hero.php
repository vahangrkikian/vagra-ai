<?php
namespace HouseService\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hero extends HS_Widget_Base {

    public function get_name()  { return 'hs_hero'; }
    public function get_title() { return __( 'HS Hero', 'house-service' ); }
    public function get_icon()  { return 'eicon-header'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'house-service' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( '240+ verified providers', 'house-service' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'house-service' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Find reliable service companies near you.', 'house-service' ),
        ] );

        $this->add_control( 'subtitle', [
            'label'   => __( 'Subtitle', 'house-service' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Cleaners, movers, repair pros, assembly teams — background-checked, reviewed by real customers, and ready to book this week.', 'house-service' ),
        ] );

        $this->add_control( 'search_placeholder_service', [
            'label'   => __( 'Search Placeholder (Service)', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'What do you need?', 'house-service' ),
        ] );

        $this->add_control( 'search_placeholder_location', [
            'label'   => __( 'Search Placeholder (Location)', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'City or ZIP', 'house-service' ),
        ] );

        $this->add_control( 'bg_image', [
            'label'   => __( 'Background Image', 'house-service' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [ 'url' => '' ],
        ] );

        $this->end_controls_section();

        /* ── Style tab ─────────────────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'house-service' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'house-service' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'house-service' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .hero__title' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'house-service' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'house-service' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'house-service' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'house-service' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hero' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $archive_url = get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' );
        $bg_url = ! empty( $s['bg_image']['url'] ) ? $s['bg_image']['url'] : get_template_directory_uri() . '/assets/images/photo_hero.jpg';
        ?>
        <section class="hero">
            <div class="shell">
                <div class="hero__grid">
                    <div class="hero__left">
                        <div class="hero__eyebrow">
                            <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'shield', 16 ) : ''; ?>
                            <?php echo esc_html( $s['eyebrow'] ); ?>
                        </div>
                        <h1 class="hero__title"><?php echo esc_html( $s['title'] ); ?></h1>
                        <p class="hero__sub"><?php echo esc_html( $s['subtitle'] ); ?></p>

                        <form class="hero__search" id="hero-search" action="<?php echo esc_url( $archive_url ); ?>" method="get">
                            <div class="hero__search-field">
                                <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'search', 20 ) : ''; ?>
                                <input type="text" name="hs_q" placeholder="<?php echo esc_attr( $s['search_placeholder_service'] ); ?>" aria-label="<?php esc_attr_e( 'Service type', 'house-service' ); ?>">
                            </div>
                            <div class="hero__search-divider"></div>
                            <div class="hero__search-field">
                                <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'pin', 20 ) : ''; ?>
                                <input type="text" name="hs_loc" placeholder="<?php echo esc_attr( $s['search_placeholder_location'] ); ?>" aria-label="<?php esc_attr_e( 'Location', 'house-service' ); ?>">
                            </div>
                            <button type="submit" class="hero__search-btn" aria-label="<?php esc_attr_e( 'Search providers', 'house-service' ); ?>">
                                <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'search', 22 ) : ''; ?>
                            </button>
                        </form>

                        <div class="hero__trust">
                            <span class="trust-pill">
                                <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'shield', 14 ) : ''; ?>
                                <?php esc_html_e( 'Background-checked', 'house-service' ); ?>
                            </span>
                            <span class="trust-pill">
                                <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'star', 14 ) : ''; ?>
                                <?php esc_html_e( 'Verified reviews', 'house-service' ); ?>
                            </span>
                            <span class="trust-pill">
                                <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'calendar', 14 ) : ''; ?>
                                <?php esc_html_e( 'Same-week availability', 'house-service' ); ?>
                            </span>
                        </div>
                    </div>

                    <div class="hero__visual">
                        <div class="hero__image">
                            <img src="<?php echo esc_url( $bg_url ); ?>" alt="<?php esc_attr_e( 'Friendly home-service crew', 'house-service' ); ?>" />
                        </div>
                        <div class="hero__chip">
                            <span class="hero__chip-dot"></span>
                            <?php esc_html_e( '1,200+ jobs this week', 'house-service' ); ?>
                        </div>
                    </div>
                </div>

                <div class="hero__stats">
                    <div class="hero__stat">
                        <div class="hero__stat-value" data-count="240">240+</div>
                        <div class="hero__stat-label"><?php esc_html_e( 'Verified pros', 'house-service' ); ?></div>
                    </div>
                    <div class="hero__stat">
                        <div class="hero__stat-value">4.8<?php echo function_exists( 'hs_icon' ) ? hs_icon( 'star', 16 ) : ''; ?></div>
                        <div class="hero__stat-label"><?php esc_html_e( 'Avg rating', 'house-service' ); ?></div>
                    </div>
                    <div class="hero__stat">
                        <div class="hero__stat-value"><?php esc_html_e( '2 hr', 'house-service' ); ?></div>
                        <div class="hero__stat-label"><?php esc_html_e( 'Median reply', 'house-service' ); ?></div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
