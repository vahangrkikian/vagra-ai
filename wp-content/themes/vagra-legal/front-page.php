<?php
/**
 * Front Page Template
 *
 * @package Vagra_Legal
 */

get_header();
?>

<!-- Hero Section -->
<section class="vagra-hero">
    <div class="vagra-container">
        <div class="vagra-hero__content">
            <h1 class="vagra-hero__title"><?php esc_html_e( 'Experienced Legal Counsel You Can Trust', 'vagra-legal' ); ?></h1>
            <p class="vagra-hero__subtitle"><?php esc_html_e( 'Dedicated attorneys fighting for your rights. From personal injury to business law, we provide the skilled representation you deserve.', 'vagra-legal' ); ?></p>
            <a href="#contact" class="vagra-btn vagra-hero__cta">
                <?php esc_html_e( 'Schedule a Free Consultation', 'vagra-legal' ); ?>
            </a>
        </div>
    </div>
</section>

<!-- Practice Areas Section -->
<section class="vagra-practice-areas" id="practice-areas">
    <div class="vagra-container">
        <div class="vagra-section-header">
            <h2 class="vagra-section-header__title"><?php esc_html_e( 'Our Practice Areas', 'vagra-legal' ); ?></h2>
            <span class="vagra-section-header__accent"></span>
            <p class="vagra-section-header__desc"><?php esc_html_e( 'We offer comprehensive legal services across multiple practice areas to meet your needs.', 'vagra-legal' ); ?></p>
        </div>

        <div class="vagra-practice-areas__grid">

            <div class="vagra-card vagra-practice-card">
                <div class="vagra-practice-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <circle cx="24" cy="20" r="10" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M14 38C14 32 18 28 24 28C30 28 34 32 34 38" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                        <path d="M30 18L36 12" stroke="var(--vagra-danger)" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="vagra-practice-card__title"><?php esc_html_e( 'Personal Injury', 'vagra-legal' ); ?></h3>
                <p class="vagra-practice-card__desc"><?php esc_html_e( 'Aggressive representation for accident victims. We fight to get you the compensation you deserve for your injuries and losses.', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-practice-card">
                <div class="vagra-practice-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <circle cx="16" cy="18" r="6" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <circle cx="32" cy="18" r="6" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <circle cx="24" cy="36" r="5" stroke="var(--vagra-accent)" stroke-width="2.5" fill="none"/>
                        <path d="M16 24V30L24 31M32 24V30L24 31" stroke="var(--vagra-primary)" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="vagra-practice-card__title"><?php esc_html_e( 'Family Law', 'vagra-legal' ); ?></h3>
                <p class="vagra-practice-card__desc"><?php esc_html_e( 'Compassionate guidance through divorce, custody, and support matters. Protecting your family\'s interests with sensitivity and strength.', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-practice-card">
                <div class="vagra-practice-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <path d="M24 8L8 16V18H40V16L24 8Z" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M12 18V36M20 18V36M28 18V36M36 18V36" stroke="var(--vagra-primary)" stroke-width="2.5"/>
                        <path d="M8 36H40" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M6 40H42" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="vagra-practice-card__title"><?php esc_html_e( 'Criminal Defense', 'vagra-legal' ); ?></h3>
                <p class="vagra-practice-card__desc"><?php esc_html_e( 'Vigorous defense of your rights and freedom. Experienced criminal defense attorneys ready to fight for the best possible outcome.', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-practice-card">
                <div class="vagra-practice-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <rect x="8" y="10" width="32" height="28" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M16 10V6H32V10" stroke="var(--vagra-primary)" stroke-width="2.5"/>
                        <path d="M8 20H40" stroke="var(--vagra-primary)" stroke-width="2.5"/>
                        <circle cx="24" cy="26" r="3" stroke="var(--vagra-accent)" stroke-width="2.5" fill="none"/>
                    </svg>
                </div>
                <h3 class="vagra-practice-card__title"><?php esc_html_e( 'Business Law', 'vagra-legal' ); ?></h3>
                <p class="vagra-practice-card__desc"><?php esc_html_e( 'Strategic legal counsel for businesses of all sizes. From formation to contracts to disputes, we protect your business interests.', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-practice-card">
                <div class="vagra-practice-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <circle cx="24" cy="24" r="16" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M24 8V14M24 34V40M8 24H14M34 24H40" stroke="var(--vagra-primary)" stroke-width="2"/>
                        <path d="M18 20C18 20 20 16 24 16C28 16 30 20 30 20" stroke="var(--vagra-primary)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                        <path d="M16 28L24 24L32 28" stroke="var(--vagra-accent)" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="vagra-practice-card__title"><?php esc_html_e( 'Immigration', 'vagra-legal' ); ?></h3>
                <p class="vagra-practice-card__desc"><?php esc_html_e( 'Navigating the complex immigration system with you. Visas, green cards, citizenship, and deportation defense handled with care.', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-practice-card">
                <div class="vagra-practice-card__icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <rect x="10" y="8" width="28" height="34" rx="3" stroke="var(--vagra-primary)" stroke-width="2.5" fill="none"/>
                        <path d="M16 16H32M16 22H32M16 28H26" stroke="var(--vagra-primary)" stroke-width="2" stroke-linecap="round"/>
                        <path d="M28 32L32 36L36 28" stroke="var(--vagra-accent)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="vagra-practice-card__title"><?php esc_html_e( 'Estate Planning', 'vagra-legal' ); ?></h3>
                <p class="vagra-practice-card__desc"><?php esc_html_e( 'Protect your legacy and your loved ones. Wills, trusts, powers of attorney, and comprehensive estate plans tailored to your goals.', 'vagra-legal' ); ?></p>
            </div>

        </div>
    </div>
</section>

<!-- Attorney Spotlight Section -->
<section class="vagra-attorneys" id="attorneys">
    <div class="vagra-container">
        <div class="vagra-section-header">
            <h2 class="vagra-section-header__title"><?php esc_html_e( 'Meet Our Attorneys', 'vagra-legal' ); ?></h2>
            <span class="vagra-section-header__accent"></span>
            <p class="vagra-section-header__desc"><?php esc_html_e( 'Our experienced team brings decades of combined legal expertise to every case.', 'vagra-legal' ); ?></p>
        </div>

        <div class="vagra-attorneys__grid">
            <div class="vagra-card vagra-attorney-card">
                <div class="vagra-attorney-card__photo"><?php esc_html_e( 'JM', 'vagra-legal' ); ?></div>
                <h3 class="vagra-attorney-card__name"><?php esc_html_e( 'James Morrison', 'vagra-legal' ); ?></h3>
                <p class="vagra-attorney-card__role"><?php esc_html_e( 'Managing Partner', 'vagra-legal' ); ?></p>
                <p class="vagra-attorney-card__specialty"><?php esc_html_e( 'Personal Injury, Business Law', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-attorney-card">
                <div class="vagra-attorney-card__photo"><?php esc_html_e( 'SC', 'vagra-legal' ); ?></div>
                <h3 class="vagra-attorney-card__name"><?php esc_html_e( 'Sarah Chen', 'vagra-legal' ); ?></h3>
                <p class="vagra-attorney-card__role"><?php esc_html_e( 'Senior Partner', 'vagra-legal' ); ?></p>
                <p class="vagra-attorney-card__specialty"><?php esc_html_e( 'Family Law, Estate Planning', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-attorney-card">
                <div class="vagra-attorney-card__photo"><?php esc_html_e( 'MR', 'vagra-legal' ); ?></div>
                <h3 class="vagra-attorney-card__name"><?php esc_html_e( 'Michael Rodriguez', 'vagra-legal' ); ?></h3>
                <p class="vagra-attorney-card__role"><?php esc_html_e( 'Partner', 'vagra-legal' ); ?></p>
                <p class="vagra-attorney-card__specialty"><?php esc_html_e( 'Criminal Defense, Immigration', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-attorney-card">
                <div class="vagra-attorney-card__photo"><?php esc_html_e( 'EW', 'vagra-legal' ); ?></div>
                <h3 class="vagra-attorney-card__name"><?php esc_html_e( 'Emily Walsh', 'vagra-legal' ); ?></h3>
                <p class="vagra-attorney-card__role"><?php esc_html_e( 'Associate', 'vagra-legal' ); ?></p>
                <p class="vagra-attorney-card__specialty"><?php esc_html_e( 'Business Law, Estate Planning', 'vagra-legal' ); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Case Results Bar -->
<section class="vagra-case-results">
    <div class="vagra-container">
        <h2 class="vagra-case-results__title"><?php esc_html_e( 'Our Track Record', 'vagra-legal' ); ?></h2>
        <div class="vagra-case-results__stats">
            <div class="vagra-case-stat">
                <span class="vagra-case-stat__number"><?php esc_html_e( '$10M+', 'vagra-legal' ); ?></span>
                <span class="vagra-case-stat__label"><?php esc_html_e( 'Recovered for Clients', 'vagra-legal' ); ?></span>
            </div>
            <div class="vagra-case-stat">
                <span class="vagra-case-stat__number"><?php esc_html_e( '500+', 'vagra-legal' ); ?></span>
                <span class="vagra-case-stat__label"><?php esc_html_e( 'Cases Won', 'vagra-legal' ); ?></span>
            </div>
            <div class="vagra-case-stat">
                <span class="vagra-case-stat__number"><?php esc_html_e( '20+', 'vagra-legal' ); ?></span>
                <span class="vagra-case-stat__label"><?php esc_html_e( 'Years of Experience', 'vagra-legal' ); ?></span>
            </div>
            <div class="vagra-case-stat">
                <span class="vagra-case-stat__number"><?php esc_html_e( '98%', 'vagra-legal' ); ?></span>
                <span class="vagra-case-stat__label"><?php esc_html_e( 'Client Satisfaction', 'vagra-legal' ); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="vagra-testimonials">
    <div class="vagra-container">
        <div class="vagra-section-header">
            <h2 class="vagra-section-header__title"><?php esc_html_e( 'What Our Clients Say', 'vagra-legal' ); ?></h2>
            <span class="vagra-section-header__accent"></span>
        </div>

        <div class="vagra-testimonials__grid">
            <div class="vagra-card vagra-testimonial">
                <div class="vagra-testimonial__quote">&ldquo;</div>
                <p class="vagra-testimonial__text"><?php esc_html_e( 'After my accident, I didn\'t know where to turn. Morrison & Associates took my case and fought for every dollar I deserved. Their dedication made all the difference.', 'vagra-legal' ); ?></p>
                <p class="vagra-testimonial__author"><?php esc_html_e( 'Robert M.', 'vagra-legal' ); ?></p>
                <p class="vagra-testimonial__case"><?php esc_html_e( 'Personal Injury', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-testimonial">
                <div class="vagra-testimonial__quote">&ldquo;</div>
                <p class="vagra-testimonial__text"><?php esc_html_e( 'Going through a divorce is never easy, but Sarah made the process as smooth as possible. She always had my children\'s best interests at heart.', 'vagra-legal' ); ?></p>
                <p class="vagra-testimonial__author"><?php esc_html_e( 'Maria L.', 'vagra-legal' ); ?></p>
                <p class="vagra-testimonial__case"><?php esc_html_e( 'Family Law', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-testimonial">
                <div class="vagra-testimonial__quote">&ldquo;</div>
                <p class="vagra-testimonial__text"><?php esc_html_e( 'Michael handled my immigration case with incredible professionalism. He kept me informed every step of the way and got me the result I needed.', 'vagra-legal' ); ?></p>
                <p class="vagra-testimonial__author"><?php esc_html_e( 'David K.', 'vagra-legal' ); ?></p>
                <p class="vagra-testimonial__case"><?php esc_html_e( 'Immigration', 'vagra-legal' ); ?></p>
            </div>

            <div class="vagra-card vagra-testimonial">
                <div class="vagra-testimonial__quote">&ldquo;</div>
                <p class="vagra-testimonial__text"><?php esc_html_e( 'When our business faced a contract dispute, the team at Morrison & Associates resolved it quickly and saved us from a costly legal battle.', 'vagra-legal' ); ?></p>
                <p class="vagra-testimonial__author"><?php esc_html_e( 'Jennifer T.', 'vagra-legal' ); ?></p>
                <p class="vagra-testimonial__case"><?php esc_html_e( 'Business Law', 'vagra-legal' ); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="vagra-cta" id="contact">
    <div class="vagra-container">
        <div class="vagra-cta__content">
            <span class="vagra-cta__accent-line"></span>
            <h2 class="vagra-cta__title"><?php esc_html_e( 'Schedule Your Free Consultation', 'vagra-legal' ); ?></h2>
            <p class="vagra-cta__desc"><?php esc_html_e( 'Every case begins with a conversation. Tell us about your situation and let our experienced attorneys advise you on your options — at no cost and no obligation.', 'vagra-legal' ); ?></p>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vagra-btn vagra-btn--cta">
                <?php esc_html_e( 'Get Started Today', 'vagra-legal' ); ?>
            </a>
        </div>
    </div>
</section>

<?php
get_footer();
