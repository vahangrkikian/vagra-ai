<?php
/**
 * Template Name: Gallery Page
 * Template Post Type: page
 *
 * @package Meridian
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- Page Hero -->
	<section class="page-hero">
		<div class="page-hero__inner">
			<div class="eyebrow eyebrow--light"><?php esc_html_e( 'The Meridian', 'meridian' ); ?></div>
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
			<p class="page-hero__sub"><?php esc_html_e( 'A look inside — the rooms, the lobby, the rooftop, the details.', 'meridian' ); ?></p>
		</div>
	</section>

	<!-- Room Gallery from CPT -->
	<section class="section">
		<div class="container">
			<div class="section__head" data-reveal>
				<div>
					<div class="eyebrow"><?php esc_html_e( 'Rooms & suites', 'meridian' ); ?></div>
					<h2 class="display"><?php esc_html_e( 'Where you will stay.', 'meridian' ); ?></h2>
				</div>
			</div>
			<div class="gallery" id="meridian-gallery">
				<?php
				$rooms = new WP_Query( array(
					'post_type'      => 'meridian_room',
					'posts_per_page' => -1,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				) );
				$idx = 0;
				if ( $rooms->have_posts() ) :
					while ( $rooms->have_posts() ) :
						$rooms->the_post();
						$img_url = get_the_post_thumbnail_url( get_the_ID(), 'meridian-gallery' );
						$tall    = ( $idx % 3 === 0 );
				?>
				<button type="button" class="gallery__tile<?php echo $tall ? ' gallery__tile--tall' : ''; ?>" data-reveal style="--d: <?php echo $idx * 50; ?>ms" data-index="<?php echo $idx; ?>" data-caption="<?php echo esc_attr( get_the_title() ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Open %s', 'meridian' ), get_the_title() ) ); ?>">
					<?php if ( $img_url ) : ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
					<?php else : ?>
						<div style="width:100%;height:100%;background:var(--navy-700);display:flex;align-items:center;justify-content:center;color:var(--gold-soft);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;"><?php echo esc_html( get_the_title() ); ?></div>
					<?php endif; ?>
				</button>
				<?php
						$idx++;
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>
	</section>

	<!-- Spaces Gallery -->
	<section class="section section--cream">
		<div class="container">
			<div class="section__head" data-reveal>
				<div>
					<div class="eyebrow"><?php esc_html_e( 'Spaces', 'meridian' ); ?></div>
					<h2 class="display"><?php esc_html_e( 'Beyond the room.', 'meridian' ); ?></h2>
				</div>
				<p class="section__lede"><?php esc_html_e( 'The lobby, the rooftop, the restaurant, the spa — the spaces that make a hotel more than a bed.', 'meridian' ); ?></p>
			</div>
			<div class="gallery">
				<?php
				$spaces = array(
					array( 'label' => __( 'Grand Lobby', 'meridian' ), 'tall' => true ),
					array( 'label' => __( 'Rooftop Pool', 'meridian' ), 'tall' => false ),
					array( 'label' => __( 'The Bar', 'meridian' ), 'tall' => false ),
					array( 'label' => __( 'Spa & Wellness', 'meridian' ), 'tall' => false ),
					array( 'label' => __( 'Restaurant', 'meridian' ), 'tall' => true ),
					array( 'label' => __( 'Fitness Center', 'meridian' ), 'tall' => false ),
				);
				foreach ( $spaces as $si => $space ) :
				?>
				<button type="button" class="gallery__tile<?php echo $space['tall'] ? ' gallery__tile--tall' : ''; ?>" data-reveal style="--d: <?php echo $si * 50; ?>ms">
					<div style="width:100%;height:100%;background:var(--navy-700);display:flex;align-items:center;justify-content:center;color:var(--gold-soft);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;"><?php echo esc_html( $space['label'] ); ?></div>
				</button>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- WP Content (if any entered in editor) -->
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php if ( get_the_content() ) : ?>
		<section class="section">
			<div class="container">
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		</section>
		<?php endif; ?>
	<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
