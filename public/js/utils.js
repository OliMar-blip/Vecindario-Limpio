// NOTIFICACIONES TOAST
function showToast(msg, type = 'info') {
    let container = document.getElementById('toast-container');
    
    // Crear el contenedor flotante si no existe en la vista actual
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none max-w-sm w-full px-4';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');

    // Paleta de colores por tipo de evento
    let bg = 'bg-slate-900 text-white border-slate-800';
    if (type === 'success') bg = 'bg-eco-700 text-white border-eco-600';
    else if (type === 'error') bg = 'bg-red-600 text-white border-red-500';
    else if (type === 'warning') bg = 'bg-amber-600 text-white border-amber-500';

    toast.className = `${bg} border px-4 py-3 rounded-2xl shadow-xl text-xs font-semibold flex items-center justify-between gap-3 pointer-events-auto transition-all duration-300 transform translate-x-5 opacity-0`;
    
    // Inyección segura escapando el mensaje
    const safeMsg = typeof escapeHtml === 'function' ? escapeHtml(msg) : msg;
    toast.innerHTML = `
        <span class="flex-1 leading-snug">${safeMsg}</span>
        <button type="button" class="close-toast text-white/80 hover:text-white transition p-1">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    `;

    container.appendChild(toast);

    if (window.lucide && typeof lucide.createIcons === 'function') {
        lucide.createIcons();
    }

    // Animación de entrada
    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-5', 'opacity-0');
    });

    let dismissTimeout;

    // Función segura para remover el toast
    const dismissToast = () => {
        clearTimeout(dismissTimeout);
        toast.classList.add('opacity-0', 'translate-x-5');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    };

    // Event listener en el botón para evitar problemas con target/parentElement
    const closeBtn = toast.querySelector('.close-toast');
    if (closeBtn) {
        closeBtn.addEventListener('click', dismissToast);
    }

    // Auto-cierre a los 4 segundos
    dismissTimeout = setTimeout(dismissToast, 4000);
}

// UTILIDAD ESCAPE HTML
function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str).replace(/[&<>"']/g, function(m) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
    });
}

// Toast que sobrevive al cambio de página (login / logout redirigen a otro HTML o ruta)
function queueToast(msg, type = 'info') {
    try {
        sessionStorage.setItem('ecobarrio_lo_pending_toast', JSON.stringify({ msg, type }));
    } catch (e) {
        console.warn('No se pudo encolar el toast en sessionStorage:', e);
    }
}

function flushPendingToast() {
    try {
        const raw = sessionStorage.getItem('ecobarrio_lo_pending_toast');
        if (raw) {
            sessionStorage.removeItem('ecobarrio_lo_pending_toast');
            const t = JSON.parse(raw);
            if (t && t.msg) {
                showToast(t.msg, t.type || 'info');
            }
        }
    } catch (e) {
        console.warn('Error al procesar pending toast:', e);
    }
}