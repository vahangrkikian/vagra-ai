<?php
/**
 * Template Name: Location Page
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
			<div class="eyebrow eyebrow--light"><?php esc_html_e( 'Midtown Manhattan', 'meridian' ); ?></div>
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
			<p class="page-hero__sub"><?php esc_html_e( 'One block off Sixth Avenue, between Bryant Park and the theaters.', 'meridian' ); ?></p>
		</div>
	</section>

	<!-- Map & Directions -->
	<section class="section">
		<div class="container location">
			<div class="location__text" data-reveal>
				<div class="eyebrow"><?php esc_html_e( 'Getting here', 'meridian' ); ?></div>
				<h2 class="display"><?php esc_html_e( 'Midtown, off the avenue.', 'meridian' ); ?></h2>
				<p class="lede"><?php esc_html_e( 'We are on a quiet side street between Bryant Park and the Hudson. Close enough to walk anywhere; quiet enough to sleep with the window open.', 'meridian' ); ?></p>
				<div class="location__address">
					<div><?php esc_html_e( '432 West 41st Street', 'meridian' ); ?></div>
					<div><?php esc_html_e( 'New York, NY 10036', 'meridian' ); ?></div>
					<a href="tel:+12125550199"><?php esc_html_e( '+1 (212) 555-0199', 'meridian' ); ?></a>
				</div>
			</div>
			<div class="location__map" data-reveal aria-label="<?php esc_attr_e( 'Map of The Meridian, Midtown Manhattan', 'meridian' ); ?>">
				<svg viewBox="0 0 600 480" class="map-svg" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
					<defs><linearGradient id="mapbg" x1="0" x2="1" y1="0" y2="1"><stop offset="0" stop-color="#f3f0e8"/><stop offset="1" stop-color="#e6e1d4"/></linearGradient></defs>
					<rect width="600" height="480" fill="url(#mapbg)"/>
					<rect x="80" y="240" width="160" height="100" fill="#cdd9c2"/>
					<text x="160" y="295" font-size="11" text-anchor="middle" fill="#4a5568" font-family="ui-monospace, monospace">BRYANT PARK</text>
					<line x1="60" y1="0" x2="30" y2="480" stroke="#fff" stroke-width="14"/><line x1="160" y1="0" x2="130" y2="480" stroke="#fff" stroke-width="14"/><line x1="260" y1="0" x2="230" y2="480" stroke="#fff" stroke-width="14"/><line x1="360" y1="0" x2="330" y2="480" stroke="#fff" stroke-width="14"/><line x1="460" y1="0" x2="430" y2="480" stroke="#fff" stroke-width="14"/><line x1="540" y1="0" x2="510" y2="480" stroke="#fff" stroke-width="14"/>
					<line x1="0" y1="60" x2="600" y2="80" stroke="#fff" stroke-width="9"/><line x1="0" y1="140" x2="600" y2="160" stroke="#fff" stroke-width="9"/><line x1="0" y1="220" x2="600" y2="240" stroke="#fff" stroke-width="9"/><line x1="0" y1="300" x2="600" y2="320" stroke="#fff" stroke-width="9"/><line x1="0" y1="380" x2="600" y2="400" stroke="#fff" stroke-width="9"/><line x1="0" y1="460" x2="600" y2="480" stroke="#fff" stroke-width="9"/>
					<g><circle cx="305" cy="195" r="32" fill="#1a365d" opacity="0.18"/><circle cx="305" cy="195" r="18" fill="#1a365d"/><circle cx="305" cy="195" r="6" fill="#d4af37"/><text x="305" y="170" font-size="11" text-anchor="middle" fill="#1a365d" font-family="ui-monospace, monospace" letter-spacing="0.05em">THE MERIDIAN</text></g>
					<text x="500" y="120" font-size="10" text-anchor="middle" fill="#4a5568" font-family="ui-monospace, monospace">TIMES SQ.</text>
					<text x="120" y="120" font-size="10" text-anchor="middle" fill="#4a5568" font-family="ui-monospace, monospace">PORT AUTH.</text>
					<text x="460" y="380" font-size="10" text-anchor="middle" fill="#4a5568" font-family="ui-monospace, monospace">GRAND CENTRAL</text>
				</svg>
			</div>
		</div>
	</section>

	<!-- Nearby -->
	<section class="section section--cream">
		<div class="container">
			<div class="section__head" data-reveal>
				<div>
					<div class="eyebrow"><?php esc_html_e( 'Neighborhood', 'meridian' ); ?></div>
					<h2 class="display"><?php esc_html_e( 'What is nearby.', 'meridian' ); ?></h2>
				</div>
				<p class="section__lede"><?php esc_html_e( 'Everything you need is within walking distance.', 'meridian' ); ?></p>
			</div>
			<ul class="nearby nearby--large">
				<?php
				$nearby = array(
					array( 'name' => 'Bryant Park',        'dist' => __( '2 min walk', 'meridian' ),  'note' => __( 'Green space, reading room, seasonal markets', 'meridian' ) ),
					array( 'name' => 'Times Square',       'dist' => __( '8 min walk', 'meridian' ),  'note' => __( 'Theater district, dining, nightlife', 'meridian' ) ),
					array( 'name' => 'Grand Central',      'dist' => __( '6 min walk', 'meridian' ),  'note' => __( 'Metro-North, subway hub, dining concourse', 'meridian' ) ),
					array( 'name' => 'MoMA',               'dist' => __( '10 min walk', 'meridian' ), 'note' => __( 'Modern art, sculpture garden, film program', 'meridian' ) ),
					array( 'name' => 'Central Park',       'dist' => __( '12 min walk', 'meridian' ), 'note' => __( 'South entrance via Columbus Circle', 'meridian' ) ),
					array( 'name' => 'Broadway Theaters',  'dist' => __( '5 min walk', 'meridian' ),  'note' => __( 'Concierge can arrange same-day tickets', 'meridian' ) ),
					array( 'name' => 'Penn Station',       'dist' => __( '10 min walk', 'meridian' ), 'note' => __( 'Amtrak, NJ Transit, LIRR connections', 'meridian' ) ),
					array( 'name' => 'Hudson Yards',       'dist' => __( '15 min walk', 'meridian' ), 'note' => __( 'Shopping, The Vessel, Edge observation deck', 'meridian' ) ),
				);
				foreach ( $nearby as $i => $n ) :
				?>
				<li data-reveal style="--d: <?php echo $i * 60; ?>ms">
					<span class="nearby__name"><?php echo esc_html( $n['name'] ); ?></span>
					<span class="nearby__note"><?php echo esc_html( $n['note'] ); ?></span>
					<span class="nearby__dist"><?php echo esc_html( $n['dist'] ); ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- Transport -->
	<section class="section section--dark">
		<div class="container">
			<div class="section__head section__head--centered" data-reveal>
				<div class="eyebrow eyebrow--light"><?php esc_html_e( 'Transport', 'meridian' ); ?></div>
				<h2 class="display display--light"><?php esc_html_e( 'Getting to The Meridian.', 'meridian' ); ?></h2>
			</div>
			<div class="amenities">
				<?php
				$transport = array(
					array( 'icon' => 'pin', 'title' => __( 'From JFK', 'meridian' ),      'body' => __( 'AirTrain to Jamaica, then E train to 42nd St-Port Authority. ~60 minutes. Taxi or car service ~45 min.', 'meridian' ) ),
					array( 'icon' => 'pin', 'title' => __( 'From LaGuardia', 'meridian' ), 'body' => __( 'M60 bus to 125th St, then subway downtown. ~50 minutes. Taxi ~30 min depending on traffic.', 'meridian' ) ),
					array( 'icon' => 'pin', 'title' => __( 'From Newark', 'meridian' ),    'body' => __( 'AirTrain to NJ Transit, then Penn Station. ~40 minutes. The hotel is a 10-minute walk from Penn.', 'meridian' ) ),
				);
				foreach ( $transport as $i => $t ) :
				?>
				<div class="amenity" data-reveal style="--d: <?php echo $i * 80; ?>ms">
					<div class="amenity__icon"><?php echo meridian_icon( $t['icon'], 26, 1.4 ); ?></div>
					<h3 class="amenity__title"><?php echo esc_html( $t['title'] ); ?></h3>
					<p class="amenity__body"><?php echo esc_html( $t['body'] ); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
