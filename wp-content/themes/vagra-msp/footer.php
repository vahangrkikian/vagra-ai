<?php
/**
 * The footer template.
 *
 * Dark 4-column grid footer with brand, tools, company, and discover links.
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

?>

    <footer id="colophon" class="site-footer">
        <div class="site-container site-footer__grid">

            <!-- Brand Column -->
            <div class="site-footer__col site-footer__brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo site-logo--footer" rel="home">
                    <svg class="site-logo__icon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect width="32" height="32" rx="8" fill="var(--vagra-primary)"/>
                        <path d="M8 16L14 22L24 10" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="site-logo__text"><?php bloginfo( 'name' ); ?></span>
                </a>
                <p class="site-footer__desc">
                    <?php echo esc_html( get_bloginfo( 'description' ) ); ?>
                </p>
                <div class="site-footer__badges">
                    <?php
                    $record_types = array( 'A', 'AAAA', 'MX', 'CNAME', 'TXT', 'NS', 'SOA', 'SRV', 'CAA', 'PTR' );
                    foreach ( $record_types as $type ) :
                        ?>
                        <span class="badge"><?php echo esc_html( $type ); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Other Tools Column -->
            <div class="site-footer__col">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Other Tools', 'vagra-msp' ); ?></h4>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer-tools',
                        'menu_id'        => 'footer-tools-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => 'vagra_footer_tools_fallback',
                    )
                );
                ?>
            </div>

            <!-- Company Column -->
            <div class="site-footer__col">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Company', 'vagra-msp' ); ?></h4>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer-company',
                        'menu_id'        => 'footer-company-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => 'vagra_footer_company_fallback',
                    )
                );
                ?>
            </div>

            <!-- Discover Column -->
            <div class="site-footer__col">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Discover', 'vagra-msp' ); ?></h4>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer-discover',
                        'menu_id'        => 'footer-discover-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => 'vagra_footer_discover_fallback',
                    )
                );
                ?>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="site-footer__bottom">
            <div class="site-container site-footer__bottom-inner">
                <p class="site-footer__copyright">
                    &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
                    <?php esc_html_e( 'All rights reserved.', 'vagra-msp' ); ?>
                </p>
                <p class="site-footer__tagline">
                    <?php esc_html_e( 'Fast, free DNS tools for IT professionals.', 'vagra-msp' ); ?>
                </p>
            </div>
        </div>

        <?php get_template_part( 'template-parts/ai-chat' ); ?>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
