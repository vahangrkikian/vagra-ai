<?php
/**
 * Archive / Blog listing template.
 *
 * CineSubHero + cinematic blog card grid with WordPress loop.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="vagra-page-blog">

	<?php
	// Dynamic eyebrow / title for different archive types.
	if ( is_category() ) {
		$eyebrow = __( 'Category', 'vagra-msp' );
		$title   = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$eyebrow = __( 'Tag', 'vagra-msp' );
		$title   = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$eyebrow = __( 'Author', 'vagra-msp' );
		$title   = get_the_author();
	} elseif ( is_date() ) {
		$eyebrow = __( 'Archive', 'vagra-msp' );
		$title   = get_the_archive_title();
	} else {
		$eyebrow = __( 'Blog', 'vagra-msp' );
		$title   = sprintf(
			'%s<br/><span class="cine-accent">%s</span>',
			esc_html__( 'Insights &', 'vagra-msp' ),
			esc_html__( 'field notes.', 'vagra-msp' )
		);
	}

	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => $eyebrow,
		'title'   => $title,
		'lede'    => __( 'Cybersecurity thinking from people who protect businesses every day. No jargon walls — just useful writing.', 'vagra-msp' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-msp' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'Blog', 'vagra-msp' ) ),
		),
	) );
	?>

	<section class="vagra-blog-list">
		<div class="site-container">
			<?php if ( have_posts() ) : ?>
				<div class="vagra-blog-grid">
					<?php
					$card_index = 0;
					$gradients  = array(
						'linear-gradient(135deg,#3366FF,#6B8AFF)',
						'linear-gradient(135deg,#0E7490,#22D3EE)',
						'linear-gradient(135deg,#059669,#34D399)',
						'linear-gradient(135deg,#7C3AED,#C4B5FD)',
						'linear-gradient(135deg,#0891B2,#67E8F9)',
						'linear-gradient(135deg,#D97706,#FCD34D)',
					);

					while ( have_posts() ) :
						the_post();
						$bg    = $gradients[ $card_index % count( $gradients ) ];
						$delay = 60 * $card_index;
					?>
						<a href="<?php the_permalink(); ?>" class="vagra-blog-card"
						   style="transition-delay:<?php echo esc_attr( $delay ); ?>ms">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="vagra-blog-card__thumb">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'vagra-blog-card__img', 'loading' => 'lazy' ) ); ?>
								</div>
							<?php else : ?>
								<div class="vagra-blog-card__thumb vagra-blog-card__thumb--gradient" style="background:<?php echo esc_attr( $bg ); ?>">
									<span class="vagra-blog-card__glyph" aria-hidden="true">&#x1F6E1;</span>
								</div>
							<?php endif; ?>

							<div class="vagra-blog-card__body">
								<div class="vagra-blog-card__meta">
									<?php
									$cats = get_the_category();
									if ( ! empty( $cats ) ) :
									?>
										<span class="vagra-blog-card__tag"><?php echo esc_html( $cats[0]->name ); ?></span>
									<?php endif; ?>
									<span><?php echo esc_html( vagra_reading_time() ); ?></span>
									<span><?php echo esc_html( get_the_date( 'M j' ) ); ?></span>
								</div>

								<h3 class="vagra-blog-card__title"><?php the_title(); ?></h3>

								<p class="vagra-blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>

								<span class="vagra-blog-card__read"><?php esc_html_e( 'Read', 'vagra-msp' ); ?> &rarr;</span>
							</div>
						</a>
					<?php
						$card_index++;
					endwhile;
					?>
				</div>

				<?php
				the_posts_pagination( array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'mid_size'  => 2,
				) );
				?>
			<?php else : ?>
				<p class="vagra-blog-empty">
					<?php esc_html_e( 'No posts found.', 'vagra-msp' ); ?>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf(
			'%s<br/><span class="cine-accent">%s</span>',
			esc_html__( 'Stay', 'vagra-msp' ),
			esc_html__( 'protected.', 'vagra-msp' )
		),
		'sub'       => __( 'Free DNS security check — one click, 30+ global resolvers.', 'vagra-msp' ),
		'cta'       => __( 'Run a Check', 'vagra-msp' ),
		'href'      => home_url( '/tools/' ),
		'secondary' => array(
			'label' => __( 'More articles', 'vagra-msp' ),
			'href'  => home_url( '/blog/' ),
		),
	) );
	?>

</main>

<?php get_footer(); ?>
