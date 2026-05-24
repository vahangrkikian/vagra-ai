<?php
/**
 * Template part for displaying posts in loops.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'tourvice-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="tourvice-card__image">
			<?php the_post_thumbnail( 'tourvice-card' ); ?>
		</a>
	<?php endif; ?>
	<div class="tourvice-card__body">
		<div class="tourvice-card__meta">
			<?php
			$categories = get_the_category();
			if ( ! empty( $categories ) ) :
				?>
				<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="tourvice-card__category">
					<?php echo esc_html( $categories[0]->name ); ?>
				</a>
			<?php endif; ?>
			<span class="tourvice-card__date"><?php echo esc_html( get_the_date() ); ?></span>
		</div>
		<?php the_title( '<h2 class="tourvice-card__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
		<div class="tourvice-card__excerpt">
			<?php the_excerpt(); ?>
		</div>
		<a href="<?php the_permalink(); ?>" class="tourvice-card__link">
			<?php esc_html_e( 'Read More', 'tourvice' ); ?> &rarr;
		</a>
	</div>
</article>
