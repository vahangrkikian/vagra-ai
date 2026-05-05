<?php
/**
 * Template part for displaying search results.
 *
 * @package Vagra_MSP
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vagra-card vagra-post' ); ?>>
    <div class="vagra-post__content">
        <header class="vagra-post__header">
            <?php the_title( sprintf( '<h2 class="vagra-post__title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

            <div class="vagra-post__meta">
                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                <span class="vagra-post__author"><?php the_author(); ?></span>
            </div>
        </header>

        <div class="vagra-post__excerpt">
            <?php the_excerpt(); ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="vagra-btn vagra-btn--primary">
            <?php esc_html_e( 'Read More', 'vagra-msp' ); ?>
        </a>
    </div>
</article>
