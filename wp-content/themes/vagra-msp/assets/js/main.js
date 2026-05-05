/**
 * Vagra MSP Cybersecurity Theme - Main JavaScript
 *
 * @package Vagra_MSP
 * @since 1.0.0
 */

( function () {
    'use strict';

    /* ------------------------------------------------------------------
       Mobile Menu Toggle
       ------------------------------------------------------------------ */

    var burger = document.getElementById( 'mobile-menu-toggle' );
    var nav    = document.getElementById( 'site-navigation' );

    if ( burger && nav ) {
        burger.addEventListener( 'click', function () {
            var expanded = burger.getAttribute( 'aria-expanded' ) === 'true';
            burger.setAttribute( 'aria-expanded', String( ! expanded ) );
            nav.classList.toggle( 'is-open' );
        } );

        // Close menu on Escape key.
        document.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
                burger.setAttribute( 'aria-expanded', 'false' );
                nav.classList.remove( 'is-open' );
                burger.focus();
            }
        } );
    }

    /* ------------------------------------------------------------------
       Sticky Header Shadow on Scroll
       ------------------------------------------------------------------ */

    var header = document.getElementById( 'masthead' );

    if ( header ) {
        var onScroll = function () {
            header.classList.toggle( 'is-scrolled', window.scrollY > 10 );
        };
        window.addEventListener( 'scroll', onScroll, { passive: true } );
        onScroll();
    }
    /* ------------------------------------------------------------------
       Principles Cards — Mouse-Tracking Glow
       ------------------------------------------------------------------ */

    document.querySelectorAll( '[data-glow]' ).forEach( function ( card ) {
        var glow = card.querySelector( '.principles__card-glow' );
        if ( ! glow ) return;

        card.addEventListener( 'mousemove', function ( e ) {
            var rect = card.getBoundingClientRect();
            glow.style.left = ( e.clientX - rect.left ) + 'px';
            glow.style.top  = ( e.clientY - rect.top ) + 'px';
        } );
    } );

    /* ------------------------------------------------------------------
       FAQ Page — Accordion Toggle
       ------------------------------------------------------------------ */

    document.querySelectorAll( '.faq-page__question' ).forEach( function ( btn ) {
        btn.addEventListener( 'click', function () {
            var item     = btn.closest( '.faq-page__item' );
            var answer   = item.querySelector( '.faq-page__answer' );
            var isOpen   = item.classList.contains( 'is-open' );

            // Close all siblings.
            var parent = item.closest( '.faq-page__list' );
            parent.querySelectorAll( '.faq-page__item.is-open' ).forEach( function ( other ) {
                if ( other !== item ) {
                    other.classList.remove( 'is-open' );
                    other.querySelector( '.faq-page__question' ).setAttribute( 'aria-expanded', 'false' );
                    other.querySelector( '.faq-page__answer' ).style.maxHeight = null;
                    other.querySelector( '.faq-page__answer' ).setAttribute( 'aria-hidden', 'true' );
                }
            } );

            // Toggle current.
            if ( isOpen ) {
                item.classList.remove( 'is-open' );
                btn.setAttribute( 'aria-expanded', 'false' );
                answer.style.maxHeight = null;
                answer.setAttribute( 'aria-hidden', 'true' );
            } else {
                item.classList.add( 'is-open' );
                btn.setAttribute( 'aria-expanded', 'true' );
                answer.style.maxHeight = answer.scrollHeight + 'px';
                answer.setAttribute( 'aria-hidden', 'false' );
            }
        } );
    } );

    /* ------------------------------------------------------------------
       Contact Form — Client-side submission with success screen
       ------------------------------------------------------------------ */

    var contactForm    = document.getElementById( 'contact-form' );
    var contactSuccess = document.getElementById( 'contact-success' );

    if ( contactForm && contactSuccess ) {
        contactForm.addEventListener( 'submit', function ( e ) {
            e.preventDefault();

            // Basic HTML5 validation.
            if ( ! contactForm.checkValidity() ) {
                contactForm.reportValidity();
                return;
            }

            // Show success screen.
            contactForm.hidden     = true;
            contactSuccess.hidden  = false;
        } );
    }
    /* ------------------------------------------------------------------
       Table of Contents — Auto-generate from article H2/H3 headings
       ------------------------------------------------------------------ */

    var tocList = document.querySelector( '.vagra-toc__list' );
    var articleBody = document.querySelector( '.vagra-article-body' );

    if ( tocList && articleBody ) {
        var headings = articleBody.querySelectorAll( 'h2, h3' );
        if ( headings.length === 0 ) {
            var tocNav = document.querySelector( '.vagra-toc' );
            if ( tocNav ) tocNav.classList.add( 'vagra-toc--empty' );
        } else {
            var currentOl = tocList;
            var lastLevel = 2;

            headings.forEach( function ( heading, i ) {
                // Ensure heading has an id for anchor linking.
                if ( ! heading.id ) {
                    heading.id = 'section-' + ( i + 1 );
                }

                var level = parseInt( heading.tagName.charAt( 1 ), 10 );
                var li = document.createElement( 'li' );
                var a  = document.createElement( 'a' );
                a.href = '#' + heading.id;
                a.textContent = heading.textContent;

                if ( level === 3 && lastLevel === 2 ) {
                    // Nest under previous H2 li.
                    var subOl = document.createElement( 'ol' );
                    subOl.className = 'vagra-toc__sub';
                    var parentLi = currentOl.lastElementChild;
                    if ( parentLi ) {
                        parentLi.appendChild( subOl );
                        currentOl = subOl;
                    }
                } else if ( level === 2 && lastLevel === 3 ) {
                    currentOl = tocList;
                }

                li.appendChild( a );
                currentOl.appendChild( li );
                lastLevel = level;
            } );
        }

        // Toggle button.
        var tocToggle = document.querySelector( '.vagra-toc__toggle' );
        if ( tocToggle ) {
            tocToggle.addEventListener( 'click', function () {
                var expanded = tocToggle.getAttribute( 'aria-expanded' ) === 'true';
                tocToggle.setAttribute( 'aria-expanded', String( ! expanded ) );
            } );
        }
    }

    /* ------------------------------------------------------------------
       Copy Link Button — Share bar
       ------------------------------------------------------------------ */

    var copyBtn = document.querySelector( '.vagra-share__btn--copy' );
    if ( copyBtn ) {
        copyBtn.addEventListener( 'click', function () {
            navigator.clipboard.writeText( window.location.href ).then( function () {
                copyBtn.classList.add( 'is-copied' );
                setTimeout( function () {
                    copyBtn.classList.remove( 'is-copied' );
                }, 2000 );
            } );
        } );
    }
} )();
