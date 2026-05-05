<?php
/**
 * Front Page Template
 *
 * @package Vagra_MSP
 */

get_header();
?>

<!-- Hero Section -->
<section class="vagra-hero">
    <div class="vagra-container">
        <div class="vagra-hero__content">
            <h1 class="vagra-hero__title"><?php esc_html_e( 'Protect Your Business with Enterprise-Grade Cybersecurity', 'vagra-msp' ); ?></h1>
            <p class="vagra-hero__subtitle"><?php esc_html_e( 'Managed security services built for growing businesses. From email protection to 24/7 monitoring, we keep your data safe so you can focus on what matters.', 'vagra-msp' ); ?></p>
            <a href="#contact" class="vagra-btn vagra-btn--primary vagra-hero__cta">
                <?php esc_html_e( 'Get a Free Security Assessment', 'vagra-msp' ); ?>
            </a>
        </div>
        <div class="vagra-hero__visual">
            <div class="vagra-hero__shield">
                <svg width="200" height="240" viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M100 10L185 50V130C185 180 145 220 100 235C55 220 15 180 15 130V50L100 10Z" fill="var(--vagra-primary)" opacity="0.15" stroke="var(--vagra-primary)" stroke-width="3"/>
                    <path d="M80 125L95 140L125 105" stroke="var(--vagra-success)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="vagra-services" id="services">
    <div class="vagra-container">
        <div class="vagra-section-header">
            <h2 class="vagra-section-header__title"><?php esc_html_e( 'Our Security Services', 'vagra-msp' ); ?></h2>
            <p class="vagra-section-header__desc"><?php esc_html_e( 'Comprehensive managed security solutions to protect every layer of your business.', 'vagra-msp' ); ?></p>
        </div>

        <div class="vagra-services__grid">

            <div class="vagra-card vagra-service-card">
                <div class="vagra-service-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <rect x="4" y="12" width="40" height="28" rx="4" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M4 20H44" stroke="var(--vagra-primary)" stroke-width="2.5"/>
                        <circle cx="24" cy="32" r="4" stroke="var(--vagra-success)" stroke-width="2.5" fill="none"/>
                        <path d="M16 8L24 12L32 8" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="vagra-service-card__title"><?php esc_html_e( 'DMARC / DKIM / SPF', 'vagra-msp' ); ?></h3>
                <p class="vagra-service-card__desc"><?php esc_html_e( 'Stop email spoofing and phishing attacks with properly configured email authentication protocols.', 'vagra-msp' ); ?></p>
            </div>

            <div class="vagra-card vagra-service-card">
                <div class="vagra-service-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <rect x="8" y="8" width="32" height="24" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M8 16H40" stroke="var(--vagra-primary)" stroke-width="2.5"/>
                        <path d="M18 36H30" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M24 32V36" stroke="var(--vagra-primary)" stroke-width="2.5"/>
                        <path d="M20 22L23 25L28 19" stroke="var(--vagra-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="vagra-service-card__title"><?php esc_html_e( 'Email Security', 'vagra-msp' ); ?></h3>
                <p class="vagra-service-card__desc"><?php esc_html_e( 'Advanced email filtering, encryption, and threat detection to safeguard your business communications.', 'vagra-msp' ); ?></p>
            </div>

            <div class="vagra-card vagra-service-card">
                <div class="vagra-service-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <path d="M24 6L40 14V26C40 36 33 43 24 46C15 43 8 36 8 26V14L24 6Z" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M18 26L22 30L30 20" stroke="var(--vagra-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="vagra-service-card__title"><?php esc_html_e( 'Endpoint Protection', 'vagra-msp' ); ?></h3>
                <p class="vagra-service-card__desc"><?php esc_html_e( 'Next-gen antivirus and EDR solutions protecting every device on your network from malware and ransomware.', 'vagra-msp' ); ?></p>
            </div>

            <div class="vagra-card vagra-service-card">
                <div class="vagra-service-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <circle cx="24" cy="24" r="18" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <circle cx="24" cy="24" r="6" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M24 6V12M24 36V42M6 24H12M36 24H42" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="24" cy="24" r="2" fill="var(--vagra-success)"/>
                    </svg>
                </div>
                <h3 class="vagra-service-card__title"><?php esc_html_e( 'Network Monitoring', 'vagra-msp' ); ?></h3>
                <p class="vagra-service-card__desc"><?php esc_html_e( '24/7 network surveillance and real-time alerting to detect and respond to threats before they cause damage.', 'vagra-msp' ); ?></p>
            </div>

            <div class="vagra-card vagra-service-card">
                <div class="vagra-service-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <path d="M24 8L28 16H36L30 22L32 30L24 26L16 30L18 22L12 16H20L24 8Z" stroke="var(--vagra-warning)" stroke-width="2.5" fill="none"/>
                        <path d="M10 38H38" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M14 42H34" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="vagra-service-card__title"><?php esc_html_e( 'Incident Response', 'vagra-msp' ); ?></h3>
                <p class="vagra-service-card__desc"><?php esc_html_e( 'Rapid response plans and expert remediation when security incidents occur. Minimize downtime and data loss.', 'vagra-msp' ); ?></p>
            </div>

            <div class="vagra-card vagra-service-card">
                <div class="vagra-service-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <circle cx="24" cy="16" r="8" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M10 40C10 32 16 28 24 28C32 28 38 32 38 40" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                        <path d="M32 12L36 8M36 8H32M36 8V12" stroke="var(--vagra-success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="vagra-service-card__title"><?php esc_html_e( 'Security Awareness Training', 'vagra-msp' ); ?></h3>
                <p class="vagra-service-card__desc"><?php esc_html_e( 'Empower your team to recognize and prevent cyber threats with engaging, up-to-date security training programs.', 'vagra-msp' ); ?></p>
            </div>

        </div>
    </div>
</section>

<!-- Social Proof Section -->
<section class="vagra-social-proof">
    <div class="vagra-container">
        <h2 class="vagra-social-proof__title"><?php esc_html_e( 'Trusted by 200+ Businesses', 'vagra-msp' ); ?></h2>
        <div class="vagra-social-proof__stats">
            <div class="vagra-stat">
                <span class="vagra-stat__number"><?php esc_html_e( '200+', 'vagra-msp' ); ?></span>
                <span class="vagra-stat__label"><?php esc_html_e( 'Clients Protected', 'vagra-msp' ); ?></span>
            </div>
            <div class="vagra-stat">
                <span class="vagra-stat__number"><?php esc_html_e( '99.9%', 'vagra-msp' ); ?></span>
                <span class="vagra-stat__label"><?php esc_html_e( 'Uptime Guarantee', 'vagra-msp' ); ?></span>
            </div>
            <div class="vagra-stat">
                <span class="vagra-stat__number"><?php esc_html_e( '24/7', 'vagra-msp' ); ?></span>
                <span class="vagra-stat__label"><?php esc_html_e( 'Security Monitoring', 'vagra-msp' ); ?></span>
            </div>
            <div class="vagra-stat">
                <span class="vagra-stat__number"><?php esc_html_e( '<15min', 'vagra-msp' ); ?></span>
                <span class="vagra-stat__label"><?php esc_html_e( 'Avg. Response Time', 'vagra-msp' ); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="vagra-cta" id="contact">
    <div class="vagra-container">
        <div class="vagra-cta__content">
            <h2 class="vagra-cta__title"><?php esc_html_e( 'Ready to Secure Your Business?', 'vagra-msp' ); ?></h2>
            <p class="vagra-cta__desc"><?php esc_html_e( 'Get a free, no-obligation security assessment. Our experts will identify vulnerabilities and recommend a protection plan tailored to your business.', 'vagra-msp' ); ?></p>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vagra-btn vagra-btn--cta">
                <?php esc_html_e( 'Schedule Your Free Assessment', 'vagra-msp' ); ?>
            </a>
        </div>
    </div>
</section>

<?php
get_footer();
