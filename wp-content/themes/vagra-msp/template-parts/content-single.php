<?php
/**
 * Template part for displaying single posts.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <div class="entry-meta" style="color: var(--vagra-muted); font-size: 14px;">
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php echo esc_html( get_the_date() ); ?>
            </time>
            <span> &mdash; <?php the_author(); ?></span>
        </div>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php the_content(); ?>

        <?php
        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'vagra-msp' ),
                'after'  => '</div>',
            )
        );
        ?>
    </div>

    <footer class="entry-footer">
        <?php
        $categories = get_the_category_list( ', ' );
        if ( $categories ) {
            printf( '<span class="cat-links">%s</span>', $categories );
        }

        $tags = get_the_tag_list( '', ', ' );
        if ( $tags ) {
            printf( '<span class="tag-links">%s</span>', $tags );
        }
        ?>
    </footer>
</article>
