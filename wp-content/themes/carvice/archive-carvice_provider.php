<?php
/**
 * Archive template for Providers.
 *
 * @package Carvice
 */

get_header();
?>

<main id="primary" class="carvice-main">
    <section class="carvice-archive-header">
        <div class="carvice-container">
            <h1 class="carvice-archive-header__title"><?php esc_html_e( 'All Providers', 'carvice' ); ?></h1>
        </div>
    </section>

    <section class="carvice-providers-section">
        <div class="carvice-container">
            <?php if ( have_posts() ) : ?>
                <div class="carvice-providers-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/provider-card' );
                    endwhile;
                    ?>
                </div>
                <?php the_posts_pagination(); ?>
            <?php else : ?>
                <p class="carvice-no-content"><?php esc_html_e( 'No providers found.', 'carvice' ); ?></p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
