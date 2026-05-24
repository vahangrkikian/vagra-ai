<?php
namespace VagraMSP\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class CTA extends MSP_Widget_Base {

    public function get_name()  { return 'vagra_msp_cta'; }
    public function get_title() { return __( 'MSP Call to Action', 'vagra-msp' ); }
    public function get_icon()  { return 'eicon-call-to-action'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-msp' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Ready to Secure Your Business?', 'vagra-msp' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Get a free, no-obligation security assessment. Our experts will identify vulnerabilities and recommend a protection plan tailored to your business.', 'vagra-msp' ),
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'Button Text', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Schedule Your Free Assessment', 'vagra-msp' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'Button URL', 'vagra-msp' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/contact/' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '/contact/';
        ?>
        <section class="vagra-cta" id="contact">
            <div class="vagra-container">
                <div class="vagra-cta__content">
                    <h2 class="vagra-cta__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <p class="vagra-cta__desc"><?php echo esc_html( $s['description'] ); ?></p>
                    <a href="<?php echo esc_url( $url ); ?>" class="vagra-btn vagra-btn--cta">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
