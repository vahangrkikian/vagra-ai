<?php
namespace VagraNSL\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Blog_Teaser extends NSL_Widget_Base {

    public function get_name() {
        return 'vagra_nsl_blog_teaser';
    }

    public function get_title() {
        return __( 'Blog Teaser', 'vagra-nslookup' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Blog', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-nslookup' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Latest from the team', 'vagra-nslookup' ),
        ] );

        $this->add_control( 'posts_count', [
            'label'   => __( 'Number of posts', 'vagra-nslookup' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 4,
            'min'     => 1,
            'max'     => 12,
        ] );

        $this->add_control( 'show_date', [
            'label'        => __( 'Show date', 'vagra-nslookup' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => __( 'Yes', 'vagra-nslookup' ),
            'label_off'    => __( 'No', 'vagra-nslookup' ),
            'return_value' => 'yes',
        ] );

        $this->add_control( 'show_excerpt', [
            'label'        => __( 'Show excerpt', 'vagra-nslookup' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => __( 'Yes', 'vagra-nslookup' ),
            'label_off'    => __( 'No', 'vagra-nslookup' ),
            'return_value' => 'yes',
        ] );

        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Style', 'vagra-nslookup' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_bg', [
            'label'     => __( 'Card Background', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-blog-card' => 'background-color: {{VALUE}}' ],
        ] );

        $this->add_control( 'title_color', [
            'label'     => __( 'Title Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-blog-card-title' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'excerpt_color', [
            'label'     => __( 'Excerpt Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-blog-card-excerpt' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'date_color', [
            'label'     => __( 'Date Color', 'vagra-nslookup' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .nsl-blog-card-date' => 'color: {{VALUE}}' ],
        ] );

        $this->add_control( 'card_border_radius', [
            'label'      => __( 'Border Radius', 'vagra-nslookup' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'default'    => [ 'size' => 12, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .nsl-blog-card' => 'border-radius: {{SIZE}}{{UNIT}}' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $query = new \WP_Query( array(
            'posts_per_page'      => absint( $s['posts_count'] ),
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        ) );

        if ( ! $query->have_posts() ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<p style="padding:40px;text-align:center;color:#6B7689;">' . esc_html__( 'No posts found. Publish some posts to see them here.', 'vagra-nslookup' ) . '</p>';
            }
            return;
        }
        ?>
        <section class="cine-section" style="background:#fff" data-reveal>
            <div class="cine-head-wrap">
                <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                    <span class="cine-section-eyebrow reveal"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $s['heading'] ) ) : ?>
                    <h2 class="cine-big-head reveal reveal-delay-1"><?php echo esc_html( $s['heading'] ); ?></h2>
                <?php endif; ?>

                <div class="nsl-blog-grid" style="margin-top:56px">
                    <?php
                    $bi = 0;
                    while ( $query->have_posts() ) :
                        $query->the_post();
                        $delay = 80 * $bi;
                    ?>
                        <article class="nsl-blog-card reveal" style="transition-delay:<?php echo esc_attr( $delay ); ?>ms">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="nsl-blog-thumb" aria-hidden="true">
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                </a>
                            <?php endif; ?>
                            <div class="nsl-blog-body">
                                <?php if ( 'yes' === $s['show_date'] ) : ?>
                                    <time class="nsl-blog-meta" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </time>
                                <?php endif; ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <?php if ( 'yes' === $s['show_excerpt'] ) : ?>
                                    <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php
                        $bi++;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
        <?php
    }
}
