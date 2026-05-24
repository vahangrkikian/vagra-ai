<?php
namespace Carvice\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Providers extends Carvice_Widget_Base {

    public function get_name()  { return 'carvice_providers'; }
    public function get_title() { return __( 'Providers', 'carvice' ); }
    public function get_icon()  { return 'eicon-person'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'carvice' ),
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', 'carvice' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Top Service Centers', 'carvice' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'carvice' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Find the best car service providers in your area.', 'carvice' ),
        ] );

        $this->add_control( 'provider_type', [
            'label'   => __( 'Provider Type', 'carvice' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'all'        => __( 'All', 'carvice' ),
                'center'     => __( 'Service Centers', 'carvice' ),
                'individual' => __( 'Individual Specialists', 'carvice' ),
                'dealer'     => __( 'Official Dealers', 'carvice' ),
            ],
            'default' => 'all',
        ] );

        $this->add_control( 'count', [
            'label'   => __( 'Number of Providers', 'carvice' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 10,
            'min'     => 1,
            'max'     => 20,
        ] );

        $this->add_control( 'see_more_url', [
            'label'   => __( 'See More URL', 'carvice' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/search/' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['see_more_url']['url'] ) ? $s['see_more_url']['url'] : '/search/';

        $query_args = [
            'post_type'      => 'carvice_provider',
            'posts_per_page' => absint( $s['count'] ),
            'orderby'        => 'meta_value_num',
            'meta_key'       => '_carvice_rating',
            'order'          => 'DESC',
        ];

        if ( 'all' !== $s['provider_type'] ) {
            if ( 'center' === $s['provider_type'] ) {
                $query_args['meta_query'] = [
                    [
                        'key'     => '_carvice_provider_type',
                        'value'   => [ 'center', 'dealer' ],
                        'compare' => 'IN',
                    ],
                ];
            } else {
                $query_args['meta_query'] = [
                    [
                        'key'   => '_carvice_provider_type',
                        'value' => $s['provider_type'],
                    ],
                ];
            }
        }

        $providers = new \WP_Query( $query_args );
        ?>
        <section class="carvice-providers-section">
            <div class="carvice-container">
                <div class="carvice-section-header">
                    <h2 class="carvice-section-header__title"><?php echo esc_html( $s['title'] ); ?></h2>
                    <a href="<?php echo esc_url( $url ); ?>" class="carvice-section-header__link">
                        <?php esc_html_e( 'See more', 'carvice' ); ?> &rarr;
                    </a>
                </div>
                <?php if ( ! empty( $s['description'] ) ) : ?>
                <p class="carvice-section-header__desc"><?php echo esc_html( $s['description'] ); ?></p>
                <?php endif; ?>
                <div class="carvice-providers-grid">
                    <?php
                    if ( $providers->have_posts() ) :
                        while ( $providers->have_posts() ) :
                            $providers->the_post();
                            get_template_part( 'template-parts/provider-card' );
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <p class="carvice-no-content"><?php esc_html_e( 'No providers found. Add providers in the admin panel.', 'carvice' ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
