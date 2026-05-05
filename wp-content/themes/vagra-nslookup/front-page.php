<?php
/**
 * Homepage template (front-page.php).
 *
 * 13-section cinematic homepage ported from page-cine-home.jsx.
 * React islands are rendered as empty mount-point divs; static sections
 * are pure PHP/HTML with reveal classes for scroll animation.
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-home">

	<?php // ─── 1. Cinematic dark hero ─── ?>
	<section class="cine-hero">
		<div class="container cine-hero-inner">
			<div>
				<span class="cine-eyebrow"><span class="dot"></span> <?php esc_html_e( '30+ resolvers · live now', 'vagra-nslookup' ); ?></span>
				<h1 class="cine-h1" style="margin-top:22px">
					<span class="cine-h1-word" style="margin-right:0.22em"><span style="animation-delay:0ms"><?php esc_html_e( 'DNS', 'vagra-nslookup' ); ?></span></span>
					<span class="cine-h1-word" style="margin-right:0.22em"><span style="animation-delay:110ms"><?php esc_html_e( 'propagation,', 'vagra-nslookup' ); ?></span></span>
					<span class="cine-h1-word" style="margin-right:0.22em"><span style="animation-delay:220ms"><?php esc_html_e( 'checked', 'vagra-nslookup' ); ?></span></span>
					<br/>
					<span class="cine-h1-word"><span class="cine-accent" style="animation-delay:420ms"><?php esc_html_e( 'globally.', 'vagra-nslookup' ); ?></span></span>
				</h1>
				<p class="cine-lede reveal reveal-delay-3">
					<?php esc_html_e( 'Query thirteen DNS record types across thirty public resolvers on six continents. Watch propagation roll out in real time. Free, instant, zero signup.', 'vagra-nslookup' ); ?>
				</p>
				<div class="cine-cta-row reveal reveal-delay-4">
					<a href="#tool" class="cine-btn cine-btn-primary">
						<?php esc_html_e( 'Check DNS Now', 'vagra-nslookup' ); ?>
						<svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10m-4-4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
					<a href="#how" class="cine-btn cine-btn-ghost"><?php esc_html_e( 'How it works', 'vagra-nslookup' ); ?></a>
				</div>
				<div class="cine-trust reveal reveal-delay-4">
					<span><?php esc_html_e( 'No signup', 'vagra-nslookup' ); ?></span><span class="cine-sep"></span>
					<span><?php esc_html_e( 'No rate limits', 'vagra-nslookup' ); ?></span><span class="cine-sep"></span>
					<span><?php esc_html_e( '13 record types', 'vagra-nslookup' ); ?></span>
				</div>
			</div>

			<div style="position:relative">
				<div class="cine-chip-float tl"><span class="dot" style="display:inline-block;width:6px;height:6px;border-radius:50%;margin-right:8px"></span><?php esc_html_e( 'propagated · ashburn · 24ms', 'vagra-nslookup' ); ?></div>
				<div class="cine-chip-float br"><span class="dot" style="display:inline-block;width:6px;height:6px;border-radius:50%;margin-right:8px"></span><?php esc_html_e( 'ttl 3600s · cloudflare', 'vagra-nslookup' ); ?></div>

				<div class="cine-tool reveal-scale in">
					<div class="cine-tool-inner">
						<div class="cine-tool-head">
							<div class="cine-tool-dots"><span></span><span></span><span></span></div>
							<span style="margin-left:12px"><?php esc_html_e( 'nslookup.am — live query', 'vagra-nslookup' ); ?></span>
						</div>
						<div class="cine-tool-form">
							<input class="cine-tool-input" value="nslookup.am" readonly aria-label="<?php esc_attr_e( 'Domain', 'vagra-nslookup' ); ?>"/>
							<span class="cine-tool-select">A</span>
							<span class="cine-tool-go"><?php esc_html_e( 'Lookup', 'vagra-nslookup' ); ?> &rarr;</span>
						</div>
						<div class="cine-pills">
							<?php
							$pill_types = array( 'A', 'AAAA', 'CNAME', 'MX', 'NS', 'TXT', 'SPF', 'DKIM', 'DMARC', 'SOA', 'CAA', 'SRV', 'PTR' );
							foreach ( $pill_types as $i => $type ) :
								$class = 0 === $i ? 'cine-pill on' : 'cine-pill';
							?>
								<span class="<?php echo esc_attr( $class ); ?>"><?php echo esc_html( $type ); ?></span>
							<?php endforeach; ?>
						</div>
						<div class="cine-results">
							<?php
							$demo_rows = array(
								array( 'loc' => 'Ashburn · US',   'ip' => '173.245.58.100', 'ms' => '24ms',  's' => 'ok' ),
								array( 'loc' => 'Frankfurt · DE', 'ip' => '173.245.58.100', 'ms' => '61ms',  's' => 'ok' ),
								array( 'loc' => 'Tokyo · JP',     'ip' => '173.245.58.100', 'ms' => '148ms', 's' => 'ok' ),
								array( 'loc' => 'Mumbai · IN',    'ip' => 'old.198.51.100', 'ms' => '191ms', 's' => 'err' ),
								array( 'loc' => 'Sydney · AU',    'ip' => '173.245.58.100', 'ms' => '203ms', 's' => 'ok' ),
							);
							foreach ( $demo_rows as $i => $row ) :
								$delay = 800 + $i * 120;
							?>
								<div class="cine-result-row" style="animation-delay:<?php echo esc_attr( $delay ); ?>ms">
									<span class="cine-result-dot <?php echo esc_attr( $row['s'] ); ?>"></span>
									<span class="cine-result-loc"><?php echo esc_html( $row['loc'] ); ?></span>
									<span class="cine-result-ip"><?php echo esc_html( $row['ip'] ); ?></span>
									<span class="cine-result-ms"><?php echo esc_html( $row['ms'] ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php // ─── 2. React island: hero tool ─── ?>
	<div id="nsl-hero-tool"></div>

	<?php // ─── 3. React island: marquee ─── ?>
	<div id="nsl-marquee"></div>

	<?php // ─── 4. Statement section ─── ?>
	<section class="cine-section cine-section-dark" id="how">
		<div class="cine-head-wrap">
			<span class="cine-section-eyebrow reveal"><?php esc_html_e( 'The method', 'vagra-nslookup' ); ?></span>
			<h2 class="cine-big-head reveal reveal-delay-1">
				<?php
				printf(
					/* translators: %1$s, %2$s: muted text spans */
					'%s <span class="muted">%s</span><br/>%s <span class="muted">%s</span> %s',
					esc_html__( 'One query.', 'vagra-nslookup' ),
					esc_html__( 'Thirty answers.', 'vagra-nslookup' ),
					esc_html__( 'A complete picture', 'vagra-nslookup' ),
					esc_html__( 'of your DNS,', 'vagra-nslookup' ),
					esc_html__( 'everywhere at once.', 'vagra-nslookup' )
				);
				?>
			</h2>
		</div>
	</section>

	<?php // ─── 5. React island: CLI demo ─── ?>
	<div id="nsl-cli"></div>

	<?php // ─── 6. Feature cards grid ─── ?>
	<section class="cine-section cine-section-dark">
		<div class="cine-head-wrap">
			<?php get_template_part( 'template-parts/cine-features' ); ?>
		</div>
	</section>

	<?php // ─── 7. Stat strip ─── ?>
	<section class="cine-section cine-section-dark">
		<div class="cine-head-wrap">
			<?php get_template_part( 'template-parts/cine-stats' ); ?>
		</div>
	</section>

	<?php // ─── 8. React island: globe ─── ?>
	<div id="nsl-globe"></div>

	<?php // ─── 9. Why Use section ─── ?>
	<section class="cine-section" style="background:#F7F8FC">
		<div class="cine-head-wrap">
			<span class="cine-section-eyebrow reveal"><?php esc_html_e( 'Why nslookup.am', 'vagra-nslookup' ); ?></span>
			<h2 class="cine-big-head reveal reveal-delay-1">
				<?php
				printf(
					'%s <span class="muted">%s</span> %s',
					esc_html__( 'The DNS tool you wanted', 'vagra-nslookup' ),
					esc_html__( 'the last time', 'vagra-nslookup' ),
					esc_html__( 'you were stuck at 2am.', 'vagra-nslookup' )
				);
				?>
			</h2>
			<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:32px;margin-top:72px">
				<?php
				$why_items = array(
					array( 'icon' => '&#9889;', 'title' => __( 'Instant results', 'vagra-nslookup' ),  'body' => __( 'Parallel queries return in under 2 seconds. No waiting, no polling.', 'vagra-nslookup' ) ),
					array( 'icon' => '&#127758;', 'title' => __( 'Global coverage', 'vagra-nslookup' ), 'body' => __( '30+ public DNS servers across 6 continents, updated continuously.', 'vagra-nslookup' ) ),
					array( 'icon' => '&#8734;',  'title' => __( 'Free forever', 'vagra-nslookup' ),     'body' => __( 'Every record, every region, no paid tier, no account required.', 'vagra-nslookup' ) ),
					array( 'icon' => '&#9702;',  'title' => __( 'No setup', 'vagra-nslookup' ),         'body' => __( 'Browser-only. Paste a domain, hit lookup, see the world answer.', 'vagra-nslookup' ) ),
				);
				foreach ( $why_items as $i => $item ) :
					$delay = 60 * $i;
				?>
					<div class="reveal" style="transition-delay:<?php echo esc_attr( $delay ); ?>ms;padding-top:24px;border-top:1px solid rgba(11,13,20,0.1)">
						<div style="font-size:28px"><?php echo $item['icon']; // phpcs:ignore -- trusted HTML entities ?></div>
						<h3 style="margin-top:16px;font-size:22px;font-weight:600;letter-spacing:-0.01em"><?php echo esc_html( $item['title'] ); ?></h3>
						<p style="margin-top:10px;color:rgba(11,13,20,0.6);font-size:15px;line-height:1.6"><?php echo esc_html( $item['body'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php // ─── 10. Record Types grid ─── ?>
	<?php get_template_part( 'template-parts/record-types-grid' ); ?>

	<?php // ─── 11. FAQ accordion ─── ?>
	<?php
	$home_faq = array(
		array(
			'cat'   => __( 'General', 'vagra-nslookup' ),
			'items' => array(
				array(
					'q' => __( 'What is nslookup.am?', 'vagra-nslookup' ),
					'a' => __( 'A free, browser-based DNS lookup and propagation checker. Enter any domain and instantly query 13 record types across 30+ global resolvers.', 'vagra-nslookup' ),
				),
				array(
					'q' => __( 'Is it really free?', 'vagra-nslookup' ),
					'a' => __( 'Yes. No signup, no rate limits, no paid tier. Every feature is available to everyone.', 'vagra-nslookup' ),
				),
				array(
					'q' => __( 'How many resolvers do you query?', 'vagra-nslookup' ),
					'a' => __( 'Over 30 public DNS resolvers spread across 6 continents, queried in parallel for speed.', 'vagra-nslookup' ),
				),
			),
		),
		array(
			'cat'   => __( 'Technical', 'vagra-nslookup' ),
			'items' => array(
				array(
					'q' => __( 'What record types are supported?', 'vagra-nslookup' ),
					'a' => __( 'A, AAAA, CNAME, MX, NS, TXT, SPF, DKIM, DMARC, SOA, PTR, CAA, and SRV — 13 in total.', 'vagra-nslookup' ),
				),
				array(
					'q' => __( 'How does propagation checking work?', 'vagra-nslookup' ),
					'a' => __( 'We query every resolver simultaneously and compare results. You see which resolvers have the current record and which are still caching an older value.', 'vagra-nslookup' ),
				),
			),
		),
	);

	get_template_part( 'template-parts/faq-accordion', null, array( 'categories' => $home_faq ) );
	?>

	<?php // ─── 12. Blog teaser ─── ?>
	<?php
	$blog_query = new WP_Query( array(
		'posts_per_page'      => 4,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	) );
	if ( $blog_query->have_posts() ) :
	?>
	<section class="cine-section" style="background:#fff">
		<div class="cine-head-wrap">
			<span class="cine-section-eyebrow reveal"><?php esc_html_e( 'Field notes', 'vagra-nslookup' ); ?></span>
			<h2 class="cine-big-head reveal reveal-delay-1"><?php esc_html_e( 'From the blog', 'vagra-nslookup' ); ?></h2>

			<div class="nsl-blog-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:32px;margin-top:56px">
				<?php
				$bi = 0;
				while ( $blog_query->have_posts() ) :
					$blog_query->the_post();
					$delay = 80 * $bi;
				?>
					<article class="nsl-blog-card reveal" style="transition-delay:<?php echo esc_attr( $delay ); ?>ms">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="nsl-blog-card-img" aria-hidden="true">
								<?php the_post_thumbnail( 'medium_large' ); ?>
							</a>
						<?php endif; ?>
						<div class="nsl-blog-card-body">
							<time class="nsl-blog-card-date mono" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
							<h3 class="nsl-blog-card-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<p class="nsl-blog-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
						</div>
					</article>
				<?php
					$bi++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>

			<div style="text-align:center;margin-top:48px" class="reveal">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="cine-btn cine-btn-ghost">
					<?php esc_html_e( 'All posts', 'vagra-nslookup' ); ?>
					<svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10m-4-4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</a>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php // ─── 13. Final CTA ─── ?>
	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Check DNS', 'vagra-nslookup' ), esc_html__( 'like it\'s 2026.', 'vagra-nslookup' ) ),
		'sub'       => __( 'Free. Instant. Worldwide. The DNS diagnostic tool built for the ones shipping at 2am.', 'vagra-nslookup' ),
		'cta'       => __( 'Start a lookup', 'vagra-nslookup' ),
		'href'      => '#tool',
		'secondary' => array(
			'label' => __( 'Read the field notes', 'vagra-nslookup' ),
			'href'  => home_url( '/blog/' ),
		),
	) );
	?>

</main>

<?php get_footer(); ?>
