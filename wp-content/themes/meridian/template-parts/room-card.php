<?php
/**
 * Room Card Template Part
 *
 * Used on front page (featured rooms), archive, and similar rooms.
 *
 * @package Meridian
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$room_id    = get_the_ID();
$price      = get_post_meta( $room_id, '_meridian_price', true );
$guests     = get_post_meta( $room_id, '_meridian_guests', true );
$size       = get_post_meta( $room_id, '_meridian_size_sqm', true );
$bed        = get_post_meta( $room_id, '_meridian_bed_type', true );
$view       = get_post_meta( $room_id, '_meridian_view', true );
$badge      = get_post_meta( $room_id, '_meridian_badge', true );
$tagline    = get_post_meta( $room_id, '_meridian_tagline', true );
$room_index = get_query_var( 'room_index', 0 );

$categories = get_the_terms( $room_id, 'meridian_room_cat' );
$category   = ( $categories && ! is_wp_error( $categories ) ) ? $categories[0]->name : '';
?>
<a href="<?php the_permalink(); ?>" class="room-card" data-reveal style="--d: <?php echo intval( $room_index ) * 80; ?>ms">
	<div class="room-card__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'meridian-card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<div style="width:100%;height:100%;background:var(--navy-800);display:flex;align-items:center;justify-content:center;color:var(--gold-soft);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;">
				<?php echo esc_html( get_the_title() ); ?>
			</div>
		<?php endif; ?>
		<?php if ( $badge ) : ?>
			<span class="room-card__badge"><?php echo esc_html( $badge ); ?></span>
		<?php endif; ?>
		<?php if ( $price ) : ?>
		<div class="room-card__price">
			<span class="room-card__price-from"><?php esc_html_e( 'From', 'meridian' ); ?></span>
			<span class="room-card__price-num">$<?php echo esc_html( number_format( (int) $price ) ); ?></span>
			<span class="room-card__price-night">/ <?php esc_html_e( 'night', 'meridian' ); ?></span>
		</div>
		<?php endif; ?>
	</div>
	<div class="room-card__body">
		<div class="room-card__head">
			<div>
				<?php if ( $category ) : ?>
					<div class="eyebrow"><?php echo esc_html( $category ); ?></div>
				<?php endif; ?>
				<h3 class="room-card__name"><?php the_title(); ?></h3>
			</div>
		</div>
		<?php if ( $tagline ) : ?>
			<p class="room-card__tag"><?php echo esc_html( $tagline ); ?></p>
		<?php endif; ?>
		<div class="room-card__specs">
			<?php if ( $guests ) : ?>
				<span><?php echo meridian_icon( 'guests', 14 ); ?> <?php echo esc_html( $guests ); ?> <?php esc_html_e( 'guests', 'meridian' ); ?></span>
			<?php endif; ?>
			<?php if ( $size ) : ?>
				<span><?php echo meridian_icon( 'ruler', 14 ); ?> <?php echo esc_html( $size ); ?> m²</span>
			<?php endif; ?>
			<?php if ( $bed ) : ?>
				<span><?php echo meridian_icon( 'bed', 14 ); ?> <?php echo esc_html( $bed ); ?></span>
			<?php endif; ?>
			<?php if ( $view ) : ?>
				<span><?php echo meridian_icon( 'eye', 14 ); ?> <?php echo esc_html( $view ); ?></span>
			<?php endif; ?>
		</div>
		<span class="room-card__cta"><?php esc_html_e( 'View Details', 'meridian' ); ?> <?php echo meridian_icon( 'arrow-right', 14 ); ?></span>
	</div>
</a>
