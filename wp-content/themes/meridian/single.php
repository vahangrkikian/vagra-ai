<?php
/**
 * Standard single post template.
 *
 * @package Meridian
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="section">
        <div class="container">
            <?php
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/content', 'single' );
            endwhile;
            ?>
        </div>
    </section>
</main>

<?php
get_footer();
