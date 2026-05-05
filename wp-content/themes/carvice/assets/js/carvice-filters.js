/**
 * Carvice Filter Pills — AJAX filtering for provider grids.
 *
 * @package Carvice
 */
( function() {
    'use strict';

    var pills      = document.querySelectorAll( '.carvice-pills .carvice-pill' );
    var grids      = document.querySelectorAll( '.carvice-providers-grid' );
    var activePill = null;

    if ( ! pills.length || ! grids.length ) {
        return;
    }

    /**
     * Build a provider card HTML string from JSON data.
     */
    function buildCard( provider ) {
        var starSvg = '<svg class="carvice-icon-star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';

        var verifiedBadge = '';
        if ( provider.is_verified ) {
            verifiedBadge = '<span class="carvice-provider-card__verified">' +
                '<svg class="carvice-icon-sm" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812z" clip-rule="evenodd"/></svg>' +
                'Official</span>';
        }

        var imageHtml = provider.thumbnail
            ? '<img src="' + provider.thumbnail + '" alt="" class="carvice-provider-card__img" />'
            : '<div class="carvice-provider-card__placeholder"></div>';

        var addressHtml = provider.address
            ? '<p class="carvice-provider-card__address">' + escapeHtml( provider.address ) + '</p>'
            : '';

        var ratingHtml = '';
        if ( provider.rating ) {
            var reviewCount = provider.review_count
                ? '<span class="carvice-provider-card__review-count">(' + provider.review_count + ')</span>'
                : '';
            ratingHtml = '<div class="carvice-provider-card__rating">' +
                starSvg +
                '<span class="carvice-provider-card__rating-num">' + provider.rating.toFixed( 1 ) + '</span>' +
                reviewCount +
                '</div>';
        }

        return '<a href="' + provider.permalink + '" class="carvice-provider-card">' +
            '<div class="carvice-provider-card__image">' + imageHtml + verifiedBadge + '</div>' +
            '<div class="carvice-provider-card__info">' +
                '<h3 class="carvice-provider-card__name">' + escapeHtml( provider.title ) + '</h3>' +
                addressHtml +
                ratingHtml +
            '</div>' +
        '</a>';
    }

    /**
     * Escape HTML entities.
     */
    function escapeHtml( str ) {
        var div = document.createElement( 'div' );
        div.appendChild( document.createTextNode( str ) );
        return div.innerHTML;
    }

    /**
     * Fetch providers and update all grids.
     */
    function fetchProviders( termId ) {
        var url = carviceFilters.restUrl + 'carvice/v1/providers';
        if ( termId ) {
            url += '?service_type=' + termId;
        }

        var xhr = new XMLHttpRequest();
        xhr.open( 'GET', url, true );
        xhr.setRequestHeader( 'X-WP-Nonce', carviceFilters.nonce );

        xhr.onload = function() {
            if ( xhr.status >= 200 && xhr.status < 300 ) {
                var providers = JSON.parse( xhr.responseText );
                renderGrids( providers );
            }
        };

        xhr.send();
    }

    /**
     * Render provider cards into all grids.
     */
    function renderGrids( providers ) {
        var html = '';

        if ( providers.length === 0 ) {
            html = '<p class="carvice-no-content">No providers found for this filter.</p>';
        } else {
            for ( var i = 0; i < providers.length; i++ ) {
                html += buildCard( providers[ i ] );
            }
        }

        for ( var g = 0; g < grids.length; g++ ) {
            grids[ g ].innerHTML = html;
        }
    }

    /**
     * Pill click handler.
     */
    function onPillClick( e ) {
        e.preventDefault();

        var pill   = e.currentTarget;
        var termId = pill.getAttribute( 'data-term-id' );

        // Toggle: if clicking the active pill, deactivate and show all.
        if ( pill === activePill ) {
            pill.classList.remove( 'active' );
            activePill = null;
            fetchProviders( null );
            return;
        }

        // Deactivate previous.
        if ( activePill ) {
            activePill.classList.remove( 'active' );
        }

        // Activate clicked pill.
        pill.classList.add( 'active' );
        activePill = pill;
        fetchProviders( termId );
    }

    // Bind click events.
    for ( var i = 0; i < pills.length; i++ ) {
        pills[ i ].addEventListener( 'click', onPillClick );
    }
} )();
