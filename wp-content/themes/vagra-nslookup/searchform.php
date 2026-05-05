<?php
/**
 * Custom search form.
 *
 * Styled to match the cinematic design system.
 *
 * @package Vagra_NSLookup
 */
?>

<form role="search" method="get" class="nsl-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:flex; gap:10px; max-width:480px; margin:0 auto">
	<label style="flex:1; display:block">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'vagra-nslookup' ); ?></span>
		<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search&hellip;', 'vagra-nslookup' ); ?>" value="<?php echo get_search_query(); ?>"
			style="width:100%; padding:14px 18px; border-radius:999px; background:#fff; border:1px solid rgba(11,13,20,0.14); color:var(--nsl-ink); font-size:15px; outline:none" />
	</label>
	<button type="submit" style="padding:14px 24px; border-radius:999px; background:var(--nsl-ink); color:#fff; border:none; font-size:14px; font-weight:600; cursor:pointer">
		<?php esc_html_e( 'Search', 'vagra-nslookup' ); ?>
	</button>
</form>
