<?php
namespace HouseService\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Providers extends HS_Widget_Base {

    public function get_name()  { return 'hs_providers'; }
    public function get_title() { return __( 'HS Providers', 'house-service' ); }
    public function get_icon()  { return 'eicon-person'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'house-service' ),
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Top rated', 'house-service' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'house-service' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Featured providers', 'house-service' ),
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'house-service' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'Vetted companies with outstanding track records and verified reviews.', 'house-service' ),
        ] );

        $this->add_control( 'count', [
            'label'   => __( 'Number of Providers', 'house-service' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 3,
            'min'     => 1,
            'max'     => 12,
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $archive_url = get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' );
        ?>
        <section class="section" id="providers">
            <div class="shell">
                <div class="section__head">
                    <div>
                        <div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div>
                        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
                        <p class="lead"><?php echo esc_html( $s['description'] ); ?></p>
                    </div>
                    <a href="<?php echo esc_url( $archive_url ); ?>" class="head-link">
                        <?php esc_html_e( 'View all', 'house-service' ); ?>
                        <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'arrow', 18 ) : ''; ?>
                    </a>
                </div>

                <div class="co-grid">
                    <?php
                    $providers_query = new \WP_Query( [
                        'post_type'      => 'hs_provider',
                        'posts_per_page' => absint( $s['count'] ),
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ] );

                    if ( $providers_query->have_posts() ) :
                        while ( $providers_query->have_posts() ) :
                            $providers_query->the_post();
                            get_template_part( 'template-parts/provider-card' );
                        endwhile;
                        wp_reset_postdata();
                    else :
                        $demo_providers = [
                            [
                                'name'     => 'SparkleClean Co.',
                                'tagline'  => 'Premium residential & commercial cleaning',
                                'category' => 'Cleaning',
                                'rating'   => '4.9',
                                'reviews'  => '127',
                                'location' => 'Los Angeles, CA',
                                'tags'     => [ 'Deep Clean', 'Move-out', 'Office' ],
                            ],
                            [
                                'name'     => 'SwiftMove Logistics',
                                'tagline'  => 'Local & long-distance moving specialists',
                                'category' => 'Moving',
                                'rating'   => '4.8',
                                'reviews'  => '89',
                                'location' => 'San Francisco, CA',
                                'tags'     => [ 'Local', 'Long-distance', 'Packing' ],
                            ],
                            [
                                'name'     => 'FixRight Repairs',
                                'tagline'  => 'Plumbing, electrical & general handyman',
                                'category' => 'Repair',
                                'rating'   => '4.7',
                                'reviews'  => '203',
                                'location' => 'Austin, TX',
                                'tags'     => [ 'Plumbing', 'Electrical', 'Drywall' ],
                            ],
                        ];

                        foreach ( array_slice( $demo_providers, 0, absint( $s['count'] ) ) as $dp ) :
                        ?>
                        <div class="co-card">
                            <div class="co-card__image">
                                <div class="ph"></div>
                                <span class="co-card__badge"><?php echo esc_html( $dp['category'] ); ?></span>
                                <span class="co-card__verified"><?php echo function_exists( 'hs_icon' ) ? hs_icon( 'check', 14 ) : ''; ?></span>
                            </div>
                            <div class="co-card__body">
                                <h3 class="co-card__name"><?php echo esc_html( $dp['name'] ); ?></h3>
                                <p class="co-card__tagline"><?php echo esc_html( $dp['tagline'] ); ?></p>
                                <div class="co-card__rating">
                                    <?php echo function_exists( 'hs_render_stars' ) ? hs_render_stars( floatval( $dp['rating'] ) ) : ''; ?>
                                    <span class="co-card__rating-num"><?php echo esc_html( $dp['rating'] ); ?></span>
                                    <span class="co-card__rating-count">(<?php echo esc_html( $dp['reviews'] ); ?>)</span>
                                </div>
                                <div class="co-card__tags">
                                    <?php foreach ( $dp['tags'] as $tag ) : ?>
                                        <span class="tag"><?php echo esc_html( $tag ); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="co-card__foot">
                                <span class="co-card__location">
                                    <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'pin', 14 ) : ''; ?>
                                    <?php echo esc_html( $dp['location'] ); ?>
                                </span>
                                <span class="co-card__link">
                                    <?php esc_html_e( 'View profile', 'house-service' ); ?>
                                    <?php echo function_exists( 'hs_icon' ) ? hs_icon( 'arrow', 16 ) : ''; ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </section>
        <?php
    }
}
