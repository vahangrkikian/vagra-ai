<?php
/**
 * Single Room Template
 *
 * @package Meridian
 */

get_header();

$room_id   = get_the_ID();
$price     = get_post_meta( $room_id, '_meridian_price', true );
$guests    = get_post_meta( $room_id, '_meridian_guests', true );
$size      = get_post_meta( $room_id, '_meridian_size_sqm', true );
$bed       = get_post_meta( $room_id, '_meridian_bed_type', true );
$view      = get_post_meta( $room_id, '_meridian_view', true );
$badge     = get_post_meta( $room_id, '_meridian_badge', true );
$tagline   = get_post_meta( $room_id, '_meridian_tagline', true );
$amenities_raw = get_post_meta( $room_id, '_meridian_amenities', true );
$amenities = array_filter( array_map( 'trim', explode( "\n", $amenities_raw ) ) );
$gallery_ids = array_filter( explode( ',', get_post_meta( $room_id, '_meridian_gallery', true ) ) );

$categories = get_the_terms( $room_id, 'meridian_room_cat' );
$category   = ( $categories && ! is_wp_error( $categories ) ) ? $categories[0]->name : '';

// Build gallery images array (featured image + gallery)
$images = array();
if ( has_post_thumbnail() ) {
	$images[] = array(
		'full'  => get_the_post_thumbnail_url( $room_id, 'large' ),
		'thumb' => get_the_post_thumbnail_url( $room_id, 'meridian-thumb' ),
		'alt'   => get_the_title(),
	);
}
foreach ( $gallery_ids as $att_id ) {
	$att_id = intval( trim( $att_id ) );
	if ( $att_id ) {
		$images[] = array(
			'full'  => wp_get_attachment_image_url( $att_id, 'large' ),
			'thumb' => wp_get_attachment_image_url( $att_id, 'meridian-thumb' ),
			'alt'   => get_post_meta( $att_id, '_wp_attachment_image_alt', true ) ?: get_the_title(),
		);
	}
}
// Pad to at least 5 thumbnails by reusing
while ( count( $images ) < 5 && count( $images ) > 0 ) {
	$images[] = $images[ count( $images ) % count( array_slice( $images, 0, max( 1, count( $images ) ) ) ) ];
}
?>

<!-- BREADCRUMBS -->
<div class="container crumbs">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'meridian' ); ?></a>
	<span>/</span>
	<a href="<?php echo esc_url( get_post_type_archive_link( 'meridian_room' ) ); ?>"><?php esc_html_e( 'Rooms', 'meridian' ); ?></a>
	<span>/</span>
	<span><?php the_title(); ?></span>
</div>

<!-- ROOM DETAIL -->
<section class="container room-detail">
	<!-- GALLERY -->
	<div class="room-detail__gallery">
		<button class="room-detail__hero" id="room-hero-image" aria-label="<?php esc_attr_e( 'Open gallery', 'meridian' ); ?>">
			<?php if ( ! empty( $images ) ) : ?>
				<img src="<?php echo esc_url( $images[0]['full'] ); ?>" alt="<?php echo esc_attr( $images[0]['alt'] ); ?>" id="room-hero-img" />
			<?php else : ?>
				<div style="width:100%;height:100%;background:var(--navy-800);display:flex;align-items:center;justify-content:center;color:var(--gold-soft);">
					<?php echo esc_html( get_the_title() ); ?>
				</div>
			<?php endif; ?>
			<?php if ( $badge ) : ?>
				<span class="room-card__badge"><?php echo esc_html( $badge ); ?></span>
			<?php endif; ?>
		</button>
		<?php if ( count( $images ) > 1 ) : ?>
		<div class="room-detail__thumbs" id="room-thumbs">
			<?php foreach ( array_slice( $images, 0, 5 ) as $i => $img ) : ?>
			<button class="thumb <?php echo $i === 0 ? 'thumb--active' : ''; ?>" data-full="<?php echo esc_url( $img['full'] ); ?>" data-index="<?php echo $i; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Photo %d', 'meridian' ), $i + 1 ) ); ?>">
				<img src="<?php echo esc_url( $img['thumb'] ); ?>" alt="" />
			</button>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>

	<!-- INFO -->
	<div class="room-detail__info">
		<?php if ( $category ) : ?>
			<div class="eyebrow"><?php echo esc_html( $category ); ?></div>
		<?php endif; ?>
		<h1 class="room-detail__title"><?php the_title(); ?></h1>
		<?php if ( $tagline ) : ?>
			<p class="room-detail__tag"><?php echo esc_html( $tagline ); ?></p>
		<?php endif; ?>

		<!-- SPECS -->
		<div class="specs">
			<?php if ( $guests ) : ?>
			<div>
				<?php echo meridian_icon( 'guests', 16 ); ?>
				<div><div class="specs__k"><?php esc_html_e( 'Guests', 'meridian' ); ?></div><div class="specs__v"><?php echo esc_html( $guests ); ?></div></div>
			</div>
			<?php endif; ?>
			<?php if ( $size ) : ?>
			<div>
				<?php echo meridian_icon( 'ruler', 16 ); ?>
				<div><div class="specs__k"><?php esc_html_e( 'Size', 'meridian' ); ?></div><div class="specs__v"><?php echo esc_html( $size ); ?> m²</div></div>
			</div>
			<?php endif; ?>
			<?php if ( $bed ) : ?>
			<div>
				<?php echo meridian_icon( 'bed', 16 ); ?>
				<div><div class="specs__k"><?php esc_html_e( 'Bed', 'meridian' ); ?></div><div class="specs__v"><?php echo esc_html( $bed ); ?></div></div>
			</div>
			<?php endif; ?>
			<?php if ( $view ) : ?>
			<div>
				<?php echo meridian_icon( 'eye', 16 ); ?>
				<div><div class="specs__k"><?php esc_html_e( 'View', 'meridian' ); ?></div><div class="specs__v"><?php echo esc_html( $view ); ?></div></div>
			</div>
			<?php endif; ?>
		</div>

		<!-- DESCRIPTION -->
		<div class="room-detail__desc">
			<?php the_content(); ?>
		</div>

		<!-- AMENITIES -->
		<?php if ( ! empty( $amenities ) ) : ?>
		<h3 class="room-detail__h3"><?php printf( esc_html__( 'In every %s', 'meridian' ), esc_html( strtolower( array_slice( explode( ' ', get_the_title() ), -1 )[0] ) ) ); ?></h3>
		<ul class="amenity-list">
			<?php foreach ( $amenities as $a ) : ?>
			<li><?php echo meridian_icon( 'check', 14 ); ?> <?php echo esc_html( $a ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>

		<!-- BOOKING CALCULATOR -->
		<aside class="calc" data-price="<?php echo esc_attr( $price ); ?>" data-max-guests="<?php echo esc_attr( $guests ); ?>" data-room-id="<?php echo esc_attr( $room_id ); ?>">
			<div class="calc__head">
				<div>
					<span class="calc__from"><?php esc_html_e( 'From', 'meridian' ); ?></span>
					<span class="calc__price">$<?php echo esc_html( number_format( (int) $price ) ); ?></span>
					<span class="calc__night">/ <?php esc_html_e( 'night', 'meridian' ); ?></span>
				</div>
				<div class="calc__guarantee"><?php esc_html_e( 'Best rate guaranteed', 'meridian' ); ?></div>
			</div>
			<div class="calc__dates">
				<label>
					<span><?php esc_html_e( 'Check in', 'meridian' ); ?></span>
					<input type="date" id="calc-checkin" />
				</label>
				<label>
					<span><?php esc_html_e( 'Check out', 'meridian' ); ?></span>
					<input type="date" id="calc-checkout" />
				</label>
			</div>
			<div class="calc__guests">
				<div class="stepper" data-stepper="calc-adults" data-min="1" data-max="<?php echo esc_attr( $guests ); ?>" data-value="2">
					<div class="stepper__text">
						<div class="stepper__label"><?php esc_html_e( 'Adults', 'meridian' ); ?></div>
						<div class="stepper__sub">13+</div>
					</div>
					<div class="stepper__controls">
						<button type="button" class="stepper-dec"><?php echo meridian_icon( 'minus', 14 ); ?></button>
						<span class="stepper-val">2</span>
						<button type="button" class="stepper-inc"><?php echo meridian_icon( 'plus', 14 ); ?></button>
					</div>
				</div>
				<div class="stepper" data-stepper="calc-children" data-min="0" data-max="<?php echo esc_attr( max( 0, (int) $guests - 2 ) ); ?>" data-value="0">
					<div class="stepper__text">
						<div class="stepper__label"><?php esc_html_e( 'Children', 'meridian' ); ?></div>
						<div class="stepper__sub">0–12</div>
					</div>
					<div class="stepper__controls">
						<button type="button" class="stepper-dec"><?php echo meridian_icon( 'minus', 14 ); ?></button>
						<span class="stepper-val">0</span>
						<button type="button" class="stepper-inc"><?php echo meridian_icon( 'plus', 14 ); ?></button>
					</div>
				</div>
			</div>
			<div class="calc__warn" id="calc-warn" style="display:none;"><?php printf( esc_html__( 'Maximum %s guests in this room.', 'meridian' ), esc_html( $guests ) ); ?></div>
			<ul class="calc__lines">
				<li><span id="calc-nightly">$<?php echo esc_html( number_format( (int) $price ) ); ?> × 3 <?php esc_html_e( 'nights', 'meridian' ); ?></span><span id="calc-subtotal">$<?php echo esc_html( number_format( (int) $price * 3 ) ); ?></span></li>
				<li><span><?php esc_html_e( 'Resort & service', 'meridian' ); ?></span><span id="calc-resort">$105</span></li>
				<li><span><?php esc_html_e( 'Taxes (14.75%)', 'meridian' ); ?></span><span id="calc-tax">$<?php echo esc_html( number_format( round( ( (int) $price * 3 + 105 ) * 0.1475 ) ) ); ?></span></li>
				<li class="calc__total"><span><?php esc_html_e( 'Total', 'meridian' ); ?></span><span id="calc-total">—</span></li>
			</ul>
			<button type="button" class="btn btn--gold btn--lg btn--block" id="calc-reserve">
				<?php esc_html_e( 'Reserve', 'meridian' ); ?> <?php echo meridian_icon( 'arrow-right', 16 ); ?>
			</button>
			<div class="calc__note"><?php esc_html_e( 'No charge today. Free cancellation up to 48h before arrival.', 'meridian' ); ?></div>
		</aside>
	</div>
</section>

<!-- SIMILAR ROOMS -->
<section class="section section--cream">
	<div class="container">
		<div class="section__head" data-reveal>
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Other rooms', 'meridian' ); ?></div>
				<h2 class="display"><?php esc_html_e( 'Similar stays.', 'meridian' ); ?></h2>
			</div>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'meridian_room' ) ); ?>" class="link-arrow">
				<?php esc_html_e( 'See all', 'meridian' ); ?> <?php echo meridian_icon( 'arrow-right', 14 ); ?>
			</a>
		</div>
		<div class="rooms-grid">
			<?php
			$similar = new WP_Query( array(
				'post_type'      => 'meridian_room',
				'posts_per_page' => 3,
				'post__not_in'   => array( $room_id ),
				'orderby'        => 'rand',
			) );
			$si = 0;
			if ( $similar->have_posts() ) :
				while ( $similar->have_posts() ) :
					$similar->the_post();
					set_query_var( 'room_index', $si );
					get_template_part( 'template-parts/room-card' );
					$si++;
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>
</section>

<!-- BOOKING MODAL (hidden, activated by JS) -->
<?php
get_template_part( 'template-parts/booking-modal', null, array(
	'room_id'   => $room_id,
	'room_name' => get_the_title(),
	'category'  => $category,
	'price'     => $price,
	'guests'    => $guests,
	'size'      => $size,
	'bed'       => $bed,
	'badge'     => $badge,
	'thumb_url' => has_post_thumbnail() ? get_the_post_thumbnail_url( $room_id, 'medium' ) : '',
) );
?>

<!-- LIGHTBOX (hidden, activated by JS) -->
<div class="lightbox" id="room-lightbox" style="display:none;" role="dialog" aria-modal="true">
	<button class="lightbox__close" aria-label="<?php esc_attr_e( 'Close', 'meridian' ); ?>"><?php echo meridian_icon( 'close', 22 ); ?></button>
	<button class="lightbox__nav lightbox__nav--prev" aria-label="<?php esc_attr_e( 'Previous', 'meridian' ); ?>"><?php echo meridian_icon( 'chevron-left', 26 ); ?></button>
	<div class="lightbox__frame">
		<img src="" alt="" id="room-lightbox-img" style="width:100%;height:100%;object-fit:cover;" />
		<div class="lightbox__caption" id="room-lightbox-caption"></div>
	</div>
	<button class="lightbox__nav lightbox__nav--next" aria-label="<?php esc_attr_e( 'Next', 'meridian' ); ?>"><?php echo meridian_icon( 'chevron-right', 26 ); ?></button>
</div>

<?php get_footer(); ?>
