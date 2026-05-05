<?php
/**
 * Template part: DNS record types grid.
 *
 * Displays a grid of 13 DNS record types with links. Email authentication
 * records (SPF, DKIM, DMARC) link to external sister tool sites.
 *
 * Expected variables (via $args):
 *   $eyebrow  string  — Optional eyebrow text.
 *   $heading  string  — Optional heading text.
 *   $lede     string  — Optional lead paragraph.
 *   $types    array   — Optional override array of record type items.
 *
 * Ported from: nslookup/project/shared/sections.jsx — RecordTypes
 *
 * @package Vagra_NSLookup
 */

$eyebrow = $args['eyebrow'] ?? __( 'Supported records', 'vagra-nslookup' );
$heading = $args['heading'] ?? __( 'All 13 record types, one lookup tool.', 'vagra-nslookup' );
$lede    = $args['lede']    ?? __( 'Deep-link any record type. For email authentication records, jump to our sister tools for dedicated validation.', 'vagra-nslookup' );

$default_types = array(
	array( 'tag' => 'A',     'desc' => __( 'IPv4 address', 'vagra-nslookup' ),             'href' => '#' ),
	array( 'tag' => 'AAAA',  'desc' => __( 'IPv6 address', 'vagra-nslookup' ),             'href' => '#' ),
	array( 'tag' => 'CNAME', 'desc' => __( 'Canonical alias', 'vagra-nslookup' ),          'href' => '#' ),
	array( 'tag' => 'MX',    'desc' => __( 'Mail exchange', 'vagra-nslookup' ),             'href' => '#' ),
	array( 'tag' => 'NS',    'desc' => __( 'Name server', 'vagra-nslookup' ),              'href' => '#' ),
	array( 'tag' => 'TXT',   'desc' => __( 'Free-form text', 'vagra-nslookup' ),           'href' => '#' ),
	array( 'tag' => 'SPF',   'desc' => __( 'Sender policy', 'vagra-nslookup' ),            'href' => 'https://spf-checker.org/',  'ext' => true ),
	array( 'tag' => 'DKIM',  'desc' => __( 'DomainKeys signing', 'vagra-nslookup' ),       'href' => 'https://dkim-checker.org/', 'ext' => true ),
	array( 'tag' => 'DMARC', 'desc' => __( 'Authentication policy', 'vagra-nslookup' ),    'href' => 'https://dmarc-checker.org/','ext' => true ),
	array( 'tag' => 'SOA',   'desc' => __( 'Start of authority', 'vagra-nslookup' ),       'href' => '#' ),
	array( 'tag' => 'PTR',   'desc' => __( 'Reverse DNS', 'vagra-nslookup' ),              'href' => '#' ),
	array( 'tag' => 'CAA',   'desc' => __( 'Certificate authority', 'vagra-nslookup' ),    'href' => '#' ),
	array( 'tag' => 'SRV',   'desc' => __( 'Service location', 'vagra-nslookup' ),         'href' => '#' ),
);

$types = $args['types'] ?? $default_types;
?>

<section class="section" id="types">
	<div class="container">
		<div class="nsl-section-head">
			<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h2><?php echo esc_html( $heading ); ?></h2>
			<?php if ( ! empty( $lede ) ) : ?>
				<p class="lead" style="max-width:620px"><?php echo esc_html( $lede ); ?></p>
			<?php endif; ?>
		</div>
		<div class="nsl-types">
			<?php foreach ( $types as $type ) :
				$is_ext = ! empty( $type['ext'] );
			?>
				<a href="<?php echo esc_url( $type['href'] ); ?>"
				   <?php if ( $is_ext ) : ?>target="_blank" rel="noopener"<?php endif; ?>
				   class="nsl-type">
					<span class="nsl-type-tag mono"><?php echo esc_html( $type['tag'] ); ?></span>
					<span class="nsl-type-d"><?php echo esc_html( $type['desc'] ); ?></span>
					<?php if ( $is_ext ) : ?>
						<svg class="nsl-type-ext" width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">
							<path d="M4 3h5v5M9 3L3 9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
