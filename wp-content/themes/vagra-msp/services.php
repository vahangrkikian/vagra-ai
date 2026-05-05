<?php
/**
 * Template Name: Services
 *
 * @package Vagra_MSP
 */

get_header();
?>

<section class="vagra-page-hero">
	<div class="vagra-container">
		<h1 class="vagra-page-hero__title"><?php esc_html_e( 'Our Security Services', 'vagra-msp' ); ?></h1>
		<p class="vagra-page-hero__desc"><?php esc_html_e( 'Comprehensive managed security solutions to protect every layer of your business.', 'vagra-msp' ); ?></p>
	</div>
</section>

<section class="vagra-services-detail">
	<div class="vagra-container">

		<div class="vagra-service-detail" id="dmarc">
			<div class="vagra-service-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<rect x="4" y="12" width="40" height="28" rx="4" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M4 20H44" stroke="var(--vagra-primary)" stroke-width="2.5"/>
					<circle cx="24" cy="32" r="4" stroke="var(--vagra-success)" stroke-width="2.5" fill="none"/>
					<path d="M16 8L24 12L32 8" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
				</svg>
			</div>
			<div class="vagra-service-detail__content">
				<h2 class="vagra-service-detail__title"><?php esc_html_e( 'DMARC / DKIM / SPF', 'vagra-msp' ); ?></h2>
				<p><?php esc_html_e( 'Stop email spoofing and phishing attacks with properly configured email authentication protocols. We implement and monitor DMARC, DKIM, and SPF records to ensure your domain cannot be impersonated.', 'vagra-msp' ); ?></p>
				<ul class="vagra-service-detail__features">
					<li><?php esc_html_e( 'Full DMARC policy implementation and monitoring', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'DKIM key rotation and management', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'SPF record optimization', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Weekly aggregate report analysis', 'vagra-msp' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-service-detail" id="email-security">
			<div class="vagra-service-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<rect x="8" y="8" width="32" height="24" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M8 16H40" stroke="var(--vagra-primary)" stroke-width="2.5"/>
					<path d="M18 36H30" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
					<path d="M24 32V36" stroke="var(--vagra-primary)" stroke-width="2.5"/>
					<path d="M20 22L23 25L28 19" stroke="var(--vagra-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="vagra-service-detail__content">
				<h2 class="vagra-service-detail__title"><?php esc_html_e( 'Email Security', 'vagra-msp' ); ?></h2>
				<p><?php esc_html_e( 'Advanced email filtering, encryption, and threat detection to safeguard your business communications from phishing, malware, and data exfiltration.', 'vagra-msp' ); ?></p>
				<ul class="vagra-service-detail__features">
					<li><?php esc_html_e( 'Advanced threat protection and sandboxing', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Email encryption for sensitive data', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Phishing simulation and training', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Data loss prevention policies', 'vagra-msp' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-service-detail" id="endpoint-protection">
			<div class="vagra-service-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<path d="M24 6L40 14V26C40 36 33 43 24 46C15 43 8 36 8 26V14L24 6Z" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M18 26L22 30L30 20" stroke="var(--vagra-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="vagra-service-detail__content">
				<h2 class="vagra-service-detail__title"><?php esc_html_e( 'Endpoint Protection', 'vagra-msp' ); ?></h2>
				<p><?php esc_html_e( 'Next-gen antivirus and EDR solutions protecting every device on your network from malware, ransomware, and zero-day threats.', 'vagra-msp' ); ?></p>
				<ul class="vagra-service-detail__features">
					<li><?php esc_html_e( 'Next-gen antivirus with AI detection', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Endpoint Detection and Response (EDR)', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Automatic patch management', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Device compliance monitoring', 'vagra-msp' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-service-detail" id="network-monitoring">
			<div class="vagra-service-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<circle cx="24" cy="24" r="18" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<circle cx="24" cy="24" r="6" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M24 6V12M24 36V42M6 24H12M36 24H42" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
					<circle cx="24" cy="24" r="2" fill="var(--vagra-success)"/>
				</svg>
			</div>
			<div class="vagra-service-detail__content">
				<h2 class="vagra-service-detail__title"><?php esc_html_e( 'Network Monitoring', 'vagra-msp' ); ?></h2>
				<p><?php esc_html_e( '24/7 network surveillance and real-time alerting to detect and respond to threats before they cause damage to your infrastructure.', 'vagra-msp' ); ?></p>
				<ul class="vagra-service-detail__features">
					<li><?php esc_html_e( '24/7 Security Operations Center (SOC)', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Intrusion detection and prevention', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Network traffic analysis', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Real-time threat alerting', 'vagra-msp' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-service-detail" id="incident-response">
			<div class="vagra-service-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<path d="M24 8L28 16H36L30 22L32 30L24 26L16 30L18 22L12 16H20L24 8Z" stroke="var(--vagra-warning)" stroke-width="2.5" fill="none"/>
					<path d="M10 38H38" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
					<path d="M14 42H34" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
				</svg>
			</div>
			<div class="vagra-service-detail__content">
				<h2 class="vagra-service-detail__title"><?php esc_html_e( 'Incident Response', 'vagra-msp' ); ?></h2>
				<p><?php esc_html_e( 'Rapid response plans and expert remediation when security incidents occur. Minimize downtime, data loss, and business impact.', 'vagra-msp' ); ?></p>
				<ul class="vagra-service-detail__features">
					<li><?php esc_html_e( 'Incident response planning and playbooks', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Forensic investigation and analysis', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Breach notification assistance', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Post-incident remediation', 'vagra-msp' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="vagra-service-detail" id="security-training">
			<div class="vagra-service-detail__icon">
				<svg width="64" height="64" viewBox="0 0 48 48" fill="none" aria-hidden="true">
					<circle cx="24" cy="16" r="8" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
					<path d="M10 40C10 32 16 28 24 28C32 28 38 32 38 40" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
					<path d="M32 12L36 8M36 8H32M36 8V12" stroke="var(--vagra-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="vagra-service-detail__content">
				<h2 class="vagra-service-detail__title"><?php esc_html_e( 'Security Awareness Training', 'vagra-msp' ); ?></h2>
				<p><?php esc_html_e( 'Empower your team to recognize and prevent cyber threats with engaging, up-to-date security training programs tailored to your industry.', 'vagra-msp' ); ?></p>
				<ul class="vagra-service-detail__features">
					<li><?php esc_html_e( 'Interactive security awareness courses', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Simulated phishing campaigns', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Compliance training (HIPAA, PCI, SOC 2)', 'vagra-msp' ); ?></li>
					<li><?php esc_html_e( 'Monthly threat briefings', 'vagra-msp' ); ?></li>
				</ul>
			</div>
		</div>

	</div>
</section>

<section class="vagra-cta" id="contact">
	<div class="vagra-container">
		<div class="vagra-cta__content">
			<h2 class="vagra-cta__title"><?php esc_html_e( 'Ready to Secure Your Business?', 'vagra-msp' ); ?></h2>
			<p class="vagra-cta__desc"><?php esc_html_e( 'Get a free, no-obligation security assessment from our team of experts.', 'vagra-msp' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vagra-btn vagra-btn--cta">
				<?php esc_html_e( 'Schedule Your Free Assessment', 'vagra-msp' ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
