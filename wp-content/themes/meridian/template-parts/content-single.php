<?php
/**
 * Template part: full single post.
 *
 * @package Meridian
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
            <?php echo esc_html( get_the_date() ); ?>
        </time>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="entry-thumbnail">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'meridian' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>

    <footer class="entry-footer">
        <?php
        $categories = get_the_category_list( ', ' );
        if ( $categories ) {
            printf( '<span class="entry-categories">%s</span>', $categories );
        }

        $tags = get_the_tag_list( '', ', ' );
        if ( $tags ) {
            printf( '<span class="entry-tags">%s</span>', $tags );
        }
        ?>
    </footer>
</article>
