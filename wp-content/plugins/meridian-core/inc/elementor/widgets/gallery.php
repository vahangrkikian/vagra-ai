<?php
namespace Meridian\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Gallery extends Meridian_Widget_Base {

    public function get_name()  { return 'meridian_gallery'; }
    public function get_title() { return __( 'Meridian Gallery', 'meridian' ); }
    public function get_icon()  { return 'eicon-gallery-masonry'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'meridian' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Gallery', 'meridian' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Inside the building.', 'meridian' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'meridian' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'A look at the spaces — the lobby, the rooftop, the rooms, the bar.', 'meridian' ),
        ] );

        $this->add_control( 'images', [
            'label'   => __( 'Gallery Images', 'meridian' ),
            'type'    => Controls_Manager::GALLERY,
            'default' => [],
        ] );

        $this->end_controls_section();

        /* ── Style tab ─────────────────────────────────────────── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Style', 'meridian' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'meridian' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'title_size', [
            'label'      => __( 'Title Font Size', 'meridian' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .display' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'content_align', [
            'label'   => __( 'Alignment', 'meridian' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => __( 'Left', 'meridian' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'meridian' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'meridian' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [
                '{{WRAPPER}} .section' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'   => __( 'Columns', 'meridian' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '3',
            'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
            'selectors' => [
                '{{WRAPPER}} .gallery' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'meridian' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors'  => [
                '{{WRAPPER}} .gallery' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $images = ! empty( $s['images'] ) ? $s['images'] : [];

        // Fall back to room CPT images if no gallery images are set.
        if ( empty( $images ) ) {
            $img_query = new \WP_Query( array(
                'post_type'      => 'meridian_room',
                'posts_per_page' => 8,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ) );
            if ( $img_query->have_posts() ) :
                while ( $img_query->have_posts() ) :
                    $img_query->the_post();
                    $url = get_the_post_thumbnail_url( get_the_ID(), 'meridian-gallery' );
                    if ( $url ) {
                        $images[] = [ 'url' => $url, 'id' => get_post_thumbnail_id() ];
                    }
                endwhile;
                wp_reset_postdata();
            endif;
        }
        ?>
        <section class="section" id="gallery">
            <div class="container">
                <div class="section__head" data-reveal>
                    <div>
                        <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                        <div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div>
                        <?php endif; ?>
                        <h2 class="display"><?php echo esc_html( $s['heading'] ); ?></h2>
                    </div>
                    <?php if ( ! empty( $s['description'] ) ) : ?>
                    <p class="section__lede"><?php echo esc_html( $s['description'] ); ?></p>
                    <?php endif; ?>
                </div>
                <div class="gallery" id="meridian-gallery">
                    <?php foreach ( $images as $i => $img ) :
                        $tall_class = ( $i % 5 === 0 ) ? ' gallery__tile--tall' : '';
                        $caption = ! empty( $img['alt'] ) ? $img['alt'] : '';
                    ?>
                    <button type="button" class="gallery__tile<?php echo $tall_class; ?>" data-reveal style="--d: <?php echo $i * 50; ?>ms" data-index="<?php echo $i; ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
                        <img src="<?php echo esc_url( $img['url'] ); ?>" alt="<?php echo esc_attr( $caption ); ?>" loading="lazy" />
                    </button>
                    <?php endforeach; ?>
                    <?php if ( empty( $images ) ) : ?>
                    <p style="color:var(--navy-400);font-size:14px;"><?php esc_html_e( 'No gallery images yet. Add images in the widget settings or create rooms with featured images.', 'meridian' ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
