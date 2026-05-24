<?php
/**
 * Template part: post excerpt in a loop.
 *
 * @package Meridian
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-card__thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'meridian-card' ); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="post-card__content">
        <h2 class="post-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <time class="post-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
            <?php echo esc_html( get_the_date() ); ?>
        </time>

        <div class="post-card__excerpt">
            <?php the_excerpt(); ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="post-card__read-more">
            <?php esc_html_e( 'Read More', 'meridian' ); ?>
        </a>
    </div>
</article>
