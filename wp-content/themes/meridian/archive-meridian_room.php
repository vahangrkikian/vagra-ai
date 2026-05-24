<?php
/**
 * Room Archive Template
 *
 * @package Meridian
 */

get_header();

$categories = get_terms( array(
	'taxonomy'   => 'meridian_room_cat',
	'hide_empty' => false,
) );
$total_rooms = wp_count_posts( 'meridian_room' )->publish;
$active_cat  = '';
if ( is_tax( 'meridian_room_cat' ) ) {
	$active_cat = get_queried_object()->slug;
}
?>

<!-- PAGE HERO -->
<section class="page-hero">
	<div class="page-hero__bg">
		<div style="width:100%;height:100%;background:linear-gradient(135deg, #1a365d, #0b1530);"></div>
		<div class="page-hero__overlay"></div>
	</div>
	<div class="container page-hero__inner">
		<div class="eyebrow eyebrow--light"><?php esc_html_e( 'Stay', 'meridian' ); ?></div>
		<h1 class="page-hero__title"><?php esc_html_e( 'Rooms & Suites', 'meridian' ); ?></h1>
		<p class="page-hero__sub"><?php esc_html_e( '184 rooms across 22 floors. Every one of them with a view, a bed worth waking up rested in, and a writing desk that did not come from a catalog.', 'meridian' ); ?></p>
	</div>
</section>

<!-- FILTER BAR -->
<div class="filterbar">
	<div class="container filterbar__inner">
		<div class="filterbar__tabs" role="tablist" id="room-filter-tabs">
			<button class="tab <?php echo empty( $active_cat ) ? 'tab--active' : ''; ?>" role="tab" data-cat="" aria-selected="<?php echo empty( $active_cat ) ? 'true' : 'false'; ?>">
				<?php esc_html_e( 'All', 'meridian' ); ?>
				<span class="tab__count"><?php echo intval( $total_rooms ); ?></span>
			</button>
			<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
				<?php foreach ( $categories as $cat ) :
					$cat_count = $cat->count;
				?>
				<button class="tab <?php echo ( $active_cat === $cat->slug ) ? 'tab--active' : ''; ?>" role="tab" data-cat="<?php echo esc_attr( $cat->slug ); ?>" aria-selected="<?php echo ( $active_cat === $cat->slug ) ? 'true' : 'false'; ?>">
					<?php echo esc_html( $cat->name ); ?>
					<span class="tab__count"><?php echo intval( $cat_count ); ?></span>
				</button>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<label class="sort">
			<span><?php esc_html_e( 'Sort', 'meridian' ); ?></span>
			<select id="room-sort">
				<option value="featured"><?php esc_html_e( 'Featured', 'meridian' ); ?></option>
				<option value="price-asc"><?php esc_html_e( 'Price, low to high', 'meridian' ); ?></option>
				<option value="price-desc"><?php esc_html_e( 'Price, high to low', 'meridian' ); ?></option>
				<option value="size"><?php esc_html_e( 'Size', 'meridian' ); ?></option>
			</select>
			<?php echo meridian_icon( 'chevron-down', 14 ); ?>
		</label>
	</div>
</div>

<!-- ROOMS GRID -->
<section class="section">
	<div class="container">
		<div class="rooms-grid rooms-grid--list" id="rooms-grid">
			<?php
			$room_index = 0;
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					set_query_var( 'room_index', $room_index );
					get_template_part( 'template-parts/room-card' );
					$room_index++;
				endwhile;
			else :
			?>
			<div class="empty"><?php esc_html_e( 'No rooms in this category right now. Try another.', 'meridian' ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
