<?php
/**
 * Template Part: Provider Card
 *
 * @package House_Service
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$card_id     = get_the_ID();
$tagline     = get_post_meta( $card_id, '_hs_tagline', true );
$category    = get_post_meta( $card_id, '_hs_category', true );
$rating      = get_post_meta( $card_id, '_hs_rating', true );
$reviews_num = get_post_meta( $card_id, '_hs_reviews', true );
$location    = get_post_meta( $card_id, '_hs_location', true );
$verified    = get_post_meta( $card_id, '_hs_verified', true );
$tags_str    = get_post_meta( $card_id, '_hs_tags', true );
$price_level = get_post_meta( $card_id, '_hs_price_level', true );

$tags = $tags_str ? array_map( 'trim', explode( ',', $tags_str ) ) : array();
?>

<a href="<?php the_permalink(); ?>" class="co-card" data-reveal data-cat="<?php echo esc_attr( sanitize_title( $category ) ); ?>" data-price="<?php echo esc_attr( $price_level ); ?>" data-name="<?php echo esc_attr( strtolower( get_the_title() ) ); ?>" data-rating="<?php echo esc_attr( $rating ); ?>" data-reviews="<?php echo esc_attr( $reviews_num ); ?>">
	<div class="co-card__image">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'hs-card' ); ?>
		<?php else : ?>
			<div class="ph"></div>
		<?php endif; ?>
		<?php
		$badge = get_post_meta( $card_id, '_hs_badge', true );
		if ( $badge ) : ?>
			<span class="co-card__badge"><?php echo esc_html( $badge ); ?></span>
		<?php elseif ( $category ) : ?>
			<span class="co-card__badge"><?php echo esc_html( $category ); ?></span>
		<?php endif; ?>
		<?php if ( $verified ) : ?>
			<span class="co-card__verified"><?php echo hs_icon( 'check', 14 ); ?></span>
		<?php endif; ?>
	</div>
	<div class="co-card__body">
		<h3 class="co-card__name"><?php the_title(); ?></h3>
		<?php if ( $tagline ) : ?>
			<p class="co-card__tagline"><?php echo esc_html( $tagline ); ?></p>
		<?php endif; ?>
		<?php if ( $rating ) : ?>
		<div class="co-card__rating">
			<?php echo hs_render_stars( floatval( $rating ) ); ?>
			<span class="co-card__rating-num"><?php echo esc_html( $rating ); ?></span>
			<?php if ( $reviews_num ) : ?>
				<span class="co-card__rating-count">(<?php echo esc_html( $reviews_num ); ?>)</span>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php if ( ! empty( $tags ) ) : ?>
		<div class="co-card__tags">
			<?php
			$shown_tags = array_slice( $tags, 0, 3 );
			foreach ( $shown_tags as $tag ) :
			?>
				<span class="tag"><?php echo esc_html( $tag ); ?></span>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
	<div class="co-card__foot">
		<?php if ( $location ) : ?>
		<span class="co-card__location">
			<?php echo hs_icon( 'pin', 14 ); ?>
			<?php echo esc_html( $location ); ?>
		</span>
		<?php endif; ?>
		<span class="co-card__link">
			<?php esc_html_e( 'View profile', 'house-service' ); ?>
			<?php echo hs_icon( 'arrow', 16 ); ?>
		</span>
	</div>
</a>
