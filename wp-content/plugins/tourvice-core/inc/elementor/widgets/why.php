<?php
namespace TourVice\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Why extends TourVice_Widget_Base {

    public function get_name()  { return 'tourvice_why'; }
    public function get_title() { return __( 'Why Choose Us', 'tourvice' ); }
    public function get_icon()  { return 'eicon-info-circle'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'tourvice' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'tourvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Why Choose TourVice', 'tourvice' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'icon_name', [
            'label'   => __( 'Icon', 'tourvice' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'guide'    => __( 'Expert Guide', 'tourvice' ),
                'luxury'   => __( 'Luxury', 'tourvice' ),
                'custom'   => __( 'Custom Itinerary', 'tourvice' ),
                'safety'   => __( 'Safety', 'tourvice' ),
                'support'  => __( '24/7 Support', 'tourvice' ),
                'value'    => __( 'Best Value', 'tourvice' ),
            ],
            'default' => 'guide',
        ] );

        $repeater->add_control( 'title', [
            'label' => __( 'Title', 'tourvice' ),
            'type'  => Controls_Manager::TEXT,
        ] );

        $repeater->add_control( 'desc', [
            'label' => __( 'Description', 'tourvice' ),
            'type'  => Controls_Manager::TEXTAREA,
        ] );

        $this->add_control( 'reasons', [
            'label'   => __( 'Reasons', 'tourvice' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'icon_name' => 'guide',  'title' => 'Expert Local Guides',    'desc' => 'Our guides are passionate locals who bring Armenia\'s history and culture to life.' ],
                [ 'icon_name' => 'luxury', 'title' => 'Luxury Accommodations',  'desc' => 'Stay in handpicked boutique hotels and luxury resorts throughout your journey.' ],
                [ 'icon_name' => 'custom', 'title' => 'Custom Itineraries',     'desc' => 'Every tour is tailored to your preferences, pace, and interests.' ],
                [ 'icon_name' => 'safety', 'title' => 'Safety First',           'desc' => 'Comprehensive safety protocols and insurance for complete peace of mind.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="tourvice-why" id="why">
            <div class="container">
                <div class="tourvice-section-header">
                    <h2 class="tourvice-section-header__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                </div>
                <div class="tourvice-why__grid">
                    <?php foreach ( $s['reasons'] as $reason ) : ?>
                    <div class="tourvice-why-card">
                        <div class="tourvice-why-card__icon">
                            <?php echo $this->get_reason_icon( $reason['icon_name'] ); ?>
                        </div>
                        <h3 class="tourvice-why-card__title"><?php echo esc_html( $reason['title'] ); ?></h3>
                        <p class="tourvice-why-card__desc"><?php echo esc_html( $reason['desc'] ); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    private function get_reason_icon( $name ) {
        $icons = [
            'guide'   => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="16" r="8" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2.5" fill="none"/><path d="M12 40c0-7 5-12 12-12s12 5 12 12" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2.5" stroke-linecap="round" fill="none"/><path d="M30 12l4-4" stroke="var(--tourvice-accent, #2d5016)" stroke-width="2" stroke-linecap="round"/><circle cx="36" cy="6" r="3" stroke="var(--tourvice-accent, #2d5016)" stroke-width="2" fill="none"/></svg>',
            'luxury'  => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M24 4l4 12h12l-10 7 4 12-10-7-10 7 4-12L8 16h12z" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2.5" fill="none"/></svg>',
            'custom'  => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect x="8" y="8" width="32" height="32" rx="4" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2.5" fill="none"/><path d="M16 16h16M16 24h10M16 32h14" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2" stroke-linecap="round"/><path d="M34 28l4 4-4 4" stroke="var(--tourvice-accent, #2d5016)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'safety'  => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M24 4L8 12v12c0 10 7 18 16 20 9-2 16-10 16-20V12L24 4z" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2.5" fill="none"/><path d="M18 24l4 4 8-8" stroke="var(--tourvice-accent, #2d5016)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'support' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="16" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2.5" fill="none"/><path d="M24 14v10l6 6" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="24" cy="24" r="2" fill="var(--tourvice-accent, #2d5016)"/></svg>',
            'value'   => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="16" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2.5" fill="none"/><path d="M20 20c0-2.2 1.8-4 4-4s4 1.8 4 4-1.8 4-4 4-4 1.8-4 4 1.8 4 4 4" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2" stroke-linecap="round"/><path d="M24 14v2M24 32v2" stroke="var(--tourvice-primary, #c8a55a)" stroke-width="2" stroke-linecap="round"/></svg>',
        ];
        return $icons[ $name ] ?? '';
    }
}
