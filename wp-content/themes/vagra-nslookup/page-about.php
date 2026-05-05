<?php
/**
 * Template Name: About
 *
 * About page with manifesto, principles, stats, and team.
 * Ported from: nslookup/project/shared/page-cine-about.jsx
 *
 * @package Vagra_NSLookup
 */

get_header();
?>

<main class="nsl-page-about">

	<?php
	get_template_part( 'template-parts/cine-sub-hero', null, array(
		'eyebrow' => __( 'About', 'vagra-nslookup' ),
		'title'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Built by people', 'vagra-nslookup' ), esc_html__( 'who live in the terminal.', 'vagra-nslookup' ) ),
		'lede'    => __( 'nslookup.am is a small team of infrastructure engineers who got tired of DNS tools that hide their work behind paywalls, newsletter prompts, and rate limits. So we built one that doesn\'t.', 'vagra-nslookup' ),
		'crumb'   => array(
			array( 'label' => __( 'Home', 'vagra-nslookup' ), 'href' => home_url( '/' ) ),
			array( 'label' => __( 'About', 'vagra-nslookup' ) ),
		),
	) );
	?>

	<?php // ─── Manifesto ─── ?>
	<section class="cine-section" style="background:#fff; padding-top:80px">
		<div class="container" style="max-width:980px; padding:0 32px">
			<div class="reveal" style="font-size:clamp(28px, 3.2vw, 44px); font-weight:500; letter-spacing:-0.02em; line-height:1.25; color:var(--nsl-ink); text-wrap:balance">
				<?php
				printf(
					'%s <span style="color:var(--nsl-primary-600)">%s</span> %s',
					esc_html__( 'DNS is the substrate. When it breaks, everything breaks. The tools that diagnose it should be', 'vagra-nslookup' ),
					esc_html__( 'as fast, free, and reliable', 'vagra-nslookup' ),
					esc_html__( 'as the protocol itself.', 'vagra-nslookup' )
				);
				?>
			</div>
		</div>
	</section>

	<?php // ─── Principles grid ─── ?>
	<section class="cine-section cine-section-dark" style="padding-top:60px">
		<div class="cine-head-wrap">
			<span class="cine-section-eyebrow reveal"><?php esc_html_e( 'Principles', 'vagra-nslookup' ); ?></span>
			<h2 class="cine-big-head reveal reveal-delay-1">
				<?php
				printf(
					'%s<br/><span class="muted">%s</span>',
					esc_html__( 'Four things', 'vagra-nslookup' ),
					esc_html__( 'we refuse to compromise.', 'vagra-nslookup' )
				);
				?>
			</h2>
			<div class="cine-features" style="margin-top:56px">
				<?php
				$principles = array(
					array( 'n' => '01', 't' => __( 'Free forever', 'vagra-nslookup' ),                   'd' => __( 'No rate walls, no signup, no "enter your email to continue." If it costs us compute, we cover it.', 'vagra-nslookup' ) ),
					array( 'n' => '02', 't' => __( 'Accurate by default', 'vagra-nslookup' ),             'd' => __( 'We fan every query out across 30+ resolvers and show you the raw variance, not a summary.', 'vagra-nslookup' ) ),
					array( 'n' => '03', 't' => __( 'No dark patterns', 'vagra-nslookup' ),                'd' => __( 'No newsletter modals, no autoplay video, no affiliate "recommendations." Just the lookup.', 'vagra-nslookup' ) ),
					array( 'n' => '04', 't' => __( 'Fast enough to use constantly', 'vagra-nslookup' ),   'd' => __( 'Sub-second response globally. The tool should feel like a terminal command, not a webapp.', 'vagra-nslookup' ) ),
				);
				foreach ( $principles as $i => $p ) :
					$delay = 60 * $i;
				?>
					<div class="cine-feature reveal" style="transition-delay:<?php echo esc_attr( $delay ); ?>ms">
						<span class="cine-feature-num"><?php echo esc_html( $p['n'] ); ?></span>
						<h3><?php echo esc_html( $p['t'] ); ?></h3>
						<p><?php echo esc_html( $p['d'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php // ─── Stat band ─── ?>
	<section style="background:#0B0D14; padding-bottom:120px">
		<div class="container" style="padding:0 32px">
			<div class="cine-stat-strip reveal">
				<?php
				$about_stats = array(
					array( 'n' => '30+',  'l' => __( 'Global resolvers', 'vagra-nslookup' ) ),
					array( 'n' => '6',    'l' => __( 'Continents covered', 'vagra-nslookup' ) ),
					array( 'n' => '2.1M', 'l' => __( 'Queries per month', 'vagra-nslookup' ) ),
					array( 'n' => '0',    'l' => __( 'Ads, ever', 'vagra-nslookup' ) ),
				);
				foreach ( $about_stats as $stat ) :
				?>
					<div class="cine-stat">
						<div class="cine-stat-n"><?php echo esc_html( $stat['n'] ); ?></div>
						<div class="cine-stat-l"><?php echo esc_html( $stat['l'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php // ─── Team ─── ?>
	<section class="cine-section" style="background:#F7F8FC">
		<div class="cine-head-wrap" style="text-align:left">
			<span class="cine-section-eyebrow reveal"><?php esc_html_e( 'Team', 'vagra-nslookup' ); ?></span>
			<h2 class="cine-big-head reveal reveal-delay-1">
				<?php
				printf(
					'%s <span class="muted">%s</span>',
					esc_html__( 'Small, senior,', 'vagra-nslookup' ),
					esc_html__( 'focused.', 'vagra-nslookup' )
				);
				?>
			</h2>
			<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:28px; margin-top:56px">
				<?php
				$team = array(
					array( 'n' => 'Ana Vartanian',   'r' => __( 'Infrastructure', 'vagra-nslookup' ),   'bg' => 'linear-gradient(135deg,#4F46E5,#818CF8)', 'i' => 'AV' ),
					array( 'n' => 'Marek Holl&oacute;s', 'r' => __( 'Backend & APIs', 'vagra-nslookup' ),   'bg' => 'linear-gradient(135deg,#0E7490,#22D3EE)', 'i' => 'MH' ),
					array( 'n' => 'Priya Iyer',      'r' => __( 'Frontend & UX', 'vagra-nslookup' ),    'bg' => 'linear-gradient(135deg,#059669,#34D399)', 'i' => 'PI' ),
					array( 'n' => 'Tom&aacute;s del Campo', 'r' => __( 'DNS Research', 'vagra-nslookup' ), 'bg' => 'linear-gradient(135deg,#D97706,#FCD34D)', 'i' => 'TC' ),
				);
				foreach ( $team as $i => $person ) :
					$delay = 50 * $i;
				?>
					<div class="reveal" style="transition-delay:<?php echo esc_attr( $delay ); ?>ms; padding:28px 24px; background:#fff; border-radius:20px; border:1px solid rgba(11,13,20,0.06)">
						<div style="width:64px; height:64px; border-radius:50%; background:<?php echo esc_attr( $person['bg'] ); ?>; display:flex; align-items:center; justify-content:center; color:#fff; font-size:22px; font-weight:700; letter-spacing:-0.02em"><?php echo esc_html( $person['i'] ); ?></div>
						<div style="margin-top:20px; font-size:18px; font-weight:600; letter-spacing:-0.01em"><?php echo $person['n']; // phpcs:ignore -- trusted HTML entities ?></div>
						<div style="margin-top:4px; font-size:13px; color:rgba(11,13,20,0.55)"><?php echo esc_html( $person['r'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/cine-final-cta', null, array(
		'heading'   => sprintf( '%s<br/><span class="cine-accent">%s</span>', esc_html__( 'Questions,', 'vagra-nslookup' ), esc_html__( 'ideas, or bugs?', 'vagra-nslookup' ) ),
		'sub'       => __( 'We read every message. No support ticket system, no AI chatbot.', 'vagra-nslookup' ),
		'cta'       => __( 'Get in touch', 'vagra-nslookup' ),
		'href'      => home_url( '/contact/' ),
		'secondary' => array(
			'label' => __( 'Read the blog', 'vagra-nslookup' ),
			'href'  => home_url( '/blog/' ),
		),
	) );
	?>

</main>

<?php get_footer(); ?>
