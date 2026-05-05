<?php
/**
 * Template part: Provider Card
 *
 * @package Carvice
 */

$provider_type = get_post_meta( get_the_ID(), '_carvice_provider_type', true );
$rating        = get_post_meta( get_the_ID(), '_carvice_rating', true );
$review_count  = get_post_meta( get_the_ID(), '_carvice_review_count', true );
$address       = get_post_meta( get_the_ID(), '_carvice_address', true );
$is_verified   = get_post_meta( get_the_ID(), '_carvice_is_verified', true );
$categories    = wp_get_post_terms( get_the_ID(), 'carvice_service_cat', array( 'fields' => 'slugs' ) );
?>

<a href="<?php the_permalink(); ?>" class="carvice-provider-card">
    <div class="carvice-provider-card__image">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'carvice-card', array( 'class' => 'carvice-provider-card__img' ) ); ?>
        <?php else : ?>
            <div class="carvice-provider-card__placeholder"></div>
        <?php endif; ?>
        <?php if ( $is_verified ) : ?>
            <span class="carvice-provider-card__verified">
                <svg class="carvice-icon-sm" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812z" clip-rule="evenodd"/></svg>
                <?php esc_html_e( 'Official', 'carvice' ); ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="carvice-provider-card__info">
        <h3 class="carvice-provider-card__name"><?php the_title(); ?></h3>

        <?php if ( $address ) : ?>
            <p class="carvice-provider-card__address"><?php echo esc_html( $address ); ?></p>
        <?php endif; ?>

        <?php if ( $rating ) : ?>
            <div class="carvice-provider-card__rating">
                <svg class="carvice-icon-star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="carvice-provider-card__rating-num"><?php echo esc_html( number_format( (float) $rating, 1 ) ); ?></span>
                <?php if ( $review_count ) : ?>
                    <span class="carvice-provider-card__review-count">(<?php echo esc_html( $review_count ); ?>)</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
            <div class="carvice-provider-card__cats">
                <?php foreach ( array_slice( $categories, 0, 4 ) as $cat_slug ) : ?>
                    <span class="carvice-provider-card__cat-icon" title="<?php echo esc_attr( $cat_slug ); ?>">
                        <?php get_template_part( 'template-parts/category-icon-sm', $cat_slug ); ?>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</a>
