<?php
namespace TourVice\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Featured_Tours extends TourVice_Widget_Base {

    public function get_name()  { return 'tourvice_featured_tours'; }
    public function get_title() { return __( 'Featured Tours', 'tourvice' ); }
    public function get_icon()  { return 'eicon-gallery-grid'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'tourvice' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'tourvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Featured Tours', 'tourvice' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'tourvice' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Handpicked journeys through Armenia\'s most spectacular destinations.', 'tourvice' ),
        ] );

        $this->add_control( 'count', [
            'label'   => __( 'Number of Tours', 'tourvice' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 6,
            'min'     => 1,
            'max'     => 12,
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'View All Text', 'tourvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'View All Tours', 'tourvice' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'View All URL', 'tourvice' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/tour/' ],
        ] );

        $this->end_controls_section();

        /* ── Style Tab ─────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'tourvice' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'tourvice' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .tourvice-featured-tours' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'tourvice' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .tourvice-section-header__title' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'tourvice' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'tourvice' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'tourvice' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'tourvice' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [
                '{{WRAPPER}} .tourvice-featured-tours' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'tourvice' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [
                '{{WRAPPER}} .tourvice-tours-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'tourvice' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [
                '{{WRAPPER}} .tourvice-tours-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s     = $this->get_settings_for_display();
        $count = ! empty( $s['count'] ) ? (int) $s['count'] : 6;
        $url   = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '/tour/';

        $tours = new \WP_Query( [
            'post_type'      => 'vagra_tour',
            'posts_per_page' => $count,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ] );
        ?>
        <section class="tourvice-featured-tours" id="tours">
            <div class="container">
                <div class="tourvice-section-header">
                    <h2 class="tourvice-section-header__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <p class="tourvice-section-header__desc"><?php echo esc_html( $s['description'] ); ?></p>
                </div>

                <?php if ( $tours->have_posts() ) : ?>
                <div class="tourvice-tours-grid">
                    <?php while ( $tours->have_posts() ) : $tours->the_post();
                        $price    = get_post_meta( get_the_ID(), '_tour_price', true );
                        $duration = get_post_meta( get_the_ID(), '_tour_duration', true );
                        $rating   = get_post_meta( get_the_ID(), '_tour_rating', true );
                    ?>
                    <div class="tourvice-tour-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                        <div class="tourvice-tour-card__image">
                            <?php the_post_thumbnail( 'medium_large' ); ?>
                        </div>
                        <?php endif; ?>
                        <div class="tourvice-tour-card__body">
                            <h3 class="tourvice-tour-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="tourvice-tour-card__meta">
                                <?php if ( $duration ) : ?>
                                <span class="tourvice-tour-card__duration"><?php echo esc_html( $duration ); ?></span>
                                <?php endif; ?>
                                <?php if ( $rating ) : ?>
                                <span class="tourvice-tour-card__rating"><?php echo esc_html( $rating ); ?>/5</span>
                                <?php endif; ?>
                            </div>
                            <?php if ( has_excerpt() ) : ?>
                            <p class="tourvice-tour-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
                            <?php endif; ?>
                            <?php if ( $price ) : ?>
                            <div class="tourvice-tour-card__price">
                                <?php printf( '$%s', esc_html( number_format( (float) $price, 0 ) ) ); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <div class="tourvice-featured-tours__footer">
                    <a href="<?php echo esc_url( $url ); ?>" class="tourvice-btn">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                    </a>
                </div>
                <?php else : ?>
                <p class="tourvice-no-tours"><?php esc_html_e( 'No tours found. Add tours via the Tours menu in wp-admin.', 'tourvice' ); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
