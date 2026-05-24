<?php
/**
 * 404 error page template.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main" role="main">
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( '404 — Page Not Found', 'driveease' ); ?></h1>
		</header>
		<div class="page-content">
			<p><?php esc_html_e( 'The page you are looking for does not exist. It may have been moved or deleted.', 'driveease' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
				<?php esc_html_e( 'Back to Home', 'driveease' ); ?>
			</a>
		</div>
	</section>
</main>
<?php
get_footer();
