<?php
/**
 * Front page template.
 *
 * @package Carvice
 */

get_header();
?>

<main id="primary" class="carvice-main">

    <!-- Hero Section -->
    <section class="carvice-hero">
        <img
            src="https://images.unsplash.com/photo-1487754180451-c456f719a1fc?w=1440&h=500&fit=crop"
            alt=""
            class="carvice-hero__bg"
        />
        <div class="carvice-container carvice-hero__content">
            <div class="carvice-hero__text">
                <h1 class="carvice-hero__title"><?php esc_html_e( "Don't know who to turn to?", 'carvice' ); ?></h1>
                <p class="carvice-hero__desc"><?php esc_html_e( 'Describe your car problem and Carvice AI will find the right specialist for you.', 'carvice' ); ?></p>
            </div>
        </div>
    </section>

    <!-- Service Categories -->
    <section class="carvice-categories">
        <div class="carvice-categories__bg"></div>
        <div class="carvice-container carvice-categories__inner">
            <?php
            $service_cats = get_terms( array(
                'taxonomy'   => 'carvice_service_cat',
                'hide_empty' => false,
                'number'     => 6,
            ) );

            if ( ! empty( $service_cats ) && ! is_wp_error( $service_cats ) ) :
            ?>
                <div class="carvice-categories__grid">
                    <?php foreach ( $service_cats as $cat ) : ?>
                        <a href="<?php echo esc_url( home_url( '/search/?category=' . $cat->slug ) ); ?>" class="carvice-category-card" data-category="<?php echo esc_attr( $cat->slug ); ?>">
                            <div class="carvice-category-card__icon">
                                <?php get_template_part( 'template-parts/category-icon', $cat->slug ); ?>
                            </div>
                            <h3 class="carvice-category-card__name"><?php echo esc_html( $cat->name ); ?></h3>
                            <p class="carvice-category-card__desc"><?php echo esc_html( $cat->description ); ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="carvice-categories__grid">
                    <?php
                    $default_cats = array(
                        array( 'slug' => 'body-repair', 'name' => 'Car Body', 'desc' => 'Body repair / dent fixing' ),
                        array( 'slug' => 'engine', 'name' => 'Engine', 'desc' => 'Motor specialist' ),
                        array( 'slug' => 'electrical', 'name' => 'Electrical', 'desc' => 'Diagnostics / electrician' ),
                        array( 'slug' => 'chassis', 'name' => 'Chassis', 'desc' => 'Body / chassis' ),
                        array( 'slug' => 'wheels', 'name' => 'Wheels / Tires', 'desc' => 'Vulcanization / tire service' ),
                        array( 'slug' => 'interior', 'name' => 'Interior', 'desc' => 'Cabin servicing' ),
                    );
                    foreach ( $default_cats as $cat ) :
                    ?>
                        <a href="<?php echo esc_url( home_url( '/?s=&carvice_service_cat=' . $cat['slug'] ) ); ?>" class="carvice-category-card" data-category="<?php echo esc_attr( $cat['slug'] ); ?>">
                            <div class="carvice-category-card__icon">
                                <?php get_template_part( 'template-parts/category-icon', $cat['slug'] ); ?>
                            </div>
                            <h3 class="carvice-category-card__name"><?php echo esc_html( $cat['name'] ); ?></h3>
                            <p class="carvice-category-card__desc"><?php echo esc_html( $cat['desc'] ); ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Service Filter Pills -->
    <section class="carvice-filter-pills">
        <div class="carvice-container">
            <?php
            $service_types = get_terms( array(
                'taxonomy'   => 'carvice_service_type',
                'hide_empty' => false,
            ) );

            if ( ! empty( $service_types ) && ! is_wp_error( $service_types ) ) :
            ?>
                <div class="carvice-pills">
                    <?php foreach ( $service_types as $type ) : ?>
                        <a href="<?php echo esc_url( get_term_link( $type ) ); ?>" class="carvice-pill" data-term-id="<?php echo esc_attr( $type->term_id ); ?>">
                            <?php echo esc_html( $type->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="carvice-pills">
                    <?php
                    $default_types = array( 'Air Condition', 'Oil Change', 'AKP', 'Detailing', 'Gas', 'Window Tint', 'Car Wrap', 'Audio System', 'Transmission', 'Auto Tuning', 'Engine Tuning' );
                    foreach ( $default_types as $type_name ) :
                    ?>
                        <span class="carvice-pill"><?php echo esc_html( $type_name ); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Top Service Centers -->
    <section class="carvice-providers-section">
        <div class="carvice-container">
            <div class="carvice-section-header">
                <h2 class="carvice-section-header__title"><?php esc_html_e( 'Top Service Centers', 'carvice' ); ?></h2>
                <a href="<?php echo esc_url( home_url( '/search/?type=company' ) ); ?>" class="carvice-section-header__link">
                    <?php esc_html_e( 'See more', 'carvice' ); ?> &rarr;
                </a>
            </div>
            <div class="carvice-providers-grid">
                <?php
                $centers = new WP_Query( array(
                    'post_type'      => 'carvice_provider',
                    'posts_per_page' => 10,
                    'meta_query'     => array(
                        array(
                            'key'     => '_carvice_provider_type',
                            'value'   => array( 'center', 'dealer' ),
                            'compare' => 'IN',
                        ),
                    ),
                    'orderby'        => 'meta_value_num',
                    'meta_key'       => '_carvice_rating',
                    'order'          => 'DESC',
                ) );

                if ( $centers->have_posts() ) :
                    while ( $centers->have_posts() ) :
                        $centers->the_post();
                        get_template_part( 'template-parts/provider-card' );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="carvice-no-content"><?php esc_html_e( 'No service centers yet. Add providers in the admin panel.', 'carvice' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Top Individual Specialists -->
    <section class="carvice-providers-section">
        <div class="carvice-container">
            <div class="carvice-section-header">
                <h2 class="carvice-section-header__title"><?php esc_html_e( 'Top Individual Specialists', 'carvice' ); ?></h2>
                <a href="<?php echo esc_url( home_url( '/search/?type=individual' ) ); ?>" class="carvice-section-header__link">
                    <?php esc_html_e( 'See more', 'carvice' ); ?> &rarr;
                </a>
            </div>
            <div class="carvice-providers-grid">
                <?php
                $specialists = new WP_Query( array(
                    'post_type'      => 'carvice_provider',
                    'posts_per_page' => 10,
                    'meta_query'     => array(
                        array(
                            'key'   => '_carvice_provider_type',
                            'value' => 'individual',
                        ),
                    ),
                    'orderby'        => 'meta_value_num',
                    'meta_key'       => '_carvice_rating',
                    'order'          => 'DESC',
                ) );

                if ( $specialists->have_posts() ) :
                    while ( $specialists->have_posts() ) :
                        $specialists->the_post();
                        get_template_part( 'template-parts/provider-card' );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="carvice-no-content"><?php esc_html_e( 'No specialists yet. Add providers in the admin panel.', 'carvice' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- AI Assistant Bar Placeholder -->
    <div class="carvice-ai-bar">
        <div class="carvice-container carvice-ai-bar__inner">
            <div class="carvice-ai-bar__chips">
                <span class="carvice-ai-bar__chip"><?php esc_html_e( 'Find a service', 'carvice' ); ?></span>
                <span class="carvice-ai-bar__chip"><?php esc_html_e( 'Call a specialist', 'carvice' ); ?></span>
                <span class="carvice-ai-bar__chip"><?php esc_html_e( 'Check price', 'carvice' ); ?></span>
            </div>
            <div class="carvice-ai-bar__input-wrap">
                <input type="text" class="carvice-ai-bar__input" placeholder="<?php esc_attr_e( 'Ask everything to Carvice AI', 'carvice' ); ?>" disabled />
                <span class="carvice-ai-bar__shortcut">Cmd+K</span>
            </div>
        </div>
    </div>

</main>

<?php
get_footer();
