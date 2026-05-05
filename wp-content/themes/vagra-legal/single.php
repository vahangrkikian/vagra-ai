<?php
/**
 * Single Post Template
 *
 * @package Vagra_Legal
 */

get_header();
?>

<div class="vagra-content-area">
    <div class="vagra-container">
        <div class="vagra-grid vagra-grid--sidebar">
            <div class="vagra-primary">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content', 'single' ); ?>

                    <?php
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                    ?>

                    <div class="vagra-post-nav">
                        <?php
                        the_post_navigation( array(
                            'prev_text' => '<span class="vagra-post-nav__label">' . esc_html__( 'Previous', 'vagra-legal' ) . '</span><span class="vagra-post-nav__title">%title</span>',
                            'next_text' => '<span class="vagra-post-nav__label">' . esc_html__( 'Next', 'vagra-legal' ) . '</span><span class="vagra-post-nav__title">%title</span>',
                        ) );
                        ?>
                    </div>
                <?php endwhile; ?>
            </div>

            <aside class="vagra-sidebar" role="complementary">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</div>

<?php
get_footer();
