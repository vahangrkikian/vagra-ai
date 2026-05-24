<?php
/**
 * Search form template.
 *
 * @package Meridian
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="search-form__label" for="meridian-search">
        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'meridian' ); ?></span>
    </label>
    <input
        type="search"
        id="meridian-search"
        class="search-form__input"
        placeholder="<?php esc_attr_e( 'Search...', 'meridian' ); ?>"
        value="<?php echo get_search_query(); ?>"
        name="s"
    />
    <button type="submit" class="search-form__submit">
        <?php esc_html_e( 'Search', 'meridian' ); ?>
    </button>
</form>
