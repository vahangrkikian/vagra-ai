<?php
/**
 * Single blog post template.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="tourvice-main" role="main">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<!-- Post Hero -->
		<section class="tourvice-post-hero">
			<div class="container">
				<div class="tourvice-post-hero__meta">
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) :
						?>
						<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="tourvice-post-hero__category">
							<?php echo esc_html( $categories[0]->name ); ?>
						</a>
					<?php endif; ?>
					<span class="tourvice-post-hero__date">
						<?php echo esc_html( get_the_date() ); ?>
					</span>
				</div>
				<h1 class="tourvice-post-hero__title"><?php the_title(); ?></h1>
				<div class="tourvice-post-hero__author">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
					<div class="tourvice-post-hero__author-info">
						<strong><?php the_author(); ?></strong>
						<span><?php echo esc_html( human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ) . ' ' . esc_html__( 'ago', 'tourvice' ); ?></span>
					</div>
				</div>
			</div>
		</section>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="tourvice-post-featured">
				<div class="container">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Post Content -->
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'tourvice-post-content' ); ?>>
			<div class="container">
				<div class="tourvice-post-content__wrap">
					<div class="tourvice-post-content__body entry-content">
						<?php the_content(); ?>
						<?php
						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tourvice' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>

					<?php
					$tags = get_the_tags();
					if ( $tags ) :
						?>
						<div class="tourvice-post-content__tags">
							<?php foreach ( $tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tourvice-post-content__tag">
									<?php echo esc_html( $tag->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</article>

		<!-- Post Navigation -->
		<nav class="tourvice-post-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'tourvice' ); ?>">
			<div class="container">
				<div class="tourvice-post-nav__links">
					<?php
					$prev_post = get_previous_post();
					$next_post = get_next_post();
					?>
					<?php if ( $prev_post ) : ?>
						<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="tourvice-post-nav__link tourvice-post-nav__link--prev">
							<span class="tourvice-post-nav__label">&larr; <?php esc_html_e( 'Previous', 'tourvice' ); ?></span>
							<span class="tourvice-post-nav__title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( $next_post ) : ?>
						<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="tourvice-post-nav__link tourvice-post-nav__link--next">
							<span class="tourvice-post-nav__label"><?php esc_html_e( 'Next', 'tourvice' ); ?> &rarr;</span>
							<span class="tourvice-post-nav__title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</nav>

		<!-- Comments -->
		<?php
		if ( comments_open() || get_comments_number() ) :
			?>
			<section class="tourvice-comments">
				<div class="container">
					<?php comments_template(); ?>
				</div>
			</section>
		<?php endif; ?>

	<?php endwhile; ?>

</main>
<?php
get_footer();
