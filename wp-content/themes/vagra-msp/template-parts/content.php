<?php
/**
 * Template part for displaying posts.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vagra-card' ); ?>>
    <header class="entry-header">
        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

        <div class="entry-meta" style="color: var(--vagra-muted); font-size: 14px;">
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php echo esc_html( get_the_date() ); ?>
            </time>
        </div>
    </header>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>

    <footer class="entry-footer">
        <a href="<?php the_permalink(); ?>" class="vagra-button vagra-button--primary">
            <?php esc_html_e( 'Read More', 'vagra-msp' ); ?>
        </a>
    </footer>
</article>
