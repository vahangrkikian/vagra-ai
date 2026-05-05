/**
 * DNS Propagation Checker — interactive tool logic.
 *
 * Calls /vagra-msp/v1/propagation and renders a 12-resolver grid
 * with 60 ms staggered fade-in and green/yellow/red status dots.
 *
 * @package Vagra_MSP
 */

( function () {
	'use strict';

	/* ── DOM refs ── */
	const domainInput = document.getElementById( 'vagra-prop-domain' );
	const typeSelect  = document.getElementById( 'vagra-prop-type' );
	const goButton    = document.getElementById( 'vagra-prop-go' );
	const gridEl      = document.getElementById( 'vagra-prop-grid' );
	const emptyEl     = document.getElementById( 'vagra-prop-empty' );
	const filtersEl   = document.getElementById( 'vagra-prop-filters' );
	const pills       = document.querySelectorAll( '.vagra-prop-pill' );
	const filters     = document.querySelectorAll( '.vagra-prop-filter' );

	if ( ! domainInput || ! goButton ) return;

	let lastResults = [];

	/* ── Pill click → sync select ── */
	pills.forEach( function ( pill ) {
		pill.addEventListener( 'click', function () {
			pills.forEach( function ( p ) { p.classList.remove( 'is-active' ); } );
			pill.classList.add( 'is-active' );
			typeSelect.value = pill.dataset.type;
		} );
	} );

	/* ── Select change → sync pill ── */
	typeSelect.addEventListener( 'change', function () {
		pills.forEach( function ( p ) {
			p.classList.toggle( 'is-active', p.dataset.type === typeSelect.value );
		} );
	} );

	/* ── Filter click ── */
	filters.forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			filters.forEach( function ( f ) { f.classList.remove( 'is-active' ); } );
			btn.classList.add( 'is-active' );
			renderGrid( lastResults, btn.dataset.filter );
		} );
	} );

	/* ── Enter key ── */
	domainInput.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Enter' ) runCheck();
	} );

	/* ── Go button ── */
	goButton.addEventListener( 'click', runCheck );

	/* ── Run propagation check ── */
	function runCheck() {
		const domain = domainInput.value.trim();
		if ( ! domain ) {
			domainInput.focus();
			return;
		}

		goButton.disabled = true;
		goButton.textContent = 'Checking…';
		emptyEl.style.display = 'none';
		gridEl.style.display  = 'grid';
		gridEl.innerHTML      = '';
		filtersEl.style.display = 'none';

		/* Show skeleton placeholders */
		for ( let i = 0; i < 12; i++ ) {
			const skel = document.createElement( 'div' );
			skel.className = 'vagra-prop-row vagra-prop-row--skeleton';
			skel.style.animationDelay = ( i * 60 ) + 'ms';
			skel.innerHTML =
				'<div class="vagra-prop-row__dot" style="background:var(--vagra-border)"></div>' +
				'<div class="vagra-prop-row__info">' +
					'<div class="vagra-prop-row__resolver" style="width:80px;height:14px;background:var(--vagra-border);border-radius:4px"></div>' +
					'<div class="vagra-prop-row__location" style="width:120px;height:10px;background:var(--vagra-border);border-radius:4px;margin-top:6px"></div>' +
				'</div>';
			gridEl.appendChild( skel );
		}

		fetch( vagraProp.restUrl, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce':   vagraProp.nonce,
			},
			body: JSON.stringify( {
				domain: domain,
				type:   typeSelect.value,
			} ),
		} )
		.then( function ( res ) { return res.json(); } )
		.then( function ( data ) {
			if ( data.code ) {
				throw new Error( data.message || 'Lookup failed' );
			}
			lastResults = classifyResults( data.resolvers || [] );
			filtersEl.style.display = 'flex';
			/* Reset filter to "All" */
			filters.forEach( function ( f ) {
				f.classList.toggle( 'is-active', f.dataset.filter === 'all' );
			} );
			renderGrid( lastResults, 'all' );
		} )
		.catch( function ( err ) {
			gridEl.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:32px;color:var(--vagra-muted)">' +
				escapeHtml( err.message ) + '</div>';
		} )
		.finally( function () {
			goButton.disabled = false;
			goButton.innerHTML = 'Check <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M3 8h10m-4-4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>';
		} );
	}

	/* ── Classify results: ok / mismatch / fail ── */
	function classifyResults( resolvers ) {
		/* Find the majority value */
		const valueCounts = {};
		resolvers.forEach( function ( r ) {
			if ( r.status === 'ok' && r.value ) {
				valueCounts[ r.value ] = ( valueCounts[ r.value ] || 0 ) + 1;
			}
		} );

		let majorityValue = '';
		let maxCount = 0;
		for ( const v in valueCounts ) {
			if ( valueCounts[ v ] > maxCount ) {
				maxCount = valueCounts[ v ];
				majorityValue = v;
			}
		}

		return resolvers.map( function ( r ) {
			let cls = 'fail';
			if ( r.status === 'ok' ) {
				cls = ( r.value === majorityValue ) ? 'ok' : 'mismatch';
			}
			return Object.assign( {}, r, { cls: cls } );
		} );
	}

	/* ── Render grid with filter ── */
	function renderGrid( results, filter ) {
		gridEl.innerHTML = '';

		const filtered = ( filter === 'all' )
			? results
			: results.filter( function ( r ) { return r.cls === filter; } );

		if ( filtered.length === 0 ) {
			gridEl.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:32px;color:var(--vagra-muted)">No results match this filter.</div>';
			return;
		}

		filtered.forEach( function ( r, i ) {
			const el = document.createElement( 'div' );
			el.className = 'vagra-prop-row';
			el.style.animationDelay = ( i * 60 ) + 'ms';

			const displayValue = r.value
				? truncate( r.value, 22 )
				: '—';

			el.innerHTML =
				'<span class="vagra-prop-row__dot vagra-prop-row__dot--' + r.cls + '"></span>' +
				'<div class="vagra-prop-row__info">' +
					'<div class="vagra-prop-row__resolver">' + escapeHtml( r.resolver ) + '</div>' +
					'<div class="vagra-prop-row__location">' + escapeHtml( r.location ) + '</div>' +
				'</div>' +
				'<div class="vagra-prop-row__value" title="' + escapeAttr( r.value || '' ) + '">' + escapeHtml( displayValue ) + '</div>' +
				'<div class="vagra-prop-row__time">' + escapeHtml( r.time + 'ms' ) + '</div>';

			gridEl.appendChild( el );
		} );
	}

	/* ── Helpers ── */
	function truncate( str, len ) {
		return str.length > len ? str.substring( 0, len ) + '…' : str;
	}

	function escapeHtml( str ) {
		const d = document.createElement( 'div' );
		d.appendChild( document.createTextNode( str ) );
		return d.innerHTML;
	}

	function escapeAttr( str ) {
		return str.replace( /&/g, '&amp;' ).replace( /"/g, '&quot;' ).replace( /</g, '&lt;' ).replace( />/g, '&gt;' );
	}

} )();
