<?php
/**
 * The main template file (ultimate fallback).
 *
 * Uses cinematic styling consistent with the rest of the theme.
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-index">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'Blog', 'vagra-nslookup' ),
		'title'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'The nslookup.am', 'vagra-nslookup' ), esc_html__( 'field notes.', 'vagra-nslookup' ) ),
		'lede'    => __( 'DNS thinking from people who spend too much time at the terminal.', 'vagra-nslookup' ),
	) );
	?>

	<section class="cine-section" style="background:#fff; padding-top:40px">
		<div class="cine-head-wrap">
			<?php if ( have_posts() ) : ?>
				<div class="nsl-blog-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:32px; margin-top:32px">
					<?php
					while ( have_posts() ) :
						the_post();
					?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'nsl-blog-card reveal' ); ?> style="border-radius:20px; overflow:hidden; background:#fff; border:1px solid rgba(11,13,20,0.08)">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" style="display:block; aspect-ratio:16/10; overflow:hidden" aria-hidden="true">
									<?php the_post_thumbnail( 'medium_large', array( 'style' => 'width:100%; height:100%; object-fit:cover' ) ); ?>
								</a>
							<?php endif; ?>
							<div style="padding:22px 24px 26px; display:flex; flex-direction:column; gap:10px">
								<div style="font-size:11px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.1em; color:rgba(11,13,20,0.5)">
									<?php echo esc_html( get_the_date( 'M j' ) ); ?>
								</div>
								<h2 style="font-size:22px; font-weight:600; letter-spacing:-0.015em; line-height:1.3">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>
								<p style="font-size:14px; color:rgba(11,13,20,0.6); line-height:1.55"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<?php
				the_posts_pagination( array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
				) );
				?>
			<?php else : ?>
				<p style="text-align:center; padding:80px 0; color:rgba(11,13,20,0.5)"><?php esc_html_e( 'No content found.', 'vagra-nslookup' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
