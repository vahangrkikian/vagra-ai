<?php
namespace VagraMSP\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hero extends MSP_Widget_Base {

    public function get_name()  { return 'vagra_msp_hero'; }
    public function get_title() { return __( 'MSP Hero', 'vagra-msp' ); }
    public function get_icon()  { return 'eicon-header'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-msp' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Protect Your Business with Enterprise-Grade Cybersecurity', 'vagra-msp' ),
        ] );

        $this->add_control( 'subtitle', [
            'label'   => __( 'Subtitle', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Managed security services built for growing businesses. From email protection to 24/7 monitoring, we keep your data safe so you can focus on what matters.', 'vagra-msp' ),
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'CTA Text', 'vagra-msp' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Get a Free Security Assessment', 'vagra-msp' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'CTA URL', 'vagra-msp' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#contact' ],
        ] );

        $this->add_control( 'bg_image', [
            'label' => __( 'Background Image', 'vagra-msp' ),
            'type'  => Controls_Manager::MEDIA,
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '#contact';
        $bg  = ! empty( $s['bg_image']['url'] ) ? ' style="background-image:url(' . esc_url( $s['bg_image']['url'] ) . ')"' : '';
        ?>
        <section class="vagra-hero"<?php echo $bg; ?>>
            <div class="vagra-container">
                <div class="vagra-hero__content">
                    <h1 class="vagra-hero__title"><?php echo esc_html( $s['title'] ); ?></h1>
                    <p class="vagra-hero__subtitle"><?php echo esc_html( $s['subtitle'] ); ?></p>
                    <a href="<?php echo esc_url( $url ); ?>" class="vagra-btn vagra-btn--primary vagra-hero__cta">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                    </a>
                </div>
                <div class="vagra-hero__visual">
                    <div class="vagra-hero__shield">
                        <svg width="200" height="240" viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M100 10L185 50V130C185 180 145 220 100 235C55 220 15 180 15 130V50L100 10Z" fill="var(--vagra-primary)" opacity="0.15" stroke="var(--vagra-primary)" stroke-width="3"/>
                            <path d="M80 125L95 140L125 105" stroke="var(--vagra-success)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
