<?php
namespace DriveEase\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class CTA extends DriveEase_Widget_Base {

    public function get_name()  { return 'driveease_cta'; }
    public function get_title() { return __( 'Call to Action', 'driveease' ); }
    public function get_icon()  { return 'eicon-call-to-action'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'driveease' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Ready to Hit the Road?', 'driveease' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'driveease' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Browse our fleet of premium vehicles and book your perfect ride in under two minutes.', 'driveease' ),
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'Button Text', 'driveease' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Browse Fleet', 'driveease' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'Button URL', 'driveease' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#fleet' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '#fleet';
        ?>
        <section class="driveease-cta">
            <div class="container">
                <div class="driveease-cta__inner">
                    <h2><?php echo esc_html( $s['heading'] ); ?></h2>
                    <p><?php echo esc_html( $s['description'] ); ?></p>
                    <a href="<?php echo esc_url( $url ); ?>" class="btn btn-primary">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
