<?php
/**
 * Template Name: Privacy Policy
 *
 * Privacy Policy page template with structured legal sections.
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
							<h2>1. <?php esc_html_e( 'Information We Collect', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'We collect information you provide directly to us when using our services, including:', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'Personal identification information (name, email address, phone number, date of birth).', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Driver\'s license details and identification documents.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Payment information (credit/debit card numbers, billing address).', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Rental history and preferences.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Communications with our customer support team.', 'driveease' ); ?></li>
							</ol>
						</div>

						<div class="legal-section">
							<h2>2. <?php esc_html_e( 'How We Use Your Information', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'We use the collected information for the following purposes:', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'To process and manage your vehicle reservations and rentals.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'To verify your identity and eligibility to rent.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'To process payments and issue receipts.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'To communicate with you about your bookings, account, and customer service inquiries.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'To improve our services and develop new features.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'To comply with legal obligations and enforce our terms.', 'driveease' ); ?></li>
							</ol>
						</div>

						<div class="legal-section">
							<h2>3. <?php esc_html_e( 'Information Sharing', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'We do not sell your personal information. We may share your data with:', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'Insurance providers to process claims related to your rental.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Payment processors to complete transactions securely.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Law enforcement agencies when required by law or to protect our legal rights.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Service providers who assist us in operating our business (e.g., IT support, analytics).', 'driveease' ); ?></li>
							</ol>
						</div>

						<div class="legal-section">
							<h2>4. <?php esc_html_e( 'Data Security', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These measures include encryption, secure servers, and regular security audits.', 'driveease' ); ?></p>
						</div>

						<div class="legal-section">
							<h2>5. <?php esc_html_e( 'Cookies and Tracking', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'Our website uses cookies and similar tracking technologies to:', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'Remember your preferences and settings.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Analyze website traffic and usage patterns.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'Provide personalized content and recommendations.', 'driveease' ); ?></li>
							</ol>
							<p><?php esc_html_e( 'You can control cookie settings through your browser preferences. Disabling cookies may affect certain features of our website.', 'driveease' ); ?></p>
						</div>

						<div class="legal-section">
							<h2>6. <?php esc_html_e( 'Your Rights', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'Depending on your jurisdiction, you may have the following rights regarding your personal data:', 'driveease' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'The right to access and receive a copy of your personal data.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'The right to correct inaccurate or incomplete information.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'The right to request deletion of your personal data.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'The right to restrict or object to processing of your data.', 'driveease' ); ?></li>
								<li><?php esc_html_e( 'The right to data portability.', 'driveease' ); ?></li>
							</ol>
							<p><?php esc_html_e( 'To exercise any of these rights, please contact us using the information provided below.', 'driveease' ); ?></p>
						</div>

						<div class="legal-section">
							<h2>7. <?php esc_html_e( 'Data Retention', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'We retain your personal information for as long as necessary to fulfill the purposes for which it was collected, including to satisfy legal, accounting, or reporting requirements. Rental records are typically retained for a minimum of seven years.', 'driveease' ); ?></p>
						</div>

						<div class="legal-section">
							<h2>8. <?php esc_html_e( 'Changes to This Policy', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised effective date. We encourage you to review this page periodically.', 'driveease' ); ?></p>
						</div>

						<div class="legal-section">
							<h2>9. <?php esc_html_e( 'Contact Information', 'driveease' ); ?></h2>
							<p><?php esc_html_e( 'If you have questions or concerns about this Privacy Policy or our data practices, please contact us:', 'driveease' ); ?></p>
							<p>
								<?php esc_html_e( 'Email: privacy@driveease.example', 'driveease' ); ?><br>
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
