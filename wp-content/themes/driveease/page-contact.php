<?php
/**
 * Template Name: Contact
 *
 * Contact page with hero, contact form, info cards, and branch locations.
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

	<!-- Contact Hero -->
	<section class="contact-hero">
		<div class="container">
			<div class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'driveease' ); ?></a>
				<i class="fa-solid fa-chevron-right"></i>
				<span><?php the_title(); ?></span>
			</div>
			<h1><?php esc_html_e( 'Get in', 'driveease' ); ?> <span><?php esc_html_e( 'Touch', 'driveease' ); ?></span></h1>
			<p><?php esc_html_e( 'Have a question or need help with your reservation? Our team is here for you 24/7.', 'driveease' ); ?></p>
		</div>
	</section>

	<!-- Contact Form + Info -->
	<section>
		<div class="container">
			<div class="contact-layout">

				<!-- Contact Form -->
				<div class="contact-form-box">
					<h2><?php esc_html_e( 'Send Us a Message', 'driveease' ); ?></h2>
					<p class="sub"><?php esc_html_e( 'Fill out the form below and we\'ll get back to you within 24 hours.', 'driveease' ); ?></p>

					<?php
					// If a form plugin shortcode exists in the page content, show it.
					$content = get_the_content();
					if ( $content ) :
						?>
						<div class="entry-content">
							<?php
							while ( have_posts() ) :
								the_post();
								the_content();
							endwhile;
							?>
						</div>
					<?php else : ?>
						<form id="driveease-contact-form" class="contact-form" method="post">
							<div class="form-row">
								<div class="form-group">
									<label for="contact-name"><?php esc_html_e( 'Full Name', 'driveease' ); ?></label>
									<input type="text" id="contact-name" name="name" required placeholder="<?php esc_attr_e( 'John Smith', 'driveease' ); ?>">
								</div>
								<div class="form-group">
									<label for="contact-email"><?php esc_html_e( 'Email Address', 'driveease' ); ?></label>
									<input type="email" id="contact-email" name="email" required placeholder="<?php esc_attr_e( 'john@example.com', 'driveease' ); ?>">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group">
									<label for="contact-phone"><?php esc_html_e( 'Phone Number', 'driveease' ); ?></label>
									<input type="tel" id="contact-phone" name="phone" placeholder="<?php esc_attr_e( '+1 (555) 000-0000', 'driveease' ); ?>">
								</div>
								<div class="form-group">
									<label for="contact-subject"><?php esc_html_e( 'Subject', 'driveease' ); ?></label>
									<select id="contact-subject" name="subject">
										<option value=""><?php esc_html_e( 'Select a topic...', 'driveease' ); ?></option>
										<option value="booking"><?php esc_html_e( 'Booking Inquiry', 'driveease' ); ?></option>
										<option value="support"><?php esc_html_e( 'Customer Support', 'driveease' ); ?></option>
										<option value="partnership"><?php esc_html_e( 'Partnership', 'driveease' ); ?></option>
										<option value="other"><?php esc_html_e( 'Other', 'driveease' ); ?></option>
									</select>
								</div>
							</div>
							<div class="form-row single">
								<div class="form-group">
									<label for="contact-message"><?php esc_html_e( 'Message', 'driveease' ); ?></label>
									<textarea id="contact-message" name="message" rows="5" required placeholder="<?php esc_attr_e( 'Tell us how we can help...', 'driveease' ); ?>"></textarea>
								</div>
							</div>
							<div class="form-submit">
								<button type="submit" class="btn btn-primary">
									<i class="fa-solid fa-paper-plane"></i>
									<?php esc_html_e( 'Send Message', 'driveease' ); ?>
								</button>
							</div>
						</form>
						<div class="success-banner" id="contactSuccess">
							<i class="fa-solid fa-circle-check"></i>
							<p><?php esc_html_e( 'Thank you! Your message has been sent successfully. We\'ll get back to you shortly.', 'driveease' ); ?></p>
						</div>
					<?php endif; ?>
				</div>

				<!-- Info Panel -->
				<div class="contact-info">
					<div class="info-card">
						<div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
						<div>
							<h4><?php esc_html_e( 'Visit Us', 'driveease' ); ?></h4>
							<p><?php esc_html_e( '123 Rental Avenue, City Center', 'driveease' ); ?><br><?php esc_html_e( 'Open Mon-Sat, 8AM-8PM', 'driveease' ); ?></p>
						</div>
					</div>
					<div class="info-card">
						<div class="info-icon"><i class="fa-solid fa-phone"></i></div>
						<div>
							<h4><?php esc_html_e( 'Call Us', 'driveease' ); ?></h4>
							<p><?php esc_html_e( '+1 (555) 123-4567', 'driveease' ); ?><br><?php esc_html_e( '24/7 Customer Support', 'driveease' ); ?></p>
						</div>
					</div>
					<div class="info-card">
						<div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
						<div>
							<h4><?php esc_html_e( 'Email Us', 'driveease' ); ?></h4>
							<p><?php esc_html_e( 'info@driveease.example', 'driveease' ); ?><br><?php esc_html_e( 'Response within 24 hours', 'driveease' ); ?></p>
						</div>
					</div>
					<div class="info-card">
						<div class="info-icon"><i class="fa-solid fa-clock"></i></div>
						<div>
							<h4><?php esc_html_e( 'Working Hours', 'driveease' ); ?></h4>
							<p><?php esc_html_e( 'Mon-Fri: 8:00 AM - 8:00 PM', 'driveease' ); ?><br><?php esc_html_e( 'Sat-Sun: 9:00 AM - 6:00 PM', 'driveease' ); ?></p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- Branches -->
	<?php
	$branches = new WP_Query( array(
		'post_type'      => 'driveease_branch',
		'posts_per_page' => 8,
		'post_status'    => 'publish',
		'orderby'        => 'title',
		'order'          => 'ASC',
	) );

	if ( $branches->have_posts() ) :
		?>
		<section id="branches">
			<div class="container">
				<div class="branches-header">
					<div class="section-label"><?php esc_html_e( 'Our Locations', 'driveease' ); ?></div>
					<h2 class="section-title"><?php esc_html_e( 'Find a Branch Near You', 'driveease' ); ?></h2>
				</div>
				<div class="branches-grid">
					<?php
					while ( $branches->have_posts() ) :
						$branches->the_post();
						$address = get_post_meta( get_the_ID(), '_branch_address', true );
						$phone   = get_post_meta( get_the_ID(), '_branch_phone', true );
						$hours   = get_post_meta( get_the_ID(), '_branch_hours_weekday', true );
						?>
						<div class="branch-card">
							<div class="branch-map">
								<i class="fa-solid fa-location-dot"></i>
								<span><?php the_title(); ?></span>
							</div>
							<div class="branch-body">
								<div class="branch-name"><?php the_title(); ?></div>
								<?php if ( $address ) : ?>
									<div class="branch-detail">
										<i class="fa-solid fa-location-dot"></i>
										<span><?php echo esc_html( $address ); ?></span>
									</div>
								<?php endif; ?>
								<?php if ( $phone ) : ?>
									<div class="branch-detail">
										<i class="fa-solid fa-phone"></i>
										<span><?php echo esc_html( $phone ); ?></span>
									</div>
								<?php endif; ?>
								<?php if ( $hours ) : ?>
									<div class="branch-hours">
										<p><strong><?php esc_html_e( 'Hours:', 'driveease' ); ?></strong> <?php echo esc_html( $hours ); ?></p>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

</main>
<?php
get_footer();
