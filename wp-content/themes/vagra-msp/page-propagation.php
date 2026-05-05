<?php
/**
 * Template Name: DNS Propagation Checker
 *
 * Six-section cinematic page:
 *   1. CineSubHero — dark hero with breadcrumb
 *   2. CinePropTool — domain input, record type selector, filter buttons, 12 resolver grid
 *   3. Understanding Propagation explainer
 *   4. Stats Band — 5 min / 48 h / 3600 s / patience
 *   5. FAQ — 5 propagation questions
 *   6. CineFinalCTA
 *
 * @package Vagra_MSP
 */

get_header();
?>

<main class="vagra-prop-page">

	<?php // ─── 1. CineSubHero ─── ?>
	<section class="vagra-prop-hero">
		<div class="vagra-container vagra-prop-hero__inner">
			<nav class="vagra-prop-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'vagra-msp' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'vagra-msp' ); ?></a>
				<span class="vagra-prop-crumb__sep">&rsaquo;</span>
				<a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php esc_html_e( 'Tools', 'vagra-msp' ); ?></a>
				<span class="vagra-prop-crumb__sep">&rsaquo;</span>
				<span><?php esc_html_e( 'Propagation Checker', 'vagra-msp' ); ?></span>
			</nav>

			<span class="vagra-prop-eyebrow"><span class="vagra-prop-dot"></span> <?php esc_html_e( '12 resolvers · 9 record types', 'vagra-msp' ); ?></span>

			<h1 class="vagra-prop-hero__title">
				<?php esc_html_e( 'DNS Propagation', 'vagra-msp' ); ?><br/>
				<span class="vagra-prop-accent"><?php esc_html_e( 'Checker', 'vagra-msp' ); ?></span>
			</h1>

			<p class="vagra-prop-hero__lede">
				<?php esc_html_e( 'Check how your DNS records have propagated across 12 global resolvers. See which servers have updated and which are still serving stale data.', 'vagra-msp' ); ?>
			</p>
		</div>
	</section>

	<?php // ─── 2. CinePropTool ─── ?>
	<section class="vagra-prop-tool" id="tool">
		<div class="vagra-container">
			<div class="vagra-prop-tool__card">
				<!-- Tool head: window chrome -->
				<div class="vagra-prop-tool__head">
					<div class="vagra-prop-tool__dots"><span></span><span></span><span></span></div>
					<span class="vagra-prop-tool__label"><?php esc_html_e( 'DNS Propagation Checker', 'vagra-msp' ); ?></span>
				</div>

				<!-- Input row -->
				<div class="vagra-prop-tool__form" role="search" aria-label="<?php esc_attr_e( 'DNS propagation check', 'vagra-msp' ); ?>">
					<input
						type="text"
						id="vagra-prop-domain"
						class="vagra-prop-tool__input"
						placeholder="<?php esc_attr_e( 'Enter domain name…', 'vagra-msp' ); ?>"
						autocomplete="off"
						spellcheck="false"
						aria-label="<?php esc_attr_e( 'Domain name', 'vagra-msp' ); ?>"
					/>
					<select id="vagra-prop-type" class="vagra-prop-tool__select" aria-label="<?php esc_attr_e( 'Record type', 'vagra-msp' ); ?>">
						<?php
						$record_types = array( 'A', 'AAAA', 'CNAME', 'MX', 'NS', 'TXT', 'SOA', 'CAA', 'SRV' );
						foreach ( $record_types as $rt ) :
						?>
							<option value="<?php echo esc_attr( $rt ); ?>"><?php echo esc_html( $rt ); ?></option>
						<?php endforeach; ?>
					</select>
					<button type="button" id="vagra-prop-go" class="vagra-prop-tool__go">
						<?php esc_html_e( 'Check', 'vagra-msp' ); ?>
						<svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10m-4-4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</div>

				<!-- Record type pills -->
				<div class="vagra-prop-pills" aria-label="<?php esc_attr_e( 'Record type shortcuts', 'vagra-msp' ); ?>">
					<?php foreach ( $record_types as $i => $rt ) : ?>
						<button type="button" class="vagra-prop-pill<?php echo 0 === $i ? ' is-active' : ''; ?>" data-type="<?php echo esc_attr( $rt ); ?>">
							<?php echo esc_html( $rt ); ?>
						</button>
					<?php endforeach; ?>
				</div>

				<!-- Filter buttons -->
				<div class="vagra-prop-filters" id="vagra-prop-filters" style="display:none">
					<button type="button" class="vagra-prop-filter is-active" data-filter="all"><?php esc_html_e( 'All', 'vagra-msp' ); ?></button>
					<button type="button" class="vagra-prop-filter" data-filter="fail"><?php esc_html_e( 'Failed', 'vagra-msp' ); ?></button>
					<button type="button" class="vagra-prop-filter" data-filter="mismatch"><?php esc_html_e( 'Mismatched', 'vagra-msp' ); ?></button>
				</div>

				<!-- Results grid -->
				<div class="vagra-prop-results" id="vagra-prop-results">
					<div class="vagra-prop-results__empty" id="vagra-prop-empty">
						<svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
							<circle cx="24" cy="24" r="18" stroke="var(--vagra-border)" stroke-width="2" fill="none"/>
							<path d="M24 16V28" stroke="var(--vagra-muted)" stroke-width="2" stroke-linecap="round"/>
							<circle cx="24" cy="34" r="1.5" fill="var(--vagra-muted)"/>
						</svg>
						<p><?php esc_html_e( 'Enter a domain above to check DNS propagation across 12 global resolvers.', 'vagra-msp' ); ?></p>
					</div>
					<div class="vagra-prop-grid" id="vagra-prop-grid" style="display:none"></div>
				</div>
			</div>
		</div>
	</section>

	<?php // ─── 3. Understanding Propagation Explainer ─── ?>
	<section class="vagra-prop-explainer">
		<div class="vagra-container" style="max-width:880px">
			<span class="vagra-prop-section-eyebrow"><?php esc_html_e( 'How it works', 'vagra-msp' ); ?></span>
			<h2 class="vagra-prop-section-title">
				<?php esc_html_e( 'Understanding DNS Propagation', 'vagra-msp' ); ?>
			</h2>
			<div class="vagra-prop-explainer__grid">
				<div class="vagra-prop-explainer__item">
					<div class="vagra-prop-explainer__num">01</div>
					<h3><?php esc_html_e( 'You update a DNS record', 'vagra-msp' ); ?></h3>
					<p><?php esc_html_e( 'When you change a DNS record at your registrar or hosting provider, the change is made on your authoritative nameserver immediately.', 'vagra-msp' ); ?></p>
				</div>
				<div class="vagra-prop-explainer__item">
					<div class="vagra-prop-explainer__num">02</div>
					<h3><?php esc_html_e( 'Caches hold old data', 'vagra-msp' ); ?></h3>
					<p><?php esc_html_e( 'Recursive resolvers around the world cache your old record for as long as the TTL (Time To Live) allows. They won\'t ask for a fresh copy until the cache expires.', 'vagra-msp' ); ?></p>
				</div>
				<div class="vagra-prop-explainer__item">
					<div class="vagra-prop-explainer__num">03</div>
					<h3><?php esc_html_e( 'Gradual global update', 'vagra-msp' ); ?></h3>
					<p><?php esc_html_e( 'As each resolver\'s cache expires, it fetches the new record. Different resolvers update at different times, so propagation happens gradually across the internet.', 'vagra-msp' ); ?></p>
				</div>
				<div class="vagra-prop-explainer__item">
					<div class="vagra-prop-explainer__num">04</div>
					<h3><?php esc_html_e( 'Full propagation', 'vagra-msp' ); ?></h3>
					<p><?php esc_html_e( 'Once every resolver has refreshed its cache, your DNS change is fully propagated. This typically takes anywhere from 5 minutes to 48 hours, depending on TTL values.', 'vagra-msp' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<?php // ─── 4. Stats Band ─── ?>
	<section class="vagra-prop-stats">
		<div class="vagra-container">
			<div class="vagra-prop-stats__grid">
				<div class="vagra-prop-stat">
					<span class="vagra-prop-stat__num"><?php esc_html_e( '5 min', 'vagra-msp' ); ?></span>
					<span class="vagra-prop-stat__label"><?php esc_html_e( 'Minimum propagation', 'vagra-msp' ); ?></span>
				</div>
				<div class="vagra-prop-stat">
					<span class="vagra-prop-stat__num"><?php esc_html_e( '48 h', 'vagra-msp' ); ?></span>
					<span class="vagra-prop-stat__label"><?php esc_html_e( 'Maximum ceiling', 'vagra-msp' ); ?></span>
				</div>
				<div class="vagra-prop-stat">
					<span class="vagra-prop-stat__num"><?php esc_html_e( '3600s', 'vagra-msp' ); ?></span>
					<span class="vagra-prop-stat__label"><?php esc_html_e( 'Common TTL default', 'vagra-msp' ); ?></span>
				</div>
				<div class="vagra-prop-stat">
					<span class="vagra-prop-stat__num">&infin;</span>
					<span class="vagra-prop-stat__label"><?php esc_html_e( 'Patience required', 'vagra-msp' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<?php // ─── 5. FAQ ─── ?>
	<section class="vagra-prop-faq">
		<div class="vagra-container" style="max-width:880px">
			<h2 class="vagra-prop-section-title"><?php esc_html_e( 'Frequently Asked Questions', 'vagra-msp' ); ?></h2>
			<?php
			$faq_items = array(
				array(
					'q' => __( 'What is DNS propagation?', 'vagra-msp' ),
					'a' => __( 'DNS propagation is the process by which updated DNS records spread across all DNS servers worldwide. When you change a DNS record, the update doesn\'t happen instantly everywhere — each server must wait for its cached copy to expire before fetching the new record from the authoritative nameserver.', 'vagra-msp' ),
				),
				array(
					'q' => __( 'How long does DNS propagation take?', 'vagra-msp' ),
					'a' => __( 'DNS propagation typically takes between 5 minutes and 48 hours, depending on the TTL (Time To Live) value set on the record. Records with lower TTLs propagate faster. If you\'re planning a migration, lower your TTL well in advance to speed up the transition.', 'vagra-msp' ),
				),
				array(
					'q' => __( 'Why do some resolvers show different results?', 'vagra-msp' ),
					'a' => __( 'Different DNS resolvers cache records independently. When you update a record, some resolvers may still be serving the old cached value while others have already fetched the new one. This is completely normal during propagation and will resolve once all caches expire.', 'vagra-msp' ),
				),
				array(
					'q' => __( 'Can I speed up DNS propagation?', 'vagra-msp' ),
					'a' => __( 'You can\'t force all DNS servers to update immediately, but you can prepare by lowering the TTL value on your records 24–48 hours before making changes. A TTL of 300 seconds (5 minutes) means resolvers will refresh more frequently, leading to faster propagation when you make your change.', 'vagra-msp' ),
				),
				array(
					'q' => __( 'What do the status colors mean?', 'vagra-msp' ),
					'a' => __( 'Green means the resolver returned a successful response and the value matches the majority of results. Yellow indicates a mismatch — the resolver returned a value that differs from the consensus. Red means the resolver failed to return any result for that record type and domain.', 'vagra-msp' ),
				),
			);

			foreach ( $faq_items as $item ) :
			?>
				<details class="vagra-prop-faq__item">
					<summary>
						<span><?php echo esc_html( $item['q'] ); ?></span>
						<span class="vagra-prop-faq__toggle">+</span>
					</summary>
					<div class="vagra-prop-faq__body">
						<p><?php echo esc_html( $item['a'] ); ?></p>
					</div>
				</details>
			<?php endforeach; ?>
		</div>
	</section>

	<?php // ─── 6. CineFinalCTA ─── ?>
	<section class="vagra-prop-cta">
		<div class="vagra-container">
			<h2 class="vagra-prop-cta__title">
				<?php esc_html_e( 'Need a full DNS lookup?', 'vagra-msp' ); ?><br/>
				<span class="vagra-prop-accent"><?php esc_html_e( 'Try our NS Lookup tool.', 'vagra-msp' ); ?></span>
			</h2>
			<p class="vagra-prop-cta__sub">
				<?php esc_html_e( 'Query 13 record types across 30+ resolvers. Free, instant, no signup required.', 'vagra-msp' ); ?>
			</p>
			<div class="vagra-prop-cta__buttons">
				<a href="<?php echo esc_url( home_url( '/ns-lookup/' ) ); ?>" class="vagra-btn vagra-btn--primary">
					<?php esc_html_e( 'NS Lookup', 'vagra-msp' ); ?>
					<svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10m-4-4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</a>
				<a href="#tool" class="vagra-btn vagra-btn--ghost">
					<?php esc_html_e( 'Check propagation again', 'vagra-msp' ); ?>
				</a>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
