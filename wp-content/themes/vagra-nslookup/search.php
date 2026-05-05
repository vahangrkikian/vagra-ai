<?php
/**
 * Search results template.
 *
 * Reuses the cinematic archive layout with search-specific hero.
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-search">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'Search', 'vagra-nslookup' ),
		'title'   => sprintf(
			'%s <span class="cine-accent">&ldquo;%s&rdquo;</span>',
			esc_html__( 'Results for', 'vagra-nslookup' ),
			esc_html( get_search_query() )
		),
		'lede'    => sprintf(
			/* translators: %d: number of results */
			esc_html__( '%d results found.', 'vagra-nslookup' ),
			(int) $wp_query->found_posts
		),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'Search', 'vagra-nslookup' ) ),
		),
	) );
	?>

	<section class="cine-section" style="background:#fff; padding-top:40px">
		<div class="cine-head-wrap">
			<?php if ( have_posts() ) : ?>
				<div class="nsl-blog-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:32px; margin-top:32px">
					<?php
					$bi = 0;
					while ( have_posts() ) :
						the_post();
						$delay = 60 * $bi;
					?>
						<article class="reveal nsl-blog-card" style="transition-delay:<?php echo esc_attr( $delay ); ?>ms; border-radius:20px; overflow:hidden; background:#fff; border:1px solid rgba(11,13,20,0.08)">
							<div style="padding:22px 24px 26px; display:flex; flex-direction:column; gap:10px">
								<div style="display:flex; gap:10px; font-size:11px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.1em; color:rgba(11,13,20,0.5)">
									<span><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span><span>&middot;</span>
									<span><?php echo esc_html( get_the_date( 'M j' ) ); ?></span>
								</div>
								<h3 style="font-size:22px; font-weight:600; letter-spacing:-0.015em; line-height:1.3">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<p style="font-size:14px; color:rgba(11,13,20,0.6); line-height:1.55"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
								<a href="<?php the_permalink(); ?>" style="margin-top:auto; color:var(--nsl-primary-600); font-size:13px; font-weight:600"><?php esc_html_e( 'Read &rarr;', 'vagra-nslookup' ); ?></a>
							</div>
						</article>
					<?php
						$bi++;
					endwhile;
					?>
				</div>

				<?php
				the_posts_pagination( array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'mid_size'  => 2,
				) );
				?>
			<?php else : ?>
				<div style="text-align:center; padding:80px 0">
					<p style="color:rgba(11,13,20,0.5); font-size:18px; margin-bottom:24px">
						<?php esc_html_e( 'No results found. Try a different search term.', 'vagra-nslookup' ); ?>
					</p>
					<?php get_search_form(); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Check DNS', 'vagra-nslookup' ), esc_html__( 'like it\'s 2026.', 'vagra-nslookup' ) ),
		'sub'       => __( 'Free. Instant. Worldwide.', 'vagra-nslookup' ),
		'cta'       => __( 'Start a lookup', 'vagra-nslookup' ),
		'href'      => home_url( '/' ),
	) );
	?>

</main>

<?php get_footer(); ?>
