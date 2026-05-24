<?php
namespace Meridian\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rooms extends Meridian_Widget_Base {

    public function get_name()  { return 'meridian_rooms'; }
    public function get_title() { return __( 'Meridian Rooms', 'meridian' ); }
    public function get_icon()  { return 'eicon-gallery-grid'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'meridian' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Featured rooms', 'meridian' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Four ways to stay.', 'meridian' ),
        ] );

        $this->add_control( 'count', [
            'label'   => __( 'Number of rooms', 'meridian' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 4,
            'min'     => 1,
            'max'     => 12,
        ] );

        $this->add_control( 'link_text', [
            'label'   => __( 'Link Text', 'meridian' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'View all rooms', 'meridian' ),
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $count = ! empty( $s['count'] ) ? (int) $s['count'] : 4;
        ?>
        <section class="section" id="featured">
            <div class="container">
                <div class="section__head" data-reveal>
                    <div>
                        <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                        <div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div>
                        <?php endif; ?>
                        <h2 class="display"><?php echo esc_html( $s['heading'] ); ?></h2>
                    </div>
                    <?php if ( ! empty( $s['link_text'] ) ) : ?>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'meridian_room' ) ); ?>" class="link-arrow">
                        <?php echo esc_html( $s['link_text'] ); ?>
                        <?php if ( function_exists( 'meridian_icon' ) ) echo meridian_icon( 'arrow-right', 14 ); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="rooms-grid">
                    <?php
                    $rooms_query = new \WP_Query( array(
                        'post_type'      => 'meridian_room',
                        'posts_per_page' => $count,
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC',
                    ) );
                    $room_index = 0;
                    if ( $rooms_query->have_posts() ) :
                        while ( $rooms_query->have_posts() ) :
                            $rooms_query->the_post();
                            set_query_var( 'room_index', $room_index );
                            get_template_part( 'template-parts/room-card' );
                            $room_index++;
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
