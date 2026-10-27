// NAVEGACIÓN ENTRE PÁGINAS DEL PANEL (RUTAS LARAVEL)
function switchTab(tab) {
    const pages = {
        'dashboard': '/dashboard',
        'acopio': '/acopio',
        'vecinos': '/vecinos',
        'rutas': '/rutas',
        'reportes': '/reportes'
    };
    window.location.href = pages[tab] || '/dashboard';
}

function toggleMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;
    
    if (sidebar.classList.contains('hidden')) {
        sidebar.classList.remove('hidden');
        sidebar.classList.add('flex');
    } else {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('flex');
    }
}

function showAppScreen() {
    // Redirección de seguridad en Laravel si está en vista auth
    if (document.getElementById('auth-view')) { 
        window.location.href = '/dashboard'; 
        return; 
    }

    // Actualizar datos del usuario activo con optional chaining para evitar errores si no existen en la vista
    const userName = document.getElementById('user-display-name');
    const userRole = document.getElementById('user-display-role');
    const userAvatar = document.getElementById('user-avatar');

    if (userName) userName.innerText = typeof currentUser !== 'undefined' ? (currentUser.name || 'EcoColaborador') : 'EcoColaborador';
    if (userRole) userRole.innerText = typeof currentUser !== 'undefined' ? (currentUser.role || 'Vecino') : 'Vecino';

    if (userAvatar) {
        const name = typeof currentUser !== 'undefined' ? (currentUser.name || 'U') : 'U';
        const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        userAvatar.innerText = initials;
    }

    // Renderizar la vista propia de cada página según la ruta activa
    const page = document.body.getAttribute('data-page');
    if (page === 'dashboard') {
        if (typeof renderDashboardCriticals === 'function') renderDashboardCriticals();
        if (typeof renderDashboardStats === 'function') renderDashboardStats();
        if (typeof initChart === 'function') initChart();
    } else if (page === 'acopio') {
        if (typeof renderAcopioTable === 'function') renderAcopioTable();
    } else if (page === 'vecinos') {
        if (typeof renderVecinosRanking === 'function') renderVecinosRanking();
    }
}