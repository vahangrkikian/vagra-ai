<?php
/**
 * Generic Page Template
 *
 * @package Carvice
 */

get_header();
?>

<main id="primary" class="carvice-main">
    <section class="carvice-page-hero">
        <div class="carvice-container">
            <h1 class="carvice-page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>

    <section class="carvice-page-content">
        <div class="carvice-container">
            <?php
            while ( have_posts() ) :
                the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<?php
get_footer();
