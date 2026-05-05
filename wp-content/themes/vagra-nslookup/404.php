<?php
/**
 * 404 (Not Found) template.
 *
 * Full dark hero with giant 404, mock terminal, search form, quick links.
 * Ported from: nslookup/project/shared/page-cine-404.jsx
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-404">

	<section class="cine-hero" style="min-height:calc(100vh - 80px); display:flex; align-items:center; justify-content:center">
		<div class="container" style="max-width:900px; padding:60px 32px; position:relative; z-index:2; text-align:center">

			<?php // ─── Status code ─── ?>
			<div class="reveal" style="font-family:var(--nsl-font-mono); font-size:clamp(14px, 1.6vw, 18px); color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:0.24em">
				<?php esc_html_e( 'Status 404 · NXDOMAIN', 'vagra-nslookup' ); ?>
			</div>

			<?php // ─── Giant 404 ─── ?>
			<div class="reveal reveal-delay-1" aria-hidden="true" style="margin-top:32px; font-family:var(--nsl-font-mono); font-weight:700; font-size:clamp(120px, 22vw, 280px); line-height:0.9; letter-spacing:-0.04em; background:linear-gradient(135deg, #A5B4FC 0%, #67E8F9 55%, #34D399 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text">
				404
			</div>

			<h1 class="cine-h1 reveal reveal-delay-2" style="margin-top:20px; font-size:clamp(32px, 4vw, 56px)">
				<?php
				printf(
					'%s<br/><span class="cine-accent">%s</span>',
					esc_html__( 'No record', 'vagra-nslookup' ),
					esc_html__( 'for that name.', 'vagra-nslookup' )
				);
				?>
			</h1>
			<p class="cine-lede reveal reveal-delay-3" style="margin-top:24px; max-width:580px; margin-left:auto; margin-right:auto">
				<?php esc_html_e( 'The page you asked about doesn\'t resolve. The upstream returned NXDOMAIN — that\'s DNS-speak for "this doesn\'t exist, please stop asking."', 'vagra-nslookup' ); ?>
			</p>

			<?php // ─── Mock terminal ─── ?>
			<div class="reveal reveal-delay-3" style="max-width:620px; margin:48px auto 0; background:rgba(0,0,0,0.4); border:1px solid rgba(255,255,255,0.08); border-radius:14px; overflow:hidden; text-align:left; backdrop-filter:blur(10px)">
				<div style="padding:10px 16px; display:flex; gap:8px; border-bottom:1px solid rgba(255,255,255,0.06)">
					<span style="width:10px; height:10px; border-radius:50%; background:#FF5F57"></span>
					<span style="width:10px; height:10px; border-radius:50%; background:#FEBC2E"></span>
					<span style="width:10px; height:10px; border-radius:50%; background:#28C840"></span>
					<span style="margin-left:auto; font-size:11px; font-family:var(--nsl-font-mono); color:rgba(255,255,255,0.35)">terminal</span>
				</div>
				<div style="padding:20px; font-family:var(--nsl-font-mono); font-size:14px; line-height:1.7; color:#E2E8F0">
					<div><span style="color:#34D399">$</span> dig <span style="color:#A5B4FC"><?php echo esc_html( esc_url( $_SERVER['REQUEST_URI'] ?? '/this-page' ) ); ?></span></div>
					<div style="color:rgba(255,255,255,0.45)">;; -&gt;&gt;HEADER&lt;&lt;- opcode: QUERY, status: <span style="color:#F87171">NXDOMAIN</span></div>
					<div style="color:rgba(255,255,255,0.45)">;; QUESTION SECTION:</div>
					<div>; nslookup.am.&nbsp;&nbsp;&nbsp;&nbsp;IN&nbsp;&nbsp;&nbsp;&nbsp;PAGE</div>
					<div style="margin-top:10px; color:rgba(255,255,255,0.45)">;; Query time: 2 msec</div>
					<div style="color:rgba(255,255,255,0.45)">;; SERVER: 8.8.8.8#53</div>
					<div><span style="color:#34D399">$</span> <span class="nsl-caret">&nbsp;</span></div>
				</div>
			</div>

			<?php // ─── Search fallback ─── ?>
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="reveal reveal-delay-3" style="margin:40px auto 0; display:flex; gap:10px; max-width:480px">
				<input type="search" name="s" placeholder="<?php esc_attr_e( 'Look up a domain instead&hellip;', 'vagra-nslookup' ); ?>" value="<?php echo get_search_query(); ?>"
					style="flex:1; padding:14px 18px; border-radius:999px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.14); color:#fff; font-size:15px; outline:none" />
				<button type="submit" style="padding:14px 24px; border-radius:999px; background:#fff; color:#0B0D14; border:none; font-size:14px; font-weight:600; cursor:pointer">
					<?php esc_html_e( 'Lookup &rarr;', 'vagra-nslookup' ); ?>
				</button>
			</form>

			<?php // ─── Quick links ─── ?>
			<div class="reveal reveal-delay-3" style="margin-top:40px; display:flex; gap:8px; flex-wrap:wrap; justify-content:center">
				<?php
				$quick_links = array(
					array( 'l' => __( 'Home', 'vagra-nslookup' ),        'h' => home_url( '/' ) ),
					array( 'l' => __( 'NS Lookup', 'vagra-nslookup' ),   'h' => home_url( '/ns-lookup/' ) ),
					array( 'l' => __( 'Propagation', 'vagra-nslookup' ), 'h' => home_url( '/propagation/' ) ),
					array( 'l' => __( 'Tools', 'vagra-nslookup' ),       'h' => home_url( '/tools/' ) ),
					array( 'l' => __( 'Blog', 'vagra-nslookup' ),        'h' => home_url( '/blog/' ) ),
					array( 'l' => __( 'Contact', 'vagra-nslookup' ),     'h' => home_url( '/contact/' ) ),
				);
				foreach ( $quick_links as $link ) :
				?>
					<a href="<?php echo esc_url( $link['h'] ); ?>" style="padding:8px 14px; border-radius:999px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.12); color:rgba(255,255,255,0.8); font-size:13px; transition:all 200ms">
						<?php echo esc_html( $link['l'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>

		</div>
	</section>

</main>

<style>
	.nsl-caret { border-right: 2px solid #E2E8F0; animation: nsl-caret-blink 1s step-end infinite; }
	@keyframes nsl-caret-blink { 50% { border-color: transparent; } }
</style>

<?php get_footer(); ?>
