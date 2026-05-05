<?php
/**
 * Archive / Blog listing template.
 *
 * CineSubHero + cinematic blog card grid with WordPress loop.
 * Ported from: nslookup/project/shared/page-cine-blog.jsx
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-blog">

	<?php
	// Dynamic eyebrow / title for different archive types.
	if ( is_category() ) {
		$eyebrow = __( 'Category', 'vagra-nslookup' );
		$title   = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$eyebrow = __( 'Tag', 'vagra-nslookup' );
		$title   = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$eyebrow = __( 'Author', 'vagra-nslookup' );
		$title   = get_the_author();
	} elseif ( is_date() ) {
		$eyebrow = __( 'Archive', 'vagra-nslookup' );
		$title   = get_the_archive_title();
	} else {
		$eyebrow = __( 'Blog', 'vagra-nslookup' );
		$title   = sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'The nslookup.am', 'vagra-nslookup' ), esc_html__( 'field notes.', 'vagra-nslookup' ) );
	}

	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => $eyebrow,
		'title'   => $title,
		'lede'    => __( 'DNS thinking from people who spend too much time at the terminal. No thought-leadership, no newsletter walls — just useful writing.', 'vagra-nslookup' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'Blog', 'vagra-nslookup' ) ),
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

						// Card gradient background.
						$gradients = array(
							'linear-gradient(135deg,#4F46E5,#818CF8)',
							'linear-gradient(135deg,#0E7490,#22D3EE)',
							'linear-gradient(135deg,#059669,#34D399)',
							'linear-gradient(135deg,#7C3AED,#C4B5FD)',
							'linear-gradient(135deg,#0891B2,#67E8F9)',
							'linear-gradient(135deg,#D97706,#FCD34D)',
						);
						$bg = $gradients[ $bi % count( $gradients ) ];
					?>
						<a href="<?php the_permalink(); ?>" class="reveal nsl-blog-card-link"
						   style="transition-delay:<?php echo esc_attr( $delay ); ?>ms; display:flex; flex-direction:column; border-radius:20px; overflow:hidden; background:#fff; border:1px solid rgba(11,13,20,0.08); transition:transform 400ms, box-shadow 400ms">
							<?php if ( has_post_thumbnail() ) : ?>
								<div style="aspect-ratio:16/10; overflow:hidden">
									<?php the_post_thumbnail( 'medium_large', array( 'style' => 'width:100%; height:100%; object-fit:cover' ) ); ?>
								</div>
							<?php else : ?>
								<div style="aspect-ratio:16/10; background:<?php echo esc_attr( $bg ); ?>; display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.9); font-family:var(--nsl-font-mono); font-size:48px; font-weight:700; letter-spacing:-0.02em">
									DNS
								</div>
							<?php endif; ?>
							<div style="padding:22px 24px 26px; flex:1; display:flex; flex-direction:column; gap:10px">
								<div style="display:flex; gap:10px; font-size:11px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.1em; color:rgba(11,13,20,0.5)">
									<?php
									$cats = get_the_category();
									if ( ! empty( $cats ) ) :
									?>
										<span><?php echo esc_html( $cats[0]->name ); ?></span><span>&middot;</span>
									<?php endif; ?>
									<span><?php echo esc_html( vagra_nsl_reading_time() ); ?></span><span>&middot;</span>
									<span><?php echo esc_html( get_the_date( 'M j' ) ); ?></span>
								</div>
								<h3 style="font-size:22px; font-weight:600; letter-spacing:-0.015em; line-height:1.3"><?php the_title(); ?></h3>
								<p style="font-size:14px; color:rgba(11,13,20,0.6); line-height:1.55"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
								<span style="margin-top:auto; color:var(--nsl-primary-600); font-size:13px; font-weight:600"><?php esc_html_e( 'Read &rarr;', 'vagra-nslookup' ); ?></span>
							</div>
						</a>
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
				<p style="text-align:center; padding:80px 0; color:rgba(11,13,20,0.5); font-size:18px">
					<?php esc_html_e( 'No posts found.', 'vagra-nslookup' ); ?>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Want these', 'vagra-nslookup' ), esc_html__( 'in your inbox?', 'vagra-nslookup' ) ),
		'sub'       => __( 'No newsletter, no spam — we publish here and on RSS only.', 'vagra-nslookup' ),
		'cta'       => __( 'Copy RSS URL', 'vagra-nslookup' ),
		'href'      => esc_url( get_bloginfo( 'rss2_url' ) ),
	) );
	?>

</main>

<?php get_footer(); ?>
