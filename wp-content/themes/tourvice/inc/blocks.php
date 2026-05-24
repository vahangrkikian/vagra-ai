<?php
/**
 * ACF Gutenberg Blocks Registration
 *
 * Each block is registered via acf_register_block_type().
 * Fields appear in the block sidebar. Render callbacks output the section HTML.
 *
 * @package TourVice
 * @since 0.2.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_register_block_type' ) ) { return; }

    /* ── Hero Slider ─────────────────────────────────────────── */
    acf_register_block_type( [
        'name'            => 'tourvice-hero-slider',
        'title'           => __( 'Hero Slider', 'tourvice' ),
        'description'     => __( 'Full-screen hero carousel with Ken Burns effect, stats, and CTA.', 'tourvice' ),
        'category'        => 'tourvice-blocks',
        'icon'            => 'slides',
        'keywords'        => [ 'hero', 'slider', 'carousel', 'banner' ],
        'mode'            => 'preview',
        'align'           => 'full',
        'supports'        => [ 'align' => [ 'full', 'wide' ], 'anchor' => true ],
        'render_callback' => 'tourvice_render_hero_slider_block',
    ] );

    /* ── Featured Tours ──────────────────────────────────────── */
    acf_register_block_type( [
        'name'            => 'tourvice-featured-tours',
        'title'           => __( 'Featured Tours', 'tourvice' ),
        'description'     => __( 'Grid of featured tour cards from the vagra_tour CPT.', 'tourvice' ),
        'category'        => 'tourvice-blocks',
        'icon'            => 'location-alt',
        'keywords'        => [ 'tours', 'featured', 'travel', 'cards' ],
        'mode'            => 'preview',
        'supports'        => [ 'align' => [ 'full', 'wide' ], 'anchor' => true ],
        'render_callback' => 'tourvice_render_featured_tours_block',
    ] );

    /* ── Group Discounts ─────────────────────────────────────── */
    acf_register_block_type( [
        'name'            => 'tourvice-group-discounts',
        'title'           => __( 'Group Discounts', 'tourvice' ),
        'description'     => __( 'Discount tier cards for group bookings.', 'tourvice' ),
        'category'        => 'tourvice-blocks',
        'icon'            => 'groups',
        'keywords'        => [ 'discounts', 'pricing', 'group', 'tiers' ],
        'mode'            => 'preview',
        'supports'        => [ 'align' => [ 'full', 'wide' ], 'anchor' => true ],
        'render_callback' => 'tourvice_render_group_discounts_block',
    ] );

    /* ── Testimonials ────────────────────────────────────────── */
    acf_register_block_type( [
        'name'            => 'tourvice-testimonials',
        'title'           => __( 'Testimonials', 'tourvice' ),
        'description'     => __( 'Guest testimonials with parallax background and glassmorphic cards.', 'tourvice' ),
        'category'        => 'tourvice-blocks',
        'icon'            => 'format-quote',
        'keywords'        => [ 'testimonials', 'reviews', 'quotes' ],
        'mode'            => 'preview',
        'supports'        => [ 'align' => [ 'full', 'wide' ], 'anchor' => true ],
        'render_callback' => 'tourvice_render_testimonials_block',
    ] );

    /* ── Newsletter ──────────────────────────────────────────── */
    acf_register_block_type( [
        'name'            => 'tourvice-newsletter',
        'title'           => __( 'Newsletter', 'tourvice' ),
        'description'     => __( 'Newsletter signup CTA with email form.', 'tourvice' ),
        'category'        => 'tourvice-blocks',
        'icon'            => 'email',
        'keywords'        => [ 'newsletter', 'subscribe', 'email', 'cta' ],
        'mode'            => 'preview',
        'supports'        => [ 'align' => [ 'full', 'wide' ], 'anchor' => true ],
        'render_callback' => 'tourvice_render_newsletter_block',
    ] );
} );

/* ── Block category ──────────────────────────────────────────── */
add_filter( 'block_categories_all', function( $categories ) {
    array_unshift( $categories, [
        'slug'  => 'tourvice-blocks',
        'title' => __( 'TourVice', 'tourvice' ),
        'icon'  => 'palmtree',
    ] );
    return $categories;
} );


/* ================================================================
   RENDER CALLBACKS
   ================================================================ */

/**
 * 1. Hero Slider
 */
function tourvice_render_hero_slider_block( $block ) {
    $title    = get_field( 'hero_title' ) ?: 'Discover Armenia';
    $subtitle = get_field( 'hero_subtitle' );
    $cta_text = get_field( 'hero_cta_text' ) ?: 'Browse Tours';
    $cta_url  = get_field( 'hero_cta_url' );

    if ( ! $cta_url && post_type_exists( 'vagra_tour' ) ) {
        $cta_url = get_post_type_archive_link( 'vagra_tour' );
    }

    // Collect slides via have_rows (works with both post meta and block data).
    $slides = [];
    if ( have_rows( 'hero_slides' ) ) {
        while ( have_rows( 'hero_slides' ) ) {
            the_row();
            $img = get_sub_field( 'image' );
            // Image can be URL string or attachment ID.
            if ( is_numeric( $img ) ) {
                $img = wp_get_attachment_url( (int) $img );
            }
            if ( $img ) {
                $slides[] = [
                    'image'    => $img,
                    'alt_text' => get_sub_field( 'alt_text' ) ?: 'Armenia landscape',
                ];
            }
        }
    }

    // Fallback: use theme hero images if no slides configured.
    if ( empty( $slides ) ) {
        $hero_dir = get_template_directory() . '/assets/images/hero/';
        $hero_uri = TOURVICE_URI . '/assets/images/hero/';
        if ( is_dir( $hero_dir ) ) {
            $files = array_merge(
                glob( $hero_dir . '*.jpg' ) ?: [],
                glob( $hero_dir . '*.jpeg' ) ?: [],
                glob( $hero_dir . '*.png' ) ?: [],
                glob( $hero_dir . '*.webp' ) ?: []
            );
            foreach ( $files as $file ) {
                $slides[] = [
                    'image'    => $hero_uri . basename( $file ),
                    'alt_text' => 'Armenia landscape',
                ];
            }
        }
    }

    // Collect stats.
    $stats = [];
    if ( have_rows( 'hero_stats' ) ) {
        while ( have_rows( 'hero_stats' ) ) {
            the_row();
            $stats[] = [
                'value' => get_sub_field( 'value' ),
                'label' => get_sub_field( 'label' ),
            ];
        }
    }

    $anchor = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'tourvice-hero';
    ?>
    <section class="tourvice-hero" id="<?php echo $anchor; ?>" aria-label="<?php esc_attr_e( 'Hero', 'tourvice' ); ?>">

        <?php if ( $slides ) : ?>
            <div class="tourvice-hero__carousel" data-interval="5500">
                <?php foreach ( $slides as $i => $slide ) : ?>
                    <img
                        class="tourvice-hero__image<?php echo 0 === $i ? ' tourvice-hero__image--active ken-burns' : ''; ?>"
                        src="<?php echo esc_url( $slide['image'] ); ?>"
                        alt="<?php echo esc_attr( $slide['alt_text'] ); ?>"
                        loading="<?php echo 0 === $i ? 'eager' : 'lazy'; ?>"
                    />
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="tourvice-hero__carousel">
                <div style="background:linear-gradient(135deg, var(--earth-800), var(--sage-800)); position:absolute; inset:0;"></div>
            </div>
        <?php endif; ?>

        <div class="tourvice-hero__overlay" aria-hidden="true"></div>

        <div class="tourvice-hero__content">
            <h1 class="tourvice-hero__title animate-fade-in"><?php echo esc_html( $title ); ?></h1>

            <?php if ( $subtitle ) : ?>
                <p class="tourvice-hero__subtitle animate-fade-in"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>

            <?php if ( $cta_text && $cta_url ) : ?>
                <div class="tourvice-hero__cta animate-fade-in">
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="tourvice-btn tourvice-btn--hero">
                        <?php echo esc_html( $cta_text ); ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ( $stats ) : ?>
                <div class="tourvice-hero__stats">
                    <?php foreach ( $stats as $stat ) : ?>
                        <div class="tourvice-hero__stat">
                            <span class="tourvice-hero__stat-value"><?php echo esc_html( $stat['value'] ); ?></span>
                            <span class="tourvice-hero__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( count( $slides ) > 1 ) : ?>
            <div class="tourvice-hero__dots" aria-label="<?php esc_attr_e( 'Slide navigation', 'tourvice' ); ?>">
                <?php foreach ( $slides as $i => $slide ) : ?>
                    <button
                        class="tourvice-hero__dot<?php echo 0 === $i ? ' tourvice-hero__dot--active' : ''; ?>"
                        data-slide="<?php echo absint( $i ); ?>"
                        aria-label="<?php printf( esc_attr__( 'Slide %d', 'tourvice' ), $i + 1 ); ?>"
                    ></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="tourvice-hero__scroll-indicator animate-bounce" aria-hidden="true">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
        </div>
    </section>
    <?php
}

/**
 * 2. Featured Tours
 */
function tourvice_render_featured_tours_block( $block ) {
    $eyebrow  = get_field( 'ftours_eyebrow' ) ?: 'Curated for you';
    $title    = get_field( 'ftours_title' ) ?: 'Featured Tours';
    $desc     = get_field( 'ftours_desc' );
    $count    = get_field( 'ftours_count' ) ?: 3;
    $cta_text = get_field( 'ftours_cta_text' ) ?: 'Browse All Tours';

    $tours = new WP_Query( [
        'post_type'      => 'vagra_tour',
        'posts_per_page' => $count,
        'meta_key'       => '_tour_rating',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ] );
    ?>
    <section class="tourvice-featured" aria-label="<?php esc_attr_e( 'Featured Tours', 'tourvice' ); ?>">
        <div class="tourvice-featured__inner container">
            <div class="tourvice-featured__header reveal">
                <p class="tourvice-featured__label"><?php echo esc_html( $eyebrow ); ?></p>
                <h2 class="tourvice-featured__title"><?php echo esc_html( $title ); ?></h2>
                <?php if ( $desc ) : ?>
                    <p class="tourvice-featured__desc"><?php echo esc_html( $desc ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( $tours->have_posts() ) : ?>
                <div class="tourvice-featured__grid">
                    <?php
                    while ( $tours->have_posts() ) :
                        $tours->the_post();
                        get_template_part( 'template-parts/tour-card' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else : ?>
                <p style="text-align:center;color:var(--earth-400);padding:2rem 0;">
                    <?php esc_html_e( 'No tours found. Add tours to see them here.', 'tourvice' ); ?>
                </p>
            <?php endif; ?>

            <div class="tourvice-featured__footer">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'vagra_tour' ) ?: '#' ); ?>" class="tourvice-btn tourvice-btn--outline">
                    <?php echo esc_html( $cta_text ); ?>
                </a>
            </div>
        </div>
    </section>
    <?php
}

/**
 * 3. Group Discounts
 */
function tourvice_render_group_discounts_block( $block ) {
    $eyebrow = get_field( 'disc_eyebrow' ) ?: 'Save more together';
    $title   = get_field( 'disc_title' ) ?: 'Group Discounts';
    $desc    = get_field( 'disc_desc' );

    $tiers = [];
    if ( have_rows( 'disc_tiers' ) ) {
        while ( have_rows( 'disc_tiers' ) ) {
            the_row();
            $tiers[] = [
                'size'     => get_sub_field( 'size' ),
                'discount' => get_sub_field( 'discount' ),
                'style'    => get_sub_field( 'style' ) ?: 'earth',
                'badge'    => get_sub_field( 'badge' ),
            ];
        }
    }
    ?>
    <section class="tourvice-discounts" aria-label="<?php esc_attr_e( 'Group Discounts', 'tourvice' ); ?>">
        <div class="tourvice-discounts__inner container">
            <div class="tourvice-discounts__header reveal">
                <p class="tourvice-discounts__label"><?php echo esc_html( $eyebrow ); ?></p>
                <h2 class="tourvice-discounts__title"><?php echo esc_html( $title ); ?></h2>
                <?php if ( $desc ) : ?>
                    <p class="tourvice-discounts__desc"><?php echo esc_html( $desc ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( $tiers ) : ?>
                <div class="tourvice-discounts__grid">
                    <?php foreach ( $tiers as $tier ) :
                        $style_class = 'tourvice-discount-tier--' . esc_attr( $tier['style'] );
                    ?>
                        <div class="tourvice-discount-tier <?php echo $style_class; ?>">
                            <?php if ( ! empty( $tier['badge'] ) ) : ?>
                                <span class="tourvice-discount-tier__badge"><?php echo esc_html( $tier['badge'] ); ?></span>
                            <?php endif; ?>
                            <div class="tourvice-discount-tier__value">
                                <?php echo esc_html( $tier['discount'] ); ?>
                            </div>
                            <p class="tourvice-discount-tier__size">
                                <?php echo esc_html( $tier['size'] ); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p style="text-align:center;color:var(--earth-400);padding:2rem 0;">
                    <?php esc_html_e( 'Add discount tiers to display them here.', 'tourvice' ); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

/**
 * 4. Testimonials
 */
function tourvice_render_testimonials_block( $block ) {
    $eyebrow  = get_field( 'test_eyebrow' ) ?: 'Real stories';
    $title    = get_field( 'test_title' ) ?: 'Guest Testimonials';
    $desc     = get_field( 'test_desc' );
    $bg_image = get_field( 'test_bg_image' );

    if ( is_numeric( $bg_image ) ) {
        $bg_image = wp_get_attachment_url( (int) $bg_image );
    }
    if ( ! $bg_image ) {
        $bg_image = TOURVICE_URI . '/assets/images/hero/Garni_Temple_at_Sunset_Armenia-scaled.jpg';
    }

    $items = [];
    if ( have_rows( 'test_items' ) ) {
        while ( have_rows( 'test_items' ) ) {
            the_row();
            $items[] = [
                'name'   => get_sub_field( 'name' ),
                'role'   => get_sub_field( 'role' ),
                'text'   => get_sub_field( 'text' ),
                'rating' => get_sub_field( 'rating' ) ?: 5,
            ];
        }
    }
    ?>
    <section class="tourvice-testimonials" style="background-image: url('<?php echo esc_url( $bg_image ); ?>');" aria-label="<?php esc_attr_e( 'Guest Testimonials', 'tourvice' ); ?>">
        <div class="tourvice-testimonials__overlay" aria-hidden="true"></div>

        <div class="tourvice-testimonials__inner container">
            <div class="tourvice-testimonials__header">
                <p class="tourvice-testimonials__label"><?php echo esc_html( $eyebrow ); ?></p>
                <h2 class="tourvice-testimonials__title"><?php echo esc_html( $title ); ?></h2>
                <?php if ( $desc ) : ?>
                    <p class="tourvice-testimonials__desc"><?php echo esc_html( $desc ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( $items ) : ?>
                <div class="tourvice-testimonials__grid">
                    <?php foreach ( $items as $item ) : ?>
                        <div class="tourvice-testimonial-card">
                            <div class="tourvice-testimonial-card__stars">
                                <?php for ( $s = 0; $s < (int) $item['rating']; $s++ ) : ?>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <p class="tourvice-testimonial-card__text">&ldquo;<?php echo esc_html( $item['text'] ); ?>&rdquo;</p>
                            <div class="tourvice-testimonials__author">
                                <p class="tourvice-testimonial-card__name"><?php echo esc_html( $item['name'] ); ?></p>
                                <?php if ( ! empty( $item['role'] ) ) : ?>
                                    <p class="tourvice-testimonial-card__role"><?php echo esc_html( $item['role'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p style="text-align:center;color:rgba(255,255,255,0.6);padding:2rem 0;">
                    <?php esc_html_e( 'Add testimonials to display them here.', 'tourvice' ); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

/**
 * 5. Newsletter
 */
function tourvice_render_newsletter_block( $block ) {
    $title       = get_field( 'nl_title' ) ?: 'Stay Updated';
    $desc        = get_field( 'nl_desc' );
    $placeholder = get_field( 'nl_placeholder' ) ?: __( 'Your email address', 'tourvice' );
    $button_text = get_field( 'nl_button' ) ?: __( 'Subscribe', 'tourvice' );
    ?>
    <section class="tourvice-newsletter" aria-label="<?php esc_attr_e( 'Newsletter', 'tourvice' ); ?>">
        <div class="tourvice-newsletter__inner reveal">
            <h2 class="tourvice-newsletter__title"><?php echo esc_html( $title ); ?></h2>

            <?php if ( $desc ) : ?>
                <p class="tourvice-newsletter__desc"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>

            <form class="tourvice-newsletter__form" id="tourvice-newsletter-form" method="post" action="#">
                <?php wp_nonce_field( 'tourvice_newsletter', 'tourvice_newsletter_nonce' ); ?>
                <input
                    type="email"
                    name="email"
                    class="tourvice-newsletter__input"
                    placeholder="<?php echo esc_attr( $placeholder ); ?>"
                    required
                />
                <button type="submit" class="tourvice-newsletter__btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span><?php echo esc_html( $button_text ); ?></span>
                </button>
            </form>

            <div class="tourvice-newsletter__success" id="tourvice-newsletter-success" hidden>
                <?php esc_html_e( 'Thank you! Check your email for exclusive offers.', 'tourvice' ); ?>
            </div>
        </div>
    </section>
    <?php
}
