<?php
/**
 * 404 template.
 *
 * @package Carvice
 */

get_header();
?>

<main id="primary" class="carvice-main">
    <div class="carvice-container" style="text-align: center; padding: 80px 0;">
        <h1><?php esc_html_e( '404 — Page Not Found', 'carvice' ); ?></h1>
        <p><?php esc_html_e( 'The page you are looking for does not exist or has been moved.', 'carvice' ); ?></p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="carvice-btn carvice-btn--primary">
            <?php esc_html_e( 'Back to Home', 'carvice' ); ?>
        </a>
    </div>
</main>

<?php
get_footer();
