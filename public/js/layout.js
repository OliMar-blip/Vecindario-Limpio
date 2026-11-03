// NAVEGACIÓN ENTRE PÁGINAS DEL PANEL (RUTAS LARAVEL)
function switchTab(tab) {
    const pages = {
        'dashboard': '/dashboard',
        'acopio': '/acopio',
        'vecinos': '/vecinos',
        'rutas': '/rutas',
        'reportes': '/reportes'
    };
    
    // Evitar recargar si ya estás en la misma URL
    const targetUrl = pages[tab] || '/dashboard';
    if (window.location.pathname !== targetUrl) {
        window.location.href = targetUrl;
    }
}

function toggleMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    const isHidden = sidebar.classList.contains('hidden');
    sidebar.classList.toggle('hidden', !isHidden);
    sidebar.classList.toggle('flex', isHidden);

    // Opcional: manejar un backdrop si existe en tu blade
    const backdrop = document.getElementById('sidebar-backdrop');
    if (backdrop) {
        backdrop.classList.toggle('hidden', !isHidden);
    }
}

function showAppScreen() {
    // Redirección de seguridad en Laravel si está en vista auth
    if (document.getElementById('auth-view')) { 
        window.location.href = '/dashboard'; 
        return; 
    }

    // 1. Extraer usuario de forma segura (soporta null y undefined)
    const user = (typeof currentUser !== 'undefined' && currentUser) ? currentUser : null;
    const defaultName = 'EcoColaborador';
    const defaultRole = 'Vecino';

    const userName = document.getElementById('user-display-name');
    const userRole = document.getElementById('user-display-role');
    const userAvatar = document.getElementById('user-avatar');

    if (userName) userName.innerText = user?.name || defaultName;
    if (userRole) userRole.innerText = user?.role || defaultRole;

    if (userAvatar) {
        const rawName = (user?.name || defaultName).trim();
        // Filtrar espacios vacíos para no romper n[0]
        const initials = rawName
            .split(/\s+/)
            .filter(Boolean)
            .map(n => n[0])
            .join('')
            .substring(0, 2)
            .toUpperCase();

        userAvatar.innerText = initials || 'EC';
    }

    // 2. Renderizar la vista propia de cada página según la ruta activa
    const page = document.body.getAttribute('data-page');

    switch (page) {
        case 'dashboard':
            if (typeof renderDashboardCriticals === 'function') renderDashboardCriticals();
            if (typeof renderDashboardStats === 'function') renderDashboardStats();
            if (typeof initChart === 'function') initChart();
            break;

        case 'acopio':
            if (typeof renderAcopioTable === 'function') renderAcopioTable();
            break;

        case 'vecinos':
            if (typeof renderVecinosRanking === 'function') renderVecinosRanking();
            break;

        case 'rutas':
            if (typeof initRoutesView === 'function') initRoutesView();
            break;

        case 'reportes':
            if (typeof initReportsView === 'function') initReportsView();
            break;
            
        default:
            break;
    }

    // Asegurar iconos si se inyectó contenido nuevo
    if (window.lucide && typeof lucide.createIcons === 'function') {
        lucide.createIcons();
    }
}