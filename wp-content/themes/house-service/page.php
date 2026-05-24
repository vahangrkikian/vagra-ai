<?php
/**
 * Page Template
 *
 * @package House_Service
 */

get_header();
?>

<section class="page-hero">
	<div class="shell">
		<h1 class="page-hero__title"><?php the_title(); ?></h1>
	</div>
</section>

<section class="content-area">
	<div class="shell">
		<?php
		while ( have_posts() ) :
			the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>
