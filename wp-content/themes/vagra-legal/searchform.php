<?php
/**
 * Search Form Template
 *
 * @package Vagra_Legal
 */
?>

<form role="search" method="get" class="vagra-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="vagra-search-input" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'vagra-legal' ); ?></label>
    <input type="search" id="vagra-search-input" class="vagra-search-form__input" placeholder="<?php esc_attr_e( 'Search&hellip;', 'vagra-legal' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <button type="submit" class="vagra-btn vagra-btn--primary vagra-search-form__submit"><?php esc_html_e( 'Search', 'vagra-legal' ); ?></button>
</form>
