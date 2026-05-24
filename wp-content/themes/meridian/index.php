<?php
/**
 * The main template file — minimal fallback.
 *
 * @package Meridian
 */

get_header(); ?>

<main class="section">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content' ); ?>
        <?php endwhile; the_posts_navigation(); else : ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
