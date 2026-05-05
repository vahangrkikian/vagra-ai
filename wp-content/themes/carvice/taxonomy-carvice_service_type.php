<?php
/**
 * Taxonomy archive template for Service Type.
 *
 * @package Carvice
 */

get_header();

$term = get_queried_object();
?>

<main id="primary" class="carvice-main">
    <section class="carvice-archive-header">
        <div class="carvice-container">
            <h1 class="carvice-archive-header__title"><?php single_term_title(); ?></h1>
            <?php if ( term_description() ) : ?>
                <div class="carvice-archive-header__description"><?php echo term_description(); ?></div>
            <?php endif; ?>
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
                <p class="carvice-no-content"><?php esc_html_e( 'No providers found for this service type.', 'carvice' ); ?></p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
