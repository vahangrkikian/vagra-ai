<?php
/**
 * Main index fallback template
 *
 * @package vagra-showcase
 */

get_header();
?>

<main class="container" style="padding-top:120px;min-height:60vh;">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2><?php the_title(); ?></h2>
                <div><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e( 'No content found.', 'vagra-showcase' ); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
