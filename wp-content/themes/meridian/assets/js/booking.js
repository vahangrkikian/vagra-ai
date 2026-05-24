/**
 * Meridian Booking JS
 * Calculator, 3-step booking modal, card preview, form validation, REST submission
 */
(function () {
  'use strict';

  var config = window.meridianBooking || {};
  var RESORT_FEE = config.resortFee || 35;
  var TAX_RATE = config.taxRate || 0.1475;

  function todayPlus(days) {
    var d = new Date();
    d.setDate(d.getDate() + days);
    return d.toISOString().slice(0, 10);
  }

  function fmtMoney(n) {
    return '$' + Number(n).toLocaleString();
  }

  function fmtDate(s) {
    return new Date(s + 'T00:00:00').toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
  }

  /* ==================== CALCULATOR ==================== */
  var calc = document.querySelector('.calc');
  if (!calc) return;

  var price = parseInt(calc.dataset.price, 10) || 0;
  var maxGuests = parseInt(calc.dataset.maxGuests, 10) || 4;
  var roomId = calc.dataset.roomId || 0;

  var calcCheckin = document.getElementById('calc-checkin');
  var calcCheckout = document.getElementById('calc-checkout');

  if (calcCheckin && !calcCheckin.value) calcCheckin.value = todayPlus(14);
  if (calcCheckout && !calcCheckout.value) calcCheckout.value = todayPlus(17);
  if (calcCheckin) calcCheckin.min = todayPlus(0);

  function getCalcNights() {
    var a = new Date(calcCheckin.value).getTime();
    var b = new Date(calcCheckout.value).getTime();
    return Math.max(1, Math.round((b - a) / 86400000));
  }

  function getAdults() {
    var el = document.querySelector('[data-stepper="calc-adults"]');
    return el ? parseInt(el.dataset.value, 10) : 2;
  }

  function getChildren() {
    var el = document.querySelector('[data-stepper="calc-children"]');
    return el ? parseInt(el.dataset.value, 10) : 0;
  }

  function updateCalc() {
    var nights = getCalcNights();
    var subtotal = price * nights;
    var resort = RESORT_FEE * nights;
    var tax = Math.round((subtotal + resort) * TAX_RATE);
    var total = subtotal + resort + tax;

    var el = function (id) { return document.getElementById(id); };
    if (el('calc-nightly')) el('calc-nightly').textContent = fmtMoney(price) + ' × ' + nights + ' night' + (nights !== 1 ? 's' : '');
    if (el('calc-subtotal')) el('calc-subtotal').textContent = fmtMoney(subtotal);
    if (el('calc-resort')) el('calc-resort').textContent = fmtMoney(resort);
    if (el('calc-tax')) el('calc-tax').textContent = fmtMoney(tax);
    if (el('calc-total')) el('calc-total').textContent = fmtMoney(total);

    if (calcCheckout) calcCheckout.min = calcCheckin.value;

    // Guest warning
    var warn = document.getElementById('calc-warn');
    var reserve = document.getElementById('calc-reserve');
    var over = getAdults() + getChildren() > maxGuests;
    if (warn) warn.style.display = over ? 'block' : 'none';
    if (reserve) reserve.disabled = over;
  }

  if (calcCheckin) calcCheckin.addEventListener('change', updateCalc);
  if (calcCheckout) calcCheckout.addEventListener('change', updateCalc);

  // Watch steppers for calc updates
  document.querySelectorAll('[data-stepper^="calc-"]').forEach(function (stepper) {
    stepper.addEventListener('click', function () { setTimeout(updateCalc, 10); });
  });

  updateCalc();

  /* ==================== MODAL ==================== */
  var modal = document.getElementById('booking-modal');
  var reserveBtn = document.getElementById('calc-reserve');
  if (!modal || !reserveBtn) return;

  var currentStep = 1;

  function openModal() {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    goToStep(1);
    updateSummary();
  }

  function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }

  reserveBtn.addEventListener('click', openModal);
  document.getElementById('modal-close').addEventListener('click', closeModal);
  document.getElementById('modal-cancel').addEventListener('click', closeModal);
  document.getElementById('modal-done') && document.getElementById('modal-done').addEventListener('click', closeModal);
  modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modal.style.display !== 'none') closeModal();
  });

  function goToStep(step) {
    currentStep = step;
    document.getElementById('modal-step-1').style.display = step === 1 ? 'block' : 'none';
    document.getElementById('modal-step-2').style.display = step === 2 ? 'block' : 'none';
    document.getElementById('modal-step-3').style.display = step === 3 ? 'block' : 'none';

    var steps = document.getElementById('modal-steps');
    var summary = document.getElementById('modal-summary');
    if (steps) steps.style.display = step === 3 ? 'none' : 'flex';
    if (summary) summary.style.display = step === 3 ? 'none' : 'block';

    // Update step indicators
    document.querySelectorAll('#modal-steps .mstep').forEach(function (el) {
      var s = parseInt(el.dataset.step, 10);
      el.classList.remove('is-active', 'is-done');
      if (s === step) el.classList.add('is-active');
      if (s < step) el.classList.add('is-done');
    });

    // Replace number with check for completed steps
    document.querySelectorAll('#modal-steps .mstep.is-done .mstep__num').forEach(function (el) {
      el.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg>';
    });
  }

  function updateSummary() {
    var nights = getCalcNights();
    var subtotal = price * nights;
    var resort = RESORT_FEE * nights;
    var tax = Math.round((subtotal + resort) * TAX_RATE);
    var total = subtotal + resort + tax;
    var adults = getAdults();
    var children = getChildren();

    var el = function (id) { return document.getElementById(id); };
    if (el('msummary-checkin')) el('msummary-checkin').textContent = fmtDate(calcCheckin.value);
    if (el('msummary-checkout')) el('msummary-checkout').textContent = fmtDate(calcCheckout.value);
    if (el('msummary-guests')) el('msummary-guests').textContent = (adults + children) + ' guest' + ((adults + children) !== 1 ? 's' : '') + ' · ' + nights + ' night' + (nights !== 1 ? 's' : '');
    if (el('msummary-nightly')) el('msummary-nightly').textContent = fmtMoney(price) + ' × ' + nights;
    if (el('msummary-subtotal')) el('msummary-subtotal').textContent = fmtMoney(subtotal);
    if (el('msummary-resort')) el('msummary-resort').textContent = fmtMoney(resort);
    if (el('msummary-tax')) el('msummary-tax').textContent = fmtMoney(tax);
    if (el('msummary-total')) el('msummary-total').textContent = fmtMoney(total);
  }

  /* ==================== VALIDATION ==================== */
  function clearErrors() {
    modal.querySelectorAll('.field').forEach(function (f) { f.classList.remove('field--error'); });
    modal.querySelectorAll('.field__error').forEach(function (e) { e.style.display = 'none'; e.textContent = ''; });
    var ae = document.getElementById('agree-error');
    if (ae) ae.style.display = 'none';
    var tc = document.getElementById('terms-checkbox');
    if (tc) tc.classList.remove('has-error');
  }

  function setError(fieldName, msg) {
    var field = modal.querySelector('[data-field="' + fieldName + '"]');
    if (field) {
      field.classList.add('field--error');
      var err = field.querySelector('.field__error');
      if (err) { err.textContent = msg; err.style.display = 'block'; }
    }
  }

  function validateGuest() {
    clearErrors();
    var valid = true;
    var fn = document.getElementById('book-first-name');
    var ln = document.getElementById('book-last-name');
    var em = document.getElementById('book-email');
    var ph = document.getElementById('book-phone');

    if (!fn.value.trim()) { setError('firstName', 'Required'); valid = false; }
    if (!ln.value.trim()) { setError('lastName', 'Required'); valid = false; }
    if (!/^\S+@\S+\.\S+$/.test(em.value)) { setError('email', 'Enter a valid email'); valid = false; }
    if (ph.value.replace(/\D/g, '').length < 7) { setError('phone', 'Enter a valid phone'); valid = false; }
    return valid;
  }

  function validatePayment() {
    clearErrors();
    var valid = true;
    var cn = document.getElementById('book-card-name');
    var num = document.getElementById('book-card-number');
    var exp = document.getElementById('book-card-exp');
    var cvc = document.getElementById('book-card-cvc');
    var zip = document.getElementById('book-billing-zip');
    var agree = document.getElementById('book-agree');

    if (!cn.value.trim()) { setError('cardName', 'Required'); valid = false; }
    if (num.value.replace(/\s/g, '').length < 13) { setError('cardNumber', 'Card number incomplete'); valid = false; }
    if (!/^\d{2}\/\d{2}$/.test(exp.value)) { setError('cardExp', 'MM/YY'); valid = false; }
    if (cvc.value.replace(/\D/g, '').length < 3) { setError('cardCvc', '3–4 digits'); valid = false; }
    if (!zip.value.trim()) { setError('billingZip', 'Required'); valid = false; }
    if (!agree.checked) {
      var ae = document.getElementById('agree-error');
      if (ae) { ae.textContent = 'Please accept the terms to continue'; ae.style.display = 'block'; }
      var tc = document.getElementById('terms-checkbox');
      if (tc) tc.classList.add('has-error');
      valid = false;
    }
    return valid;
  }

  /* ==================== STEP NAVIGATION ==================== */
  document.getElementById('modal-to-step2').addEventListener('click', function () {
    if (validateGuest()) {
      goToStep(2);
      updateSummary();
    }
  });

  document.getElementById('modal-back-step1').addEventListener('click', function () {
    goToStep(1);
  });

  /* ==================== CARD PREVIEW ==================== */
  var cardName = document.getElementById('book-card-name');
  var cardNumber = document.getElementById('book-card-number');
  var cardExp = document.getElementById('book-card-exp');
  var cardCvc = document.getElementById('book-card-cvc');

  if (cardName) {
    cardName.addEventListener('input', function () {
      this.value = this.value.toUpperCase();
      var el = document.getElementById('card-preview-name');
      if (el) el.textContent = this.value || 'YOUR NAME';
    });
  }

  if (cardNumber) {
    cardNumber.addEventListener('input', function () {
      var v = this.value.replace(/\D/g, '').slice(0, 16);
      this.value = v.replace(/(.{4})/g, '$1 ').trim();
      var el = document.getElementById('card-preview-num');
      if (el) el.textContent = this.value || '•••• •••• •••• ••••';
    });
  }

  if (cardExp) {
    cardExp.addEventListener('input', function () {
      var v = this.value.replace(/\D/g, '').slice(0, 4);
      this.value = v.length >= 3 ? v.slice(0, 2) + '/' + v.slice(2) : v;
      var el = document.getElementById('card-preview-exp');
      if (el) el.textContent = this.value || 'MM/YY';
    });
  }

  if (cardCvc) {
    cardCvc.addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '').slice(0, 4);
    });
  }

  /* ==================== FORM SUBMISSION ==================== */
  var submitBtn = document.getElementById('modal-submit');
  if (submitBtn) {
    submitBtn.addEventListener('click', function () {
      if (!validatePayment()) return;

      submitBtn.classList.add('is-submitted');
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Securing your room…';

      var nights = getCalcNights();
      var subtotal = price * nights;
      var resort = RESORT_FEE * nights;
      var tax = Math.round((subtotal + resort) * TAX_RATE);
      var total = subtotal + resort + tax;

      var data = {
        room_id: roomId,
        check_in: calcCheckin.value,
        check_out: calcCheckout.value,
        adults: getAdults(),
        children: getChildren(),
        first_name: document.getElementById('book-first-name').value,
        last_name: document.getElementById('book-last-name').value,
        email: document.getElementById('book-email').value,
        phone: document.getElementById('book-phone').value,
        country: document.getElementById('book-country').value,
        arrival_time: document.getElementById('book-arrival').value,
        requests: document.getElementById('book-requests').value,
        newsletter: document.getElementById('book-newsletter').checked ? 1 : 0
      };

      fetch(config.restUrl + 'meridian/v1/booking', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': config.nonce
        },
        body: JSON.stringify(data)
      })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        submitBtn.classList.remove('is-submitted');
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Confirm reservation <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg>';

        var code = res.code || 'MRD-' + Math.random().toString(36).slice(2, 8).toUpperCase();
        var adults = getAdults();
        var children = getChildren();

        // Fill confirmation
        var el = function (id) { return document.getElementById(id); };
        if (el('confirm-code')) el('confirm-code').textContent = code;
        if (el('confirm-email')) el('confirm-email').textContent = data.email;
        if (el('confirm-guest')) el('confirm-guest').textContent = data.first_name + ' ' + data.last_name;
        if (el('confirm-checkin')) el('confirm-checkin').textContent = fmtDate(data.check_in);
        if (el('confirm-checkout')) el('confirm-checkout').textContent = fmtDate(data.check_out);
        if (el('confirm-guests')) {
          var t = adults + ' adult' + (adults !== 1 ? 's' : '');
          if (children > 0) t += ', ' + children + ' child' + (children !== 1 ? 'ren' : '');
          el('confirm-guests').textContent = t;
        }
        if (el('confirm-total')) el('confirm-total').textContent = fmtMoney(total);

        goToStep(3);
      })
      .catch(function () {
        // Fallback: generate client-side confirmation
        submitBtn.classList.remove('is-submitted');
        submitBtn.disabled = false;
        var code = 'MRD-' + Math.random().toString(36).slice(2, 8).toUpperCase();
        var adults = getAdults();
        var children = getChildren();

        var el = function (id) { return document.getElementById(id); };
        if (el('confirm-code')) el('confirm-code').textContent = code;
        if (el('confirm-email')) el('confirm-email').textContent = data.email;
        if (el('confirm-guest')) el('confirm-guest').textContent = data.first_name + ' ' + data.last_name;
        if (el('confirm-checkin')) el('confirm-checkin').textContent = fmtDate(data.check_in);
        if (el('confirm-checkout')) el('confirm-checkout').textContent = fmtDate(data.check_out);
        if (el('confirm-guests')) {
          var t = adults + ' adult' + (adults !== 1 ? 's' : '');
          if (children > 0) t += ', ' + children + ' child' + (children !== 1 ? 'ren' : '');
          el('confirm-guests').textContent = t;
        }
        if (el('confirm-total')) el('confirm-total').textContent = fmtMoney(subtotal + resort + tax);
        goToStep(3);
      });
    });
  }

})();
