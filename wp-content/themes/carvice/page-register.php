<?php
/**
 * Template Name: Sign Up
 *
 * @package Carvice
 */

get_header();
?>

<main id="primary" class="carvice-main">
    <div class="carvice-auth-page">
        <div class="carvice-auth-card carvice-auth-card--wide">
            <h1 class="carvice-auth-card__title"><?php esc_html_e( 'Sign Up', 'carvice' ); ?></h1>

            <!-- Tab Navigation -->
            <div class="carvice-tabs">
                <button class="carvice-tab active" data-tab="user"><?php esc_html_e( 'User', 'carvice' ); ?></button>
                <button class="carvice-tab" data-tab="individual"><?php esc_html_e( 'Individual Specialist', 'carvice' ); ?></button>
                <button class="carvice-tab" data-tab="company"><?php esc_html_e( 'Company', 'carvice' ); ?></button>
                <button class="carvice-tab" data-tab="dealer"><?php esc_html_e( 'Official Dealer', 'carvice' ); ?></button>
            </div>

            <!-- Tab: User -->
            <div class="carvice-tab-panel active" id="tab-user">
                <form class="carvice-auth-form">
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'First Name', 'carvice' ); ?></label>
                            <input type="text" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Last Name', 'carvice' ); ?></label>
                            <input type="text" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Email', 'carvice' ); ?></label>
                        <input type="email" class="carvice-input" />
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Phone', 'carvice' ); ?></label>
                        <input type="tel" class="carvice-input" />
                    </div>
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Password', 'carvice' ); ?></label>
                            <input type="password" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Confirm Password', 'carvice' ); ?></label>
                            <input type="password" class="carvice-input" />
                        </div>
                    </div>
                    <button type="button" class="carvice-btn carvice-btn--primary carvice-btn--full"><?php esc_html_e( 'Sign Up', 'carvice' ); ?></button>
                </form>
            </div>

            <!-- Tab: Individual Specialist -->
            <div class="carvice-tab-panel" id="tab-individual">
                <form class="carvice-auth-form">
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'First Name', 'carvice' ); ?></label>
                            <input type="text" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Last Name', 'carvice' ); ?></label>
                            <input type="text" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'City', 'carvice' ); ?></label>
                            <input type="text" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Country', 'carvice' ); ?></label>
                            <input type="text" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Address', 'carvice' ); ?></label>
                        <input type="text" class="carvice-input" />
                    </div>
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Email', 'carvice' ); ?></label>
                            <input type="email" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Phone', 'carvice' ); ?></label>
                            <input type="tel" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Password', 'carvice' ); ?></label>
                            <input type="password" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Confirm Password', 'carvice' ); ?></label>
                            <input type="password" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Select your service categories', 'carvice' ); ?></label>
                        <div class="carvice-checkbox-grid">
                            <?php
                            $all_cats = get_terms( array( 'taxonomy' => 'carvice_service_cat', 'hide_empty' => false ) );
                            if ( ! empty( $all_cats ) && ! is_wp_error( $all_cats ) ) :
                                foreach ( $all_cats as $cat ) : ?>
                                    <label class="carvice-checkbox"><input type="checkbox" name="categories[]" value="<?php echo esc_attr( $cat->slug ); ?>" /> <?php echo esc_html( $cat->name ); ?></label>
                                <?php endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Brief description', 'carvice' ); ?></label>
                        <textarea class="carvice-input carvice-textarea" rows="3"></textarea>
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Profile Photo', 'carvice' ); ?></label>
                        <div class="carvice-file-upload"><?php esc_html_e( 'Add profile photo', 'carvice' ); ?></div>
                    </div>
                    <button type="button" class="carvice-btn carvice-btn--primary carvice-btn--full"><?php esc_html_e( 'Sign Up', 'carvice' ); ?></button>
                </form>
            </div>

            <!-- Tab: Company -->
            <div class="carvice-tab-panel" id="tab-company">
                <form class="carvice-auth-form">
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Organization Name', 'carvice' ); ?></label>
                        <input type="text" class="carvice-input" />
                    </div>
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'City', 'carvice' ); ?></label>
                            <input type="text" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Country', 'carvice' ); ?></label>
                            <input type="text" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Address', 'carvice' ); ?></label>
                        <input type="text" class="carvice-input" />
                    </div>
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Email', 'carvice' ); ?></label>
                            <input type="email" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Phone', 'carvice' ); ?></label>
                            <input type="tel" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Password', 'carvice' ); ?></label>
                            <input type="password" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Confirm Password', 'carvice' ); ?></label>
                            <input type="password" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Select your service categories', 'carvice' ); ?></label>
                        <div class="carvice-checkbox-grid">
                            <?php
                            if ( ! empty( $all_cats ) && ! is_wp_error( $all_cats ) ) :
                                foreach ( $all_cats as $cat ) : ?>
                                    <label class="carvice-checkbox"><input type="checkbox" name="categories[]" value="<?php echo esc_attr( $cat->slug ); ?>" /> <?php echo esc_html( $cat->name ); ?></label>
                                <?php endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Employee Photos', 'carvice' ); ?></label>
                        <div class="carvice-file-upload"><?php esc_html_e( 'Add employee photos', 'carvice' ); ?></div>
                    </div>
                    <button type="button" class="carvice-btn carvice-btn--primary carvice-btn--full"><?php esc_html_e( 'Sign Up', 'carvice' ); ?></button>
                </form>
            </div>

            <!-- Tab: Dealer -->
            <div class="carvice-tab-panel" id="tab-dealer">
                <form class="carvice-auth-form">
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Organization Name', 'carvice' ); ?></label>
                        <input type="text" class="carvice-input" />
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Brand Represented', 'carvice' ); ?></label>
                        <input type="text" class="carvice-input" />
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Address', 'carvice' ); ?></label>
                        <input type="text" class="carvice-input" />
                    </div>
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Email', 'carvice' ); ?></label>
                            <input type="email" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Phone', 'carvice' ); ?></label>
                            <input type="tel" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-row">
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Password', 'carvice' ); ?></label>
                            <input type="password" class="carvice-input" />
                        </div>
                        <div class="carvice-form-group">
                            <label><?php esc_html_e( 'Confirm Password', 'carvice' ); ?></label>
                            <input type="password" class="carvice-input" />
                        </div>
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Official Website', 'carvice' ); ?></label>
                        <input type="url" class="carvice-input" />
                    </div>
                    <div class="carvice-form-group">
                        <label><?php esc_html_e( 'Shop Photo', 'carvice' ); ?></label>
                        <div class="carvice-file-upload"><?php esc_html_e( 'Add shop photo', 'carvice' ); ?></div>
                    </div>
                    <button type="button" class="carvice-btn carvice-btn--primary carvice-btn--full"><?php esc_html_e( 'Sign Up', 'carvice' ); ?></button>
                </form>
            </div>

            <p class="carvice-auth-card__switch">
                <?php esc_html_e( 'Already have an account?', 'carvice' ); ?>
                <a href="<?php echo esc_url( home_url( '/login' ) ); ?>"><?php esc_html_e( 'Sign In', 'carvice' ); ?></a>
            </p>
        </div>
    </div>
</main>

<?php
get_footer();
