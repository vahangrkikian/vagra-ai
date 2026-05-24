<?php
/**
 * Single Post Template
 *
 * @package House_Service
 */

get_header();
?>

<section class="page-hero">
	<div class="shell">
		<h1 class="page-hero__title"><?php the_title(); ?></h1>
		<p class="page-hero__desc">
			<?php echo hs_icon( 'calendar', 16 ); ?>
			<?php echo esc_html( get_the_date() ); ?>
			&middot;
			<?php echo esc_html( get_the_author() ); ?>
		</p>
	</div>
</section>

<section class="content-area">
	<div class="shell">
		<?php
		while ( have_posts() ) :
			the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( has_post_thumbnail() ) : ?>
			<div class="photo" style="border-radius: var(--radius-lg); margin-bottom: 32px; max-height: 480px; overflow: hidden;">
				<?php the_post_thumbnail( 'hs-hero' ); ?>
			</div>
			<?php endif; ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>
