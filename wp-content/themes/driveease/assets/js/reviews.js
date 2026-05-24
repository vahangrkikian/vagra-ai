/**
 * DriveEase — Reviews interaction script.
 *
 * Star-picker widget and AJAX review submission.
 *
 * @package DriveEase
 * @since 1.0.2
 */
(function () {
	'use strict';

	/* ── Star Picker ─────────────────────────────── */
	var picker = document.querySelector('.star-picker');
	var hiddenInput = document.getElementById('driveease-rating-input');

	if (picker && hiddenInput) {
		var stars = picker.querySelectorAll('.star-pick');

		function setRating(val) {
			hiddenInput.value = val;
			stars.forEach(function (s, idx) {
				s.classList.toggle('active', idx < val);
			});
		}

		stars.forEach(function (star, idx) {
			star.addEventListener('mouseenter', function () {
				stars.forEach(function (s, i) {
					s.classList.toggle('hovered', i <= idx);
				});
			});

			star.addEventListener('click', function () {
				setRating(idx + 1);
			});
		});

		picker.addEventListener('mouseleave', function () {
			stars.forEach(function (s) {
				s.classList.remove('hovered');
			});
		});
	}

	/* ── AJAX Submit ─────────────────────────────── */
	var form = document.getElementById('driveease-review-form');
	if (form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();

			var btn = form.querySelector('button[type="submit"]');
			var notice = document.getElementById('review-form-notice');
			var rating = hiddenInput ? hiddenInput.value : 0;
			var comment = form.querySelector('textarea[name="review_comment"]').value.trim();

			if (!rating || rating < 1) {
				showNotice(notice, 'Please select a star rating.', 'error');
				return;
			}
			if (!comment) {
				showNotice(notice, 'Please write a review comment.', 'error');
				return;
			}

			btn.disabled = true;
			btn.textContent = btn.dataset.loading || 'Submitting…';

			var data = new FormData();
			data.append('action', 'driveease_submit_review');
			data.append('nonce', form.dataset.nonce);
			data.append('car_id', form.dataset.carId);
			data.append('driveease_rating', rating);
			data.append('comment', comment);

			fetch(form.dataset.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: data,
			})
				.then(function (r) { return r.json(); })
				.then(function (resp) {
					if (resp.success) {
						showNotice(notice, resp.data.message, 'success');
						form.querySelector('textarea').value = '';
						if (hiddenInput) hiddenInput.value = '0';
						if (picker) {
							picker.querySelectorAll('.star-pick').forEach(function (s) {
								s.classList.remove('active');
							});
						}
						btn.textContent = 'Review Submitted';
						// Reload after brief delay so the new review appears.
						setTimeout(function () { location.reload(); }, 1200);
					} else {
						showNotice(notice, resp.data.message || 'Something went wrong.', 'error');
						btn.disabled = false;
						btn.textContent = btn.dataset.label || 'Submit Review';
					}
				})
				.catch(function () {
					showNotice(notice, 'Network error. Please try again.', 'error');
					btn.disabled = false;
					btn.textContent = btn.dataset.label || 'Submit Review';
				});
		});
	}

	function showNotice(el, msg, type) {
		if (!el) return;
		el.textContent = msg;
		el.className = 'review-form-notice ' + type;
		el.style.display = 'block';
	}
})();
