<?php
/**
 * 404 Template
 *
 * @package Vagra_Legal
 */

get_header();
?>

<div class="vagra-content-area">
    <div class="vagra-container" style="text-align: center; padding: 80px 16px;">
        <h1><?php esc_html_e( 'Page Not Found', 'vagra-legal' ); ?></h1>
        <p style="color: var(--vagra-muted); margin: 16px 0 32px;">
            <?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'vagra-legal' ); ?>
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vagra-btn vagra-btn--primary">
            <?php esc_html_e( 'Return Home', 'vagra-legal' ); ?>
        </a>
    </div>
</div>

<?php
get_footer();
