// NOTIFICACIONES TOAST
function showToast(msg, type = 'info') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');

    let bg = 'bg-slate-900 text-white';
    if (type === 'success') bg = 'bg-eco-700 text-white';

    toast.className = `${bg} px-4 py-3 rounded-2xl shadow-xl text-xs font-semibold flex items-center justify-between gap-3 pointer-events-auto transition-all duration-300 transform translate-x-5 opacity-0`;
    toast.innerHTML = `
        <span>${msg}</span>
        <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
    `;

    container.appendChild(toast);
    lucide.createIcons();

    setTimeout(() => {
        toast.classList.remove('translate-x-5', 'opacity-0');
    }, 10);

    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-x-5');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// UTILIDAD ESCAPE HTML
function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, function(m) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
    });
}

// Toast que sobrevive al cambio de página (login / logout redirigen a otro HTML)
function queueToast(msg, type = 'info') {
    try { sessionStorage.setItem('ecobarrio_lo_pending_toast', JSON.stringify({ msg, type })); } catch (e) {}
}

function flushPendingToast() {
    try {
        const raw = sessionStorage.getItem('ecobarrio_lo_pending_toast');
        if (raw) {
            sessionStorage.removeItem('ecobarrio_lo_pending_toast');
            const t = JSON.parse(raw);
            showToast(t.msg, t.type);
        }
    } catch (e) {}
}
