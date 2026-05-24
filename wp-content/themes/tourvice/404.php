<?php
/**
 * 404 error page template.
 *
 * @package TourVice
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="tourvice-main" role="main">
	<section class="tourvice-404">
		<div class="container">
			<h1 class="tourvice-404__title"><?php esc_html_e( '404 — Page Not Found', 'tourvice' ); ?></h1>
			<p class="tourvice-404__text"><?php esc_html_e( 'The page you are looking for does not exist. It may have been moved or deleted.', 'tourvice' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tourvice-btn tourvice-btn--primary">
				<?php esc_html_e( 'Back to Home', 'tourvice' ); ?>
			</a>
		</div>
	</section>
</main>
<?php
get_footer();
