<?php
/**
 * Template Name: Terms of Service
 *
 * Terms of Service page template with structured legal sections.
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

	<!-- Legal Hero -->
	<section class="legal-hero">
		<div class="container">
			<div class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'driveease' ); ?></a>
				<i class="fa-solid fa-chevron-right"></i>
				<span><?php the_title(); ?></span>
			</div>
			<h1><?php the_title(); ?></h1>
			<p class="legal-updated"><?php esc_html_e( 'Last updated:', 'driveease' ); ?> <?php echo esc_html( get_the_modified_date() ); ?></p>
		</div>
	</section>

	<!-- Legal Content -->
	<section class="legal-content">
		<div class="container">
			<div class="legal-body">
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

						<div class="legal-section">
							<h2>1. <?php esc_html_e( 'Acceptance of Terms', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'By accessing or using the DriveEase website and services, you agree to be bound by these Terms of Service. If you do not agree to all the terms and conditions, you must not use our services.', 'driveease' ); ?></p>
						</div>

						<div class="legal-section">
							<h2>2. <?php esc_html_e( 'Rental Agreement', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'Each vehicle rental is subject to a separate rental agreement executed at the time of pickup. These Terms of Service supplement, but do not replace, the individual rental agreement.', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'You must be at least 21 years of age to rent a vehicle.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'A valid driver\'s license held for a minimum of one year is required.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'A credit or debit card in the renter\'s name must be presented at pickup.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'International renters must provide an International Driving Permit (IDP) alongside their domestic license.', 'driveease' ); ?></li>
							</ol>
						</div>

						<div class="legal-section">
							<h2>3. <?php esc_html_e( 'Reservations and Cancellations', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'Reservations can be made through our website, by phone, or at any DriveEase branch location.', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'Cancellations made at least 24 hours before the scheduled pickup time will receive a full refund.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Cancellations made less than 24 hours before pickup may incur a cancellation fee.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'No-shows will be charged the full rental amount for the first day.', 'driveease' ); ?></li>
							</ol>
						</div>

						<div class="legal-section">
							<h2>4. <?php esc_html_e( 'Vehicle Use and Responsibilities', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'The renter agrees to use the vehicle in a responsible manner and in compliance with all applicable laws and regulations.', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'Vehicles may not be used for illegal purposes, racing, or off-road driving unless specifically authorized.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Smoking is prohibited in all vehicles. A cleaning fee will be charged for violations.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'The renter is responsible for all traffic violations and tolls incurred during the rental period.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Only authorized drivers listed in the rental agreement may operate the vehicle.', 'driveease' ); ?></li>
							</ol>
						</div>

						<div class="legal-section">
							<h2>5. <?php esc_html_e( 'Insurance and Liability', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'All rentals include basic insurance coverage. Additional coverage options are available at the time of booking or pickup.', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'The renter is liable for any damage to the vehicle not covered by the selected insurance plan.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'DriveEase is not liable for personal belongings left in the vehicle.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Claims must be reported within 24 hours of the incident.', 'driveease' ); ?></li>
							</ol>
						</div>

						<div class="legal-section">
							<h2>6. <?php esc_html_e( 'Payment Terms', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'Payment is due at the time of vehicle pickup unless otherwise agreed in writing.', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'A security deposit will be held on your payment card and released upon satisfactory return of the vehicle.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Late returns may be charged at the applicable daily rate plus a late-return surcharge.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Fuel charges apply if the vehicle is not returned with the same fuel level as at pickup.', 'driveease' ); ?></li>
							</ol>
						</div>

						<div class="legal-section">
							<h2>7. <?php esc_html_e( 'Limitation of Liability', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'To the maximum extent permitted by law, DriveEase shall not be liable for any indirect, incidental, special, or consequential damages arising from the use of our services or vehicles.', 'driveease' ); ?></p>
						</div>

						<div class="legal-section">
							<h2>8. <?php esc_html_e( 'Changes to Terms', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'DriveEase reserves the right to modify these Terms of Service at any time. Changes will be posted on this page with an updated revision date. Continued use of our services constitutes acceptance of the revised terms.', 'driveease' ); ?></p>
						</div>

						<div class="legal-section">
							<h2>9. <?php esc_html_e( 'Contact Information', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'If you have any questions about these Terms of Service, please contact us:', 'driveease' ); ?></p>
							<p>
								<?php esc_html_e( 'Email: legal@driveease.example', 'driveease' ); ?><br>
								<?php esc_html_e( 'Phone: +X (XXX) XXX-XXXX', 'driveease' ); ?><br>
								<?php esc_html_e( 'Address: 123 Placeholder Street, City Name, Country', 'driveease' ); ?>
							</p>
						</div>

					<?php
					endif;
				endwhile;
				?>
			</div>
		</div>
	</section>

</main>
<?php
get_footer();
