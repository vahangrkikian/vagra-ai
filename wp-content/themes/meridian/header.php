<?php
/**
 * Theme header — The Meridian luxury hotel navigation.
 *
 * @package Meridian
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="nav <?php echo is_front_page() ? 'nav--transparent' : 'nav--solid'; ?>" id="meridian-nav" role="banner">
    <div class="nav__inner">
        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo <?php echo is_front_page() ? '' : 'logo--dark'; ?>">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
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

        <!-- Primary navigation -->
        <nav class="nav__links" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'meridian' ); ?>">
            <?php
            if ( has_nav_menu( 'primary' ) ) :
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ) );
            else :
                $fallback_links = array(
                    array( 'url' => home_url( '/' ),         'label' => __( 'Home', 'meridian' ) ),
                    array( 'url' => get_post_type_archive_link( 'meridian_room' ),   'label' => __( 'Rooms', 'meridian' ) ),
                    array( 'url' => home_url( '/about/' ),   'label' => __( 'About', 'meridian' ) ),
                    array( 'url' => home_url( '/gallery/' ), 'label' => __( 'Gallery', 'meridian' ) ),
                    array( 'url' => home_url( '/location/' ),'label' => __( 'Location', 'meridian' ) ),
                );
                foreach ( $fallback_links as $link ) :
                    printf( '<a href="%s">%s</a>', esc_url( $link['url'] ), esc_html( $link['label'] ) );
                endforeach;
            endif;
            ?>
        </nav>

        <!-- CTA area -->
        <div class="nav__cta">
            <a href="tel:+12125551234" class="nav__phone">
                <?php echo meridian_icon( 'phone', 16 ); ?>
                <span><?php esc_html_e( '+1 (212) 555-1234', 'meridian' ); ?></span>
            </a>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'meridian_room' ) ); ?>" class="btn btn--gold">
                <?php esc_html_e( 'Book Now', 'meridian' ); ?>
            </a>
            <button class="nav__burger" id="meridian-burger" aria-label="<?php esc_attr_e( 'Toggle menu', 'meridian' ); ?>">
                <?php echo meridian_icon( 'menu', 24 ); ?>
            </button>
        </div>
    </div>

    <!-- Mobile navigation drawer -->
    <div class="nav__mobile" id="meridian-mobile-nav">
        <?php
        if ( has_nav_menu( 'primary' ) ) :
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '<div class="nav__mobile-links">%3$s</div>',
                'fallback_cb'    => false,
                'depth'          => 1,
            ) );
        else :
            $mobile_links = array(
                array( 'url' => home_url( '/' ),         'label' => __( 'Home', 'meridian' ) ),
                array( 'url' => get_post_type_archive_link( 'meridian_room' ),   'label' => __( 'Rooms', 'meridian' ) ),
                array( 'url' => home_url( '/about/' ),   'label' => __( 'About', 'meridian' ) ),
                array( 'url' => home_url( '/gallery/' ), 'label' => __( 'Gallery', 'meridian' ) ),
                array( 'url' => home_url( '/location/' ),'label' => __( 'Location', 'meridian' ) ),
            );
            foreach ( $mobile_links as $link ) :
                printf( '<a href="%s">%s</a>', esc_url( $link['url'] ), esc_html( $link['label'] ) );
            endforeach;
        endif;
        ?>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'meridian_room' ) ); ?>" class="btn btn--gold btn--block">
            <?php esc_html_e( 'Book Now', 'meridian' ); ?>
        </a>
    </div>
</header>
