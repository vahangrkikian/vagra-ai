<?php
/**
 * Template Name: About
 *
 * About page template with hero, mission, stats, values, and team sections.
 *
 * @package DriveEase
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Elementor: if built with Elementor, let it render.
if ( defined( 'ELEMENTOR_VERSION' )
     && \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) {
    get_header();
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    get_footer();
    return;
}

get_header();
?>
<main id="main-content" class="site-main" role="main">

	<!-- About Hero -->
	<section class="about-hero">
		<div class="container">
			<div class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'driveease' ); ?></a>
				<i class="fa-solid fa-chevron-right"></i>
				<span><?php the_title(); ?></span>
			</div>
			<h1><?php esc_html_e( 'About', 'driveease' ); ?> <span><?php esc_html_e( 'DriveEase', 'driveease' ); ?></span></h1>
			<p><?php esc_html_e( 'Making every journey memorable with premium vehicles, transparent pricing, and world-class service.', 'driveease' ); ?></p>
		</div>
	</section>

	<!-- Mission / Story -->
	<section class="about-mission">
		<div class="container">
			<div class="about-mission-grid">
				<div class="about-mission-content">
					<?php
					while ( have_posts() ) :
						the_post();
						$content = get_the_content();
						if ( $content ) :
							?>
							<div class="entry-content">
								<?php the_content(); ?>
							</div>
						<?php else : ?>
							<div class="section-label"><?php esc_html_e( 'Our Story', 'driveease' ); ?></div>
							<h2 class="section-title"><?php esc_html_e( 'Driving Excellence Since Day One', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'DriveEase was founded with a simple mission: to make car rental easy, affordable, and enjoyable. We believe everyone deserves access to quality vehicles without the hassle of hidden fees or complicated processes.', 'driveease' ); ?></p>
							<p><?php esc_html_e( 'Today, we serve thousands of customers across multiple locations, offering a diverse fleet of well-maintained vehicles for every need — from compact city cars to spacious SUVs for family adventures.', 'driveease' ); ?></p>
						<?php
						endif;
					endwhile;
					?>
				</div>
				<div class="about-mission-image">
					<div class="about-image-placeholder">
						<i class="fa-solid fa-car-side"></i>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Stats -->
	<section class="about-stats">
		<div class="container">
			<div class="stats-grid">
				<div class="stat-card">
					<div class="stat-number">10K+</div>
					<div class="stat-label"><?php esc_html_e( 'Happy Customers', 'driveease' ); ?></div>
				</div>
				<div class="stat-card">
					<div class="stat-number">
						<?php
						$car_count = wp_count_posts( 'driveease_car' );
						echo esc_html( $car_count->publish ? $car_count->publish . '+' : '50+' );
						?>
					</div>
					<div class="stat-label"><?php esc_html_e( 'Vehicles in Fleet', 'driveease' ); ?></div>
				</div>
				<div class="stat-card">
					<div class="stat-number">
						<?php
						$branch_count = wp_count_posts( 'driveease_branch' );
						echo esc_html( $branch_count->publish ? $branch_count->publish : '5' );
						?>
					</div>
					<div class="stat-label"><?php esc_html_e( 'Branch Locations', 'driveease' ); ?></div>
				</div>
				<div class="stat-card">
					<div class="stat-number">24/7</div>
					<div class="stat-label"><?php esc_html_e( 'Customer Support', 'driveease' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- Values -->
	<section class="about-values">
		<div class="container">
			<div class="values-header">
				<div class="section-label"><?php esc_html_e( 'Our Values', 'driveease' ); ?></div>
				<h2 class="section-title"><?php esc_html_e( 'What Drives Us Forward', 'driveease' ); ?></h2>
			</div>
			<div class="values-grid">
				<div class="value-card">
					<div class="value-icon"><i class="fa-solid fa-shield-halved"></i></div>
					<h3><?php esc_html_e( 'Safety First', 'driveease' ); ?></h3>
					<p><?php esc_html_e( 'Every vehicle undergoes rigorous maintenance checks and comes with comprehensive insurance coverage.', 'driveease' ); ?></p>
				</div>
				<div class="value-card">
					<div class="value-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
					<h3><?php esc_html_e( 'Transparent Pricing', 'driveease' ); ?></h3>
					<p><?php esc_html_e( 'No hidden fees, no surprises. What you see is what you pay — clear and honest pricing every time.', 'driveease' ); ?></p>
				</div>
				<div class="value-card">
					<div class="value-icon"><i class="fa-solid fa-heart"></i></div>
					<h3><?php esc_html_e( 'Customer Obsessed', 'driveease' ); ?></h3>
					<p><?php esc_html_e( 'Your satisfaction drives everything we do. From booking to return, we\'re here to make it seamless.', 'driveease' ); ?></p>
				</div>
				<div class="value-card">
					<div class="value-icon"><i class="fa-solid fa-leaf"></i></div>
					<h3><?php esc_html_e( 'Eco Conscious', 'driveease' ); ?></h3>
					<p><?php esc_html_e( 'Our growing fleet of hybrid and electric vehicles reflects our commitment to a greener future.', 'driveease' ); ?></p>
				</div>
			</div>
		</div>
	</section>

</main>
<?php
get_footer();
