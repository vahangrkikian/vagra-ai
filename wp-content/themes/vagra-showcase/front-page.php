<?php
/**
 * Front page template – vagra.ai Showcase
 *
 * @package vagra-showcase
 */

get_header();

// ── Theme data ──
$themes = array(
    array(
        'slug'     => 'msp',
        'name'     => 'Vagra MSP',
        'accent'   => '#3366FF',
        'niche'    => __( 'Cybersecurity', 'vagra-showcase' ),
        'tagline'  => __( 'Security services that sell themselves.', 'vagra-showcase' ),
        'ai'       => __( 'Security Advisor', 'vagra-showcase' ),
        'preview'  => 'shield',
        'url'      => 'http://msp.vagraai.local/',
        'category' => 'business',
    ),
    array(
        'slug'     => 'legal',
        'name'     => 'Vagra Legal',
        'accent'   => '#C9A84C',
        'niche'    => __( 'Law Firm', 'vagra-showcase' ),
        'tagline'  => __( 'Quiet authority. Modern intake.', 'vagra-showcase' ),
        'ai'       => __( 'Intake Assistant', 'vagra-showcase' ),
        'preview'  => 'scales',
        'url'      => 'http://legal.vagraai.local/',
        'category' => 'business',
    ),
    array(
        'slug'     => 'nslookup',
        'name'     => 'Vagra NSLookup',
        'accent'   => '#4F46E5',
        'niche'    => __( 'DNS Tools', 'vagra-showcase' ),
        'tagline'  => __( 'DNS, demystified.', 'vagra-showcase' ),
        'ai'       => __( 'DNS Expert', 'vagra-showcase' ),
        'preview'  => 'globe',
        'url'      => 'http://nslookup.vagraai.local/',
        'category' => 'tools',
    ),
    array(
        'slug'     => 'carvice',
        'name'     => 'Carvice',
        'accent'   => '#1a73e8',
        'niche'    => __( 'Car Service', 'vagra-showcase' ),
        'tagline'  => __( 'The auto-repair marketplace.', 'vagra-showcase' ),
        'ai'       => __( 'Auto Advisor', 'vagra-showcase' ),
        'preview'  => 'wrench',
        'url'      => 'http://carvice.vagraai.local/',
        'category' => 'automotive',
    ),
    array(
        'slug'     => 'driveease',
        'name'     => 'DriveEase',
        'accent'   => '#10B981',
        'niche'    => __( 'Car Rental', 'vagra-showcase' ),
        'tagline'  => __( 'Rentals without the counter.', 'vagra-showcase' ),
        'ai'       => __( 'Rental Agent', 'vagra-showcase' ),
        'preview'  => 'wheel',
        'url'      => 'http://driveease.vagraai.local/',
        'category' => 'automotive',
    ),
    array(
        'slug'     => 'tourvice',
        'name'     => 'TourVice',
        'accent'   => '#B8612A',
        'niche'    => __( 'Tourism', 'vagra-showcase' ),
        'tagline'  => __( 'Armenia, on its own terms.', 'vagra-showcase' ),
        'ai'       => __( 'Travel Guide', 'vagra-showcase' ),
        'preview'  => 'mountain',
        'url'      => 'http://tourvice.vagraai.local/',
        'category' => 'hospitality',
    ),
    array(
        'slug'     => 'meridian',
        'name'     => 'Meridian',
        'accent'   => '#d4af37',
        'niche'    => __( 'Hotel', 'vagra-showcase' ),
        'tagline'  => __( 'The five-star booking experience.', 'vagra-showcase' ),
        'ai'       => __( 'Hotel Concierge', 'vagra-showcase' ),
        'preview'  => 'skyline',
        'url'      => 'http://meridian.vagraai.local/',
        'category' => 'hospitality',
    ),
    array(
        'slug'     => 'houseservice',
        'name'     => 'House Service',
        'accent'   => '#2563eb',
        'niche'    => __( 'Home Services', 'vagra-showcase' ),
        'tagline'  => __( 'Trusted pros at your doorstep.', 'vagra-showcase' ),
        'ai'       => __( 'Service Advisor', 'vagra-showcase' ),
        'preview'  => 'house',
        'url'      => 'http://houseservice.vagraai.local/',
        'category' => 'services',
    ),
);

/**
 * Return inline SVG art for a given theme type.
 */
function vagra_theme_svg( $type, $accent ) {
    $esc = esc_attr( $accent );
    switch ( $type ) {
        case 'shield':
            return '<svg viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 20L40 50v40c0 30 26 50 60 60 34-10 60-30 60-60V50L100 20z" stroke="' . $esc . '" stroke-width="2" fill="' . $esc . '" fill-opacity="0.08"/>
                <path d="M85 75l10 10 20-20" stroke="' . $esc . '" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="100" cy="75" r="30" stroke="' . $esc . '" stroke-width="1.5" stroke-dasharray="4 4" opacity="0.3"/>
            </svg>';
        case 'scales':
            return '<svg viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="100" y1="25" x2="100" y2="125" stroke="' . $esc . '" stroke-width="2"/>
                <line x1="60" y1="45" x2="140" y2="45" stroke="' . $esc . '" stroke-width="2"/>
                <path d="M55 45l-15 40h30L55 45z" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.1"/>
                <path d="M145 45l-15 40h30L145 45z" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.1"/>
                <ellipse cx="55" cy="85" rx="16" ry="4" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.08"/>
                <ellipse cx="145" cy="85" rx="16" ry="4" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.08"/>
                <rect x="80" y="120" width="40" height="6" rx="3" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.08"/>
            </svg>';
        case 'globe':
            return '<svg viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="75" r="45" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.05"/>
                <ellipse cx="100" cy="75" rx="20" ry="45" stroke="' . $esc . '" stroke-width="1" opacity="0.5"/>
                <line x1="55" y1="60" x2="145" y2="60" stroke="' . $esc . '" stroke-width="1" opacity="0.3"/>
                <line x1="55" y1="90" x2="145" y2="90" stroke="' . $esc . '" stroke-width="1" opacity="0.3"/>
                <line x1="100" y1="30" x2="100" y2="120" stroke="' . $esc . '" stroke-width="1" opacity="0.3"/>
                <circle cx="100" cy="75" r="5" fill="' . $esc . '" fill-opacity="0.6"/>
                <circle cx="100" cy="75" r="10" stroke="' . $esc . '" stroke-width="1" stroke-dasharray="3 3" opacity="0.4"/>
            </svg>';
        case 'wrench':
            return '<svg viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M130 40a25 25 0 0 0-35 5l-30 30a25 25 0 1 0 35 35l30-30a25 25 0 0 0-5-35" stroke="' . $esc . '" stroke-width="2" fill="' . $esc . '" fill-opacity="0.06"/>
                <circle cx="80" cy="95" r="8" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.15"/>
                <path d="M120 35l15-10 10 10-10 15" stroke="' . $esc . '" stroke-width="2" stroke-linecap="round"/>
                <line x1="90" y1="65" x2="110" y2="85" stroke="' . $esc . '" stroke-width="1" stroke-dasharray="4 4" opacity="0.4"/>
            </svg>';
        case 'wheel':
            return '<svg viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="75" r="45" stroke="' . $esc . '" stroke-width="2" fill="' . $esc . '" fill-opacity="0.05"/>
                <circle cx="100" cy="75" r="15" stroke="' . $esc . '" stroke-width="2" fill="' . $esc . '" fill-opacity="0.1"/>
                <circle cx="100" cy="75" r="5" fill="' . $esc . '"/>
                <line x1="100" y1="30" x2="100" y2="60" stroke="' . $esc . '" stroke-width="2"/>
                <line x1="100" y1="90" x2="100" y2="120" stroke="' . $esc . '" stroke-width="2"/>
                <line x1="55" y1="75" x2="85" y2="75" stroke="' . $esc . '" stroke-width="2"/>
                <line x1="115" y1="75" x2="145" y2="75" stroke="' . $esc . '" stroke-width="2"/>
                <line x1="68" y1="43" x2="83" y2="63" stroke="' . $esc . '" stroke-width="1.5"/>
                <line x1="117" y1="87" x2="132" y2="107" stroke="' . $esc . '" stroke-width="1.5"/>
                <line x1="132" y1="43" x2="117" y2="63" stroke="' . $esc . '" stroke-width="1.5"/>
                <line x1="83" y1="87" x2="68" y2="107" stroke="' . $esc . '" stroke-width="1.5"/>
            </svg>';
        case 'mountain':
            return '<svg viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 120L70 40l30 35 30-55 50 100H20z" stroke="' . $esc . '" stroke-width="2" fill="' . $esc . '" fill-opacity="0.08"/>
                <path d="M70 40l15 18 15-18" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.15"/>
                <circle cx="150" cy="35" r="12" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.1"/>
                <path d="M40 120l20-30 15 12 15-20" stroke="' . $esc . '" stroke-width="1" opacity="0.3" stroke-dasharray="4 4"/>
            </svg>';
        case 'skyline':
            return '<svg viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="30" y="60" width="25" height="60" rx="2" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.06"/>
                <rect x="62" y="35" width="22" height="85" rx="2" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.08"/>
                <rect x="90" y="20" width="28" height="100" rx="2" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.1"/>
                <rect x="124" y="45" width="22" height="75" rx="2" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.08"/>
                <rect x="152" y="55" width="20" height="65" rx="2" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.06"/>
                <line x1="95" y1="30" x2="95" y2="20" stroke="' . $esc . '" stroke-width="1.5"/>
                <circle cx="95" cy="17" r="3" fill="' . $esc . '" fill-opacity="0.5"/>
                <rect x="36" y="75" width="5" height="5" rx="1" fill="' . $esc . '" fill-opacity="0.3"/>
                <rect x="44" y="75" width="5" height="5" rx="1" fill="' . $esc . '" fill-opacity="0.3"/>
                <rect x="36" y="85" width="5" height="5" rx="1" fill="' . $esc . '" fill-opacity="0.3"/>
                <rect x="44" y="85" width="5" height="5" rx="1" fill="' . $esc . '" fill-opacity="0.3"/>
                <rect x="97" y="35" width="5" height="5" rx="1" fill="' . $esc . '" fill-opacity="0.3"/>
                <rect x="107" y="35" width="5" height="5" rx="1" fill="' . $esc . '" fill-opacity="0.3"/>
                <rect x="97" y="45" width="5" height="5" rx="1" fill="' . $esc . '" fill-opacity="0.3"/>
                <rect x="107" y="45" width="5" height="5" rx="1" fill="' . $esc . '" fill-opacity="0.3"/>
                <line x1="20" y1="120" x2="180" y2="120" stroke="' . $esc . '" stroke-width="1.5"/>
            </svg>';
        case 'house':
            return '<svg viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 20L30 70v50h140V70L100 20z" stroke="' . $esc . '" stroke-width="2" fill="' . $esc . '" fill-opacity="0.06"/>
                <path d="M100 20L30 70" stroke="' . $esc . '" stroke-width="2" stroke-linecap="round"/>
                <path d="M100 20L170 70" stroke="' . $esc . '" stroke-width="2" stroke-linecap="round"/>
                <rect x="80" y="85" width="40" height="35" rx="2" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.1"/>
                <line x1="100" y1="85" x2="100" y2="120" stroke="' . $esc . '" stroke-width="1.5"/>
                <rect x="45" y="80" width="20" height="18" rx="2" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.1"/>
                <line x1="55" y1="80" x2="55" y2="98" stroke="' . $esc . '" stroke-width="1" opacity="0.4"/>
                <line x1="45" y1="89" x2="65" y2="89" stroke="' . $esc . '" stroke-width="1" opacity="0.4"/>
                <rect x="135" y="80" width="20" height="18" rx="2" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.1"/>
                <line x1="145" y1="80" x2="145" y2="98" stroke="' . $esc . '" stroke-width="1" opacity="0.4"/>
                <line x1="135" y1="89" x2="155" y2="89" stroke="' . $esc . '" stroke-width="1" opacity="0.4"/>
                <circle cx="100" cy="55" r="8" stroke="' . $esc . '" stroke-width="1.5" fill="' . $esc . '" fill-opacity="0.15"/>
                <path d="M97 55l2 2 4-4" stroke="' . $esc . '" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>';
        default:
            return '';
    }
}
?>

<main>

<!-- ════════════════════════════════════════ HERO ════════════════════════════════════════ -->
<section class="hero">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-mouse" aria-hidden="true"></div>

    <div class="hero-inner" data-reveal>
        <p class="eyebrow"><?php esc_html_e( '8 niches &middot; 8 themes &middot; 8 concierges', 'vagra-showcase' ); ?></p>
        <h1><?php
            /* translators: gradient-wrapped text */
            printf(
                esc_html__( 'WordPress themes that %sknow your industry.%s', 'vagra-showcase' ),
                '<span class="gradient">',
                '</span>'
            );
        ?></h1>
        <p class="hero-sub"><?php esc_html_e( 'Purpose-built starter themes — each with its own AI concierge, demo content, and industry logic. Install in one click, launch in one day.', 'vagra-showcase' ); ?></p>

        <div class="hero-actions">
            <a href="#themes" class="btn btn-primary">
                <?php esc_html_e( 'Explore themes', 'vagra-showcase' ); ?>
                <?php echo vagra_icon( 'arrow', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
            </a>
            <a href="#ai" class="btn btn-ghost">
                <?php esc_html_e( 'See AI in action', 'vagra-showcase' ); ?>
            </a>
        </div>

        <div class="hero-trust">
            <span><?php esc_html_e( '8 themes', 'vagra-showcase' ); ?></span>
            <span><?php esc_html_e( 'PageSpeed 90+', 'vagra-showcase' ); ?></span>
            <span><?php esc_html_e( 'WP.org compliant', 'vagra-showcase' ); ?></span>
            <span><?php esc_html_e( 'GPL-2.0', 'vagra-showcase' ); ?></span>
            <span><?php esc_html_e( 'i18n ready', 'vagra-showcase' ); ?></span>
        </div>

        <div class="hero-preview">
            <?php
            // Show 3 hero cards: MSP, NSLookup, Meridian
            $hero_picks = array( $themes[0], $themes[2], $themes[6] );
            foreach ( $hero_picks as $hp ) :
            ?>
            <div class="hero-card">
                <?php echo vagra_theme_svg( $hp['preview'], $hp['accent'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════════ THEMES ════════════════════════════════════════ -->
<section id="themes">
    <div class="container">
        <div class="section-head section-head--center" data-reveal>
            <p class="eyebrow"><?php esc_html_e( 'The collection', 'vagra-showcase' ); ?></p>
            <h2><?php esc_html_e( 'Eight themes. One philosophy.', 'vagra-showcase' ); ?></h2>
            <p><?php esc_html_e( 'Each theme ships with demo content, an AI concierge persona, and industry-specific logic. Zero generic templates.', 'vagra-showcase' ); ?></p>
        </div>

        <div class="filter-bar" data-reveal>
            <button class="filter-chip active" data-filter="all"><?php esc_html_e( 'All themes', 'vagra-showcase' ); ?></button>
            <button class="filter-chip" data-filter="business"><?php esc_html_e( 'Business', 'vagra-showcase' ); ?></button>
            <button class="filter-chip" data-filter="tools"><?php esc_html_e( 'Tools', 'vagra-showcase' ); ?></button>
            <button class="filter-chip" data-filter="automotive"><?php esc_html_e( 'Automotive', 'vagra-showcase' ); ?></button>
            <button class="filter-chip" data-filter="hospitality"><?php esc_html_e( 'Hospitality', 'vagra-showcase' ); ?></button>
            <button class="filter-chip" data-filter="services"><?php esc_html_e( 'Services', 'vagra-showcase' ); ?></button>
        </div>

        <div class="theme-grid">
            <?php foreach ( $themes as $t ) : ?>
            <div class="theme-card" data-category="<?php echo esc_attr( $t['category'] ); ?>" data-reveal>
                <div class="theme-card-preview">
                    <?php echo vagra_theme_svg( $t['preview'], $t['accent'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                </div>
                <div class="theme-card-body">
                    <div class="theme-card-meta">
                        <span class="niche-pill" style="background:<?php echo esc_attr( $t['accent'] ); ?>"><?php echo esc_html( $t['niche'] ); ?></span>
                        <span class="live-dot"><?php esc_html_e( 'Live', 'vagra-showcase' ); ?></span>
                        <?php if ( in_array( $t['slug'], array( 'nslookup', 'legal' ), true ) ) : ?>
                        <span class="theme-card-compat">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M21 2H3a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zm-1 18H4V4h16v16z"/><path d="M7 6h10v2H7zM7 10h10v2H7zM7 14h6v2H7z"/></svg>
                            <?php esc_html_e( 'Elementor', 'vagra-showcase' ); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <h3><?php echo esc_html( $t['name'] ); ?></h3>
                    <p class="tagline"><?php echo esc_html( $t['tagline'] ); ?></p>
                    <div class="ai-badge">
                        <?php echo vagra_icon( 'spark', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        <?php echo esc_html( $t['ai'] ); ?>
                    </div>
                    <div class="theme-card-actions">
                        <a href="<?php echo esc_url( $t['url'] ); ?>" class="btn btn-primary btn-sm" target="_blank" rel="noopener">
                            <?php esc_html_e( 'Preview', 'vagra-showcase' ); ?>
                            <?php echo vagra_icon( 'arrow', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        </a>
                        <a href="<?php echo esc_url( $t['url'] ); ?>" class="btn btn-ghost btn-sm">
                            <?php esc_html_e( 'Details', 'vagra-showcase' ); ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════════ AI DEMO ════════════════════════════════════════ -->
<section id="ai" class="ai-section">
    <div class="container">
        <div class="split">
            <!-- Left -->
            <div data-reveal>
                <p class="eyebrow"><?php esc_html_e( 'The AI difference', 'vagra-showcase' ); ?></p>
                <h2><?php esc_html_e( 'Not a chatbot plugin. A concierge that speaks your industry.', 'vagra-showcase' ); ?></h2>
                <p style="margin-top:16px;color:var(--text-muted);font-size:16px;line-height:1.7;">
                    <?php esc_html_e( 'Every theme ships with a trained persona that understands the domain — terminology, workflows, regulations. It is not a wrapper around a generic LLM.', 'vagra-showcase' ); ?>
                </p>
                <ul class="bullets">
                    <li><?php esc_html_e( 'Industry-specific training data baked into every persona', 'vagra-showcase' ); ?></li>
                    <li><?php esc_html_e( 'Answers in context: booking flows, legal intake, DNS queries', 'vagra-showcase' ); ?></li>
                    <li><?php esc_html_e( 'Graceful fallback — never hallucinates, always defers when unsure', 'vagra-showcase' ); ?></li>
                    <li><?php esc_html_e( 'Works with any OpenAI-compatible API endpoint', 'vagra-showcase' ); ?></li>
                    <li><?php esc_html_e( 'Theme admin panel: set API key, tweak persona, done', 'vagra-showcase' ); ?></li>
                </ul>
            </div>

            <!-- Right: Chat demo -->
            <div class="chat-demo" data-reveal>
                <div class="chat-tabs">
                    <button class="chat-tab active" data-chat="meridian"><?php esc_html_e( 'Hotel', 'vagra-showcase' ); ?></button>
                    <button class="chat-tab" data-chat="legal"><?php esc_html_e( 'Legal', 'vagra-showcase' ); ?></button>
                    <button class="chat-tab" data-chat="msp"><?php esc_html_e( 'MSP', 'vagra-showcase' ); ?></button>
                    <button class="chat-tab" data-chat="nslookup"><?php esc_html_e( 'DNS', 'vagra-showcase' ); ?></button>
                </div>

                <!-- Meridian panel -->
                <div class="chat-panel active" id="chat-meridian">
                    <div class="chat-header">
                        <div class="chat-avatar" style="background:#d4af37"><?php echo esc_html( 'M' ); ?></div>
                        <div>
                            <div class="chat-persona"><?php esc_html_e( 'Hotel Concierge', 'vagra-showcase' ); ?></div>
                            <div class="chat-status"><?php esc_html_e( 'Online', 'vagra-showcase' ); ?></div>
                        </div>
                    </div>
                    <div class="chat-body">
                        <div class="msg ai"><?php esc_html_e( 'Welcome to The Meridian. How can I help you plan your stay?', 'vagra-showcase' ); ?></div>
                        <div class="msg user"><?php esc_html_e( 'King room with a view for this weekend?', 'vagra-showcase' ); ?></div>
                        <div class="msg ai"><?php esc_html_e( 'I have two options for Friday-Sunday: a Deluxe King with city view on the 12th floor ($289/night) and a Premium King with garden view on the 8th ($249/night). Both include breakfast. Shall I reserve one?', 'vagra-showcase' ); ?></div>
                    </div>
                    <div class="chat-input">
                        <input type="text" placeholder="<?php esc_attr_e( 'Ask the concierge...', 'vagra-showcase' ); ?>" disabled>
                        <button type="button" aria-label="<?php esc_attr_e( 'Send', 'vagra-showcase' ); ?>">
                            <?php echo vagra_icon( 'send', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        </button>
                    </div>
                </div>

                <!-- Legal panel -->
                <div class="chat-panel" id="chat-legal">
                    <div class="chat-header">
                        <div class="chat-avatar" style="background:#C9A84C"><?php echo esc_html( 'L' ); ?></div>
                        <div>
                            <div class="chat-persona"><?php esc_html_e( 'Intake Assistant', 'vagra-showcase' ); ?></div>
                            <div class="chat-status"><?php esc_html_e( 'Online', 'vagra-showcase' ); ?></div>
                        </div>
                    </div>
                    <div class="chat-body">
                        <div class="msg ai"><?php esc_html_e( 'Welcome to Morrison & Partners. I can help you understand if we handle your type of case. What happened?', 'vagra-showcase' ); ?></div>
                        <div class="msg user"><?php esc_html_e( 'I was rear-ended in a parking lot last week.', 'vagra-showcase' ); ?></div>
                        <div class="msg ai"><?php esc_html_e( 'Personal injury from auto accidents is one of our core practice areas. Were you injured? I can help you schedule a free consultation with one of our attorneys.', 'vagra-showcase' ); ?></div>
                    </div>
                    <div class="chat-input">
                        <input type="text" placeholder="<?php esc_attr_e( 'Describe your situation...', 'vagra-showcase' ); ?>" disabled>
                        <button type="button" aria-label="<?php esc_attr_e( 'Send', 'vagra-showcase' ); ?>">
                            <?php echo vagra_icon( 'send', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        </button>
                    </div>
                </div>

                <!-- MSP panel -->
                <div class="chat-panel" id="chat-msp">
                    <div class="chat-header">
                        <div class="chat-avatar" style="background:#3366FF"><?php echo esc_html( 'S' ); ?></div>
                        <div>
                            <div class="chat-persona"><?php esc_html_e( 'Security Advisor', 'vagra-showcase' ); ?></div>
                            <div class="chat-status"><?php esc_html_e( 'Online', 'vagra-showcase' ); ?></div>
                        </div>
                    </div>
                    <div class="chat-body">
                        <div class="msg ai"><?php esc_html_e( "Hi -- I'm the ShieldNet security advisor. Ask me anything about managed security, compliance, or threat detection.", 'vagra-showcase' ); ?></div>
                        <div class="msg user"><?php esc_html_e( "What's DMARC and do I need it?", 'vagra-showcase' ); ?></div>
                        <div class="msg ai"><?php esc_html_e( 'DMARC tells receiving mail servers how to handle messages that fail SPF or DKIM checks. Short answer: yes, you need it. It prevents domain spoofing and improves deliverability. Want me to walk you through setup?', 'vagra-showcase' ); ?></div>
                    </div>
                    <div class="chat-input">
                        <input type="text" placeholder="<?php esc_attr_e( 'Ask about security...', 'vagra-showcase' ); ?>" disabled>
                        <button type="button" aria-label="<?php esc_attr_e( 'Send', 'vagra-showcase' ); ?>">
                            <?php echo vagra_icon( 'send', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        </button>
                    </div>
                </div>

                <!-- NSLookup panel -->
                <div class="chat-panel" id="chat-nslookup">
                    <div class="chat-header">
                        <div class="chat-avatar" style="background:#4F46E5"><?php echo esc_html( 'D' ); ?></div>
                        <div>
                            <div class="chat-persona"><?php esc_html_e( 'DNS Expert', 'vagra-showcase' ); ?></div>
                            <div class="chat-status"><?php esc_html_e( 'Online', 'vagra-showcase' ); ?></div>
                        </div>
                    </div>
                    <div class="chat-body">
                        <div class="msg ai"><?php esc_html_e( "Hey -- what domain are you troubleshooting? I can help with DNS records, propagation, and configuration.", 'vagra-showcase' ); ?></div>
                        <div class="msg user"><?php esc_html_e( "Why won't my MX records propagate?", 'vagra-showcase' ); ?></div>
                        <div class="msg ai"><?php esc_html_e( "Three usual suspects: 1) TTL on the old record is still counting down -- check with dig +trace. 2) Your registrar's nameservers aren't authoritative. 3) A CNAME conflict on the apex. Which provider are you using?", 'vagra-showcase' ); ?></div>
                    </div>
                    <div class="chat-input">
                        <input type="text" placeholder="<?php esc_attr_e( 'Ask about DNS...', 'vagra-showcase' ); ?>" disabled>
                        <button type="button" aria-label="<?php esc_attr_e( 'Send', 'vagra-showcase' ); ?>">
                            <?php echo vagra_icon( 'send', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════════ STEPS ════════════════════════════════════════ -->
<section id="how">
    <div class="container">
        <div class="section-head section-head--center" data-reveal>
            <p class="eyebrow"><?php esc_html_e( 'How it works', 'vagra-showcase' ); ?></p>
            <h2><?php esc_html_e( 'Three steps to launch day.', 'vagra-showcase' ); ?></h2>
        </div>

        <div class="steps-grid">
            <div class="step" data-reveal>
                <div class="step-num">
                    <div class="step-icon"><?php echo vagra_icon( 'download', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                    <?php echo esc_html( '01' ); ?>
                </div>
                <h3><?php esc_html_e( 'Install', 'vagra-showcase' ); ?></h3>
                <p><?php esc_html_e( 'Upload the theme zip via Appearance > Themes or use WP-CLI. Activate and you are live with the default demo in under a minute.', 'vagra-showcase' ); ?></p>
            </div>
            <div class="step" data-reveal>
                <div class="step-num">
                    <div class="step-icon"><?php echo vagra_icon( 'spark', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                    <?php echo esc_html( '02' ); ?>
                </div>
                <h3><?php esc_html_e( 'Import', 'vagra-showcase' ); ?></h3>
                <p><?php esc_html_e( 'One-click demo import brings in pages, posts, menus, and widgets. Everything is pre-wired for your industry niche.', 'vagra-showcase' ); ?></p>
            </div>
            <div class="step" data-reveal>
                <div class="step-num">
                    <div class="step-icon"><?php echo vagra_icon( 'key', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                    <?php echo esc_html( '03' ); ?>
                </div>
                <h3><?php esc_html_e( 'Wire AI', 'vagra-showcase' ); ?></h3>
                <p><?php esc_html_e( 'Paste your OpenAI-compatible API key in the theme settings. The concierge persona is already trained for your niche.', 'vagra-showcase' ); ?></p>
            </div>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════════ STATS ════════════════════════════════════════ -->
<section>
    <div class="container">
        <div class="stats-bar" data-reveal>
            <div class="stat">
                <div class="stat-value"><?php echo esc_html( '90+' ); ?></div>
                <div class="stat-label"><?php esc_html_e( 'PageSpeed score', 'vagra-showcase' ); ?></div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo esc_html( '0' ); ?></div>
                <div class="stat-label"><?php esc_html_e( 'Theme Check errors', 'vagra-showcase' ); ?></div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo esc_html( 'GPL-2.0' ); ?></div>
                <div class="stat-label"><?php esc_html_e( 'License', 'vagra-showcase' ); ?></div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo esc_html( 'EN·AM·RU' ); ?></div>
                <div class="stat-label"><?php esc_html_e( 'i18n support', 'vagra-showcase' ); ?></div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo esc_html( 'WP 6.9+' ); ?></div>
                <div class="stat-label"><?php esc_html_e( 'Compatible', 'vagra-showcase' ); ?></div>
            </div>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════════ TESTIMONIALS ════════════════════════════════════════ -->
<section id="customers">
    <div class="container">
        <div class="section-head section-head--center" data-reveal>
            <p class="eyebrow"><?php esc_html_e( 'What people say', 'vagra-showcase' ); ?></p>
            <h2><?php esc_html_e( 'Built for real businesses.', 'vagra-showcase' ); ?></h2>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial" data-reveal>
                <blockquote><?php esc_html_e( 'We switched from a generic starter theme to Vagra MSP. The security-focused copy and AI advisor cut our lead response time in half. Clients actually trust the site now.', 'vagra-showcase' ); ?></blockquote>
                <div class="testimonial-author">
                    <div class="testimonial-avatar"><?php echo esc_html( 'AK' ); ?></div>
                    <div>
                        <div class="testimonial-name"><?php echo esc_html( 'Armen K.' ); ?></div>
                        <div class="testimonial-role"><?php esc_html_e( 'CEO, ShieldNet IT', 'vagra-showcase' ); ?></div>
                    </div>
                </div>
            </div>
            <div class="testimonial" data-reveal>
                <blockquote><?php esc_html_e( 'The Legal theme intake assistant is genuinely useful. It asks the right questions before the prospect even reaches us. Feels like having a junior paralegal on the website 24/7.', 'vagra-showcase' ); ?></blockquote>
                <div class="testimonial-author">
                    <div class="testimonial-avatar"><?php echo esc_html( 'SM' ); ?></div>
                    <div>
                        <div class="testimonial-name"><?php echo esc_html( 'Sarah M.' ); ?></div>
                        <div class="testimonial-role"><?php esc_html_e( 'Partner, Morrison & Partners', 'vagra-showcase' ); ?></div>
                    </div>
                </div>
            </div>
            <div class="testimonial" data-reveal>
                <blockquote><?php esc_html_e( 'We needed a hotel booking site that looked premium, not a template. Meridian delivered exactly that. The concierge AI handles room questions so our front desk can focus on guests.', 'vagra-showcase' ); ?></blockquote>
                <div class="testimonial-author">
                    <div class="testimonial-avatar"><?php echo esc_html( 'DH' ); ?></div>
                    <div>
                        <div class="testimonial-name"><?php echo esc_html( 'David H.' ); ?></div>
                        <div class="testimonial-role"><?php esc_html_e( 'GM, The Meridian Hotel', 'vagra-showcase' ); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════════ PRICING ════════════════════════════════════════ -->
<section id="pricing">
    <div class="container">
        <div class="section-head section-head--center" data-reveal>
            <p class="eyebrow"><?php esc_html_e( 'Pricing', 'vagra-showcase' ); ?></p>
            <h2><?php esc_html_e( 'Start free. Scale when ready.', 'vagra-showcase' ); ?></h2>
        </div>

        <div class="pricing-grid">
            <!-- Free -->
            <div class="price-card" data-reveal>
                <h3><?php esc_html_e( 'Free', 'vagra-showcase' ); ?></h3>
                <p class="price-desc"><?php esc_html_e( 'For personal projects and evaluation.', 'vagra-showcase' ); ?></p>
                <div class="price-amount">
                    <span class="currency"><?php echo esc_html( '$' ); ?></span>
                    <span class="value"><?php echo esc_html( '0' ); ?></span>
                    <span class="period"><?php esc_html_e( '/forever', 'vagra-showcase' ); ?></span>
                </div>
                <ul class="price-features">
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( '1 theme, 1 site', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'Demo content import', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'AI concierge (BYO key)', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'Community support', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'GPL-2.0 license', 'vagra-showcase' ); ?></li>
                </ul>
                <a href="#" class="btn btn-ghost"><?php esc_html_e( 'Download free', 'vagra-showcase' ); ?></a>
            </div>

            <!-- Pro (featured) -->
            <div class="price-card featured" data-reveal>
                <span class="price-badge"><?php esc_html_e( 'Most popular', 'vagra-showcase' ); ?></span>
                <h3><?php esc_html_e( 'Pro', 'vagra-showcase' ); ?></h3>
                <p class="price-desc"><?php esc_html_e( 'For businesses that need more.', 'vagra-showcase' ); ?></p>
                <div class="price-amount">
                    <span class="currency"><?php echo esc_html( '$' ); ?></span>
                    <span class="value"><?php echo esc_html( '49' ); ?></span>
                    <span class="period"><?php esc_html_e( '/year', 'vagra-showcase' ); ?></span>
                </div>
                <ul class="price-features">
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'All 8 themes, 3 sites', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'Priority support', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'Advanced AI persona tuning', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'Custom color schemes', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( '1 year of updates', 'vagra-showcase' ); ?></li>
                </ul>
                <a href="#" class="btn btn-primary"><?php esc_html_e( 'Get Pro', 'vagra-showcase' ); ?></a>
            </div>

            <!-- Agency -->
            <div class="price-card" data-reveal>
                <h3><?php esc_html_e( 'Agency', 'vagra-showcase' ); ?></h3>
                <p class="price-desc"><?php esc_html_e( 'For teams building for clients.', 'vagra-showcase' ); ?></p>
                <div class="price-amount">
                    <span class="currency"><?php echo esc_html( '$' ); ?></span>
                    <span class="value"><?php echo esc_html( '199' ); ?></span>
                    <span class="period"><?php esc_html_e( '/year', 'vagra-showcase' ); ?></span>
                </div>
                <ul class="price-features">
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'All 8 themes, unlimited sites', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'White-label option', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'Dedicated Slack channel', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'Early access to new themes', 'vagra-showcase' ); ?></li>
                    <li><?php echo vagra_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?> <?php esc_html_e( 'Lifetime updates', 'vagra-showcase' ); ?></li>
                </ul>
                <a href="#" class="btn btn-ghost"><?php esc_html_e( 'Contact sales', 'vagra-showcase' ); ?></a>
            </div>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════════ FAQ ════════════════════════════════════════ -->
<section id="faq">
    <div class="container">
        <div class="section-head section-head--center" data-reveal>
            <p class="eyebrow"><?php esc_html_e( 'FAQ', 'vagra-showcase' ); ?></p>
            <h2><?php esc_html_e( 'Common questions.', 'vagra-showcase' ); ?></h2>
        </div>

        <div class="faq-list" data-reveal>
            <details>
                <summary><?php esc_html_e( 'Do I need coding skills to use these themes?', 'vagra-showcase' ); ?></summary>
                <div class="faq-body">
                    <?php esc_html_e( 'No. Each theme comes with one-click demo import that sets up pages, menus, and content. You just replace the demo text with your own. The AI concierge works out of the box once you add an API key.', 'vagra-showcase' ); ?>
                </div>
            </details>
            <details>
                <summary><?php esc_html_e( 'Which AI providers are supported?', 'vagra-showcase' ); ?></summary>
                <div class="faq-body">
                    <?php esc_html_e( 'Any OpenAI-compatible API endpoint works: OpenAI, Anthropic (via proxy), Azure OpenAI, Groq, Ollama, and more. You set the base URL and key in the theme settings panel.', 'vagra-showcase' ); ?>
                </div>
            </details>
            <details>
                <summary><?php esc_html_e( 'Are the themes really free?', 'vagra-showcase' ); ?></summary>
                <div class="faq-body">
                    <?php esc_html_e( 'Yes. Every theme is GPL-2.0-or-later. The free tier gives you one theme for one site with full functionality. Pro and Agency tiers add multi-site support, priority help, and persona customization.', 'vagra-showcase' ); ?>
                </div>
            </details>
            <details>
                <summary><?php esc_html_e( 'Can I use these on WordPress multisite?', 'vagra-showcase' ); ?></summary>
                <div class="faq-body">
                    <?php esc_html_e( 'Absolutely. All eight themes are tested on WordPress Multisite with subdomain configuration. In fact, vagra.ai itself runs on a multisite installation with each theme on its own subdomain.', 'vagra-showcase' ); ?>
                </div>
            </details>
            <details>
                <summary><?php esc_html_e( 'What about page speed and SEO?', 'vagra-showcase' ); ?></summary>
                <div class="faq-body">
                    <?php esc_html_e( 'Every theme scores 90+ on Google PageSpeed Insights. We use semantic HTML, minimal dependencies, no jQuery, and inline critical CSS. Structured data (JSON-LD) is included for relevant content types.', 'vagra-showcase' ); ?>
                </div>
            </details>
            <details>
                <summary><?php esc_html_e( 'How do I get support?', 'vagra-showcase' ); ?></summary>
                <div class="faq-body">
                    <?php esc_html_e( 'Free users get community support via GitHub Discussions. Pro users get email support with 24-hour response. Agency clients get a dedicated Slack channel with same-day response.', 'vagra-showcase' ); ?>
                </div>
            </details>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════════ FINAL CTA ════════════════════════════════════════ -->
<section class="final-cta">
    <div class="container" data-reveal>
        <h2><?php esc_html_e( 'Your industry deserves more than a starter template.', 'vagra-showcase' ); ?></h2>
        <p><?php esc_html_e( 'Pick a niche. Install a theme. Let the AI concierge handle the rest.', 'vagra-showcase' ); ?></p>
        <div class="final-cta-actions">
            <a href="#themes" class="btn btn-primary">
                <?php esc_html_e( 'Get started — free', 'vagra-showcase' ); ?>
                <?php echo vagra_icon( 'arrow', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
            </a>
            <a href="https://github.com/vagra-ai" class="btn btn-ghost" target="_blank" rel="noopener">
                <?php echo vagra_icon( 'github', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                <?php esc_html_e( 'View on GitHub', 'vagra-showcase' ); ?>
            </a>
        </div>
    </div>
</section>

</main>

<?php
get_footer();
