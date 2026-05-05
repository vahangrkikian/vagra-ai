/**
 * Carvice Gallery — Thumbnail click swaps featured image.
 *
 * @package Carvice
 */
( function() {
    'use strict';

    var featured = document.querySelector( '.carvice-provider-gallery__featured' );
    var thumbs   = document.querySelectorAll( '.carvice-provider-gallery__thumb' );

    if ( ! featured || ! thumbs.length ) {
        return;
    }

    var featuredImg = featured.querySelector( '.carvice-provider-gallery__img' );
    if ( ! featuredImg ) {
        return;
    }

    // Mark first thumb as active initially.
    if ( thumbs.length > 0 ) {
        thumbs[0].classList.add( 'active' );
    }

    for ( var i = 0; i < thumbs.length; i++ ) {
        thumbs[ i ].addEventListener( 'click', function( e ) {
            var thumb = e.currentTarget;

            // Remove active state from all thumbs.
            for ( var j = 0; j < thumbs.length; j++ ) {
                thumbs[ j ].classList.remove( 'active' );
            }
            thumb.classList.add( 'active' );

            // Fade transition on featured image.
            featuredImg.style.opacity = '0';
            featuredImg.style.transition = 'opacity 0.25s ease';

            setTimeout( function() {
                // Use the full-size version from srcset or the thumb src.
                var fullSrc = thumb.getAttribute( 'data-full-src' ) || thumb.src;
                var fullAlt = thumb.alt || '';

                featuredImg.src    = fullSrc;
                featuredImg.alt    = fullAlt;
                featuredImg.srcset = '';
                featuredImg.style.opacity = '1';
            }, 250 );
        } );
    }
} )();
