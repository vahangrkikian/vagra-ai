<?php
namespace Carvice\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class CTA extends Carvice_Widget_Base {

    public function get_name()  { return 'carvice_cta'; }
    public function get_title() { return __( 'Call to Action', 'carvice' ); }
    public function get_icon()  { return 'eicon-call-to-action'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'carvice' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'carvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Need Help with Your Car?', 'carvice' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'carvice' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Describe your issue and let Carvice AI find the perfect specialist for you.', 'carvice' ),
        ] );

        $this->add_control( 'button_text', [
            'label'   => __( 'Button Text', 'carvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Find a Specialist', 'carvice' ),
        ] );

        $this->add_control( 'button_url', [
            'label'   => __( 'Button URL', 'carvice' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/search/' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '/search/';
        ?>
        <section class="carvice-cta">
            <div class="carvice-container">
                <div class="carvice-cta__inner">
                    <h2 class="carvice-cta__title"><?php echo esc_html( $s['title'] ); ?></h2>
                    <p class="carvice-cta__desc"><?php echo esc_html( $s['description'] ); ?></p>
                    <a href="<?php echo esc_url( $url ); ?>" class="carvice-btn carvice-btn--primary">
                        <?php echo esc_html( $s['button_text'] ); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
