/**
 * Meridian Room Filters JS
 * Category tab filtering + sort via REST API
 */
(function () {
  'use strict';

  var config = window.meridianFilters || {};
  var tabs = document.querySelectorAll('#room-filter-tabs .tab');
  var sortSelect = document.getElementById('room-sort');
  var grid = document.getElementById('rooms-grid');

  if (!tabs.length || !grid) return;

  var activeCat = '';
  var activeSort = 'featured';

  // Detect pre-selected category
  tabs.forEach(function (tab) {
    if (tab.classList.contains('tab--active')) {
      activeCat = tab.dataset.cat || '';
    }
  });

  function fetchRooms() {
    var url = config.restUrl + 'meridian/v1/rooms?sort=' + encodeURIComponent(activeSort);
    if (activeCat) url += '&room_cat=' + encodeURIComponent(activeCat);

    grid.style.opacity = '0.5';

    fetch(url, {
      headers: { 'X-WP-Nonce': config.nonce }
    })
    .then(function (r) { return r.json(); })
    .then(function (rooms) {
      grid.style.opacity = '1';

      if (!rooms || !rooms.length) {
        grid.innerHTML = '<div class="empty">No rooms in this category right now. Try another.</div>';
        return;
      }

      var html = '';
      rooms.forEach(function (room, i) {
        html += '<a href="' + escHtml(room.permalink) + '" class="room-card" data-reveal style="--d: ' + (i * 80) + 'ms">';
        html += '<div class="room-card__media">';
        if (room.thumbnail) {
          html += '<img src="' + escHtml(room.thumbnail) + '" alt="' + escHtml(room.title) + '" loading="lazy" />';
        } else {
          html += '<div style="width:100%;height:100%;background:var(--navy-800);display:flex;align-items:center;justify-content:center;color:var(--gold-soft);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;">' + escHtml(room.title) + '</div>';
        }
        if (room.badge) {
          html += '<span class="room-card__badge">' + escHtml(room.badge) + '</span>';
        }
        if (room.price) {
          html += '<div class="room-card__price"><span class="room-card__price-from">From</span><span class="room-card__price-num">$' + Number(room.price).toLocaleString() + '</span><span class="room-card__price-night">/ night</span></div>';
        }
        html += '</div>';
        html += '<div class="room-card__body">';
        if (room.category) html += '<div class="eyebrow">' + escHtml(room.category) + '</div>';
        html += '<h3 class="room-card__name">' + escHtml(room.title) + '</h3>';
        if (room.tagline) html += '<p class="room-card__tag">' + escHtml(room.tagline) + '</p>';
        html += '<div class="room-card__specs">';
        if (room.guests) html += '<span>' + iconSvg('guests') + ' ' + escHtml(room.guests) + ' guests</span>';
        if (room.size) html += '<span>' + iconSvg('ruler') + ' ' + escHtml(room.size) + ' m²</span>';
        if (room.bed) html += '<span>' + iconSvg('bed') + ' ' + escHtml(room.bed) + '</span>';
        if (room.view) html += '<span>' + iconSvg('eye') + ' ' + escHtml(room.view) + '</span>';
        html += '</div>';
        html += '<span class="room-card__cta">View Details ' + iconSvg('arrow-right') + '</span>';
        html += '</div></a>';
      });

      grid.innerHTML = html;

      // Re-trigger scroll reveals
      grid.querySelectorAll('[data-reveal]').forEach(function (el) {
        el.classList.add('is-visible');
      });
    })
    .catch(function () {
      grid.style.opacity = '1';
    });
  }

  // Tab clicks
  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      activeCat = tab.dataset.cat || '';
      tabs.forEach(function (t) { t.classList.remove('tab--active'); t.setAttribute('aria-selected', 'false'); });
      tab.classList.add('tab--active');
      tab.setAttribute('aria-selected', 'true');
      fetchRooms();

      // Update URL
      var url = new URL(window.location);
      if (activeCat) {
        url.searchParams.set('room_cat', activeCat);
      } else {
        url.searchParams.delete('room_cat');
      }
      history.replaceState(null, '', url);
    });
  });

  // Sort change
  if (sortSelect) {
    sortSelect.addEventListener('change', function () {
      activeSort = this.value;
      fetchRooms();
    });
  }

  // Inline SVG icons for JS-rendered cards
  function iconSvg(name) {
    var p = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">';
    switch (name) {
      case 'guests': return p + '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16 11a3 3 0 1 0 0-6"/><path d="M22 20a5 5 0 0 0-5-5"/></svg>';
      case 'ruler': return p + '<path d="M3 14 14 3l7 7L10 21Z"/><path d="m7 12 2 2m1-5 2 2m2-5 2 2"/></svg>';
      case 'bed': return p + '<path d="M3 18V8m18 10v-5a3 3 0 0 0-3-3H3"/><path d="M3 18h18"/><circle cx="7.5" cy="12.5" r="1.5"/></svg>';
      case 'eye': return p + '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>';
      case 'arrow-right': return p + '<path d="M5 12h14m-5-6 6 6-6 6"/></svg>';
      default: return '';
    }
  }

  function escHtml(str) {
    var div = document.createElement('div');
    div.textContent = str || '';
    return div.innerHTML;
  }

})();
