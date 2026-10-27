// Control de acceso entre páginas (equivale al cambio AUTH / APP del original)
(function () {
    var logged = null;
    try { logged = JSON.parse(localStorage.getItem('ecobarrio_lo_user')) || null; } catch (e) {}
    var isAuthPage = document.currentScript.getAttribute('data-page') === 'auth';
    if (isAuthPage && logged) window.location.replace('dashboard.html');
    if (!isAuthPage && !logged) window.location.replace('index.html');
})();
