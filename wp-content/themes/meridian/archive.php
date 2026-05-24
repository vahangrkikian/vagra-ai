<?php
/**
 * Standard archive template.
 *
 * @package Meridian
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="section">
        <div class="container">

            <header class="archive-header">
                <?php
                the_archive_title( '<h1 class="archive-header__title">', '</h1>' );
                the_archive_description( '<div class="archive-header__description">', '</div>' );
                ?>
            </header>

            <?php if ( have_posts() ) : ?>

                <div class="posts-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/content' );
                    endwhile;
                    ?>
                </div>

                <nav class="pagination">
                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => __( '&laquo; Previous', 'meridian' ),
                        'next_text' => __( 'Next &raquo;', 'meridian' ),
                    ) );
                    ?>
                </nav>

            <?php else : ?>

                <?php get_template_part( 'template-parts/content', 'none' ); ?>

            <?php endif; ?>

        </div>
    </section>
</main>

<?php
get_footer();
