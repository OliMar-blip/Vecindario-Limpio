// ==========================================
// GESTIÓN DE REPORTES E IMPACTO (ECOBARRIO)
// ==========================================

document.addEventListener('DOMContentLoaded', () => {
    // Inicializar iconos de Lucide si están presentes en la vista de reportes
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

// Función simulada de notificación (Toast) si no está declarada de forma global
function showToast(message, type = 'success') {
    // Si ya tienes un sistema de toast global en app.js, esta función se complementa
    console.log(`[Reportes Toast - ${type}]: ${message}`);
    
    // Crear un elemento visual temporal en pantalla si no existe una función global
    const toast = document.createElement('div');
    toast.className = `fixed bottom-5 right-5 z-50 px-4 py-3 rounded-xl shadow-xl text-xs font-semibold text-white transition-all transform translate-y-0 ${
        type === 'success' ? 'bg-emerald-600' : 'bg-slate-900'
    }`;
    toast.innerHTML = `<div class="flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4"></i> ${message}</div>`;
    document.body.appendChild(toast);
    
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}