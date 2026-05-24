<?php
/**
 * Template Part: Tour Card
 *
 * Reusable card for vagra_tour posts. Converts TourCard.jsx.
 * Used in front-page.php (featured grid), archive-vagra_tour.php, and search results.
 *
 * Expects to be called inside The Loop (global $post set).
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tour_id       = get_the_ID();
$tour_price    = get_post_meta( $tour_id, '_tour_price', true );
$tour_rating   = get_post_meta( $tour_id, '_tour_rating', true );
$tour_group_min = get_post_meta( $tour_id, '_tour_group_min', true );
$tour_group_max = get_post_meta( $tour_id, '_tour_group_max', true );

/* Location taxonomy term */
$location_terms = get_the_terms( $tour_id, 'tour_location' );
$location_name  = '';
if ( $location_terms && ! is_wp_error( $location_terms ) ) {
	$location_name = $location_terms[0]->name;
}

/* Group size display string */
$group_display = '';
if ( $tour_group_min && $tour_group_max ) {
	$group_display = intval( $tour_group_min ) . '-' . intval( $tour_group_max ) . ' ' . __( 'people', 'tourvice' );
} elseif ( $tour_group_max ) {
	$group_display = __( 'Up to', 'tourvice' ) . ' ' . intval( $tour_group_max ) . ' ' . __( 'people', 'tourvice' );
}

/* Price: strip non-numeric for data-usd, keep formatted for display */
$price_numeric = preg_replace( '/[^0-9.]/', '', $tour_price );
$price_display = $tour_price ? '$' . number_format( (float) $price_numeric ) : '';

/* Featured image */
$has_thumb = has_post_thumbnail( $tour_id );
$thumb_url = $has_thumb
	? get_the_post_thumbnail_url( $tour_id, 'tourvice-card' )
	: TOURVICE_URI . '/assets/images/placeholder-tour.jpg';
?>

<a href="<?php the_permalink(); ?>" class="tourvice-card reveal" aria-label="<?php the_title_attribute(); ?>">
	<div class="tourvice-card__image-wrap">
		<img
			class="tourvice-card__image"
			src="<?php echo esc_url( $thumb_url ); ?>"
			alt="<?php the_title_attribute(); ?>"
			loading="lazy"
			width="800"
			height="500"
		/>

		<?php if ( $price_display ) : ?>
			<span class="tourvice-card__price-badge" data-usd="<?php echo esc_attr( $price_numeric ); ?>">
				<?php echo esc_html( $price_display ); ?>
			</span>
		<?php endif; ?>

		<div class="tourvice-card__hover-overlay" aria-hidden="true">
			<span class="tourvice-card__hover-cta" data-i18n="card_view_tour"><?php esc_html_e( 'View Tour', 'tourvice' ); ?> &rarr;</span>
		</div>
	</div>

	<div class="tourvice-card__body">
		<?php if ( $location_name ) : ?>
			<div class="tourvice-card__location">
				<svg class="tourvice-card__location-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
					<circle cx="12" cy="10" r="3"></circle>
				</svg>
				<span class="tourvice-card__location-text"><?php echo esc_html( $location_name ); ?></span>
			</div>
		<?php endif; ?>

		<h3 class="tourvice-card__title"><?php the_title(); ?></h3>

		<p class="tourvice-card__desc"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15, '...' ) ); ?></p>

		<div class="tourvice-card__footer">
			<?php if ( $tour_rating ) : ?>
				<div class="tourvice-card__rating">
					<svg class="tourvice-card__star" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
						<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
					</svg>
					<span class="tourvice-card__rating-value"><?php echo esc_html( $tour_rating ); ?></span>
					<?php
					$rc = class_exists( 'TourVice_Reviews' ) ? TourVice_Reviews::get_review_count( get_the_ID() ) : 0;
					if ( $rc > 0 ) :
					?>
						<span class="tourvice-card__review-count">(<?php echo absint( $rc ); ?>)</span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $group_display ) : ?>
				<div class="tourvice-card__group">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
						<circle cx="9" cy="7" r="4"></circle>
						<path d="M23 21v-2a4 4 0 00-3-3.87"></path>
						<path d="M16 3.13a4 4 0 010 7.75"></path>
					</svg>
					<span class="tourvice-card__group-text"><?php echo esc_html( $group_display ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</a>
