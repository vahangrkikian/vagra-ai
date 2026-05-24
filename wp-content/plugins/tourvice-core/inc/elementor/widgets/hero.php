<?php
namespace TourVice\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hero extends TourVice_Widget_Base {

    public function get_name()  { return 'tourvice_hero'; }
    public function get_title() { return __( 'Tour Hero', 'tourvice' ); }
    public function get_icon()  { return 'eicon-header'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'tourvice' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'tourvice' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Discover the Beauty of Armenia', 'tourvice' ),
        ] );

        $this->add_control( 'subtitle', [
            'label'   => __( 'Subtitle', 'tourvice' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Experience breathtaking landscapes, ancient monasteries, and vibrant culture with our expertly crafted luxury tours.', 'tourvice' ),
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'CTA Text', 'tourvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Explore Tours', 'tourvice' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'CTA URL', 'tourvice' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#tours' ],
        ] );

        $this->add_control( 'bg_image', [
            'label' => __( 'Background Image', 'tourvice' ),
            'type'  => Controls_Manager::MEDIA,
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '#tours';
        $bg  = ! empty( $s['bg_image']['url'] ) ? ' style="background-image:url(' . esc_url( $s['bg_image']['url'] ) . ')"' : '';
        ?>
        <section class="tourvice-hero"<?php echo $bg; ?>>
            <div class="container">
                <div class="tourvice-hero__content">
                    <h1 class="tourvice-hero__title"><?php echo esc_html( $s['title'] ); ?></h1>
                    <p class="tourvice-hero__subtitle"><?php echo esc_html( $s['subtitle'] ); ?></p>
                    <a href="<?php echo esc_url( $url ); ?>" class="tourvice-btn tourvice-hero__cta">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
