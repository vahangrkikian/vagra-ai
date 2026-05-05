<?php
/**
 * Single post template.
 *
 * Dark article hero + the_content() with vagra-article-body styling + CineFinalCTA.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

get_header();

while ( have_posts() ) :
	the_post();
?>

<main id="primary" class="vagra-page-single">

	<?php // ─── Article hero ─── ?>
	<section class="cine-sub-hero" style="min-height:auto">
		<div class="cine-sub-hero__gradient" aria-hidden="true"></div>
		<div class="cine-sub-hero__grid" aria-hidden="true"></div>
		<div class="site-container cine-sub-hero__inner" style="max-width:860px">
			<nav class="vagra-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'vagra-msp' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vagra-crumb__link"><?php esc_html_e( 'Home', 'vagra-msp' ); ?></a>
				<span class="vagra-crumb__sep">&rsaquo;</span>
				<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="vagra-crumb__link"><?php esc_html_e( 'Blog', 'vagra-msp' ); ?></a>
				<span class="vagra-crumb__sep">&rsaquo;</span>
				<span class="vagra-crumb__current"><?php the_title(); ?></span>
			</nav>

			<div class="vagra-post-meta">
				<?php
				$cats = get_the_category();
				if ( ! empty( $cats ) ) :
				?>
					<span class="vagra-post-meta__tag"><?php echo esc_html( $cats[0]->name ); ?></span>
				<?php endif; ?>
				<span><?php echo esc_html( vagra_reading_time() ); ?></span>
				<span><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
			</div>

			<h1 class="cine-sub-hero__title" style="font-size:clamp(36px, 5vw, 68px)">
				<?php the_title(); ?>
			</h1>

			<?php if ( has_excerpt() ) : ?>
				<p class="cine-sub-hero__lede">
					<?php echo esc_html( get_the_excerpt() ); ?>
				</p>
			<?php endif; ?>

			<div class="vagra-post-byline">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 44, '', '', array( 'class' => 'vagra-post-byline__avatar' ) ); ?>
				<div>
					<div class="vagra-post-byline__name"><?php the_author(); ?></div>
					<div class="vagra-post-byline__role"><?php echo esc_html( get_the_author_meta( 'description' ) ?: get_bloginfo( 'name' ) ); ?></div>
				</div>
			</div>

			<?php // ─── Social Share ─── ?>
			<div class="vagra-share" aria-label="<?php esc_attr_e( 'Share this article', 'vagra-msp' ); ?>">
				<span class="vagra-share__label"><?php esc_html_e( 'Share', 'vagra-msp' ); ?></span>
				<?php
				$share_url   = rawurlencode( get_permalink() );
				$share_title = rawurlencode( get_the_title() );
				?>
				<a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>"
				   class="vagra-share__btn" target="_blank" rel="noopener noreferrer"
				   aria-label="<?php esc_attr_e( 'Share on X / Twitter', 'vagra-msp' ); ?>">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
				</a>
				<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>"
				   class="vagra-share__btn" target="_blank" rel="noopener noreferrer"
				   aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'vagra-msp' ); ?>">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
				</a>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>"
				   class="vagra-share__btn" target="_blank" rel="noopener noreferrer"
				   aria-label="<?php esc_attr_e( 'Share on Facebook', 'vagra-msp' ); ?>">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
				</a>
				<button class="vagra-share__btn vagra-share__btn--copy"
				        aria-label="<?php esc_attr_e( 'Copy link to clipboard', 'vagra-msp' ); ?>">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</button>
			</div>
		</div>
	</section>

	<?php // ─── Article body ─── ?>
	<section class="vagra-article-section">
		<div class="site-container vagra-article">
			<?php // ─── Table of Contents (populated by JS) ─── ?>
			<nav class="vagra-toc" aria-label="<?php esc_attr_e( 'Table of contents', 'vagra-msp' ); ?>">
				<button class="vagra-toc__toggle" aria-expanded="true">
					<?php esc_html_e( 'Table of Contents', 'vagra-msp' ); ?>
					<svg class="vagra-toc__icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
				</button>
				<ol class="vagra-toc__list"></ol>
			</nav>

			<div class="vagra-article-body">
				<?php the_content(); ?>
			</div>

			<?php the_tags( '<div class="vagra-post-tags">', '', '</div>' ); ?>
		</div>
	</section>

	<?php // ─── Post navigation ─── ?>
	<section class="vagra-article-section" style="padding-top:0; padding-bottom:40px">
		<div class="site-container vagra-article">
			<?php
			the_post_navigation( array(
				'prev_text' => '<span class="vagra-post-nav__label">' . esc_html__( '&larr; Previous', 'vagra-msp' ) . '</span><br/>%title',
				'next_text' => '<span class="vagra-post-nav__label">' . esc_html__( 'Next &rarr;', 'vagra-msp' ) . '</span><br/>%title',
			) );
			?>
		</div>
	</section>

	<?php // ─── Related Posts ─── ?>
	<?php get_template_part( 'template-parts/related-posts' ); ?>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf(
			'%s<br/><span class="cine-accent">%s</span>',
			esc_html__( 'Check your DNS', 'vagra-msp' ),
			esc_html__( 'right now.', 'vagra-msp' )
		),
		'sub'       => __( '30+ global resolvers. One click.', 'vagra-msp' ),
		'cta'       => __( 'Run a Check', 'vagra-msp' ),
		'href'      => home_url( '/tools/' ),
		'secondary' => array(
			'label' => __( 'More articles', 'vagra-msp' ),
			'href'  => home_url( '/blog/' ),
		),
	) );
	?>

</main>

<?php
endwhile;
get_footer();
?>
