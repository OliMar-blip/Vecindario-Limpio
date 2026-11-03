// ==========================================
// CONTROL DE ACCESO (Evita que miren páginas sin permiso)
// ==========================================
(function () {
    let sesionActiva = null;

    // Intentamos leer el usuario guardado en el navegador
    try {
        const datos = localStorage.getItem('ecobarrio_lo_user');
        sesionActiva = datos ? JSON.parse(datos) : null;
    } catch (e) {
        sesionActiva = null;
    }

    // Revisamos si de verdad hay datos de usuario cargados
    const tienePermiso = Boolean(sesionActiva && (sesionActiva.id || sesionActiva.email));

    // Averiguamos si estamos en la pantalla de login o adentro del sistema
    const rutaActual = window.location.pathname.toLowerCase();
    const esPaginaLogin = rutaActual === '/' || rutaActual.endsWith('index.html') || rutaActual.includes('login');

    // Si ya inició sesión y quiere volver al login, lo mandamos al dashboard
    if (esPaginaLogin && tienePermiso) {
        window.location.replace('/dashboard');
    }

    // Si no ha iniciado sesión y quiere entrar al dashboard, lo botamos al login
    if (!esPaginaLogin && !tienePermiso) {
        window.location.replace('/');
    }
})();