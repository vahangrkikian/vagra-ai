<?php
/**
 * Footer template
 *
 * @package vagra-showcase
 */
?>

<footer class="site-footer">
    <div class="container">
        <div class="foot-grid">
            <!-- Brand -->
            <div class="foot-brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand">
                    <span class="brand-mark">V</span>
                    <?php echo esc_html( 'vagra' ); ?><span class="brand-dot"><?php echo esc_html( '.ai' ); ?></span>
                </a>
                <p><?php esc_html_e( 'WordPress themes that know your industry. Built by Ethiuni — bridges, not cathedrals.', 'vagra-showcase' ); ?></p>
                <div class="foot-socials">
                    <a href="https://github.com/vagra-ai" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'GitHub', 'vagra-showcase' ); ?>">
                        <?php echo vagra_icon( 'github', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                    </a>
                    <a href="#" aria-label="<?php esc_attr_e( 'X (Twitter)', 'vagra-showcase' ); ?>">
                        <?php echo vagra_icon( 'x', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                    </a>
                    <a href="#" aria-label="<?php esc_attr_e( 'LinkedIn', 'vagra-showcase' ); ?>">
                        <?php echo vagra_icon( 'linkedin', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                    </a>
                </div>
            </div>

            <!-- Themes -->
            <div class="foot-col">
                <h4><?php esc_html_e( 'Themes', 'vagra-showcase' ); ?></h4>
                <ul>
                    <li><a href="<?php echo esc_url( 'http://msp.vagraai.local/' ); ?>"><?php esc_html_e( 'Vagra MSP', 'vagra-showcase' ); ?></a></li>
                    <li><a href="<?php echo esc_url( 'http://legal.vagraai.local/' ); ?>"><?php esc_html_e( 'Vagra Legal', 'vagra-showcase' ); ?></a></li>
                    <li><a href="<?php echo esc_url( 'http://nslookup.vagraai.local/' ); ?>"><?php esc_html_e( 'Vagra NSLookup', 'vagra-showcase' ); ?></a></li>
                    <li><a href="<?php echo esc_url( 'http://carvice.vagraai.local/' ); ?>"><?php esc_html_e( 'Carvice', 'vagra-showcase' ); ?></a></li>
                    <li><a href="<?php echo esc_url( 'http://driveease.vagraai.local/' ); ?>"><?php esc_html_e( 'DriveEase', 'vagra-showcase' ); ?></a></li>
                    <li><a href="<?php echo esc_url( 'http://tourvice.vagraai.local/' ); ?>"><?php esc_html_e( 'TourVice', 'vagra-showcase' ); ?></a></li>
                    <li><a href="<?php echo esc_url( 'http://meridian.vagraai.local/' ); ?>"><?php esc_html_e( 'Meridian', 'vagra-showcase' ); ?></a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div class="foot-col">
                <h4><?php esc_html_e( 'Resources', 'vagra-showcase' ); ?></h4>
                <ul>
                    <li><a href="#"><?php esc_html_e( 'Documentation', 'vagra-showcase' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Changelog', 'vagra-showcase' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Support', 'vagra-showcase' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Status', 'vagra-showcase' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Blog', 'vagra-showcase' ); ?></a></li>
                </ul>
            </div>

            <!-- Company -->
            <div class="foot-col">
                <h4><?php esc_html_e( 'Company', 'vagra-showcase' ); ?></h4>
                <ul>
                    <li><a href="#"><?php esc_html_e( 'About Ethiuni', 'vagra-showcase' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Contact', 'vagra-showcase' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Press kit', 'vagra-showcase' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Privacy', 'vagra-showcase' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Terms', 'vagra-showcase' ); ?></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="foot-bottom">
        <div class="container">
            <div class="foot-bottom-inner">
                <span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php esc_html_e( 'Vagra.ai &middot; All themes GPL-2.0-or-later', 'vagra-showcase' ); ?></span>
                <div class="foot-domains">
                    <a href="http://nslookup.vagraai.local/" target="_blank" rel="noopener"><?php echo esc_html( 'nslookup.am' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( 'vagra.ai' ); ?></a>
                    <a href="http://meridian.vagraai.local/" target="_blank" rel="noopener"><?php echo esc_html( 'meridian.hotel' ); ?></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
