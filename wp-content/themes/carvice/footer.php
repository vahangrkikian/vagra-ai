<?php
/**
 * Theme footer — matches Carmaster prototype layout.
 *
 * @package Carvice
 */
?>

<footer class="carvice-footer">
    <!-- Row 1: Countries + Language -->
    <div class="carvice-footer__row carvice-footer__row--countries">
        <div class="carvice-container carvice-footer__row-inner">
            <div class="carvice-footer__countries">
                <span class="carvice-footer__country muted"><?php esc_html_e( 'Russia', 'carvice' ); ?></span>
                <span class="carvice-footer__country active"><?php esc_html_e( 'Armenia', 'carvice' ); ?></span>
                <span class="carvice-footer__country muted"><?php esc_html_e( 'Kazakhstan', 'carvice' ); ?></span>
            </div>
            <div class="carvice-footer__lang">
                <span class="carvice-footer__lang-label"><?php esc_html_e( 'Language:', 'carvice' ); ?></span>
                <button class="carvice-footer__lang-btn">
                    Armenian
                    <svg class="carvice-icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Row 2: Footer menu -->
    <div class="carvice-footer__row carvice-footer__row--menu">
        <div class="carvice-container">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => 'carvice-footer__menu',
                'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                'fallback_cb'    => 'carvice_footer_menu_fallback',
                'depth'          => 1,
            ) );
            ?>
        </div>
    </div>

    <!-- Row 3: Service categories -->
    <div class="carvice-footer__row">
        <div class="carvice-container">
            <div class="carvice-footer__cats">
                <?php
                $footer_cats = get_terms( array( 'taxonomy' => 'carvice_service_cat', 'hide_empty' => false, 'number' => 6 ) );
                if ( ! empty( $footer_cats ) && ! is_wp_error( $footer_cats ) ) :
                    foreach ( $footer_cats as $cat ) : ?>
                        <a href="<?php echo esc_url( home_url( '/search/?category=' . $cat->slug ) ); ?>" class="carvice-footer__cat-link"><?php echo esc_html( $cat->name ); ?></a>
                    <?php endforeach;
                else :
                    $defaults = array( 'Car Body', 'Engine', 'Electrical', 'Chassis', 'Wheels / Tires', 'Interior' );
                    foreach ( $defaults as $name ) : ?>
                        <span class="carvice-footer__cat-link"><?php echo esc_html( $name ); ?></span>
                    <?php endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>

    <!-- Row 3: Service types -->
    <div class="carvice-footer__row">
        <div class="carvice-container">
            <div class="carvice-footer__types">
                <?php
                $footer_types = get_terms( array( 'taxonomy' => 'carvice_service_type', 'hide_empty' => false ) );
                if ( ! empty( $footer_types ) && ! is_wp_error( $footer_types ) ) :
                    foreach ( $footer_types as $type ) : ?>
                        <a href="<?php echo esc_url( home_url( '/search/?service=' . $type->slug ) ); ?>" class="carvice-footer__type-link"><?php echo esc_html( $type->name ); ?></a>
                    <?php endforeach;
                else :
                    $default_types = array( 'Air Condition', 'Oil Change', 'AKP', 'Detailing', 'Gas', 'Window Tint', 'Car Wrap', 'Audio System', 'Transmission', 'Auto Tuning', 'Engine Tuning' );
                    foreach ( $default_types as $name ) : ?>
                        <span class="carvice-footer__type-link"><?php echo esc_html( $name ); ?></span>
                    <?php endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>

    <!-- Row 4: Logo + Powered by -->
    <div class="carvice-footer__row carvice-footer__row--bottom">
        <div class="carvice-container carvice-footer__row-inner">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="carvice-logo carvice-logo--footer">
                <span class="carvice-logo__text carvice-logo__text--sm">car<span class="carvice-logo__accent">v</span>ice</span>
                <span class="carvice-logo__tagline">all services<br/>for your car</span>
            </a>
            <span class="carvice-footer__powered">
                <?php esc_html_e( 'Powered by', 'carvice' ); ?> <strong>bee inc.</strong>
            </span>
        </div>
    </div>
</footer>

<?php get_template_part( 'template-parts/ai-chat' ); ?>
<?php wp_footer(); ?>
</body>
</html>
