<?php
/**
 * Generic page template
 *
 * @package vagra-showcase
 */

get_header();
?>

<main class="container" style="padding-top:120px;min-height:60vh;">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
