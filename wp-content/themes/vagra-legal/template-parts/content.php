<?php
/**
 * Template Part: Content
 *
 * @package Vagra_Legal
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vagra-entry' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="vagra-entry__thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'large' ); ?>
            </a>
        </div>
    <?php endif; ?>

    <header class="vagra-entry__header">
        <h2 class="vagra-entry__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <div class="vagra-entry__meta">
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php echo esc_html( get_the_date() ); ?>
            </time>
            <?php if ( has_category() ) : ?>
                <span class="vagra-entry__cats"> &mdash; <?php the_category( ', ' ); ?></span>
            <?php endif; ?>
        </div>
    </header>

    <div class="vagra-entry__content">
        <?php the_excerpt(); ?>
    </div>

    <a href="<?php the_permalink(); ?>" class="vagra-btn vagra-btn--primary">
        <?php esc_html_e( 'Read More', 'vagra-legal' ); ?>
    </a>
</article>
