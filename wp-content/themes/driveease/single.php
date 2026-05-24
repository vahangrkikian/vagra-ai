<?php
/**
 * Single blog post template.
 *
 * @package DriveEase
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main" role="main">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<!-- Post Hero -->
		<section class="post-hero">
			<div class="container">
				<div class="post-hero-meta">
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) :
						?>
						<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="blog-card-category">
							<?php echo esc_html( $categories[0]->name ); ?>
						</a>
					<?php endif; ?>
					<span class="blog-card-date">
						<i class="fa-regular fa-calendar"></i>
						<?php echo esc_html( get_the_date() ); ?>
					</span>
				</div>
				<h1 class="post-hero-title"><?php the_title(); ?></h1>
				<div class="post-author">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
					<div class="post-author-info">
						<strong><?php the_author(); ?></strong>
						<span><?php echo esc_html( human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ) . ' ' . esc_html__( 'ago', 'driveease' ); ?></span>
					</div>
				</div>
			</div>
		</section>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-featured-image">
				<div class="container">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Post Content -->
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content-section' ); ?>>
			<div class="container">
				<div class="post-content-wrap">
					<div class="post-content entry-content">
						<?php the_content(); ?>
						<?php
						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'driveease' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>

					<?php
					$tags = get_the_tags();
					if ( $tags ) :
						?>
						<div class="post-tags">
							<i class="fa-solid fa-tags"></i>
							<?php foreach ( $tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="post-tag">
									<?php echo esc_html( $tag->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</article>

		<!-- Post Navigation -->
		<nav class="post-nav-section" aria-label="<?php esc_attr_e( 'Post navigation', 'driveease' ); ?>">
			<div class="container">
				<div class="post-nav">
					<?php
					$prev_post = get_previous_post();
					$next_post = get_next_post();
					?>
					<?php if ( $prev_post ) : ?>
						<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="post-nav-link post-nav-prev">
							<span class="post-nav-label"><i class="fa-solid fa-arrow-left"></i> <?php esc_html_e( 'Previous', 'driveease' ); ?></span>
							<span class="post-nav-title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( $next_post ) : ?>
						<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="post-nav-link post-nav-next">
							<span class="post-nav-label"><?php esc_html_e( 'Next', 'driveease' ); ?> <i class="fa-solid fa-arrow-right"></i></span>
							<span class="post-nav-title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</nav>

		<!-- Comments -->
		<?php
		if ( comments_open() || get_comments_number() ) :
			?>
			<section class="post-comments-section">
				<div class="container">
					<div class="post-content-wrap">
						<?php comments_template(); ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

	<?php endwhile; ?>

</main>
<?php
get_footer();
