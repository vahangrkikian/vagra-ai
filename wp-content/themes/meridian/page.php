<?php
/**
 * Standard page template.
 *
 * @package Meridian
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

    <!-- Page Hero -->
    <section class="page-hero">
        <div class="page-hero__inner">
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'meridian' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </div>
    </section>

    <?php endwhile; ?>
</main>

<?php
get_footer();
