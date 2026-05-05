</main><!-- .vagra-main -->

<footer class="vagra-footer" role="contentinfo">
    <div class="vagra-container">
        <div class="vagra-footer__widgets">
            <div class="vagra-footer__col">
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                <?php endif; ?>
            </div>
            <div class="vagra-footer__col">
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                <?php endif; ?>
            </div>
            <div class="vagra-footer__col">
                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                <?php endif; ?>
            </div>
            <div class="vagra-footer__col">
                <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-4' ); ?>
                <?php endif; ?>
            </div>
        </div>

        <p class="vagra-footer__disclaimer">
            <?php esc_html_e( 'The information on this website is for general information purposes only. Nothing on this site should be taken as legal advice for any individual case or situation. This information is not intended to create, and receipt or viewing does not constitute, an attorney-client relationship.', 'vagra-legal' ); ?>
        </p>

        <div class="vagra-footer__bottom">
            <nav class="vagra-footer__nav" aria-label="<?php esc_attr_e( 'Footer Menu', 'vagra-legal' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'vagra-footer-nav',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ) );
                ?>
            </nav>

            <p class="vagra-footer__copy">
                &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'vagra-legal' ); ?>
            </p>
        </div>
    </div>
</footer>

<?php get_template_part( 'template-parts/ai-chat' ); ?>

<?php wp_footer(); ?>
</body>
</html>
