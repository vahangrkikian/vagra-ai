<?php
namespace HouseService\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class Categories extends HS_Widget_Base {

    public function get_name()  { return 'hs_categories'; }
    public function get_title() { return __( 'HS Categories', 'house-service' ); }
    public function get_icon()  { return 'eicon-gallery-grid'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'house-service' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Categories', 'house-service' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'What can we help with?', 'house-service' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'house-service' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Browse by service type to find the right team for the job.', 'house-service' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'icon_name', [
            'label'   => __( 'Icon', 'house-service' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'cleaning' => __( 'Cleaning', 'house-service' ),
                'moving'   => __( 'Moving', 'house-service' ),
                'repair'   => __( 'Repair', 'house-service' ),
                'assembly' => __( 'Assembly', 'house-service' ),
            ],
            'default' => 'cleaning',
        ] );

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Category', 'house-service' ),
        ] );

        $repeater->add_control( 'desc', [
            'label'   => __( 'Description', 'house-service' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => '',
        ] );

        $repeater->add_control( 'count', [
            'label'   => __( 'Provider Count', 'house-service' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 0,
        ] );

        $this->add_control( 'categories', [
            'label'   => __( 'Categories', 'house-service' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'title' => 'Cleaning', 'desc' => 'Deep cleans, move-out, office cleaning, and regular maintenance.', 'icon_name' => 'cleaning', 'count' => 64 ],
                [ 'title' => 'Moving', 'desc' => 'Local moves, long-distance, packing services, and storage.', 'icon_name' => 'moving', 'count' => 38 ],
                [ 'title' => 'Repair', 'desc' => 'Plumbing, electrical, HVAC, appliance repair, and handyman.', 'icon_name' => 'repair', 'count' => 92 ],
                [ 'title' => 'Assembly', 'desc' => 'Furniture assembly, TV mounting, shelving, and installations.', 'icon_name' => 'assembly', 'count' => 51 ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $archive_url = get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' );
        ?>
        <section class="section" id="categories">
            <div class="shell">
                <div class="section__head">
                    <div>
                        <div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div>
                        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
                        <p class="lead"><?php echo esc_html( $s['description'] ); ?></p>
                    </div>
                    <a href="<?php echo esc_url( home_url( '/categories/' ) ); ?>" class="head-link">
                        <?php esc_html_e( 'All categories', 'house-service' ); ?>
                        <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'arrow', 18 ) : ''; ?>
                    </a>
                </div>

                <div class="cat-grid">
                    <?php foreach ( $s['categories'] as $cat ) : ?>
                    <a href="<?php echo esc_url( add_query_arg( 'hs_cat', sanitize_title( $cat['title'] ), $archive_url ) ); ?>" class="cat-card">
                        <div class="cat-card__icon"><?php echo $this->get_cat_icon( $cat['icon_name'] ); ?></div>
                        <h3 class="cat-card__title"><?php echo esc_html( $cat['title'] ); ?></h3>
                        <p class="cat-card__desc"><?php echo esc_html( $cat['desc'] ); ?></p>
                        <div class="cat-card__foot">
                            <span class="cat-card__count">
                                <?php
                                printf(
                                    esc_html__( '%d providers', 'house-service' ),
                                    absint( $cat['count'] )
                                );
                                ?>
                            </span>
                            <span class="cat-card__arrow"><?php echo function_exists( 'hs_icon' ) ? hs_icon( 'arrow', 16 ) : ''; ?></span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    private function get_cat_icon( $name ) {
        $icons = [
            'cleaning' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6l3 1 2 3v6l-2 4h4l-2-4v-6l2-3 3-1"/><path d="M14 4l1 2h6l1-2"/><circle cx="12" cy="20" r="2"/></svg>',
            'moving'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="6" width="22" height="12" rx="2"/><path d="M1 10h22"/><path d="M6 18v2"/><path d="M18 18v2"/></svg>',
            'repair'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>',
            'assembly' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/><path d="M12 12v4"/><path d="M10 14h4"/></svg>',
        ];
        return $icons[ $name ] ?? '';
    }
}
