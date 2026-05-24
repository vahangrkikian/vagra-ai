<?php
/**
 * Template Name: About Page
 * Template Post Type: page
 *
 * @package Meridian
 */

// Elementor: if built with Elementor, let it render.
if ( defined( 'ELEMENTOR_VERSION' )
     && \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) {
    get_header();
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    get_footer();
    return;
}

get_header();
?>

<main id="primary" class="site-main">

	<!-- Page Hero -->
	<section class="page-hero">
		<div class="page-hero__inner">
			<div class="eyebrow eyebrow--light"><?php esc_html_e( 'Since 1928', 'meridian' ); ?></div>
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
			<p class="page-hero__sub"><?php esc_html_e( 'A hotel that has always preferred understatement to spectacle.', 'meridian' ); ?></p>
		</div>
	</section>

	<!-- Story -->
	<section class="section">
		<div class="container">
			<div class="about-grid" data-reveal>
				<div class="about-grid__text">
					<div class="eyebrow"><?php esc_html_e( 'Our Story', 'meridian' ); ?></div>
					<h2 class="display"><?php esc_html_e( 'Built as a home. Run as one ever since.', 'meridian' ); ?></h2>
					<p class="lede"><?php esc_html_e( 'The Meridian opened in 1928 as a residential tower on a quiet block between Bryant Park and the Hudson. It was converted to a hotel in 1962, but the residential philosophy never left: real kitchens, full-size closets, proper desks, and rooms designed for living — not just sleeping.', 'meridian' ); ?></p>
					<p><?php esc_html_e( 'Today the hotel has 184 rooms across 24 floors, two restaurants, a rooftop pool, and a six-treatment spa. We employ 220 people, most of whom have been here for more than five years. That continuity is the point — guests return because the staff remembers.', 'meridian' ); ?></p>
				</div>
				<div class="about-grid__image">
					<div class="about-placeholder" aria-hidden="true">
						<svg viewBox="0 0 400 500" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="400" height="500" fill="#122448"/>
							<rect x="160" y="80" width="80" height="340" fill="#1a365d"/>
							<rect x="100" y="160" width="200" height="260" fill="#1a365d"/>
							<rect x="120" y="180" width="40" height="30" fill="#d4af37" opacity="0.4"/>
							<rect x="180" y="180" width="40" height="30" fill="#d4af37" opacity="0.6"/>
							<rect x="240" y="180" width="40" height="30" fill="#d4af37" opacity="0.3"/>
							<rect x="120" y="230" width="40" height="30" fill="#d4af37" opacity="0.5"/>
							<rect x="180" y="230" width="40" height="30" fill="#d4af37" opacity="0.4"/>
							<rect x="240" y="230" width="40" height="30" fill="#d4af37" opacity="0.7"/>
							<rect x="120" y="280" width="40" height="30" fill="#d4af37" opacity="0.3"/>
							<rect x="180" y="280" width="40" height="30" fill="#d4af37" opacity="0.5"/>
							<rect x="240" y="280" width="40" height="30" fill="#d4af37" opacity="0.4"/>
							<text x="200" y="400" text-anchor="middle" fill="#d4af37" font-size="12" font-family="serif" opacity="0.6">Est. 1928</text>
						</svg>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Values -->
	<section class="section section--cream">
		<div class="container">
			<div class="section__head section__head--centered" data-reveal>
				<div class="eyebrow"><?php esc_html_e( 'Our principles', 'meridian' ); ?></div>
				<h2 class="display"><?php esc_html_e( 'What we believe in.', 'meridian' ); ?></h2>
			</div>
			<div class="amenities">
				<?php
				$values = array(
					array( 'icon' => 'bell', 'title' => __( 'Genuine Service', 'meridian' ), 'body' => __( 'We hire for warmth and train for skill. Our staff knows your name by the second visit — because they want to, not because a system told them to.', 'meridian' ) ),
					array( 'icon' => 'bed',  'title' => __( 'Quiet Luxury', 'meridian' ),    'body' => __( 'No marble lobbies, no chandeliers, no gold leaf. Just excellent materials, considered design, and rooms that feel like home.', 'meridian' ) ),
					array( 'icon' => 'star', 'title' => __( 'Consistency', 'meridian' ),     'body' => __( 'The same high standard on a Tuesday in February as a Saturday in June. Every room, every floor, every time.', 'meridian' ) ),
				);
				foreach ( $values as $i => $v ) :
				?>
				<div class="amenity" data-reveal style="--d: <?php echo $i * 80; ?>ms">
					<div class="amenity__icon"><?php echo meridian_icon( $v['icon'], 26, 1.4 ); ?></div>
					<h3 class="amenity__title"><?php echo esc_html( $v['title'] ); ?></h3>
					<p class="amenity__body"><?php echo esc_html( $v['body'] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Numbers -->
	<section class="section section--dark">
		<div class="container">
			<div class="stats" data-reveal>
				<?php
				$stats = array(
					array( 'number' => '1928', 'label' => __( 'Year founded', 'meridian' ) ),
					array( 'number' => '184',  'label' => __( 'Rooms & suites', 'meridian' ) ),
					array( 'number' => '220',  'label' => __( 'Team members', 'meridian' ) ),
					array( 'number' => '96%',  'label' => __( 'Guest return rate', 'meridian' ) ),
				);
				foreach ( $stats as $s ) :
				?>
				<div class="stat">
					<div class="stat__number"><?php echo esc_html( $s['number'] ); ?></div>
					<div class="stat__label"><?php echo esc_html( $s['label'] ); ?></div>
				</div>
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
