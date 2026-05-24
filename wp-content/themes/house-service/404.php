<?php
/**
 * 404 Template
 *
 * @package House_Service
 */

get_header();
?>

<section class="four-oh-four">
	<div class="shell">
		<div class="four-oh-four__code">404</div>
		<h2><?php esc_html_e( 'Page not found', 'house-service' ); ?></h2>
		<p><?php esc_html_e( 'The page you\'re looking for doesn\'t exist or has been moved. Try browsing our providers instead.', 'house-service' ); ?></p>
		<div style="display: flex; gap: 12px; justify-content: center;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
				<?php echo hs_icon( 'house', 18 ); ?>
				<?php esc_html_e( 'Go home', 'house-service' ); ?>
			</a>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'hs_provider' ) ?: home_url( '/hs_provider/' ) ); ?>" class="btn btn-secondary">
				<?php esc_html_e( 'Browse providers', 'house-service' ); ?>
			</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
