<?php
/**
 * Front Page Template
 *
 * @package Meridian
 */

get_header();
?>

<!-- HERO -->
<section class="hero">
	<div class="hero__bg">
		<svg class="ph-skyline" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
			<defs>
				<linearGradient id="sky" x1="0" x2="0" y1="0" y2="1">
					<stop offset="0" stop-color="#0b1530"/><stop offset="0.25" stop-color="#1a365d"/><stop offset="0.5" stop-color="#3d2a52"/><stop offset="0.75" stop-color="#9a5c3f"/><stop offset="1" stop-color="#d4af37"/>
				</linearGradient>
				<linearGradient id="city" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#0a1226"/><stop offset="1" stop-color="#04070f"/></linearGradient>
				<pattern id="windows" x="0" y="0" width="14" height="22" patternUnits="userSpaceOnUse">
					<rect width="14" height="22" fill="transparent"/>
					<rect x="3" y="4" width="3" height="5" fill="#f5d68a" opacity="0.55"/>
					<rect x="8" y="4" width="3" height="5" fill="#f5d68a" opacity="0.25"/>
					<rect x="3" y="13" width="3" height="5" fill="#f5d68a" opacity="0.35"/>
					<rect x="8" y="13" width="3" height="5" fill="#f5d68a" opacity="0.55"/>
				</pattern>
			</defs>
			<rect width="1600" height="900" fill="url(#sky)"/>
			<circle cx="1180" cy="240" r="90" fill="#f5d68a" opacity="0.35"/>
			<circle cx="1180" cy="240" r="50" fill="#f7e2a5" opacity="0.55"/>
			<g opacity="0.65"><rect x="0" y="500" width="58" height="400" fill="#0a1226"/><rect x="70" y="420" width="58" height="480" fill="#0a1226"/><rect x="140" y="480" width="58" height="420" fill="#0a1226"/><rect x="210" y="380" width="58" height="520" fill="#0a1226"/><rect x="280" y="450" width="58" height="450" fill="#0a1226"/><rect x="350" y="520" width="58" height="380" fill="#0a1226"/><rect x="420" y="350" width="58" height="550" fill="#0a1226"/><rect x="490" y="440" width="58" height="460" fill="#0a1226"/><rect x="560" y="380" width="58" height="520" fill="#0a1226"/><rect x="630" y="500" width="58" height="400" fill="#0a1226"/><rect x="700" y="340" width="58" height="560" fill="#0a1226"/><rect x="770" y="420" width="58" height="480" fill="#0a1226"/><rect x="840" y="500" width="58" height="400" fill="#0a1226"/><rect x="910" y="380" width="58" height="520" fill="#0a1226"/><rect x="980" y="460" width="58" height="440" fill="#0a1226"/><rect x="1050" y="520" width="58" height="380" fill="#0a1226"/><rect x="1120" y="400" width="58" height="500" fill="#0a1226"/><rect x="1190" y="480" width="58" height="420" fill="#0a1226"/><rect x="1260" y="350" width="58" height="550" fill="#0a1226"/><rect x="1330" y="500" width="58" height="400" fill="#0a1226"/><rect x="1400" y="440" width="58" height="460" fill="#0a1226"/><rect x="1470" y="520" width="58" height="380" fill="#0a1226"/><rect x="1540" y="400" width="58" height="500" fill="#0a1226"/></g>
			<g><rect x="0" y="460" width="78" height="440" fill="url(#city)"/><rect x="2" y="470" width="74" height="420" fill="url(#windows)"/></g>
			<g><rect x="92" y="340" width="78" height="560" fill="url(#city)"/><rect x="94" y="350" width="74" height="540" fill="url(#windows)"/></g>
			<g><rect x="184" y="420" width="78" height="480" fill="url(#city)"/><rect x="186" y="430" width="74" height="460" fill="url(#windows)"/></g>
			<g><rect x="276" y="300" width="78" height="600" fill="url(#city)"/><rect x="278" y="310" width="74" height="580" fill="url(#windows)"/></g>
			<g><rect x="368" y="390" width="78" height="510" fill="url(#city)"/><rect x="370" y="400" width="74" height="490" fill="url(#windows)"/></g>
			<g><rect x="460" y="350" width="78" height="550" fill="url(#city)"/><rect x="462" y="360" width="74" height="530" fill="url(#windows)"/></g>
			<g><rect x="552" y="280" width="78" height="620" fill="url(#city)"/><rect x="554" y="290" width="74" height="600" fill="url(#windows)"/></g>
			<g><rect x="644" y="420" width="78" height="480" fill="url(#city)"/><rect x="646" y="430" width="74" height="460" fill="url(#windows)"/></g>
			<g><rect x="828" y="380" width="78" height="520" fill="url(#city)"/><rect x="830" y="390" width="74" height="500" fill="url(#windows)"/></g>
			<g><rect x="920" y="300" width="78" height="600" fill="url(#city)"/><rect x="922" y="310" width="74" height="580" fill="url(#windows)"/></g>
			<g><rect x="1012" y="440" width="78" height="460" fill="url(#city)"/><rect x="1014" y="450" width="74" height="440" fill="url(#windows)"/></g>
			<g><rect x="1104" y="360" width="78" height="540" fill="url(#city)"/><rect x="1106" y="370" width="74" height="520" fill="url(#windows)"/></g>
			<g><rect x="1196" y="300" width="78" height="600" fill="url(#city)"/><rect x="1198" y="310" width="74" height="580" fill="url(#windows)"/></g>
			<g><rect x="1288" y="400" width="78" height="500" fill="url(#city)"/><rect x="1290" y="410" width="74" height="480" fill="url(#windows)"/></g>
			<g><rect x="1380" y="340" width="78" height="560" fill="url(#city)"/><rect x="1382" y="350" width="74" height="540" fill="url(#windows)"/></g>
			<g><rect x="1472" y="420" width="78" height="480" fill="url(#city)"/><rect x="1474" y="430" width="74" height="460" fill="url(#windows)"/></g>
			<g><rect x="760" y="180" width="50" height="500" fill="#070c1a"/><rect x="762" y="200" width="46" height="460" fill="url(#windows)"/><polygon points="785,80 770,180 800,180" fill="#070c1a"/><circle cx="785" cy="80" r="3" fill="#d4af37"/></g>
		</svg>
		<div class="hero__overlay"></div>
	</div>
	<div class="hero__content">
		<div class="hero__eyebrow"><span></span><?php esc_html_e( 'Midtown Manhattan · Est. 1928', 'meridian' ); ?></div>
		<h1 class="hero__title"><?php esc_html_e( 'Where comfort meets the city.', 'meridian' ); ?></h1>
		<p class="hero__sub"><?php esc_html_e( 'A 5-star urban retreat above the streets of Midtown — quiet rooms, considered service, and a view that has not gotten old in ninety-eight years.', 'meridian' ); ?></p>
	</div>
	<div class="hero__booking">
		<?php get_template_part( 'template-parts/booking-widget' ); ?>
	</div>
	<a href="#featured" class="hero__scroll" aria-label="<?php esc_attr_e( 'Scroll to content', 'meridian' ); ?>">
		<span><?php esc_html_e( 'Discover', 'meridian' ); ?></span>
		<?php echo meridian_icon( 'arrow-down', 18 ); ?>
	</a>
</section>

<!-- WELCOME BAND -->
<section class="band" id="about">
	<div class="band__inner" data-reveal>
		<div class="eyebrow"><?php esc_html_e( 'Welcome', 'meridian' ); ?></div>
		<h2 class="display"><?php esc_html_e( 'A hotel that feels less like a hotel.', 'meridian' ); ?></h2>
		<p class="lede"><?php esc_html_e( 'The Meridian was built in 1928 as a residential tower and has been refusing to feel like a chain hotel ever since. 184 rooms, two restaurants, a rooftop, and a front desk staffed by people who answer to names — not numbers.', 'meridian' ); ?></p>
	</div>
</section>

<!-- FEATURED ROOMS -->
<section class="section" id="featured">
	<div class="container">
		<div class="section__head" data-reveal>
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Featured rooms', 'meridian' ); ?></div>
				<h2 class="display"><?php esc_html_e( 'Four ways to stay.', 'meridian' ); ?></h2>
			</div>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'meridian_room' ) ); ?>" class="link-arrow">
				<?php esc_html_e( 'View all rooms', 'meridian' ); ?> <?php echo meridian_icon( 'arrow-right', 14 ); ?>
			</a>
		</div>
		<div class="rooms-grid">
			<?php
			$rooms_query = new WP_Query( array(
				'post_type'      => 'meridian_room',
				'posts_per_page' => 4,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			) );
			$room_index = 0;
			if ( $rooms_query->have_posts() ) :
				while ( $rooms_query->have_posts() ) :
					$rooms_query->the_post();
					set_query_var( 'room_index', $room_index );
					get_template_part( 'template-parts/room-card' );
					$room_index++;
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>
</section>

<!-- AMENITIES -->
<section class="section section--dark">
	<div class="container">
		<div class="section__head" data-reveal>
			<div>
				<div class="eyebrow eyebrow--light"><?php esc_html_e( 'The essentials', 'meridian' ); ?></div>
				<h2 class="display display--light"><?php esc_html_e( 'What you can expect, every time.', 'meridian' ); ?></h2>
			</div>
			<p class="section__lede"><?php esc_html_e( 'No upsells. No surprises. Everything below is included with every reservation, in every room.', 'meridian' ); ?></p>
		</div>
		<div class="amenities">
			<?php
			$amenities = array(
				array( 'icon' => 'pin',  'title' => __( 'Prime Midtown Location', 'meridian' ), 'body' => __( 'Two blocks from Bryant Park, six from Times Square, a short walk to Central Park.', 'meridian' ) ),
				array( 'icon' => 'bell', 'title' => __( '24/7 Concierge', 'meridian' ),         'body' => __( 'Reservations, theater, transportation — handled before you think to ask.', 'meridian' ) ),
				array( 'icon' => 'bed',  'title' => __( 'Egyptian Cotton Linens', 'meridian' ),  'body' => __( '600-thread-count sheets, down pillows, and a curated pillow menu in every room.', 'meridian' ) ),
				array( 'icon' => 'wifi', 'title' => __( '1 Gbps Wi-Fi', 'meridian' ),           'body' => __( 'Symmetric fiber across the property — fast enough for the largest team call.', 'meridian' ) ),
				array( 'icon' => 'pool', 'title' => __( 'Rooftop Lounge & Pool', 'meridian' ),  'body' => __( 'A heated infinity pool, a quiet bar, and the best view of the skyline at sunset.', 'meridian' ) ),
				array( 'icon' => 'spa',  'title' => __( 'Spa & Fitness', 'meridian' ),           'body' => __( 'A full Technogym floor, two studios, and a six-treatment spa one level below.', 'meridian' ) ),
			);
			foreach ( $amenities as $i => $a ) :
			?>
			<div class="amenity" data-reveal style="--d: <?php echo $i * 60; ?>ms">
				<div class="amenity__icon"><?php echo meridian_icon( $a['icon'], 26, 1.4 ); ?></div>
				<h3 class="amenity__title"><?php echo esc_html( $a['title'] ); ?></h3>
				<p class="amenity__body"><?php echo esc_html( $a['body'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- GALLERY -->
<section class="section" id="gallery">
	<div class="container">
		<div class="section__head" data-reveal>
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Gallery', 'meridian' ); ?></div>
				<h2 class="display"><?php esc_html_e( 'Inside the building.', 'meridian' ); ?></h2>
			</div>
			<p class="section__lede"><?php esc_html_e( 'A look at the spaces — the lobby, the rooftop, the rooms, the bar.', 'meridian' ); ?></p>
		</div>
		<div class="gallery" id="meridian-gallery">
			<?php
			$gallery_labels = array(
				array( 'label' => 'Classic City Room', 'tall' => true ),
				array( 'label' => 'Ocean View Suite', 'tall' => false ),
				array( 'label' => 'Deluxe King', 'tall' => false ),
				array( 'label' => 'Mountain View Suite', 'tall' => false ),
				array( 'label' => 'Spa', 'tall' => true ),
				array( 'label' => 'Dining', 'tall' => false ),
				array( 'label' => 'Facade', 'tall' => false ),
				array( 'label' => 'Corridor', 'tall' => false ),
			);
			$room_images = array();
			$img_query = new WP_Query( array(
				'post_type'      => 'meridian_room',
				'posts_per_page' => 4,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			) );
			if ( $img_query->have_posts() ) :
				while ( $img_query->have_posts() ) :
					$img_query->the_post();
					$room_images[] = get_the_post_thumbnail_url( get_the_ID(), 'meridian-gallery' );
				endwhile;
				wp_reset_postdata();
			endif;

			foreach ( $gallery_labels as $i => $tile ) :
				$img_url = isset( $room_images[ $i ] ) ? $room_images[ $i ] : '';
				$tall_class = $tile['tall'] ? ' gallery__tile--tall' : '';
			?>
			<button type="button" class="gallery__tile<?php echo $tall_class; ?>" data-reveal style="--d: <?php echo $i * 50; ?>ms" data-index="<?php echo $i; ?>" data-caption="<?php echo esc_attr( $tile['label'] ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Open %s', 'meridian' ), $tile['label'] ) ); ?>">
				<?php if ( $img_url ) : ?>
					<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $tile['label'] ); ?>" loading="lazy" />
				<?php else : ?>
					<div style="width:100%;height:100%;background:var(--navy-700);display:flex;align-items:center;justify-content:center;color:var(--gold-soft);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;"><?php echo esc_html( $tile['label'] ); ?></div>
				<?php endif; ?>
			</button>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- TESTIMONIALS -->
<section class="section section--cream">
	<div class="container">
		<div class="section__head section__head--centered" data-reveal>
			<div class="eyebrow"><?php esc_html_e( 'Guests', 'meridian' ); ?></div>
			<h2 class="display"><?php esc_html_e( 'What people say.', 'meridian' ); ?></h2>
		</div>
		<div class="testimonials">
			<?php
			$testimonials = array(
				array(
					'name'   => 'Eleanor Whitfield',
					'role'   => __( 'Returning guest, London', 'meridian' ),
					'quote'  => __( 'The Meridian is the only hotel in Manhattan that gets the small things right. Quiet rooms, real coffee, and a front desk that remembers your name on the second visit.', 'meridian' ),
					'rating' => 5,
				),
				array(
					'name'   => 'Marcus Tan',
					'role'   => __( 'Business traveler, Singapore', 'meridian' ),
					'quote'  => __( 'Booked the Executive Studio for a four-night sprint. The desk is real, the chair is real, and the wifi is faster than my office. I extended by two days.', 'meridian' ),
					'rating' => 5,
				),
				array(
					'name'   => 'The Alvarez Family',
					'role'   => __( 'Family suite guests, Madrid', 'meridian' ),
					'quote'  => __( "We travel with three kids under ten. The Family Suite was the first hotel room that didn't feel like a compromise. The kids had their own door. We had ours.", 'meridian' ),
					'rating' => 5,
				),
			);
			foreach ( $testimonials as $i => $t ) :
				$initials = implode( '', array_map( function( $w ) { return mb_substr( $w, 0, 1 ); }, array_slice( explode( ' ', $t['name'] ), 0, 2 ) ) );
			?>
			<figure class="t-card" data-reveal style="--d: <?php echo $i * 100; ?>ms">
				<div class="t-card__rating">
					<?php for ( $s = 0; $s < $t['rating']; $s++ ) : ?>
						<?php echo meridian_icon( 'star', 14 ); ?>
					<?php endfor; ?>
				</div>
				<blockquote class="t-card__quote"><?php echo esc_html( $t['quote'] ); ?></blockquote>
				<figcaption class="t-card__who">
					<div class="t-card__avatar" aria-hidden="true"><?php echo esc_html( $initials ); ?></div>
					<div>
						<div class="t-card__name"><?php echo esc_html( $t['name'] ); ?></div>
						<div class="t-card__role"><?php echo esc_html( $t['role'] ); ?></div>
					</div>
				</figcaption>
			</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- LOCATION -->
<section class="section" id="location">
	<div class="container location">
		<div class="location__text" data-reveal>
			<div class="eyebrow"><?php esc_html_e( 'Location', 'meridian' ); ?></div>
			<h2 class="display"><?php esc_html_e( 'Midtown, off the avenue.', 'meridian' ); ?></h2>
			<p class="lede"><?php esc_html_e( 'We are one block off Sixth, on a quiet side street between Bryant Park and the theaters. Close enough to walk; quiet enough to sleep.', 'meridian' ); ?></p>
			<div class="location__address">
				<div>432 West 41st Street</div>
				<div>New York, NY 10036</div>
				<a href="tel:+12125550199">+1 (212) 555-0199</a>
			</div>
			<ul class="nearby">
				<?php
				$nearby = array(
					array( 'name' => 'Bryant Park',       'dist' => __( '2 min walk', 'meridian' ) ),
					array( 'name' => 'Times Square',      'dist' => __( '8 min walk', 'meridian' ) ),
					array( 'name' => 'Grand Central',     'dist' => __( '6 min walk', 'meridian' ) ),
					array( 'name' => 'MoMA',              'dist' => __( '10 min walk', 'meridian' ) ),
					array( 'name' => 'Central Park',      'dist' => __( '12 min walk', 'meridian' ) ),
					array( 'name' => 'Broadway Theaters',  'dist' => __( '5 min walk', 'meridian' ) ),
				);
				foreach ( $nearby as $n ) :
				?>
				<li>
					<span class="nearby__name"><?php echo esc_html( $n['name'] ); ?></span>
					<span class="nearby__dist"><?php echo esc_html( $n['dist'] ); ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
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

<?php get_footer(); ?>
