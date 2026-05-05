<?php
/**
 * Single Provider template.
 *
 * @package Carvice
 */

get_header();

$provider_type  = get_post_meta( get_the_ID(), '_carvice_provider_type', true );
$phone          = get_post_meta( get_the_ID(), '_carvice_phone', true );
$address        = get_post_meta( get_the_ID(), '_carvice_address', true );
$bio            = get_post_meta( get_the_ID(), '_carvice_bio', true );
$rating         = get_post_meta( get_the_ID(), '_carvice_rating', true );
$review_count   = get_post_meta( get_the_ID(), '_carvice_review_count', true );
$promocode      = get_post_meta( get_the_ID(), '_carvice_promocode', true );
$rep_brand      = get_post_meta( get_the_ID(), '_carvice_represented_brand', true );
$is_verified    = get_post_meta( get_the_ID(), '_carvice_is_verified', true );
$gallery_ids    = get_post_meta( get_the_ID(), '_carvice_gallery', true );
$working_hours  = get_post_meta( get_the_ID(), '_carvice_working_hours', true );
$latitude       = get_post_meta( get_the_ID(), '_carvice_latitude', true );
$longitude      = get_post_meta( get_the_ID(), '_carvice_longitude', true );
$price_range    = get_post_meta( get_the_ID(), '_carvice_price_range', true );
$service_cats   = wp_get_post_terms( get_the_ID(), 'carvice_service_cat' );
$service_types  = wp_get_post_terms( get_the_ID(), 'carvice_service_type' );
$brands         = wp_get_post_terms( get_the_ID(), 'carvice_brand' );

$type_labels = array(
    'center'     => __( 'Service Center', 'carvice' ),
    'individual' => __( 'Individual Specialist', 'carvice' ),
    'dealer'     => __( 'Official Dealer', 'carvice' ),
);
$type_classes = array(
    'center'     => 'carvice-badge--blue',
    'individual' => 'carvice-badge--green',
    'dealer'     => 'carvice-badge--purple',
);

// Social links.
$socials = array();
$social_keys = array(
    'website'   => '_carvice_social_website',
    'instagram' => '_carvice_social_instagram',
    'facebook'  => '_carvice_social_facebook',
    'telegram'  => '_carvice_social_telegram',
    'whatsapp'  => '_carvice_social_whatsapp',
    'tiktok'    => '_carvice_social_tiktok',
);
foreach ( $social_keys as $name => $key ) {
    $val = get_post_meta( get_the_ID(), $key, true );
    if ( $val ) {
        $socials[ $name ] = $val;
    }
}
?>

<main id="primary" class="carvice-main">

    <?php if ( 'dealer' === $provider_type && has_post_thumbnail() ) : ?>
        <!-- Dealer Hero Banner -->
        <section class="carvice-provider-hero">
            <?php the_post_thumbnail( 'carvice-hero', array( 'class' => 'carvice-provider-hero__img' ) ); ?>
            <?php if ( $rep_brand ) : ?>
                <div class="carvice-provider-hero__brand"><?php echo esc_html( $rep_brand ); ?></div>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <!-- Top Bar -->
    <div class="carvice-provider-topbar">
        <div class="carvice-container carvice-provider-topbar__inner">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="carvice-provider-topbar__back">
                <svg class="carvice-icon-sm" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                <?php esc_html_e( 'Back', 'carvice' ); ?>
            </a>
            <div class="carvice-provider-topbar__info">
                <h1 class="carvice-provider-topbar__name"><?php the_title(); ?></h1>
                <?php if ( $provider_type && isset( $type_labels[ $provider_type ] ) ) : ?>
                    <span class="carvice-badge <?php echo esc_attr( $type_classes[ $provider_type ] ?? '' ); ?>">
                        <?php echo esc_html( $type_labels[ $provider_type ] ); ?>
                    </span>
                <?php endif; ?>
                <?php if ( $is_verified ) : ?>
                    <span class="carvice-badge carvice-badge--verified">
                        <svg class="carvice-icon-xs" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812z" clip-rule="evenodd"/></svg>
                        <?php esc_html_e( 'Verified', 'carvice' ); ?>
                    </span>
                <?php endif; ?>
            </div>
            <?php if ( $rating ) : ?>
                <div class="carvice-provider-topbar__rating">
                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                        <svg class="carvice-icon-star <?php echo $i <= round( $rating ) ? 'filled' : 'empty'; ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <?php endfor; ?>
                    <span class="carvice-provider-topbar__rating-num"><?php echo esc_html( number_format( (float) $rating, 1 ) ); ?></span>
                    <?php if ( $review_count ) : ?>
                        <span class="carvice-provider-topbar__review-count">(<?php echo esc_html( $review_count ); ?> <?php esc_html_e( 'reviews', 'carvice' ); ?>)</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content -->
    <div class="carvice-container carvice-provider-layout">

        <!-- Left Column (65%) -->
        <div class="carvice-provider-main">

            <!-- Featured Image + Gallery -->
            <div class="carvice-provider-gallery">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="carvice-provider-gallery__featured">
                        <?php the_post_thumbnail( 'carvice-gallery', array( 'class' => 'carvice-provider-gallery__img' ) ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $gallery_ids ) : ?>
                    <div class="carvice-provider-gallery__thumbs">
                        <?php
                        $ids = array_map( 'intval', explode( ',', $gallery_ids ) );
                        foreach ( array_slice( $ids, 0, 6 ) as $img_id ) :
                            $full_src = wp_get_attachment_image_url( $img_id, 'carvice-gallery' );
                            $img = wp_get_attachment_image( $img_id, 'thumbnail', false, array(
                                'class'        => 'carvice-provider-gallery__thumb',
                                'data-full-src' => $full_src,
                            ) );
                            if ( $img ) :
                        ?>
                            <?php echo $img; ?>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Category Icons -->
            <?php if ( ! empty( $service_cats ) && ! is_wp_error( $service_cats ) ) : ?>
                <div class="carvice-provider-cats">
                    <?php foreach ( $service_cats as $cat ) : ?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="carvice-provider-cat-pill">
                            <?php get_template_part( 'template-parts/category-icon-sm', $cat->slug ); ?>
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Service Type Pills -->
            <?php if ( ! empty( $service_types ) && ! is_wp_error( $service_types ) ) : ?>
                <div class="carvice-provider-services">
                    <?php foreach ( $service_types as $type ) : ?>
                        <span class="carvice-pill carvice-pill--small"><?php echo esc_html( $type->name ); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- CTA Buttons -->
            <div class="carvice-provider-cta">
                <?php if ( $phone ) : ?>
                    <a href="tel:<?php echo esc_attr( $phone ); ?>" class="carvice-btn carvice-btn--primary">
                        <svg class="carvice-icon-sm" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        <?php esc_html_e( 'Call Now', 'carvice' ); ?>
                    </a>
                <?php endif; ?>
                <button class="carvice-btn carvice-btn--outline" disabled>
                    <svg class="carvice-icon-sm" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    <?php esc_html_e( 'Message', 'carvice' ); ?>
                </button>
                <button class="carvice-btn carvice-btn--outline" disabled>
                    <?php esc_html_e( 'Request Call', 'carvice' ); ?>
                </button>
            </div>

            <!-- Bio -->
            <?php if ( $bio ) : ?>
                <div class="carvice-provider-bio">
                    <h2><?php esc_html_e( 'About', 'carvice' ); ?></h2>
                    <p><?php echo esc_html( $bio ); ?></p>
                </div>
            <?php endif; ?>

            <!-- Address -->
            <?php if ( $address ) : ?>
                <div class="carvice-provider-address">
                    <svg class="carvice-icon-sm" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    <span><?php echo esc_html( $address ); ?></span>
                    <?php if ( $latitude && $longitude ) : ?>
                        <a href="https://www.google.com/maps?q=<?php echo esc_attr( $latitude ); ?>,<?php echo esc_attr( $longitude ); ?>" target="_blank" rel="noopener noreferrer" class="carvice-provider-address__map"><?php esc_html_e( 'View on Map', 'carvice' ); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Working Hours -->
            <?php if ( $working_hours ) : ?>
                <div class="carvice-provider-hours">
                    <svg class="carvice-icon-sm" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span><?php echo esc_html( $working_hours ); ?></span>
                </div>
            <?php endif; ?>

            <!-- Price Range -->
            <?php if ( $price_range ) : ?>
                <?php
                $price_labels = array(
                    'budget'  => __( '$ Budget', 'carvice' ),
                    'mid'     => __( '$$ Mid-range', 'carvice' ),
                    'premium' => __( '$$$ Premium', 'carvice' ),
                );
                ?>
                <div class="carvice-provider-price">
                    <span class="carvice-badge carvice-badge--price"><?php echo esc_html( $price_labels[ $price_range ] ?? $price_range ); ?></span>
                </div>
            <?php endif; ?>

            <!-- Promo Code -->
            <?php if ( $promocode ) : ?>
                <div class="carvice-provider-promo">
                    <span class="carvice-provider-promo__label"><?php esc_html_e( 'Promocode', 'carvice' ); ?>:</span>
                    <code class="carvice-provider-promo__code"><?php echo esc_html( $promocode ); ?></code>
                </div>
            <?php endif; ?>

            <!-- Reviews Section -->
            <div class="carvice-provider-reviews">
                <div class="carvice-provider-reviews__header">
                    <h2><?php esc_html_e( 'Reviews & Comments', 'carvice' ); ?>
                        <?php if ( $review_count ) : ?>
                            <span class="carvice-provider-reviews__count">(<?php echo esc_html( $review_count ); ?>)</span>
                        <?php endif; ?>
                    </h2>
                    <a href="#" class="carvice-provider-reviews__more"><?php esc_html_e( 'See more', 'carvice' ); ?></a>
                </div>

                <?php if ( 'dealer' === $provider_type ) : ?>
                    <!-- Review form (dealer only) -->
                    <div class="carvice-review-form">
                        <h3 class="carvice-review-form__title"><?php esc_html_e( 'Write a review', 'carvice' ); ?></h3>
                        <div class="carvice-review-form__stars">
                            <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                <svg class="carvice-icon-star empty" fill="currentColor" viewBox="0 0 20 20" style="width:24px;height:24px;cursor:pointer;"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <?php endfor; ?>
                        </div>
                        <textarea class="carvice-input carvice-textarea" rows="3" placeholder="<?php esc_attr_e( 'Write a review', 'carvice' ); ?>"></textarea>
                        <div class="carvice-review-form__actions">
                            <button class="carvice-review-form__attach">
                                <svg class="carvice-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                                <?php esc_html_e( 'Attach photo', 'carvice' ); ?>
                            </button>
                            <button class="carvice-btn carvice-btn--primary"><?php esc_html_e( 'Write a review', 'carvice' ); ?></button>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Review cards -->
                <?php
                $comments = get_comments( array(
                    'post_id' => get_the_ID(),
                    'status'  => 'approve',
                    'orderby' => 'comment_date',
                    'order'   => 'DESC',
                ) );

                if ( ! empty( $comments ) ) :
                    foreach ( $comments as $comment ) :
                        $star_rating = get_comment_meta( $comment->comment_ID, '_carvice_star_rating', true );
                ?>
                    <div class="carvice-review-card">
                        <div class="carvice-review-card__header">
                            <div class="carvice-review-card__author">
                                <div class="carvice-review-card__avatar">
                                    <?php echo esc_html( mb_substr( $comment->comment_author, 0, 1 ) ); ?>
                                </div>
                                <div>
                                    <p class="carvice-review-card__name"><?php echo esc_html( $comment->comment_author ); ?></p>
                                    <p class="carvice-review-card__date"><?php echo esc_html( date_i18n( 'd.m.Y', strtotime( $comment->comment_date ) ) ); ?></p>
                                </div>
                            </div>
                            <?php if ( $star_rating ) : ?>
                                <div class="carvice-review-card__stars">
                                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                        <svg class="carvice-icon-star <?php echo $i <= intval( $star_rating ) ? 'filled' : 'empty'; ?>" fill="currentColor" viewBox="0 0 20 20" style="width:16px;height:16px;"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="carvice-review-card__text"><?php echo esc_html( $comment->comment_content ); ?></p>
                        <button class="carvice-review-card__reply"><?php esc_html_e( 'Reply', 'carvice' ); ?></button>
                    </div>
                <?php
                    endforeach;
                else :
                ?>
                    <p class="carvice-no-content"><?php esc_html_e( 'No reviews yet.', 'carvice' ); ?></p>
                <?php endif; ?>
            </div>

        </div>

        <!-- Right Sidebar (35%) -->
        <aside class="carvice-provider-sidebar">

            <!-- Rating Breakdown (with percentage bars) -->
            <?php if ( $rating ) : ?>
                <div class="carvice-sidebar-card carvice-rating-card">
                    <div class="carvice-rating-card__summary">
                        <span class="carvice-rating-card__number"><?php echo esc_html( number_format( (float) $rating, 1 ) ); ?></span>
                        <div>
                            <div class="carvice-rating-card__stars">
                                <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                    <svg class="carvice-icon-star <?php echo $i <= round( $rating ) ? 'filled' : 'empty'; ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <?php endfor; ?>
                            </div>
                            <?php if ( $review_count ) : ?>
                                <span class="carvice-rating-card__count"><?php echo esc_html( $review_count ); ?> <?php esc_html_e( 'reviews', 'carvice' ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="carvice-rating-bars">
                        <?php
                        $bar_percents = array( 5 => 68, 4 => 20, 3 => 7, 2 => 3, 1 => 2 );
                        foreach ( $bar_percents as $stars => $pct ) :
                        ?>
                            <div class="carvice-rating-bar">
                                <span class="carvice-rating-bar__label"><?php echo esc_html( $stars ); ?></span>
                                <svg class="carvice-icon-star filled" fill="currentColor" viewBox="0 0 20 20" style="width:14px;height:14px;"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <div class="carvice-rating-bar__track">
                                    <div class="carvice-rating-bar__fill" style="width: <?php echo esc_attr( $pct ); ?>%"></div>
                                </div>
                                <span class="carvice-rating-bar__pct"><?php echo esc_html( $pct ); ?>%</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Social Links -->
            <?php if ( ! empty( $socials ) ) : ?>
                <div class="carvice-sidebar-card">
                    <h3><?php esc_html_e( 'Social Links', 'carvice' ); ?></h3>
                    <ul class="carvice-social-list">
                        <?php foreach ( $socials as $name => $url ) : ?>
                            <li>
                                <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php echo esc_html( ucfirst( $name ) ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Brands -->
            <?php if ( ! empty( $brands ) && ! is_wp_error( $brands ) ) : ?>
                <div class="carvice-sidebar-card">
                    <h3><?php esc_html_e( 'Brands Serviced', 'carvice' ); ?></h3>
                    <div class="carvice-brand-tags">
                        <?php foreach ( $brands as $brand ) : ?>
                            <span class="carvice-brand-tag"><?php echo esc_html( $brand->name ); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Related Providers (2-col grid matching reference) -->
            <div class="carvice-sidebar-card carvice-sidebar-card--related">
                <h3><?php esc_html_e( 'Other Providers', 'carvice' ); ?></h3>
                <div class="carvice-related-grid">
                    <?php
                    $related = new WP_Query( array(
                        'post_type'      => 'carvice_provider',
                        'posts_per_page' => 4,
                        'post__not_in'   => array( get_the_ID() ),
                        'orderby'        => 'rand',
                    ) );

                    if ( $related->have_posts() ) :
                        while ( $related->have_posts() ) :
                            $related->the_post();
                            $rel_rating = get_post_meta( get_the_ID(), '_carvice_rating', true );
                            $rel_reviews = get_post_meta( get_the_ID(), '_carvice_review_count', true );
                    ?>
                        <a href="<?php the_permalink(); ?>" class="carvice-related-card">
                            <div class="carvice-related-card__image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'carvice-card', array( 'class' => 'carvice-related-card__img' ) ); ?>
                                <?php else : ?>
                                    <div class="carvice-provider-card__placeholder"></div>
                                <?php endif; ?>
                            </div>
                            <div class="carvice-related-card__info">
                                <p class="carvice-related-card__name"><?php the_title(); ?></p>
                                <div class="carvice-related-card__rating">
                                    <svg class="carvice-icon-star filled" fill="currentColor" viewBox="0 0 20 20" style="width:12px;height:12px;"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="carvice-related-card__rating-num"><?php echo esc_html( $rel_rating ? number_format( (float) $rel_rating, 1 ) : '0.0' ); ?></span>
                                    <span class="carvice-related-card__review-count">(<?php echo esc_html( $rel_reviews ?: '0' ); ?>)</span>
                                </div>
                            </div>
                        </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </aside>

    </div>

</main>

<?php
get_footer();
