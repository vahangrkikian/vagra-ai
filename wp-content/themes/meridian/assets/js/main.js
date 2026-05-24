/**
 * Meridian Main JS
 * Nav scroll, mobile menu, gallery lightbox, scroll reveals, booking widget, room detail gallery, newsletter
 */
(function () {
  'use strict';

  /* ==================== HELPERS ==================== */
  function todayPlus(days) {
    var d = new Date();
    d.setDate(d.getDate() + days);
    return d.toISOString().slice(0, 10);
  }

  function fmtMoney(n) {
    return '$' + Number(n).toLocaleString();
  }

  /* ==================== NAV SCROLL ==================== */
  var nav = document.querySelector('.nav');
  if (nav && document.body.classList.contains('home')) {
    var onScroll = function () {
      if (window.scrollY > 40) {
        nav.classList.remove('nav--transparent');
        nav.classList.add('nav--solid');
      } else {
        nav.classList.remove('nav--solid');
        nav.classList.add('nav--transparent');
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ==================== MOBILE HAMBURGER ==================== */
  var burger = document.querySelector('.nav__burger');
  if (burger) {
    burger.addEventListener('click', function () {
      nav.classList.toggle('nav--open');
      var expanded = nav.classList.contains('nav--open');
      burger.setAttribute('aria-expanded', expanded);
    });
    // Close mobile nav when a link is clicked
    document.querySelectorAll('.nav__mobile a').forEach(function (a) {
      a.addEventListener('click', function () {
        nav.classList.remove('nav--open');
        burger.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* ==================== SCROLL REVEAL ==================== */
  var revealEls = document.querySelectorAll('[data-reveal]');
  if (revealEls.length && 'IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          e.target.classList.add('is-visible');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.12 });
    revealEls.forEach(function (el) { io.observe(el); });
  }

  /* ==================== BOOKING WIDGET (hero) ==================== */
  var bookingWidget = document.getElementById('meridian-booking-widget');
  if (bookingWidget) {
    var checkinInput = document.getElementById('booking-checkin');
    var checkoutInput = document.getElementById('booking-checkout');
    var nightsSpan = document.getElementById('booking-nights');

    // Set default dates
    if (checkinInput && !checkinInput.value) checkinInput.value = todayPlus(7);
    if (checkoutInput && !checkoutInput.value) checkoutInput.value = todayPlus(10);
    if (checkinInput) checkinInput.min = todayPlus(0);

    function updateNights() {
      if (!checkinInput || !checkoutInput) return;
      var a = new Date(checkinInput.value).getTime();
      var b = new Date(checkoutInput.value).getTime();
      var n = Math.max(1, Math.round((b - a) / 86400000));
      if (nightsSpan) nightsSpan.textContent = n + (n === 1 ? ' night' : ' nights');
      checkoutInput.min = checkinInput.value;
    }
    if (checkinInput) checkinInput.addEventListener('change', updateNights);
    if (checkoutInput) checkoutInput.addEventListener('change', updateNights);
    updateNights();

    // Guests dropdown
    var guestsField = document.getElementById('booking-guests-field');
    var guestsToggle = document.getElementById('booking-guests-toggle');
    var guestsPop = document.getElementById('booking-guests-pop');
    var guestsText = document.getElementById('booking-guests-text');

    if (guestsToggle && guestsPop) {
      guestsToggle.addEventListener('click', function () {
        guestsPop.style.display = guestsPop.style.display === 'none' ? 'block' : 'none';
      });
      document.addEventListener('mousedown', function (e) {
        if (guestsField && !guestsField.contains(e.target)) {
          guestsPop.style.display = 'none';
        }
      });
    }
  }

  /* ==================== STEPPER CONTROLS (generic) ==================== */
  document.querySelectorAll('[data-stepper]').forEach(function (stepper) {
    var val = parseInt(stepper.dataset.value, 10) || 0;
    var min = parseInt(stepper.dataset.min, 10) || 0;
    var max = parseInt(stepper.dataset.max, 10) || 10;
    var valSpan = stepper.querySelector('.stepper-val');
    var decBtn = stepper.querySelector('.stepper-dec');
    var incBtn = stepper.querySelector('.stepper-inc');

    function update() {
      if (valSpan) valSpan.textContent = val;
      if (decBtn) decBtn.disabled = val <= min;
      if (incBtn) incBtn.disabled = val >= max;
      stepper.dataset.value = val;

      // Update hidden inputs for booking widget
      var name = stepper.dataset.stepper;
      if (name === 'adults') {
        var h = document.getElementById('booking-adults');
        if (h) h.value = val;
      }
      if (name === 'children') {
        var h2 = document.getElementById('booking-children');
        if (h2) h2.value = val;
      }

      // Update guests text
      var adultsEl = document.querySelector('[data-stepper="adults"]');
      var childrenEl = document.querySelector('[data-stepper="children"]');
      if (adultsEl && childrenEl && guestsText) {
        var total = parseInt(adultsEl.dataset.value, 10) + parseInt(childrenEl.dataset.value, 10);
        guestsText.textContent = total + (total === 1 ? ' guest' : ' guests');
      }
    }

    if (decBtn) decBtn.addEventListener('click', function () { if (val > min) { val--; update(); } });
    if (incBtn) incBtn.addEventListener('click', function () { if (val < max) { val++; update(); } });
    update();
  });

  /* ==================== GALLERY LIGHTBOX (front page) ==================== */
  var galleryEl = document.getElementById('meridian-gallery');
  if (galleryEl) {
    var lightbox = null;
    var tiles = galleryEl.querySelectorAll('.gallery__tile');
    var currentIndex = 0;
    var tileImages = [];

    tiles.forEach(function (tile, i) {
      var img = tile.querySelector('img');
      tileImages.push({
        src: img ? img.src : '',
        caption: tile.dataset.caption || ''
      });
    });

    function openLightbox(index) {
      currentIndex = index;
      if (!lightbox) {
        lightbox = document.createElement('div');
        lightbox.className = 'lightbox';
        lightbox.innerHTML =
          '<button class="lightbox__close" aria-label="Close"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6l12 12M18 6 6 18"/></svg></button>' +
          '<button class="lightbox__nav lightbox__nav--prev" aria-label="Previous"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg></button>' +
          '<div class="lightbox__frame"><img src="" alt="" style="width:100%;height:100%;object-fit:cover;" /><div class="lightbox__caption"></div></div>' +
          '<button class="lightbox__nav lightbox__nav--next" aria-label="Next"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg></button>';
        document.body.appendChild(lightbox);

        lightbox.querySelector('.lightbox__close').addEventListener('click', closeLightbox);
        lightbox.querySelector('.lightbox__nav--prev').addEventListener('click', function (e) { e.stopPropagation(); navigate(-1); });
        lightbox.querySelector('.lightbox__nav--next').addEventListener('click', function (e) { e.stopPropagation(); navigate(1); });
        lightbox.querySelector('.lightbox__frame').addEventListener('click', function (e) { e.stopPropagation(); });
        lightbox.addEventListener('click', closeLightbox);
      }
      updateLightbox();
      lightbox.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
      if (lightbox) lightbox.style.display = 'none';
      document.body.style.overflow = '';
    }

    function navigate(dir) {
      currentIndex = (currentIndex + dir + tileImages.length) % tileImages.length;
      updateLightbox();
    }

    function updateLightbox() {
      if (!lightbox) return;
      var img = lightbox.querySelector('.lightbox__frame img');
      var caption = lightbox.querySelector('.lightbox__caption');
      var data = tileImages[currentIndex];
      if (img) img.src = data.src || '';
      if (caption) caption.textContent = data.caption;
    }

    tiles.forEach(function (tile, i) {
      tile.addEventListener('click', function () { openLightbox(i); });
    });

    document.addEventListener('keydown', function (e) {
      if (!lightbox || lightbox.style.display === 'none') return;
      if (e.key === 'Escape') closeLightbox();
      if (e.key === 'ArrowLeft') navigate(-1);
      if (e.key === 'ArrowRight') navigate(1);
    });
  }

  /* ==================== ROOM DETAIL GALLERY ==================== */
  var roomHero = document.getElementById('room-hero-img');
  var roomThumbs = document.getElementById('room-thumbs');
  var roomLightbox = document.getElementById('room-lightbox');

  if (roomHero && roomThumbs) {
    var thumbs = roomThumbs.querySelectorAll('.thumb');
    var activeThumb = 0;
    var roomImages = [];
    thumbs.forEach(function (t) {
      roomImages.push(t.dataset.full);
    });

    thumbs.forEach(function (thumb, i) {
      thumb.addEventListener('click', function () {
        activeThumb = i;
        roomHero.src = thumb.dataset.full;
        thumbs.forEach(function (t) { t.classList.remove('thumb--active'); });
        thumb.classList.add('thumb--active');
      });
    });

    // Open lightbox from hero
    var heroBtn = document.getElementById('room-hero-image');
    if (heroBtn && roomLightbox) {
      heroBtn.addEventListener('click', function () {
        var lbImg = document.getElementById('room-lightbox-img');
        var lbCaption = document.getElementById('room-lightbox-caption');
        if (lbImg) lbImg.src = roomImages[activeThumb] || roomHero.src;
        if (lbCaption) lbCaption.textContent = document.title + ' · Photo ' + (activeThumb + 1) + ' of ' + roomImages.length;
        roomLightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
      });

      roomLightbox.querySelector('.lightbox__close').addEventListener('click', function () {
        roomLightbox.style.display = 'none';
        document.body.style.overflow = '';
      });
      roomLightbox.addEventListener('click', function (e) {
        if (e.target === roomLightbox) {
          roomLightbox.style.display = 'none';
          document.body.style.overflow = '';
        }
      });
      roomLightbox.querySelector('.lightbox__nav--prev').addEventListener('click', function (e) {
        e.stopPropagation();
        activeThumb = (activeThumb - 1 + roomImages.length) % roomImages.length;
        var lbImg = document.getElementById('room-lightbox-img');
        var lbCaption = document.getElementById('room-lightbox-caption');
        if (lbImg) lbImg.src = roomImages[activeThumb];
        if (lbCaption) lbCaption.textContent = document.title + ' · Photo ' + (activeThumb + 1) + ' of ' + roomImages.length;
        roomHero.src = roomImages[activeThumb];
        thumbs.forEach(function (t) { t.classList.remove('thumb--active'); });
        if (thumbs[activeThumb]) thumbs[activeThumb].classList.add('thumb--active');
      });
      roomLightbox.querySelector('.lightbox__nav--next').addEventListener('click', function (e) {
        e.stopPropagation();
        activeThumb = (activeThumb + 1) % roomImages.length;
        var lbImg = document.getElementById('room-lightbox-img');
        var lbCaption = document.getElementById('room-lightbox-caption');
        if (lbImg) lbImg.src = roomImages[activeThumb];
        if (lbCaption) lbCaption.textContent = document.title + ' · Photo ' + (activeThumb + 1) + ' of ' + roomImages.length;
        roomHero.src = roomImages[activeThumb];
        thumbs.forEach(function (t) { t.classList.remove('thumb--active'); });
        if (thumbs[activeThumb]) thumbs[activeThumb].classList.add('thumb--active');
      });

      document.addEventListener('keydown', function (e) {
        if (roomLightbox.style.display === 'none') return;
        if (e.key === 'Escape') {
          roomLightbox.style.display = 'none';
          document.body.style.overflow = '';
        }
      });
    }
  }

  /* ==================== NEWSLETTER FORM ==================== */
  var newsForm = document.querySelector('.footer__news');
  if (newsForm) {
    newsForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var input = newsForm.querySelector('input[type="email"]');
      if (input && input.value.includes('@')) {
        var okEl = newsForm.querySelector('.footer__news-ok');
        if (!okEl) {
          okEl = document.createElement('div');
          okEl.className = 'footer__news-ok';
          okEl.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Subscribed. Thank you.';
          newsForm.appendChild(okEl);
        }
        input.value = '';
      }
    });
  }

})();
