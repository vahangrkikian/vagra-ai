/**
 * Carvice Reviews — Interactive star rating for comment form.
 *
 * @package Carvice
 */
( function() {
    'use strict';

    var commentForm = document.getElementById( 'commentform' );
    if ( ! commentForm ) {
        return;
    }

    // Create star rating widget.
    var wrapper = document.createElement( 'div' );
    wrapper.className = 'carvice-star-rating';

    var label = document.createElement( 'label' );
    label.className = 'carvice-star-rating__label';
    label.textContent = 'Your Rating';
    wrapper.appendChild( label );

    var starsContainer = document.createElement( 'div' );
    starsContainer.className = 'carvice-star-rating__stars';

    var hiddenInput = document.createElement( 'input' );
    hiddenInput.type  = 'hidden';
    hiddenInput.name  = 'carvice_rating';
    hiddenInput.value = '0';

    var starSvgPath = 'M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z';

    var stars = [];
    var selectedRating = 0;

    for ( var i = 1; i <= 5; i++ ) {
        var star = document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' );
        star.setAttribute( 'viewBox', '0 0 20 20' );
        star.setAttribute( 'fill', 'currentColor' );
        star.setAttribute( 'data-value', i );
        star.classList.add( 'carvice-star-rating__star', 'empty' );

        var path = document.createElementNS( 'http://www.w3.org/2000/svg', 'path' );
        path.setAttribute( 'd', starSvgPath );
        star.appendChild( path );

        stars.push( star );
        starsContainer.appendChild( star );
    }

    wrapper.appendChild( starsContainer );
    wrapper.appendChild( hiddenInput );

    // Insert before the submit button.
    var submitWrap = commentForm.querySelector( '.form-submit' ) ||
                     commentForm.querySelector( 'input[type="submit"]' );
    if ( submitWrap ) {
        var parent = submitWrap.parentNode === commentForm ? commentForm : submitWrap.parentNode;
        parent.insertBefore( wrapper, submitWrap );
    } else {
        commentForm.appendChild( wrapper );
    }

    /**
     * Update visual star state.
     */
    function fillStars( count ) {
        for ( var j = 0; j < stars.length; j++ ) {
            if ( j < count ) {
                stars[ j ].classList.remove( 'empty' );
                stars[ j ].classList.add( 'filled' );
            } else {
                stars[ j ].classList.remove( 'filled' );
                stars[ j ].classList.add( 'empty' );
            }
        }
    }

    // Hover preview.
    starsContainer.addEventListener( 'mouseover', function( e ) {
        var star = e.target.closest( '.carvice-star-rating__star' );
        if ( star ) {
            fillStars( parseInt( star.getAttribute( 'data-value' ), 10 ) );
        }
    } );

    starsContainer.addEventListener( 'mouseout', function() {
        fillStars( selectedRating );
    } );

    // Click to select.
    starsContainer.addEventListener( 'click', function( e ) {
        var star = e.target.closest( '.carvice-star-rating__star' );
        if ( star ) {
            selectedRating = parseInt( star.getAttribute( 'data-value' ), 10 );
            hiddenInput.value = selectedRating;
            fillStars( selectedRating );
        }
    } );
} )();
