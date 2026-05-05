<?php
/**
 * Template part: Related Posts
 *
 * Shows up to 3 related posts matched by category, then tag, then recency.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_id = get_the_ID();
$related     = vagra_get_related_posts( $current_id, 3 );

if ( empty( $related ) ) {
	return;
}

$gradients = array(
	'linear-gradient(135deg,#3366FF,#6B8AFF)',
	'linear-gradient(135deg,#0E7490,#22D3EE)',
	'linear-gradient(135deg,#059669,#34D399)',
);
?>

<section class="vagra-related" aria-label="<?php esc_attr_e( 'Related articles', 'vagra-msp' ); ?>">
	<div class="site-container">
		<h2 class="vagra-related__title"><?php esc_html_e( 'Related Articles', 'vagra-msp' ); ?></h2>

		<div class="vagra-related__grid">
			<?php foreach ( $related as $i => $post ) : setup_postdata( $post ); ?>
				<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="vagra-related__card">
					<?php if ( has_post_thumbnail( $post ) ) : ?>
						<div class="vagra-related__thumb">
							<?php echo get_the_post_thumbnail( $post, 'medium_large' ); ?>
						</div>
					<?php else : ?>
						<div class="vagra-related__thumb vagra-related__thumb--gradient" style="background:<?php echo esc_attr( $gradients[ $i % count( $gradients ) ] ); ?>">
							<span aria-hidden="true">&#x1F6E1;</span>
						</div>
					<?php endif; ?>

					<div class="vagra-related__body">
						<div class="vagra-related__meta">
							<?php
							$cats = get_the_category( $post->ID );
							if ( ! empty( $cats ) ) :
							?>
								<span class="vagra-related__tag"><?php echo esc_html( $cats[0]->name ); ?></span>
							<?php endif; ?>
							<span><?php echo esc_html( vagra_reading_time_for( $post->ID ) ); ?></span>
							<span><?php echo esc_html( get_the_date( 'M j', $post ) ); ?></span>
						</div>
						<h3 class="vagra-related__card-title"><?php echo esc_html( get_the_title( $post ) ); ?></h3>
					</div>
				</a>
			<?php endforeach; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
