<?php
/**
 * Theme Preview Switcher
 *
 * Allows previewing any installed theme via ?preview_theme=theme-slug URL parameter.
 * Only works for logged-in administrators for security.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_filter( 'template', 'vagra_preview_theme_template' );
add_filter( 'stylesheet', 'vagra_preview_theme_stylesheet' );

function vagra_preview_theme_template( $template ) {
    $preview = vagra_get_preview_theme();
    if ( $preview ) {
        return $preview;
    }
    return $template;
}

function vagra_preview_theme_stylesheet( $stylesheet ) {
    $preview = vagra_get_preview_theme();
    if ( $preview ) {
        return $preview;
    }
    return $stylesheet;
}

function vagra_get_preview_theme() {
    if ( ! isset( $_GET['preview_theme'] ) ) {
        return false;
    }

    // Only allow logged-in administrators
    if ( ! current_user_can( 'manage_options' ) ) {
        return false;
    }

    $theme_slug = sanitize_file_name( $_GET['preview_theme'] );

    // Only allow known theme slugs for security
    $allowed = array( 'vagra-msp', 'vagra-legal', 'vagra-nslookup', 'carvice' );
    if ( ! in_array( $theme_slug, $allowed, true ) ) {
        return false;
    }

    // Verify theme exists
    $theme = wp_get_theme( $theme_slug );
    if ( ! $theme->exists() ) {
        return false;
    }

    return $theme_slug;
}

// Allow iframe embedding from same origin for the demo page
add_action( 'send_headers', function() {
    if ( isset( $_GET['preview_theme'] ) ) {
        header( 'X-Frame-Options: SAMEORIGIN' );
    }
});

// Admin page: Theme Demo Preview
add_action( 'admin_menu', function() {
    add_theme_page(
        'Theme Demo Preview',
        'Demo Preview',
        'manage_options',
        'vagra-demo-preview',
        'vagra_demo_preview_page'
    );
});

function vagra_demo_preview_page() {
    $site_url = home_url( '/' );
    ?>
    <div class="wrap">
        <h1>Theme Demo Preview</h1>
        <p>Preview both Vagra themes without activating/deactivating. Click a tab or use the direct links below.</p>

        <h2 class="nav-tab-wrapper" id="vagra-preview-tabs">
            <a href="#" class="nav-tab nav-tab-active" data-theme="vagra-msp">Vagra MSP</a>
            <a href="#" class="nav-tab" data-theme="vagra-legal">Vagra Legal</a>
            <a href="#" class="nav-tab" data-theme="vagra-nslookup">Vagra NSLookup</a>
            <a href="#" class="nav-tab" data-theme="carvice">Carvice</a>
            <a href="#" class="nav-tab" data-theme="side-by-side">Side by Side</a>
        </h2>

        <div id="vagra-preview-single" style="margin-top:15px;">
            <iframe id="vagra-preview-frame" src="<?php echo esc_url( $site_url . '?preview_theme=vagra-msp' ); ?>" style="width:100%;height:80vh;border:1px solid #ccc;border-radius:4px;"></iframe>
        </div>

        <div id="vagra-preview-sidebyside" style="margin-top:15px;display:none;">
            <div style="display:flex;gap:10px;">
                <div style="flex:1;">
                    <h3 style="margin:0 0 5px;">Vagra MSP</h3>
                    <iframe src="<?php echo esc_url( $site_url . '?preview_theme=vagra-msp' ); ?>" style="width:100%;height:75vh;border:1px solid #ccc;border-radius:4px;"></iframe>
                </div>
                <div style="flex:1;">
                    <h3 style="margin:0 0 5px;">Vagra Legal</h3>
                    <iframe src="<?php echo esc_url( $site_url . '?preview_theme=vagra-legal' ); ?>" style="width:100%;height:75vh;border:1px solid #ccc;border-radius:4px;"></iframe>
                </div>
                <div style="flex:1;">
                    <h3 style="margin:0 0 5px;">Vagra NSLookup</h3>
                    <iframe src="<?php echo esc_url( $site_url . '?preview_theme=vagra-nslookup' ); ?>" style="width:100%;height:75vh;border:1px solid #ccc;border-radius:4px;"></iframe>
                </div>
            </div>
        </div>

        <h3>Direct Preview Links</h3>
        <ul>
            <li><strong>Vagra MSP:</strong> <a href="<?php echo esc_url( $site_url . '?preview_theme=vagra-msp' ); ?>" target="_blank"><?php echo esc_html( $site_url . '?preview_theme=vagra-msp' ); ?></a></li>
            <li><strong>Vagra Legal:</strong> <a href="<?php echo esc_url( $site_url . '?preview_theme=vagra-legal' ); ?>" target="_blank"><?php echo esc_html( $site_url . '?preview_theme=vagra-legal' ); ?></a></li>
            <li><strong>Vagra NSLookup:</strong> <a href="<?php echo esc_url( $site_url . '?preview_theme=vagra-nslookup' ); ?>" target="_blank"><?php echo esc_html( $site_url . '?preview_theme=vagra-nslookup' ); ?></a></li>
            <li><strong>Carvice:</strong> <a href="<?php echo esc_url( $site_url . '?preview_theme=carvice' ); ?>" target="_blank"><?php echo esc_html( $site_url . '?preview_theme=carvice' ); ?></a></li>
        </ul>
        <p><em>Customizer previews (with live editing):</em></p>
        <ul>
            <li><a href="<?php echo admin_url( 'customize.php?theme=vagra-msp' ); ?>" target="_blank">Customize Vagra MSP</a></li>
            <li><a href="<?php echo admin_url( 'customize.php?theme=vagra-legal' ); ?>" target="_blank">Customize Vagra Legal</a></li>
            <li><a href="<?php echo admin_url( 'customize.php?theme=vagra-nslookup' ); ?>" target="_blank">Customize Vagra NSLookup</a></li>
            <li><a href="<?php echo admin_url( 'customize.php?theme=carvice' ); ?>" target="_blank">Customize Carvice</a></li>
        </ul>
    </div>
    <script>
    document.querySelectorAll('#vagra-preview-tabs .nav-tab').forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('#vagra-preview-tabs .nav-tab').forEach(function(t){ t.classList.remove('nav-tab-active'); });
            this.classList.add('nav-tab-active');
            var theme = this.dataset.theme;
            if (theme === 'side-by-side') {
                document.getElementById('vagra-preview-single').style.display = 'none';
                document.getElementById('vagra-preview-sidebyside').style.display = 'block';
            } else {
                document.getElementById('vagra-preview-single').style.display = 'block';
                document.getElementById('vagra-preview-sidebyside').style.display = 'none';
                document.getElementById('vagra-preview-frame').src = '<?php echo esc_js( $site_url ); ?>' + '?preview_theme=' + theme;
            }
        });
    });
    </script>
    <?php
}
