<?php
/**
 * Footer Template
 *
 * @package House_Service
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
</main>

<footer class="site-footer">
	<div class="shell">
		<div class="site-footer__inner">
			<p class="site-footer__disclaimer">
				<?php esc_html_e( 'This is a demo marketplace theme by vagra.ai. Provider profiles, reviews, and pricing shown are for demonstration purposes only. No real transactions are processed.', 'house-service' ); ?>
			</p>
			<p class="site-footer__copy">
				<?php echo hs_icon( 'shield', 14 ); ?>
				<?php
				printf(
					/* translators: %1$s = year, %2$s = site name */
					esc_html__( '%1$s %2$s. All rights reserved.', 'house-service' ),
					esc_html( date_i18n( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</p>
		</div>
	</div>
</footer>

<?php get_template_part( 'template-parts/ai-chat' ); ?>

<?php wp_footer(); ?>
</body>
</html>
