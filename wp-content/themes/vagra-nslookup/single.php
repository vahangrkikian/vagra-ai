<?php
/**
 * Single post template.
 *
 * Dark article hero + the_content() with nsl-article-body class + CineFinalCTA.
 * Ported from: nslookup/project/shared/page-cine-post.jsx
 *
 * @package Vagra_NSLookup
 */

get_header();

while ( have_posts() ) :
	the_post();
?>

<main class="nsl-page-single">

	<?php // ─── Article hero ─── ?>
	<section class="cine-hero" style="min-height:auto">
		<div class="container" style="max-width:860px; padding:120px 32px 72px; position:relative; z-index:2">
			<nav class="nsl-crumb reveal" style="color:rgba(255,255,255,0.5)" aria-label="<?php esc_attr_e( 'Breadcrumb', 'vagra-nslookup' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:rgba(255,255,255,0.6)"><?php esc_html_e( 'Home', 'vagra-nslookup' ); ?></a>
				<span style="color:rgba(255,255,255,0.2)">&rsaquo;</span>
				<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" style="color:rgba(255,255,255,0.6)"><?php esc_html_e( 'Blog', 'vagra-nslookup' ); ?></a>
				<span style="color:rgba(255,255,255,0.2)">&rsaquo;</span>
				<span style="color:#fff"><?php the_title(); ?></span>
			</nav>

			<div style="margin-top:32px; display:flex; gap:14px; font-size:12px; font-family:var(--nsl-font-mono); color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:0.1em" class="reveal reveal-delay-1">
				<?php
				$cats = get_the_category();
				if ( ! empty( $cats ) ) :
				?>
					<span><?php echo esc_html( $cats[0]->name ); ?></span><span>&middot;</span>
				<?php endif; ?>
				<span><?php echo esc_html( vagra_nsl_reading_time() ); ?></span><span>&middot;</span>
				<span><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
			</div>

			<h1 class="cine-h1 reveal reveal-delay-1" style="margin-top:20px; font-size:clamp(36px, 5vw, 68px)">
				<?php the_title(); ?>
			</h1>

			<?php if ( has_excerpt() ) : ?>
				<p class="cine-lede reveal reveal-delay-2" style="margin-top:28px">
					<?php echo esc_html( get_the_excerpt() ); ?>
				</p>
			<?php endif; ?>

			<div class="reveal reveal-delay-3" style="margin-top:36px; display:flex; gap:12px; align-items:center">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 44, '', '', array( 'style' => 'border-radius:50%' ) ); ?>
				<div>
					<div style="font-weight:600; color:#fff; font-size:14px"><?php the_author(); ?></div>
					<div style="font-size:12px; color:rgba(255,255,255,0.5)"><?php echo esc_html( get_the_author_meta( 'description' ) ?: get_bloginfo( 'name' ) ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<?php // ─── Article body ─── ?>
	<section class="cine-section" style="background:#fff; padding-top:80px">
		<div class="container nsl-article">
			<div class="nsl-article-body reveal">
				<?php the_content(); ?>
			</div>

			<?php // ─── Post tags ─── ?>
			<?php the_tags( '<div class="nsl-post-tags" style="margin-top:48px; display:flex; gap:8px; flex-wrap:wrap">', '', '</div>' ); ?>
		</div>
	</section>

	<?php // ─── Post navigation ─── ?>
	<section style="background:#fff; padding-bottom:40px">
		<div class="container" style="max-width:860px; padding:0 32px">
			<?php
			the_post_navigation( array(
				'prev_text' => '<span style="font-size:12px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.1em; color:rgba(11,13,20,0.4)">' . esc_html__( '&larr; Previous', 'vagra-nslookup' ) . '</span><br/>%title',
				'next_text' => '<span style="font-size:12px; font-family:var(--nsl-font-mono); text-transform:uppercase; letter-spacing:0.1em; color:rgba(11,13,20,0.4)">' . esc_html__( 'Next &rarr;', 'vagra-nslookup' ) . '</span><br/>%title',
			) );
			?>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Check propagation', 'vagra-nslookup' ), esc_html__( 'right now.', 'vagra-nslookup' ) ),
		'sub'       => __( '30+ global resolvers. One click.', 'vagra-nslookup' ),
		'cta'       => __( 'Run a check', 'vagra-nslookup' ),
		'href'      => home_url( '/propagation/' ),
		'secondary' => array(
			'label' => __( 'More field notes', 'vagra-nslookup' ),
			'href'  => home_url( '/blog/' ),
		),
	) );
	?>

</main>

<?php
endwhile;
get_footer();
?>
