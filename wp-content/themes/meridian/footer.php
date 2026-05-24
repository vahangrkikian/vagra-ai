<?php
/**
 * Theme footer — The Meridian luxury hotel.
 *
 * @package Meridian
 */
?>

<footer class="footer" role="contentinfo">
    <div class="container">
        <!-- Top 5-column grid -->
        <div class="footer__top">
            <!-- Brand column -->
            <div class="footer__brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo logo--light">
                    <svg width="28" height="28" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="16" cy="16" r="14" />
                        <path d="M16 2v28M2 16h28" opacity="0.3" />
                        <path d="M16 5l2.5 5.5L24 12l-4 4 1 6-5-3-5 3 1-6-4-4 5.5-1.5Z" fill="currentColor" stroke="none" opacity="0.15" />
                        <path d="M16 2a18 18 0 0 1 4.5 14A18 18 0 0 1 16 30" />
                        <path d="M16 2a18 18 0 0 0-4.5 14A18 18 0 0 0 16 30" />
                    </svg>
                    <span class="logo__text">
                        <span class="logo__word"><?php bloginfo( 'name' ); ?></span>
                        <span class="logo__sub"><?php esc_html_e( 'New York', 'meridian' ); ?></span>
                    </span>
                </a>
                <p class="footer__about">
                    <?php esc_html_e( 'A 5-star urban retreat in the heart of Midtown Manhattan, where luxury meets quiet sophistication.', 'meridian' ); ?>
                </p>
                <div class="footer__social">
                    <a href="#" aria-label="<?php esc_attr_e( 'Instagram', 'meridian' ); ?>">
                        <?php echo meridian_icon( 'instagram', 18 ); ?>
                    </a>
                    <a href="#" aria-label="<?php esc_attr_e( 'Facebook', 'meridian' ); ?>">
                        <?php echo meridian_icon( 'facebook', 18 ); ?>
                    </a>
                    <a href="#" aria-label="<?php esc_attr_e( 'X', 'meridian' ); ?>">
                        <?php echo meridian_icon( 'x', 18 ); ?>
                    </a>
                </div>
            </div>

            <!-- Stay column -->
            <div class="footer__col">
                <h4><?php esc_html_e( 'Stay', 'meridian' ); ?></h4>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'meridian_room' ) ); ?>"><?php esc_html_e( 'Rooms & Suites', 'meridian' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/long-stays/' ) ); ?>"><?php esc_html_e( 'Long Stays', 'meridian' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/offers/' ) ); ?>"><?php esc_html_e( 'Offers', 'meridian' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/gift-cards/' ) ); ?>"><?php esc_html_e( 'Gift Cards', 'meridian' ); ?></a>
            </div>

            <!-- The Hotel column -->
            <div class="footer__col">
                <h4><?php esc_html_e( 'The Hotel', 'meridian' ); ?></h4>
                <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'meridian' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>"><?php esc_html_e( 'Gallery', 'meridian' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/location/' ) ); ?>"><?php esc_html_e( 'Location', 'meridian' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/careers/' ) ); ?>"><?php esc_html_e( 'Careers', 'meridian' ); ?></a>
            </div>

            <!-- Contact column -->
            <div class="footer__col">
                <h4><?php esc_html_e( 'Contact', 'meridian' ); ?></h4>
                <div>
                    <a href="tel:+12125551234"><?php esc_html_e( '+1 (212) 555-1234', 'meridian' ); ?></a>
                </div>
                <div>
                    <a href="mailto:stay@themeridian.example"><?php esc_html_e( 'stay@themeridian.example', 'meridian' ); ?></a>
                </div>
                <div>
                    <?php esc_html_e( '401 West 42nd Street', 'meridian' ); ?><br />
                    <?php esc_html_e( 'New York, NY 10036', 'meridian' ); ?>
                </div>
            </div>

            <!-- Newsletter column -->
            <div class="footer__news">
                <h4><?php esc_html_e( 'Newsletter', 'meridian' ); ?></h4>
                <p><?php esc_html_e( 'Exclusive rates, seasonal packages, and insider guides — delivered monthly.', 'meridian' ); ?></p>
                <form class="footer__news-row" action="#" method="post">
                    <input
                        type="email"
                        name="email"
                        placeholder="<?php esc_attr_e( 'Your email', 'meridian' ); ?>"
                        required
                    />
                    <button type="submit" class="btn btn--gold">
                        <?php echo meridian_icon( 'arrow-right', 18 ); ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer__bottom">
            <span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'meridian' ); ?></span>
            <div class="footer__legal">
                <a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>"><?php esc_html_e( 'Privacy', 'meridian' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'meridian' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/accessibility/' ) ); ?>"><?php esc_html_e( 'Accessibility', 'meridian' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/modern-slavery/' ) ); ?>"><?php esc_html_e( 'Modern Slavery', 'meridian' ); ?></a>
            </div>
        </div>
    </div>
</footer>

<?php get_template_part( 'template-parts/ai-chat' ); ?>
<?php wp_footer(); ?>
</body>
</html>
