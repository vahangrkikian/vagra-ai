<?php
namespace DriveEase\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Fleet extends DriveEase_Widget_Base {

    public function get_name()  { return 'driveease_fleet'; }
    public function get_title() { return __( 'Fleet Grid', 'driveease' ); }
    public function get_icon()  { return 'eicon-gallery-grid'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'driveease' ),
        ] );

        $this->add_control( 'label', [
            'label'   => __( 'Section Label', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Our Vehicles', 'driveease' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Choose Your Vehicle', 'driveease' ),
        ] );

        $this->add_control( 'count', [
            'label'   => __( 'Number of Cars', 'driveease' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 12,
            'min'     => 1,
            'max'     => 24,
        ] );

        $this->add_control( 'show_filters', [
            'label'        => __( 'Show Category Filters', 'driveease' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => __( 'Yes', 'driveease' ),
            'label_off'    => __( 'No', 'driveease' ),
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
                '{{WRAPPER}} #fleet' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                '{{WRAPPER}} #fleet' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'driveease' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [
                '{{WRAPPER}} .fleet-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'driveease' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [
                '{{WRAPPER}} .fleet-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s     = $this->get_settings_for_display();
        $count = ! empty( $s['count'] ) ? (int) $s['count'] : 12;
        ?>
        <section id="fleet">
            <div class="container">
                <div class="fleet-header">
                    <div>
                        <div class="section-label"><?php echo esc_html( $s['label'] ); ?></div>
                        <h2 class="section-title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    </div>
                    <?php if ( 'yes' === $s['show_filters'] ) : ?>
                    <div class="fleet-filters">
                        <button class="filter-btn active" data-filter="all"><?php esc_html_e( 'All', 'driveease' ); ?></button>
                        <?php
                        $categories = get_terms( [
                            'taxonomy'   => 'car_category',
                            'hide_empty' => false,
                        ] );
                        if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) :
                            foreach ( $categories as $cat ) :
                                printf(
                                    '<button class="filter-btn" data-filter="%s">%s</button>',
                                    esc_attr( sanitize_title( $cat->name ) ),
                                    esc_html( $cat->name )
                                );
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="fleet-grid" id="fleetGrid">
                    <?php
                    $featured_cars = new \WP_Query( [
                        'post_type'      => 'driveease_car',
                        'posts_per_page' => $count,
                        'meta_query'     => [
                            [
                                'key'   => '_car_featured',
                                'value' => '1',
                            ],
                        ],
                    ] );

                    if ( $featured_cars->have_posts() ) :
                        while ( $featured_cars->have_posts() ) :
                            $featured_cars->the_post();

                            $car_id       = get_the_ID();
                            $price        = get_post_meta( $car_id, '_car_price_per_day', true );
                            $seats        = get_post_meta( $car_id, '_car_seats', true );
                            $transmission = get_post_meta( $car_id, '_car_transmission', true );
                            $fuel         = get_post_meta( $car_id, '_car_fuel_type', true );
                            $year         = get_post_meta( $car_id, '_car_year', true );

                            $car_cats = get_the_terms( $car_id, 'car_category' );
                            $cat_name = '';
                            $cat_slug = '';
                            if ( ! is_wp_error( $car_cats ) && ! empty( $car_cats ) ) {
                                $cat_name = $car_cats[0]->name;
                                $cat_slug = sanitize_title( $car_cats[0]->name );
                            }

                            $car_class = $cat_name ? $cat_name . ' Class' : '';
                            if ( $year ) {
                                $car_class .= ' &middot; ' . esc_html( $year );
                            }

                            $thumbnail = get_the_post_thumbnail_url( $car_id, 'medium_large' );
                            if ( ! $thumbnail && defined( 'DRIVEEASE_URI' ) ) {
                                $thumbnail = DRIVEEASE_URI . '/assets/images/car-placeholder.jpg';
                            }
                            ?>
                            <div class="car-card" data-category="<?php echo esc_attr( $cat_slug ); ?>" data-name="<?php echo esc_attr( get_the_title() ); ?>" data-price="<?php echo esc_attr( $price ); ?>">
                                <div class="car-img-wrap">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"/>
                                    </a>
                                    <?php if ( $cat_name ) : ?>
                                        <span class="car-badge" style="background:var(--accent)"><?php echo esc_html( $cat_name ); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="car-body">
                                    <a href="<?php the_permalink(); ?>" class="car-name-link"><?php the_title(); ?></a>
                                    <div class="car-class"><?php echo wp_kses_post( $car_class ); ?></div>
                                    <div class="car-specs">
                                        <?php if ( $seats ) : ?>
                                            <div class="spec"><i class="fa-solid fa-user-group"></i> <?php echo esc_html( $seats ); ?> <?php esc_html_e( 'Seats', 'driveease' ); ?></div>
                                        <?php endif; ?>
                                        <?php if ( $transmission ) : ?>
                                            <div class="spec"><i class="fa-solid fa-gears"></i> <?php echo esc_html( $transmission ); ?></div>
                                        <?php endif; ?>
                                        <?php if ( $fuel ) : ?>
                                            <div class="spec"><i class="fa-solid fa-gas-pump"></i> <?php echo esc_html( $fuel ); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="car-footer">
                                        <div class="price" data-usd="<?php echo esc_attr( $price ); ?>">$<?php echo esc_html( $price ); ?><span class="price-suf"><?php esc_html_e( '/day', 'driveease' ); ?></span></div>
                                        <button class="btn btn-primary open-booking" style="padding:10px 20px;font-size:.85rem"><?php esc_html_e( 'Reserve', 'driveease' ); ?></button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>
        <?php
    }
}
