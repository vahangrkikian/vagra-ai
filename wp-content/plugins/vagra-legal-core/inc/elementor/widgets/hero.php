<?php
namespace VagraLegal\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hero extends Legal_Widget_Base {

    public function get_name()  { return 'vagra_legal_hero'; }
    public function get_title() { return __( 'Legal Hero', 'vagra-legal' ); }
    public function get_icon()  { return 'eicon-header'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'vagra-legal' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Experienced Legal Counsel You Can Trust', 'vagra-legal' ),
        ] );

        $this->add_control( 'subtitle', [
            'label'   => __( 'Subtitle', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Dedicated attorneys fighting for your rights. From personal injury to business law, we provide the skilled representation you deserve.', 'vagra-legal' ),
        ] );

        $this->add_control( 'cta_text', [
            'label'   => __( 'CTA Text', 'vagra-legal' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Schedule a Free Consultation', 'vagra-legal' ),
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'CTA URL', 'vagra-legal' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '#contact' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $url = ! empty( $s['cta_url']['url'] ) ? $s['cta_url']['url'] : '#contact';
        ?>
        <section class="vagra-hero">
            <div class="vagra-container">
                <div class="vagra-hero__content">
                    <h1 class="vagra-hero__title"><?php echo esc_html( $s['title'] ); ?></h1>
                    <p class="vagra-hero__subtitle"><?php echo esc_html( $s['subtitle'] ); ?></p>
                    <a href="<?php echo esc_url( $url ); ?>" class="vagra-btn vagra-hero__cta">
                        <?php echo esc_html( $s['cta_text'] ); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
