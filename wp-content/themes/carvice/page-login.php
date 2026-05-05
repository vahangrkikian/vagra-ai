<?php
/**
 * Template Name: Sign In
 *
 * @package Carvice
 */

get_header();
?>

<main id="primary" class="carvice-main">
    <div class="carvice-auth-page">
        <div class="carvice-auth-card">
            <h1 class="carvice-auth-card__title"><?php esc_html_e( 'Sign In', 'carvice' ); ?></h1>

            <form method="post" action="<?php echo esc_url( wp_login_url( home_url() ) ); ?>" class="carvice-auth-form">
                <div class="carvice-form-group">
                    <label for="carvice-login-email"><?php esc_html_e( 'Email or Phone', 'carvice' ); ?></label>
                    <input type="text" id="carvice-login-email" name="log" class="carvice-input" required />
                </div>

                <div class="carvice-form-group">
                    <label for="carvice-login-password"><?php esc_html_e( 'Password', 'carvice' ); ?></label>
                    <input type="password" id="carvice-login-password" name="pwd" class="carvice-input" required />
                </div>

                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="carvice-auth-form__forgot">
                    <?php esc_html_e( 'Forgot password?', 'carvice' ); ?>
                </a>

                <button type="submit" class="carvice-btn carvice-btn--primary carvice-btn--full">
                    <?php esc_html_e( 'Sign In', 'carvice' ); ?>
                </button>
            </form>

            <div class="carvice-auth-divider">
                <span><?php esc_html_e( 'Or sign in with', 'carvice' ); ?></span>
            </div>

            <div class="carvice-social-auth">
                <button class="carvice-social-btn carvice-social-btn--fb" disabled>Facebook</button>
                <button class="carvice-social-btn carvice-social-btn--vk" disabled>VK</button>
                <button class="carvice-social-btn carvice-social-btn--google" disabled>Google</button>
                <button class="carvice-social-btn carvice-social-btn--mailru" disabled>Mail.ru</button>
                <button class="carvice-social-btn carvice-social-btn--ok" disabled>OK</button>
            </div>

            <p class="carvice-auth-card__switch">
                <?php esc_html_e( "Don't have an account?", 'carvice' ); ?>
                <a href="<?php echo esc_url( home_url( '/register' ) ); ?>"><?php esc_html_e( 'Sign Up', 'carvice' ); ?></a>
            </p>
        </div>
    </div>
</main>

<?php
get_footer();
