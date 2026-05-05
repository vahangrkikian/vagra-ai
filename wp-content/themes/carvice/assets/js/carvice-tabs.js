/**
 * Tab switching for registration page.
 *
 * @package Carvice
 */
(function () {
    document.querySelectorAll('.carvice-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            var target = this.getAttribute('data-tab');

            document.querySelectorAll('.carvice-tab').forEach(function (t) {
                t.classList.remove('active');
            });
            this.classList.add('active');

            document.querySelectorAll('.carvice-tab-panel').forEach(function (panel) {
                panel.classList.remove('active');
            });

            var panel = document.getElementById('tab-' + target);
            if (panel) {
                panel.classList.add('active');
            }
        });
    });
})();
