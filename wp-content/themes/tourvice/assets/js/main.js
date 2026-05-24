/**
 * TourVice — Main JavaScript
 *
 * Hero carousel, scroll reveal, header scroll, mobile menu,
 * tour search/filter, booking modal, newsletter, contact form, chat widget.
 * Pure vanilla JS — no jQuery.
 *
 * @package TourVice
 * @since   1.0.0
 */

'use strict';

( function () {

  /* ================================================================
     HERO CAROUSEL
     ================================================================ */

  function initHeroCarousel() {
    var images = document.querySelectorAll( '.tourvice-hero__image' );
    var dots   = document.querySelectorAll( '.tourvice-hero__dot' );

    if ( ! images.length ) {
      return;
    }

    var current  = 0;
    var total    = images.length;
    var interval = null;

    function showSlide( index ) {
      images.forEach( function ( img, i ) {
        if ( i === index ) {
          img.classList.add( 'tourvice-hero__image--active', 'ken-burns' );
        } else {
          img.classList.remove( 'tourvice-hero__image--active', 'ken-burns' );
        }
      } );

      dots.forEach( function ( dot, i ) {
        dot.classList.toggle( 'tourvice-hero__dot--active', i === index );
      } );

      current = index;
    }

    function nextSlide() {
      showSlide( ( current + 1 ) % total );
    }

    function startAutoplay() {
      stopAutoplay();
      interval = setInterval( nextSlide, 5500 );
    }

    function stopAutoplay() {
      if ( interval ) {
        clearInterval( interval );
        interval = null;
      }
    }

    dots.forEach( function ( dot, i ) {
      dot.addEventListener( 'click', function () {
        showSlide( i );
        startAutoplay();
      } );
    } );

    showSlide( 0 );
    startAutoplay();
  }

  /* ================================================================
     SCROLL REVEAL
     ================================================================ */

  function initScrollReveal() {
    var reveals = document.querySelectorAll( '.reveal' );

    if ( ! reveals.length || ! ( 'IntersectionObserver' in window ) ) {
      reveals.forEach( function ( el ) {
        el.classList.add( 'visible' );
      } );
      return;
    }

    var observer = new IntersectionObserver(
      function ( entries ) {
        entries.forEach( function ( entry ) {
          if ( entry.isIntersecting ) {
            entry.target.classList.add( 'visible' );
          }
        } );
      },
      { threshold: 0.15 }
    );

    reveals.forEach( function ( el ) {
      observer.observe( el );
    } );
  }

  /* ================================================================
     HEADER SCROLL
     ================================================================ */

  function initHeaderScroll() {
    var header = document.querySelector( '.tourvice-header' );

    if ( ! header || header.classList.contains( 'tourvice-header--solid' ) ) {
      return;
    }

    function onScroll() {
      if ( window.scrollY > 60 ) {
        header.classList.add( 'tourvice-header--scrolled' );
      } else {
        header.classList.remove( 'tourvice-header--scrolled' );
      }
    }

    window.addEventListener( 'scroll', onScroll, { passive: true } );
    onScroll();
  }

  /* ================================================================
     MOBILE MENU TOGGLE
     ================================================================ */

  function initMobileMenu() {
    var hamburger = document.querySelector( '.tourvice-header__hamburger' );
    var menu      = document.querySelector( '.tourvice-header__mobile-menu' );

    if ( ! hamburger || ! menu ) {
      return;
    }

    hamburger.addEventListener( 'click', function ( e ) {
      e.stopPropagation();
      menu.classList.toggle( 'is-open' );
    } );

    var menuLinks = menu.querySelectorAll( 'a' );
    menuLinks.forEach( function ( link ) {
      link.addEventListener( 'click', function () {
        menu.classList.remove( 'is-open' );
      } );
    } );

    document.addEventListener( 'click', function ( e ) {
      if ( ! menu.contains( e.target ) && ! hamburger.contains( e.target ) ) {
        menu.classList.remove( 'is-open' );
      }
    } );
  }

  /* ================================================================
     TOUR SEARCH & FILTER (archive page)
     ================================================================ */

  function initTourFilter() {
    var searchInput = document.querySelector( '.tourvice-search-bar__input' );
    var pills       = document.querySelectorAll( '.tourvice-filter-pill' );
    var cards       = document.querySelectorAll( '.tourvice-tour-grid .tourvice-archive__card-wrap' );
    var countEl     = document.querySelector( '.tourvice-tour-count' );
    var emptyState  = document.querySelector( '.tourvice-empty-state--js' );

    if ( ! searchInput && ! pills.length ) {
      return;
    }

    var activeLocation = 'all';
    var debounceTimer  = null;

    function filterTours() {
      var query   = searchInput ? searchInput.value.toLowerCase().trim() : '';
      var visible = 0;

      cards.forEach( function ( card ) {
        var title    = ( card.dataset.title || '' ).toLowerCase();
        var location = ( card.dataset.location || '' ).toLowerCase();

        var matchSearch   = ! query || title.indexOf( query ) !== -1;
        var matchLocation = activeLocation === 'all' || location === activeLocation.toLowerCase();

        if ( matchSearch && matchLocation ) {
          card.style.display = '';
          visible++;
        } else {
          card.style.display = 'none';
        }
      } );

      if ( countEl ) {
        var tourWord = typeof TourviceI18n !== 'undefined'
          ? TourviceI18n.t( visible === 1 ? 'tour_singular' : 'tour_plural' )
          : ( visible === 1 ? 'tour' : 'tours' );
        var foundWord = typeof TourviceI18n !== 'undefined'
          ? TourviceI18n.t( 'found' )
          : 'found';
        countEl.textContent = visible + ' ' + tourWord + ' ' + foundWord;
      }

      if ( emptyState ) {
        emptyState.style.display = visible === 0 ? '' : 'none';
      }
    }

    if ( searchInput ) {
      searchInput.addEventListener( 'input', function () {
        clearTimeout( debounceTimer );
        debounceTimer = setTimeout( filterTours, 250 );
      } );
    }

    pills.forEach( function ( pill ) {
      pill.addEventListener( 'click', function () {
        pills.forEach( function ( p ) {
          p.classList.remove( 'tourvice-filter-pill--active' );
        } );
        pill.classList.add( 'tourvice-filter-pill--active' );
        activeLocation = pill.dataset.location || 'all';
        filterTours();
      } );
    } );
  }

  /* ================================================================
     BOOKING MODAL
     ================================================================ */

  function initBookingModal() {
    var overlay    = document.querySelector( '.tourvice-modal-overlay' );
    var modal      = document.querySelector( '.tourvice-modal' );
    var openBtns   = document.querySelectorAll( '[data-open-booking]' );
    var closeBtn   = document.querySelector( '.tourvice-modal__close' );
    var form       = document.querySelector( '.tourvice-modal__form form, .tourvice-modal__form' );
    var successEl  = document.querySelector( '.tourvice-modal__success' );
    var formWrap   = document.querySelector( '.tourvice-modal__form' );

    if ( ! overlay ) {
      return;
    }

    function openModal() {
      /* Sync sidebar values into the modal summary */
      var groupSelect = document.querySelector( '.tourvice-booking-card__select' );
      var totalEl     = document.getElementById( 'tourvice-price-total' );
      var modalGroup  = overlay.querySelector( '.tourvice-modal__summary-item' );
      var modalTotal  = overlay.querySelector( '.tourvice-modal__summary-price' );
      var hiddenGroup = overlay.querySelector( 'input[name="booking_group_size"]' );
      var hiddenTotal = overlay.querySelector( 'input[name="booking_total"]' );

      if ( groupSelect && modalGroup ) {
        modalGroup.textContent = groupSelect.value + ' people';
      }
      if ( totalEl && modalTotal ) {
        modalTotal.textContent = 'Total: ' + totalEl.textContent;
      }
      if ( groupSelect && hiddenGroup ) {
        hiddenGroup.value = groupSelect.value;
      }
      if ( totalEl && hiddenTotal ) {
        hiddenTotal.value = totalEl.textContent.replace( /[^0-9.]/g, '' );
      }

      overlay.classList.add( 'is-open' );
      document.body.classList.add( 'tourvice-no-scroll' );
    }

    function closeModal() {
      overlay.classList.remove( 'is-open' );
      document.body.classList.remove( 'tourvice-no-scroll' );
    }

    openBtns.forEach( function ( btn ) {
      btn.addEventListener( 'click', openModal );
    } );

    if ( closeBtn ) {
      closeBtn.addEventListener( 'click', closeModal );
    }

    overlay.addEventListener( 'click', function ( e ) {
      if ( e.target === overlay ) {
        closeModal();
      }
    } );

    document.addEventListener( 'keydown', function ( e ) {
      if ( e.key === 'Escape' && overlay.classList.contains( 'is-open' ) ) {
        closeModal();
      }
    } );

    /* Group size change -> recalculate prices */
    var groupSelect = document.querySelector( '.tourvice-booking-card__select' );

    if ( groupSelect ) {
      groupSelect.addEventListener( 'change', function () {
        recalculatePrice();
      } );
    }

    function recalculatePrice() {
      if ( ! groupSelect ) {
        return;
      }

      var groupSize     = parseInt( groupSelect.value, 10 ) || 2;
      var basePriceEl   = document.getElementById( 'tourvice-booking-card' );
      var discountEl    = document.getElementById( 'tourvice-booking-card' );
      var perPersonEl   = document.getElementById( 'tourvice-price-person' );
      var groupTotalEl  = document.getElementById( 'tourvice-price-group' );
      var totalEl       = document.getElementById( 'tourvice-price-total' );
      var discountAlert = document.querySelector( '.tourvice-discount-alert' );
      var discountText  = document.querySelector( '.tourvice-discount-alert__text' );
      var groupCountEl  = document.getElementById( 'tourvice-group-count' );

      if ( ! basePriceEl ) {
        return;
      }

      var basePrice = parseFloat( basePriceEl.dataset.basePrice ) || 0;

      /* Determine discount based on group size */
      var discount = 0;
      if ( groupSize >= 16 ) {
        discount = 30;
      } else if ( groupSize >= 11 ) {
        discount = 20;
      } else if ( groupSize >= 7 ) {
        discount = 15;
      } else if ( groupSize >= 4 ) {
        discount = 5;
      }

      /* Override with tour-level discount if provided */
      if ( discountEl && discountEl.dataset.discount ) {
        discount = parseFloat( discountEl.dataset.discount ) || discount;
      }

      var pricePerPerson = Math.round( basePrice * ( 1 - discount / 100 ) );
      var totalPrice     = pricePerPerson * groupSize;

      if ( perPersonEl ) {
        perPersonEl.textContent = '$' + pricePerPerson;
      }
      if ( groupTotalEl ) {
        groupTotalEl.textContent = '$' + totalPrice;
      }
      if ( totalEl ) {
        totalEl.textContent = '$' + totalPrice;
      }
      if ( groupCountEl ) {
        groupCountEl.textContent = groupSize + ' people';
      }

      if ( discountAlert ) {
        if ( discount > 0 ) {
          discountAlert.style.display = '';
          if ( discountText ) {
            discountText.textContent = discount + '% discount applied!';
          }
        } else {
          discountAlert.style.display = 'none';
        }
      }

      /* Update modal summary if present */
      var modalGroupEl = document.querySelector( '.tourvice-modal__summary-item' );
      var modalPriceEl = document.querySelector( '.tourvice-modal__summary-price' );

      if ( modalGroupEl ) {
        modalGroupEl.textContent = groupSize + ' people';
      }
      if ( modalPriceEl ) {
        modalPriceEl.textContent = 'Total: $' + totalPrice;
      }
    }

    /* Form validation and AJAX submit */
    if ( form && form.tagName === 'FORM' ) {
      form.addEventListener( 'submit', function ( e ) {
        e.preventDefault();
        var errors = {};
        var nameField  = form.querySelector( '[name="booking_name"]' );
        var emailField = form.querySelector( '[name="booking_email"]' );
        var phoneField = form.querySelector( '[name="booking_phone"]' );
        var dateField  = form.querySelector( '[name="booking_date"]' );

        /* Clear previous errors */
        form.querySelectorAll( '.tourvice-modal__form-error' ).forEach( function ( el ) {
          el.textContent = '';
        } );
        form.querySelectorAll( '.tourvice-modal__form-input--error' ).forEach( function ( el ) {
          el.classList.remove( 'tourvice-modal__form-input--error' );
        } );

        if ( nameField && ! nameField.value.trim() ) {
          errors.name = 'Name is required';
        }
        if ( emailField && ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( emailField.value ) ) {
          errors.email = 'Valid email required';
        }
        if ( phoneField && ! phoneField.value.trim() ) {
          errors.phone = 'Phone is required';
        }
        if ( dateField && ! dateField.value ) {
          errors.date = 'Travel date is required';
        }

        if ( Object.keys( errors ).length > 0 ) {
          Object.keys( errors ).forEach( function ( key ) {
            var input   = form.querySelector( '[name="booking_' + key + '"]' );
            var errorEl = form.querySelector( '[data-field="booking_' + key + '"]' );
            if ( input ) {
              input.classList.add( 'tourvice-modal__form-input--error' );
            }
            if ( errorEl ) {
              errorEl.textContent = errors[ key ];
              errorEl.removeAttribute( 'hidden' );
            }
          } );
          return;
        }

        /* AJAX submit */
        var formData = new FormData( form );
        formData.append( 'action', 'tourvice_submit_booking' );

        if ( typeof tourviceData !== 'undefined' && tourviceData.nonce ) {
          formData.append( 'nonce', tourviceData.nonce );
        }

        var ajaxUrl = ( typeof tourviceData !== 'undefined' && tourviceData.ajax_url )
          ? tourviceData.ajax_url
          : '/wp-admin/admin-ajax.php';

        fetch( ajaxUrl, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin',
        } )
          .then( function ( res ) { return res.json(); } )
          .then( function ( data ) {
            if ( formWrap ) { formWrap.style.display = 'none'; }
            if ( successEl ) { successEl.style.display = ''; }
          } )
          .catch( function () {
            if ( formWrap ) { formWrap.style.display = 'none'; }
            if ( successEl ) { successEl.style.display = ''; }
          } );
      } );
    }
  }

  /* ================================================================
     NEWSLETTER FORM
     ================================================================ */

  function initNewsletter() {
    var form       = document.querySelector( '.tourvice-newsletter__form' );
    var successMsg = document.querySelector( '.tourvice-newsletter__success' );

    if ( ! form ) {
      return;
    }

    form.addEventListener( 'submit', function ( e ) {
      e.preventDefault();

      var emailInput = form.querySelector( 'input[type="email"]' );
      if ( ! emailInput || ! emailInput.value.trim() ) {
        return;
      }

      if ( successMsg ) {
        successMsg.style.display = '';
        successMsg.textContent = 'Thank you! Check your email for exclusive offers.';

        setTimeout( function () {
          successMsg.style.display = 'none';
        }, 3000 );
      }

      emailInput.value = '';
    } );
  }

  /* ================================================================
     CONTACT FORM
     ================================================================ */

  function initContactForm() {
    var form       = document.querySelector( '.tourvice-contact-form' );
    var successMsg = document.querySelector( '.tourvice-contact-success' );

    if ( ! form ) {
      return;
    }

    form.addEventListener( 'submit', function ( e ) {
      e.preventDefault();

      var nameField    = form.querySelector( '[name="contact_name"]' );
      var emailField   = form.querySelector( '[name="contact_email"]' );
      var subjectField = form.querySelector( '[name="contact_subject"]' );
      var messageField = form.querySelector( '[name="contact_message"]' );
      var errors = {};

      /* Clear previous errors */
      form.querySelectorAll( '.tourvice-contact-form__error' ).forEach( function ( el ) {
        el.textContent = '';
      } );
      form.querySelectorAll( '.tourvice-contact-form__input--error, .tourvice-contact-form__textarea--error' ).forEach( function ( el ) {
        el.classList.remove( 'tourvice-contact-form__input--error', 'tourvice-contact-form__textarea--error' );
      } );

      if ( nameField && ! nameField.value.trim() ) {
        errors.name = 'Name required';
      }
      if ( emailField && ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( emailField.value ) ) {
        errors.email = 'Valid email required';
      }
      if ( subjectField && ! subjectField.value.trim() ) {
        errors.subject = 'Subject required';
      }
      if ( messageField && ! messageField.value.trim() ) {
        errors.message = 'Message required';
      }

      if ( Object.keys( errors ).length > 0 ) {
        Object.keys( errors ).forEach( function ( key ) {
          var input   = form.querySelector( '[name="contact_' + key + '"]' );
          var errorEl = form.querySelector( '[data-field="contact_' + key + '"]' );
          if ( input ) {
            var errorClass = input.tagName === 'TEXTAREA'
              ? 'tourvice-contact-form__textarea--error'
              : 'tourvice-contact-form__input--error';
            input.classList.add( errorClass );
          }
          if ( errorEl ) {
            errorEl.textContent = errors[ key ];
            errorEl.removeAttribute( 'hidden' );
          }
        } );
        return;
      }

      /* AJAX submit */
      var formData = new FormData( form );
      formData.append( 'action', 'tourvice_contact' );

      if ( typeof tourviceData !== 'undefined' && tourviceData.nonce ) {
        formData.append( 'nonce', tourviceData.nonce );
      }

      var ajaxUrl = ( typeof tourviceData !== 'undefined' && tourviceData.ajax_url )
        ? tourviceData.ajax_url
        : '/wp-admin/admin-ajax.php';

      fetch( ajaxUrl, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
      } )
        .then( function ( res ) { return res.json(); } )
        .then( function () {
          showContactSuccess();
        } )
        .catch( function () {
          showContactSuccess();
        } );

      function showContactSuccess() {
        if ( successMsg ) {
          successMsg.style.display = '';

          setTimeout( function () {
            successMsg.style.display = 'none';
          }, 3000 );
        }

        if ( nameField )    { nameField.value = ''; }
        if ( emailField )   { emailField.value = ''; }
        if ( subjectField ) { subjectField.value = ''; }
        if ( messageField ) { messageField.value = ''; }
      }
    } );
  }

  /* ================================================================
     CHAT WIDGET
     ================================================================ */

  function initChatWidget() {
    var chatWrap = document.getElementById( 'tourvice-chat' );
    var toggle   = document.getElementById( 'tourvice-chat-toggle' );
    var panel    = document.getElementById( 'tourvice-chat-panel' );
    var closeBtn = document.querySelector( '.tourvice-chat__close' );
    var form     = document.getElementById( 'tourvice-chat-form' );
    var input    = document.getElementById( 'tourvice-chat-input' );
    var messages = document.getElementById( 'tourvice-chat-messages' );
    var chips    = document.querySelectorAll( '.tourvice-chat__chip' );

    if ( ! toggle || ! panel ) {
      return;
    }

    function togglePanel() {
      var isOpen = panel.classList.toggle( 'is-open' );
      toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
      panel.setAttribute( 'aria-hidden', isOpen ? 'false' : 'true' );
      if ( isOpen && input ) {
        input.focus();
      }
    }

    function closePanel() {
      panel.classList.remove( 'is-open' );
      toggle.setAttribute( 'aria-expanded', 'false' );
      panel.setAttribute( 'aria-hidden', 'true' );
    }

    toggle.addEventListener( 'click', togglePanel );

    if ( closeBtn ) {
      closeBtn.addEventListener( 'click', closePanel );
    }

    function scrollToBottom() {
      if ( messages ) {
        messages.scrollTop = messages.scrollHeight;
      }
    }

    function appendMessage( text, role ) {
      if ( ! messages ) { return; }

      var msg = document.createElement( 'div' );
      msg.className = 'tourvice-chat__message tourvice-chat__message--' + role;
      var bubble = document.createElement( 'div' );
      bubble.className = 'tourvice-chat__bubble';
      bubble.textContent = text;
      msg.appendChild( bubble );
      messages.appendChild( msg );
      scrollToBottom();
    }

    function showTyping() {
      if ( ! messages ) { return null; }

      var typing = document.createElement( 'div' );
      typing.className = 'tourvice-chat__message tourvice-chat__message--assistant';
      typing.innerHTML =
        '<div class="tourvice-chat__bubble tourvice-chat__typing-bubble">' +
        '<span class="tourvice-chat__dot"></span>' +
        '<span class="tourvice-chat__dot"></span>' +
        '<span class="tourvice-chat__dot"></span>' +
        '</div>';
      messages.appendChild( typing );
      scrollToBottom();
      return typing;
    }

    function removeTyping( el ) {
      if ( el && el.parentNode ) {
        el.parentNode.removeChild( el );
      }
    }

    function sendMessage( text ) {
      if ( ! text || ! text.trim() ) { return; }

      appendMessage( text, 'user' );
      var typing = showTyping();

      var restUrl = ( typeof tourviceData !== 'undefined' && tourviceData.rest_url )
        ? tourviceData.rest_url
        : '/wp-json/';

      fetch( restUrl + 'tourvice/v1/chat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify( { message: text } ),
        credentials: 'same-origin',
      } )
        .then( function ( res ) { return res.json(); } )
        .then( function ( data ) {
          removeTyping( typing );
          var reply = ( data && data.reply ) ? data.reply : 'Thank you for your message! Our team will get back to you soon.';
          appendMessage( reply, 'assistant' );
        } )
        .catch( function () {
          removeTyping( typing );
          appendMessage( 'Thank you for your message! Our team will get back to you soon.', 'assistant' );
        } );
    }

    if ( form && input ) {
      form.addEventListener( 'submit', function ( e ) {
        e.preventDefault();
        var text = input.value.trim();
        input.value = '';
        sendMessage( text );
      } );
    }

    chips.forEach( function ( chip ) {
      chip.addEventListener( 'click', function () {
        var text = chip.textContent.trim();
        sendMessage( text );
      } );
    } );
  }

  /* ================================================================
     INIT ON DOM READY
     ================================================================ */

  function init() {
    initHeroCarousel();
    initScrollReveal();
    initHeaderScroll();
    initMobileMenu();
    initTourFilter();
    initBookingModal();
    initNewsletter();
    initContactForm();
    initChatWidget();
  }

  if ( document.readyState === 'loading' ) {
    document.addEventListener( 'DOMContentLoaded', init );
  } else {
    init();
  }

} )();

/* Currency menu toggle (global, called from header onclick) */
function toggleCurrMenu() {
  var menu = document.getElementById( 'tourviceCurrMenu' );
  if ( menu ) {
    menu.classList.toggle( 'open' );
  }
}

/* Close currency menu when clicking outside */
document.addEventListener( 'click', function ( e ) {
  var wrap = document.getElementById( 'tourviceCurrWrap' );
  var menu = document.getElementById( 'tourviceCurrMenu' );
  if ( wrap && menu && ! wrap.contains( e.target ) ) {
    menu.classList.remove( 'open' );
  }
} );
