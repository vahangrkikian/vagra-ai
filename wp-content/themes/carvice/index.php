<?php
/**
 * The main template file.
 *
 * @package Carvice
 */

get_header();
?>

<main id="primary" class="carvice-main">
    <div class="carvice-container">
        <?php if ( have_posts() ) : ?>
            <div class="carvice-posts-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'carvice-post-card' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="carvice-post-card__image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'carvice-card' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="carvice-post-card__content">
                            <h2 class="carvice-post-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'No posts found.', 'carvice' ); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
