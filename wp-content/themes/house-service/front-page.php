<?php
/**
 * Front Page Template
 *
 * @package House_Service
 */

get_header();
?>

<!-- HERO -->
<section class="hero">
	<div class="shell">
		<div class="hero__grid">

			<!-- Left: Text + Search -->
			<div class="hero__left" data-reveal>
				<div class="hero__eyebrow">
					<?php echo hs_icon( 'shield', 16 ); ?>
					<?php esc_html_e( '240+ verified providers', 'house-service' ); ?>
				</div>
				<h1 class="hero__title"><?php esc_html_e( 'Find reliable service companies near you.', 'house-service' ); ?></h1>
				<p class="hero__sub"><?php esc_html_e( 'Cleaners, movers, repair pros, assembly teams — background-checked, reviewed by real customers, and ready to book this week.', 'house-service' ); ?></p>

				<!-- Search card -->
				<form class="hero__search" id="hero-search" action="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ); ?>" method="get">
					<div class="hero__search-field">
						<?php echo hs_icon( 'search', 20 ); ?>
						<input type="text" name="hs_q" placeholder="<?php esc_attr_e( 'What do you need?', 'house-service' ); ?>" aria-label="<?php esc_attr_e( 'Service type', 'house-service' ); ?>">
					</div>
					<div class="hero__search-divider"></div>
					<div class="hero__search-field">
						<?php echo hs_icon( 'pin', 20 ); ?>
						<input type="text" name="hs_loc" placeholder="<?php esc_attr_e( 'City or ZIP', 'house-service' ); ?>" aria-label="<?php esc_attr_e( 'Location', 'house-service' ); ?>">
					</div>
					<button type="submit" class="hero__search-btn" aria-label="<?php esc_attr_e( 'Search providers', 'house-service' ); ?>">
						<?php echo hs_icon( 'search', 22 ); ?>
					</button>
				</form>

				<!-- Trust pills -->
				<div class="hero__trust">
					<span class="trust-pill">
						<?php echo hs_icon( 'shield', 14 ); ?>
						<?php esc_html_e( 'Background-checked', 'house-service' ); ?>
					</span>
					<span class="trust-pill">
						<?php echo hs_icon( 'star', 14 ); ?>
						<?php esc_html_e( 'Verified reviews', 'house-service' ); ?>
					</span>
					<span class="trust-pill">
						<?php echo hs_icon( 'calendar', 14 ); ?>
						<?php esc_html_e( 'Same-week availability', 'house-service' ); ?>
					</span>
				</div>
			</div>

			<!-- Right: Visual -->
			<div class="hero__visual" data-reveal>
				<div class="hero__image">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/photo_hero.jpg' ); ?>" alt="<?php esc_attr_e( 'Friendly home-service crew', 'house-service' ); ?>" />
				</div>
				<div class="hero__chip">
					<span class="hero__chip-dot"></span>
					<?php esc_html_e( '1,200+ jobs this week', 'house-service' ); ?>
				</div>
			</div>

		</div>

		<!-- Stats row -->
		<div class="hero__stats" data-reveal>
			<div class="hero__stat">
				<div class="hero__stat-value" data-count="240">240+</div>
				<div class="hero__stat-label"><?php esc_html_e( 'Verified pros', 'house-service' ); ?></div>
			</div>
			<div class="hero__stat">
				<div class="hero__stat-value">4.8<?php echo hs_icon( 'star', 16 ); ?></div>
				<div class="hero__stat-label"><?php esc_html_e( 'Avg rating', 'house-service' ); ?></div>
			</div>
			<div class="hero__stat">
				<div class="hero__stat-value"><?php esc_html_e( '2 hr', 'house-service' ); ?></div>
				<div class="hero__stat-label"><?php esc_html_e( 'Median reply', 'house-service' ); ?></div>
			</div>
		</div>
	</div>
</section>

<!-- CATEGORIES -->
<section class="section" id="categories">
	<div class="shell">
		<div class="section__head" data-reveal>
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Categories', 'house-service' ); ?></div>
				<h2><?php esc_html_e( 'What can we help with?', 'house-service' ); ?></h2>
				<p class="lead"><?php esc_html_e( 'Browse by service type to find the right team for the job.', 'house-service' ); ?></p>
			</div>
			<a href="<?php echo esc_url( home_url( '/categories/' ) ); ?>" class="head-link">
				<?php esc_html_e( 'All categories', 'house-service' ); ?>
				<?php echo hs_icon( 'arrow', 18 ); ?>
			</a>
		</div>

		<div class="cat-grid">
			<?php
			$categories = array(
				array(
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6l3 1 2 3v6l-2 4h4l-2-4v-6l2-3 3-1"/><path d="M14 4l1 2h6l1-2"/><circle cx="12" cy="20" r="2"/></svg>',
					'title' => __( 'Cleaning', 'house-service' ),
					'desc'  => __( 'Deep cleans, move-out, office cleaning, and regular maintenance.', 'house-service' ),
					'count' => 64,
				),
				array(
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="6" width="22" height="12" rx="2"/><path d="M1 10h22"/><path d="M6 18v2"/><path d="M18 18v2"/></svg>',
					'title' => __( 'Moving', 'house-service' ),
					'desc'  => __( 'Local moves, long-distance, packing services, and storage.', 'house-service' ),
					'count' => 38,
				),
				array(
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>',
					'title' => __( 'Repair', 'house-service' ),
					'desc'  => __( 'Plumbing, electrical, HVAC, appliance repair, and handyman.', 'house-service' ),
					'count' => 92,
				),
				array(
					'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/><path d="M12 12v4"/><path d="M10 14h4"/></svg>',
					'title' => __( 'Assembly', 'house-service' ),
					'desc'  => __( 'Furniture assembly, TV mounting, shelving, and installations.', 'house-service' ),
					'count' => 51,
				),
			);

			foreach ( $categories as $index => $cat ) :
			?>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ? add_query_arg( 'hs_cat', sanitize_title( $cat['title'] ), get_post_type_archive_link( 'hs_provider' ) ) : home_url( '/hs_provider/' ) ); ?>" class="cat-card" data-reveal>
				<div class="cat-card__icon"><?php echo $cat['icon']; ?></div>
				<h3 class="cat-card__title"><?php echo esc_html( $cat['title'] ); ?></h3>
				<p class="cat-card__desc"><?php echo esc_html( $cat['desc'] ); ?></p>
				<div class="cat-card__foot">
					<span class="cat-card__count">
						<?php
						printf(
							/* translators: %d = number of providers */
							esc_html__( '%d providers', 'house-service' ),
							absint( $cat['count'] )
						);
						?>
					</span>
					<span class="cat-card__arrow"><?php echo hs_icon( 'arrow', 16 ); ?></span>
				</div>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- PRICING -->
<section class="section section--alt" id="pricing">
	<div class="shell">
		<div class="section__head" data-reveal>
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Transparent pricing', 'house-service' ); ?></div>
				<h2><?php esc_html_e( 'Know what you\'ll pay upfront.', 'house-service' ); ?></h2>
				<p class="lead"><?php esc_html_e( 'Starting prices for the most popular home services. Exact quotes are free and obligation-free.', 'house-service' ); ?></p>
			</div>
		</div>

		<div class="price-grid">
			<?php
			$pricing = array(
				array(
					'icon'     => 'Cleaning',
					'svg'      => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6l3 1 2 3v6l-2 4h4l-2-4v-6l2-3 3-1"/><path d="M14 4l1 2h6l1-2"/></svg>',
					'category' => __( 'Cleaning', 'house-service' ),
					'amount'   => '$89',
					'unit'     => __( '/visit', 'house-service' ),
					'items'    => array(
						__( 'Kitchen & bathrooms deep clean', 'house-service' ),
						__( 'Vacuuming & mopping all floors', 'house-service' ),
						__( 'Dusting surfaces & fixtures', 'house-service' ),
						__( 'Trash removal & recycling', 'house-service' ),
					),
					'extras'   => __( 'Add-ons: fridge interior, oven, windows', 'house-service' ),
					'featured' => false,
				),
				array(
					'icon'     => 'Moving',
					'svg'      => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="6" width="22" height="12" rx="2"/><path d="M1 10h22"/><path d="M6 18v2"/><path d="M18 18v2"/></svg>',
					'category' => __( 'Moving', 'house-service' ),
					'amount'   => '$129',
					'unit'     => __( '/hour', 'house-service' ),
					'items'    => array(
						__( '2-person crew with truck', 'house-service' ),
						__( 'Furniture padding & wrapping', 'house-service' ),
						__( 'Disassembly & reassembly', 'house-service' ),
						__( 'Floor & doorway protection', 'house-service' ),
					),
					'extras'   => __( 'Add-ons: packing supplies, storage', 'house-service' ),
					'featured' => true,
					'flag'     => __( 'Most booked', 'house-service' ),
				),
				array(
					'icon'     => 'Repair',
					'svg'      => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>',
					'category' => __( 'Repair', 'house-service' ),
					'amount'   => '$95',
					'unit'     => __( '/visit', 'house-service' ),
					'items'    => array(
						__( 'Diagnostic & assessment included', 'house-service' ),
						__( 'Licensed & insured technicians', 'house-service' ),
						__( 'Common parts stocked on truck', 'house-service' ),
						__( '90-day repair guarantee', 'house-service' ),
					),
					'extras'   => __( 'Add-ons: emergency/same-day surcharge', 'house-service' ),
					'featured' => false,
				),
				array(
					'icon'     => 'Assembly',
					'svg'      => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/><path d="M12 12v4"/><path d="M10 14h4"/></svg>',
					'category' => __( 'Assembly', 'house-service' ),
					'amount'   => '$65',
					'unit'     => __( '/item', 'house-service' ),
					'items'    => array(
						__( 'IKEA & flat-pack furniture', 'house-service' ),
						__( 'TV wall mounting', 'house-service' ),
						__( 'Shelving & storage units', 'house-service' ),
						__( 'Cleanup of packaging waste', 'house-service' ),
					),
					'extras'   => __( 'Add-ons: wall anchoring, cord concealment', 'house-service' ),
					'featured' => false,
				),
			);

			foreach ( $pricing as $card ) :
				$class = 'price-card';
				if ( $card['featured'] ) {
					$class .= ' price-card--featured';
				}
			?>
			<div class="<?php echo esc_attr( $class ); ?>" data-reveal>
				<?php if ( ! empty( $card['flag'] ) ) : ?>
					<span class="price-card__flag"><?php echo esc_html( $card['flag'] ); ?></span>
				<?php endif; ?>
				<div class="price-card__icon"><?php echo $card['svg']; ?></div>
				<div class="price-card__category"><?php echo esc_html( $card['category'] ); ?></div>
				<div class="price-card__amount"><?php echo esc_html( $card['amount'] ); ?><span class="price-card__unit"><?php echo esc_html( $card['unit'] ); ?></span></div>
				<ul class="price-card__list">
					<?php foreach ( $card['items'] as $item ) : ?>
					<li class="price-card__item">
						<?php echo hs_icon( 'check', 16 ); ?>
						<span><?php echo esc_html( $item ); ?></span>
					</li>
					<?php endforeach; ?>
				</ul>
				<p class="price-card__extras"><?php echo esc_html( $card['extras'] ); ?></p>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ); ?>" class="btn <?php echo $card['featured'] ? 'btn-white' : 'btn-primary'; ?> btn-block">
					<?php esc_html_e( 'Browse providers', 'house-service' ); ?>
					<?php echo hs_icon( 'arrow', 18 ); ?>
				</a>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- FEATURED PROVIDERS -->
<section class="section" id="providers">
	<div class="shell">
		<div class="section__head" data-reveal>
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Top rated', 'house-service' ); ?></div>
				<h2><?php esc_html_e( 'Featured providers', 'house-service' ); ?></h2>
				<p class="lead"><?php esc_html_e( 'Vetted companies with outstanding track records and verified reviews.', 'house-service' ); ?></p>
			</div>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ); ?>" class="head-link">
				<?php esc_html_e( 'View all', 'house-service' ); ?>
				<?php echo hs_icon( 'arrow', 18 ); ?>
			</a>
		</div>

		<div class="co-grid">
			<?php
			$providers_query = new WP_Query( array(
				'post_type'      => 'hs_provider',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );

			if ( $providers_query->have_posts() ) :
				while ( $providers_query->have_posts() ) :
					$providers_query->the_post();
					get_template_part( 'template-parts/provider-card' );
				endwhile;
				wp_reset_postdata();
			else :
				// Fallback demo cards when no providers exist.
				$demo_providers = array(
					array(
						'name'     => 'SparkleClean Co.',
						'tagline'  => 'Premium residential & commercial cleaning',
						'category' => 'Cleaning',
						'rating'   => '4.9',
						'reviews'  => '127',
						'location' => 'Los Angeles, CA',
						'tags'     => array( 'Deep Clean', 'Move-out', 'Office' ),
					),
					array(
						'name'     => 'SwiftMove Logistics',
						'tagline'  => 'Local & long-distance moving specialists',
						'category' => 'Moving',
						'rating'   => '4.8',
						'reviews'  => '89',
						'location' => 'San Francisco, CA',
						'tags'     => array( 'Local', 'Long-distance', 'Packing' ),
					),
					array(
						'name'     => 'FixRight Repairs',
						'tagline'  => 'Plumbing, electrical & general handyman',
						'category' => 'Repair',
						'rating'   => '4.7',
						'reviews'  => '203',
						'location' => 'Austin, TX',
						'tags'     => array( 'Plumbing', 'Electrical', 'Drywall' ),
					),
				);

				foreach ( $demo_providers as $dp ) :
				?>
				<div class="co-card" data-reveal>
					<div class="co-card__image">
						<div class="ph"></div>
						<span class="co-card__badge"><?php echo esc_html( $dp['category'] ); ?></span>
						<span class="co-card__verified"><?php echo hs_icon( 'check', 14 ); ?></span>
					</div>
					<div class="co-card__body">
						<h3 class="co-card__name"><?php echo esc_html( $dp['name'] ); ?></h3>
						<p class="co-card__tagline"><?php echo esc_html( $dp['tagline'] ); ?></p>
						<div class="co-card__rating">
							<?php echo hs_render_stars( floatval( $dp['rating'] ) ); ?>
							<span class="co-card__rating-num"><?php echo esc_html( $dp['rating'] ); ?></span>
							<span class="co-card__rating-count">(<?php echo esc_html( $dp['reviews'] ); ?>)</span>
						</div>
						<div class="co-card__tags">
							<?php foreach ( $dp['tags'] as $tag ) : ?>
								<span class="tag"><?php echo esc_html( $tag ); ?></span>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="co-card__foot">
						<span class="co-card__location">
							<?php echo hs_icon( 'pin', 14 ); ?>
							<?php echo esc_html( $dp['location'] ); ?>
						</span>
						<span class="co-card__link">
							<?php esc_html_e( 'View profile', 'house-service' ); ?>
							<?php echo hs_icon( 'arrow', 16 ); ?>
						</span>
					</div>
				</div>
				<?php endforeach;
			endif;
			?>
		</div>
	</div>
</section>

<!-- CTA STRIP -->
<section class="cta-strip">
	<div class="shell">
		<div class="cta-strip__card" data-reveal>
			<h2 class="cta-strip__title"><?php esc_html_e( 'Ready to find your pro?', 'house-service' ); ?></h2>
			<p class="cta-strip__desc"><?php esc_html_e( 'Browse verified providers, compare quotes, and book the right team for your home project — all in one place.', 'house-service' ); ?></p>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ); ?>" class="btn btn-white btn-lg">
				<?php esc_html_e( 'Browse providers', 'house-service' ); ?>
				<?php echo hs_icon( 'arrow', 18 ); ?>
			</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
