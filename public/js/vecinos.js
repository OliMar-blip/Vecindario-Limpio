// ==========================================
// GESTIÓN DE ECOCOLABORADORES Y RANKING
// ==========================================

// Inicializar la lista desde localStorage o usar los valores por defecto
let vecinosList = JSON.parse(localStorage.getItem('vecinos_data')) || [
    { id: 1, name: "María Elena Gutiérrez", dni: "45123987", sector: "Sol de Oro", badge: "Líder Verde", points: 1250, avatar: "https://ui-avatars.com/api/?name=Maria+Elena+Gutierrez&background=22c55e&color=fff" },
    { id: 2, name: "Jorge Carlos Quispe", dni: "10982345", sector: "Covida", badge: "Brigadista VIP", points: 1100, avatar: "https://ui-avatars.com/api/?name=Jorge+Carlos+Quispe&background=22c55e&color=fff" },
    { id: 3, name: "Lucía Mendoza", dni: "78451236", sector: "Mercurio", badge: "EcoVecino", points: 980, avatar: "https://ui-avatars.com/api/?name=Lucia+Mendoza&background=22c55e&color=fff" }
];

// Función para guardar en el almacenamiento local del navegador
function saveVecinosData() {
    localStorage.setItem('vecinos_data', JSON.stringify(vecinosList));
}

// Función de seguridad para evitar inyecciones HTML en textos
function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

// Función simulada de Toast si no la tienes global
function showToast(message, type = 'success') {
    console.log(`[Toast - ${type}]: ${message}`);
}

// Renderizar tabla y podio principal
function renderVecinosRanking() {
    // Ordenar por EcoPuntos descendente para generar ranking
    vecinosList.sort((a, b) => b.points - a.points);

    // Render Podio Top 3
    renderPodium();

    // Render Tabla Completa
    const tbody = document.getElementById('vecinos-table-body');
    if (!tbody) return;
    tbody.innerHTML = '';

    vecinosList.forEach((vecino, index) => {
        const rank = index + 1;
        let rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 font-bold text-slate-600 text-xs">${rank}</span>`;

        if (rank === 1) rankBadge = `<span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-400 text-white font-extrabold text-sm shadow">🥇 1</span>`;
        else if (rank === 2) rankBadge = `<span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-300 text-slate-800 font-extrabold text-sm shadow">🥈 2</span>`;
        else if (rank === 3) rankBadge = `<span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-700 text-white font-extrabold text-sm shadow">🥉 3</span>`;

        const tr = document.createElement('tr');
        tr.className = "hover:bg-slate-50 transition";
        tr.innerHTML = `
            <td class="p-4 text-center">${rankBadge}</td>
            <td class="p-4">
                <div class="flex items-center gap-3">
                    <img src="${vecino.avatar}" class="w-9 h-9 rounded-full object-cover border border-eco-200" alt="avatar" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(vecino.name)}'">
                    <div>
                        <div class="font-bold text-slate-900">${escapeHtml(vecino.name)}</div>
                        <div class="text-xs text-slate-400">ID: Vecino-${vecino.id}</div>
                    </div>
                </div>
            </td>
            <td class="p-4 text-xs text-slate-600">
                <div class="font-semibold text-slate-800">${escapeHtml(vecino.sector)}</div>
                <div>DNI: ${escapeHtml(vecino.dni)}</div>
            </td>
            <td class="p-4">
                <span class="px-2.5 py-1 bg-eco-50 border border-eco-200 text-eco-800 font-semibold text-xs rounded-lg inline-flex items-center gap-1">
                    <i data-lucide="award" class="w-3.5 h-3.5 text-eco-600"></i> ${escapeHtml(vecino.badge)}
                </span>
            </td>
            <td class="p-4 font-black text-eco-700 text-base">
                ${vecino.points} <span class="text-xs font-normal text-slate-500">pts</span>
            </td>
            <td class="p-4 text-right">
                <button onclick="addPoints(${vecino.id})" class="px-3 py-1.5 bg-eco-600 hover:bg-eco-700 text-white text-xs font-semibold rounded-lg shadow transition inline-flex items-center gap-1">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> +50 pts
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Guardar cambios automáticamente
    saveVecinosData();

    const statEco = document.getElementById('stat-total-ecosocios');
    if (statEco) statEco.innerText = vecinosList.length;
    
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

// Renderizar el podio del Top 3
function renderPodium() {
    const podium = document.getElementById('podium-container');
    if (!podium) return;
    podium.innerHTML = '';

    const top3 = vecinosList.slice(0, 3);
    if (top3.length === 0) return;

    const order = [top3[1], top3[0], top3[2]]; // Visual: 2do, 1ro, 3ro

    order.forEach((item) => {
        if (!item) return;
        const isFirst = item === top3[0];
        const card = document.createElement('div');
        card.className = `p-5 rounded-3xl border flex flex-col items-center text-center relative overflow-hidden ${
            isFirst ? 'bg-gradient-to-b from-amber-50 to-white border-amber-300 shadow-xl lg:-mt-3' : 'bg-white border-slate-200 shadow-sm'
        }`;

        let crown = isFirst ? '<div class="text-2xl mb-1">👑 #1 Líder del Mes</div>' : `<div class="text-xs font-bold text-slate-400 mb-1">Puesto #${top3.indexOf(item) + 1}</div>`;

        card.innerHTML = `
            ${crown}
            <img src="${item.avatar}" class="w-16 h-16 rounded-full object-cover border-4 ${isFirst ? 'border-amber-400' : 'border-eco-500'} shadow-md my-2" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(item.name)}'">
            <h4 class="font-bold text-slate-900 text-sm mt-1">${escapeHtml(item.name)}</h4>
            <p class="text-xs text-slate-500 mb-2">Sector ${escapeHtml(item.sector)}</p>
            <div class="px-4 py-1.5 rounded-2xl bg-eco-100 text-eco-800 font-black text-lg">
                ${item.points} <span class="text-xs font-semibold">EcoPuntos</span>
            </div>
        `;
        podium.appendChild(card);
    });
}

// Sumar puntos a un vecino
function addPoints(id) {
    const index = vecinosList.findIndex(v => v.id === id);
    if (index !== -1) {
        vecinosList[index].points += 50;
        if (vecinosList[index].points >= 1000) vecinosList[index].badge = 'Líder Verde';
        else if (vecinosList[index].points >= 800) vecinosList[index].badge = 'Brigadista VIP';

        renderVecinosRanking();
        showToast(`+50 EcoPuntos asignados a ${vecinosList[index].name}`, 'success');
    }
}

// Filtrar vecinos desde la barra de búsqueda
function filterVecinos() {
    const searchInput = document.getElementById('search-vecinos');
    if (!searchInput) return;
    const query = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('#vecinos-table-body tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
}

// Control de modales
function openVecinoModal() {
    const form = document.getElementById('form-vecino');
    if (form) form.reset();
    const modal = document.getElementById('modal-vecino');
    if (modal) modal.classList.remove('hidden');
}

function closeVecinoModal() {
    const modal = document.getElementById('modal-vecino');
    if (modal) modal.classList.add('hidden');
}

// Guardar nuevo vecino desde el formulario
function saveVecino(e) {
    if (e) e.preventDefault();
    
    const nameEl = document.getElementById('vecino-name');
    const dniEl = document.getElementById('vecino-dni');
    const sectorEl = document.getElementById('vecino-sector');
    const badgeEl = document.getElementById('vecino-badge');
    const pointsEl = document.getElementById('vecino-points');

    if (!nameEl || !dniEl || !sectorEl) return;

    const name = nameEl.value;
    const dni = dniEl.value;
    const sector = sectorEl.value;
    const badge = badgeEl ? badgeEl.value : 'EcoVecino';
    const points = pointsEl ? (parseInt(pointsEl.value) || 0) : 0;

    vecinosList.push({
        id: Date.now(),
        name, dni, sector, badge, points,
        avatar: `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=22c55e&color=fff`
    });

    closeVecinoModal();
    renderVecinosRanking();
    showToast('EcoColaborador registrado exitosamente en el ranking', 'success');
}

// Ejecutar renderizado al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('vecinos-table-body')) {
        renderVecinosRanking();
    }
});