<?php
/**
 * Default page template.
 *
 * Used for pages without a specific template. CineSubHero + the_content().
 *
 * @package Vagra_NSLookup
 */

get_header();

while ( have_posts() ) :
	the_post();
?>

<main class="nsl-page-default">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => get_post_type_object( get_post_type() )->labels->singular_name,
		'title'   => get_the_title(),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => get_the_title() ),
		),
	) );
	?>

	<section class="cine-section" style="background:#fff; padding-top:60px">
		<div class="container nsl-article">
			<div class="nsl-article-body reveal">
				<?php the_content(); ?>
			</div>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Check DNS', 'vagra-nslookup' ), esc_html__( 'like it\'s 2026.', 'vagra-nslookup' ) ),
		'sub'       => __( 'Free. Instant. Worldwide.', 'vagra-nslookup' ),
		'cta'       => __( 'Start a lookup', 'vagra-nslookup' ),
		'href'      => home_url( '/' ),
	) );
	?>

</main>

<?php
endwhile;
get_footer();
?>
