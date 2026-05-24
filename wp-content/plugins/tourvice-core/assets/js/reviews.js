/**
 * TourVice Reviews — Star Rating Interaction
 *
 * Handles the star-input UI in the comment form:
 * - Hover preview
 * - Click to select
 * - Updates hidden input value
 * - Validates before form submit
 *
 * @package TourVice_Core
 * @since   1.0.0
 */

'use strict';

( function () {

  function initStarInput() {
    var container = document.getElementById( 'tourvice-star-input' );
    var hidden    = document.getElementById( 'tourvice-rating-value' );
    var errorEl   = document.getElementById( 'tourvice-rating-error' );

    if ( ! container || ! hidden ) {
      return;
    }

    var stars    = container.querySelectorAll( '.tourvice-star-input__star' );
    var selected = 0;

    function highlightStars( count ) {
      stars.forEach( function ( star, idx ) {
        if ( idx < count ) {
          star.classList.add( 'hovered' );
          star.querySelector( 'svg' ).setAttribute( 'fill', '#facc15' );
        } else {
          star.classList.remove( 'hovered' );
          star.querySelector( 'svg' ).setAttribute( 'fill', 'none' );
        }
      } );
    }

    function setSelected( count ) {
      selected = count;
      hidden.value = count;

      stars.forEach( function ( star, idx ) {
        if ( idx < count ) {
          star.classList.add( 'selected' );
          star.querySelector( 'svg' ).setAttribute( 'fill', '#facc15' );
        } else {
          star.classList.remove( 'selected' );
          star.querySelector( 'svg' ).setAttribute( 'fill', 'none' );
        }
      } );

      if ( errorEl && count > 0 ) {
        errorEl.setAttribute( 'hidden', '' );
      }
    }

    /* Hover */
    stars.forEach( function ( star ) {
      star.addEventListener( 'mouseenter', function () {
        var val = parseInt( star.dataset.value, 10 );
        highlightStars( val );
      } );
    } );

    /* Mouse leave — restore selected state */
    container.addEventListener( 'mouseleave', function () {
      setSelected( selected );
    } );

    /* Click */
    stars.forEach( function ( star ) {
      star.addEventListener( 'click', function ( e ) {
        e.preventDefault();
        var val = parseInt( star.dataset.value, 10 );
        setSelected( val );
      } );
    } );

    /* Validate before form submit */
    var form = container.closest( 'form' );
    if ( form ) {
      form.addEventListener( 'submit', function ( e ) {
        if ( ! hidden.value || parseInt( hidden.value, 10 ) < 1 ) {
          e.preventDefault();
          if ( errorEl ) {
            errorEl.removeAttribute( 'hidden' );
          }
          container.scrollIntoView( { behavior: 'smooth', block: 'center' } );
        }
      } );
    }
  }

  if ( document.readyState === 'loading' ) {
    document.addEventListener( 'DOMContentLoaded', initStarInput );
  } else {
    initStarInput();
  }

} )();
