<?php
/**
 * Search Results Template
 *
 * @package Vagra_Legal
 */

get_header();
?>

<div class="vagra-page-header">
    <div class="vagra-container">
        <h1 class="vagra-page-header__title">
            <?php
            /* translators: %s: search query */
            printf( esc_html__( 'Search Results for: %s', 'vagra-legal' ), '<span>' . get_search_query() . '</span>' );
            ?>
        </h1>
    </div>
</div>

<div class="vagra-content-area">
    <div class="vagra-container">
        <div class="vagra-grid vagra-grid--sidebar">
            <div class="vagra-primary">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/content', 'search' ); ?>
                    <?php endwhile; ?>

                    <div class="vagra-pagination">
                        <?php
                        the_posts_pagination( array(
                            'mid_size'  => 2,
                            'prev_text' => esc_html__( '&laquo; Previous', 'vagra-legal' ),
                            'next_text' => esc_html__( 'Next &raquo;', 'vagra-legal' ),
                        ) );
                        ?>
                    </div>
                <?php else : ?>
                    <?php get_template_part( 'template-parts/content', 'none' ); ?>
                <?php endif; ?>
            </div>

            <aside class="vagra-sidebar" role="complementary">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</div>

<?php
get_footer();
