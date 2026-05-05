<?php
/**
 * Template Part: Page Content
 *
 * @package Vagra_Legal
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vagra-entry vagra-entry--page' ); ?>>
    <header class="vagra-page-header">
        <h1 class="vagra-page-header__title"><?php the_title(); ?></h1>
    </header>

    <div class="vagra-entry__content">
        <?php the_content(); ?>

        <?php
        wp_link_pages( array(
            'before' => '<div class="vagra-page-links">' . esc_html__( 'Pages:', 'vagra-legal' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>
</article>
