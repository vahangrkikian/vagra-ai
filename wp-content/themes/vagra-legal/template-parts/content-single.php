<?php
/**
 * Template Part: Single Post Content
 *
 * @package Vagra_Legal
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vagra-entry vagra-entry--single' ); ?>>
    <header class="vagra-entry__header">
        <h1 class="vagra-entry__title"><?php the_title(); ?></h1>
        <div class="vagra-entry__meta">
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php echo esc_html( get_the_date() ); ?>
            </time>
            <span class="vagra-entry__author"> &mdash; <?php the_author(); ?></span>
            <?php if ( has_category() ) : ?>
                <span class="vagra-entry__cats"> &mdash; <?php the_category( ', ' ); ?></span>
            <?php endif; ?>
        </div>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="vagra-entry__thumbnail">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    <?php endif; ?>

    <div class="vagra-entry__content">
        <?php the_content(); ?>

        <?php
        wp_link_pages( array(
            'before' => '<div class="vagra-page-links">' . esc_html__( 'Pages:', 'vagra-legal' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>

    <footer class="vagra-entry__footer">
        <?php if ( has_tag() ) : ?>
            <div class="vagra-entry__tags">
                <?php the_tags( '<span class="vagra-entry__tags-label">' . esc_html__( 'Tags:', 'vagra-legal' ) . '</span> ', ', ' ); ?>
            </div>
        <?php endif; ?>
    </footer>
</article>
