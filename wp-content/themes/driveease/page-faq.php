<?php
/**
 * Template Name: FAQ
 *
 * FAQ page template with hero and accordion sections.
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

	<!-- FAQ Hero -->
	<section class="faq-hero">
		<div class="container">
			<div class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'driveease' ); ?></a>
				<i class="fa-solid fa-chevron-right"></i>
				<span><?php the_title(); ?></span>
			</div>
			<h1><?php esc_html_e( 'Frequently Asked', 'driveease' ); ?> <span><?php esc_html_e( 'Questions', 'driveease' ); ?></span></h1>
			<p><?php esc_html_e( 'Find quick answers to common questions about bookings, vehicles, insurance, and more.', 'driveease' ); ?></p>
		</div>
	</section>

	<!-- FAQ Content -->
	<section class="faq-section">
		<div class="container">
			<div class="faq-wrapper">
				<?php
				// If the page has custom content (e.g. from the editor), show it.
				while ( have_posts() ) :
					the_post();
					$content = get_the_content();
					if ( $content ) :
						?>
						<div class="entry-content faq-custom">
							<?php the_content(); ?>
						</div>
					<?php else : ?>
						<!-- Default FAQ accordion -->
						<div class="faq-category">
							<h2 class="faq-cat-title"><i class="fa-solid fa-car"></i> <?php esc_html_e( 'Booking & Reservations', 'driveease' ); ?></h2>
							<div class="faq-accordion">
								<div class="faq-item">
									<button class="faq-question" aria-expanded="false">
										<span><?php esc_html_e( 'How do I make a reservation?', 'driveease' ); ?></span>
										<i class="fa-solid fa-chevron-down"></i>
									</button>
									<div class="faq-answer">
										<p><?php esc_html_e( 'You can book a vehicle directly on our website using the booking widget on the homepage, or by clicking the "Book Now" button on any car listing. You can also call us or visit any of our branch locations.', 'driveease' ); ?></p>
									</div>
								</div>
								<div class="faq-item">
									<button class="faq-question" aria-expanded="false">
										<span><?php esc_html_e( 'Can I modify or cancel my booking?', 'driveease' ); ?></span>
										<i class="fa-solid fa-chevron-down"></i>
									</button>
									<div class="faq-answer">
										<p><?php esc_html_e( 'Yes! You can cancel free of charge up to 24 hours before your scheduled pick-up. Modifications can be made at any time subject to availability.', 'driveease' ); ?></p>
									</div>
								</div>
								<div class="faq-item">
									<button class="faq-question" aria-expanded="false">
										<span><?php esc_html_e( 'What documents do I need to rent a car?', 'driveease' ); ?></span>
										<i class="fa-solid fa-chevron-down"></i>
									</button>
									<div class="faq-answer">
										<p><?php esc_html_e( 'You will need a valid driver\'s licence, a credit or debit card in your name, and a government-issued ID. International renters may also need an International Driving Permit (IDP).', 'driveease' ); ?></p>
									</div>
								</div>
							</div>
						</div>

						<div class="faq-category">
							<h2 class="faq-cat-title"><i class="fa-solid fa-shield-halved"></i> <?php esc_html_e( 'Insurance & Coverage', 'driveease' ); ?></h2>
							<div class="faq-accordion">
								<div class="faq-item">
									<button class="faq-question" aria-expanded="false">
										<span><?php esc_html_e( 'Is insurance included in the rental price?', 'driveease' ); ?></span>
										<i class="fa-solid fa-chevron-down"></i>
									</button>
									<div class="faq-answer">
										<p><?php esc_html_e( 'Yes, all our rentals include comprehensive insurance coverage at no additional cost. You can also opt for premium coverage to reduce your excess to zero.', 'driveease' ); ?></p>
									</div>
								</div>
								<div class="faq-item">
									<button class="faq-question" aria-expanded="false">
										<span><?php esc_html_e( 'What happens if the car is damaged?', 'driveease' ); ?></span>
										<i class="fa-solid fa-chevron-down"></i>
									</button>
									<div class="faq-answer">
										<p><?php esc_html_e( 'Report any damage immediately to our 24/7 support line. With standard insurance, a small excess may apply. With our premium coverage, you are fully covered.', 'driveease' ); ?></p>
									</div>
								</div>
							</div>
						</div>

						<div class="faq-category">
							<h2 class="faq-cat-title"><i class="fa-solid fa-gas-pump"></i> <?php esc_html_e( 'Vehicle & Fuel', 'driveease' ); ?></h2>
							<div class="faq-accordion">
								<div class="faq-item">
									<button class="faq-question" aria-expanded="false">
										<span><?php esc_html_e( 'What is the fuel policy?', 'driveease' ); ?></span>
										<i class="fa-solid fa-chevron-down"></i>
									</button>
									<div class="faq-answer">
										<p><?php esc_html_e( 'Our policy is full-to-full: you pick up the car with a full tank and return it full. If you return it without refuelling, a refuelling charge will apply.', 'driveease' ); ?></p>
									</div>
								</div>
								<div class="faq-item">
									<button class="faq-question" aria-expanded="false">
										<span><?php esc_html_e( 'Is there a mileage limit?', 'driveease' ); ?></span>
										<i class="fa-solid fa-chevron-down"></i>
									</button>
									<div class="faq-answer">
										<p><?php esc_html_e( 'Most of our rentals include unlimited mileage. Specific terms may vary for luxury and specialty vehicles — check the details on each car listing.', 'driveease' ); ?></p>
									</div>
								</div>
							</div>
						</div>

						<!-- CTA -->
						<div class="faq-cta">
							<h3><?php esc_html_e( 'Still have questions?', 'driveease' ); ?></h3>
							<p><?php esc_html_e( 'Our support team is available 24/7 to help you with anything you need.', 'driveease' ); ?></p>
							<?php
							$contact_page = get_page_by_path( 'contact' );
							$contact_url  = $contact_page ? get_permalink( $contact_page ) : home_url( '/contact/' );
							?>
							<a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-primary">
								<i class="fa-solid fa-headset"></i>
								<?php esc_html_e( 'Contact Us', 'driveease' ); ?>
							</a>
						</div>
					<?php
					endif;
				endwhile;
				?>
			</div>
		</div>
	</section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.faq-question').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var item = this.closest('.faq-item');
			var expanded = this.getAttribute('aria-expanded') === 'true';
			// Close all siblings.
			item.parentElement.querySelectorAll('.faq-item.open').forEach(function (openItem) {
				if (openItem !== item) {
					openItem.classList.remove('open');
					openItem.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
				}
			});
			// Toggle current.
			item.classList.toggle('open');
			this.setAttribute('aria-expanded', String(!expanded));
		});
	});
});
</script>

<?php
get_footer();
