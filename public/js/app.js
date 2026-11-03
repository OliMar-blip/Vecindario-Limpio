// ==========================================
// GESTIÓN DE PUNTOS DE ACOPIO (ECOBARRIO)
// ==========================================

let acopioList = JSON.parse(localStorage.getItem('acopio_data')) || [
    { id: 1, name: "Punto Limpio Covida", sector: "Av. Antúnez de Mayolo CDRA 8", type: "Plásticos y PET", level: 85 },
    { id: 2, name: "EcoContenedor Sol de Oro", sector: "Jr. Los Alisos 450", type: "Cartón y Papel", level: 40 },
    { id: 3, name: "Estación Recicla Mercurio", sector: "Calle Mercurio Mz. B", type: "Multiresiduos / RAEE", level: 92 }
];

function saveAcopioData() {
    localStorage.setItem('acopio_data', JSON.stringify(acopioList));
}

function renderAcopioTable() {
    const tbody = document.getElementById('acopio-table-body');
    if (!tbody) return;
    tbody.innerHTML = '';

    acopioList.forEach((item) => {
        let badgeColor = "bg-emerald-100 text-emerald-800 border-emerald-200";
        if (item.level > 80) {
            badgeColor = "bg-rose-100 text-rose-800 border-rose-200"; // Nivel alto de llenado
        } else if (item.level > 50) {
            badgeColor = "bg-amber-100 text-amber-800 border-amber-200"; // Nivel medio
        }

        const tr = document.createElement('tr');
        tr.className = "hover:bg-slate-50 transition";
        tr.innerHTML = `
            <td class="p-4">
                <div class="font-bold text-slate-900">${item.name}</div>
                <div class="text-xs text-slate-400">${item.sector}</div>
            </td>
            <td class="p-4">
                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold text-xs rounded-lg border border-slate-200">
                    ${item.type}
                </span>
            </td>
            <td class="p-4 text-xs font-semibold text-slate-600">
                Operativo / Activo
            </td>
            <td class="p-4">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg border ${badgeColor}">
                        ${item.level}% Llenado
                    </span>
                </div>
            </td>
            <td class="p-4 text-right">
                <button onclick="deleteAcopio(${item.id})" class="p-1.5 text-slate-400 hover:text-rose-600 transition rounded-lg hover:bg-rose-50" title="Eliminar punto">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    saveAcopioData();
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

function openAcopioModal() {
    const modal = document.getElementById('modal-acopio');
    const form = document.getElementById('form-acopio');
    if (form) form.reset();
    if (modal) modal.classList.remove('hidden');
}

function closeAcopioModal() {
    const modal = document.getElementById('modal-acopio');
    if (modal) modal.classList.add('hidden');
}

function saveAcopio(e) {
    if (e) e.preventDefault();

    const name = document.getElementById('acopio-name').value;
    const sector = document.getElementById('acopio-sector').value;
    const type = document.getElementById('acopio-type').value;
    const level = parseInt(document.getElementById('acopio-level').value) || 0;

    acopioList.push({
        id: Date.now(),
        name,
        sector,
        type,
        level
    });

    closeAcopioModal();
    renderAcopioTable();
}

function deleteAcopio(id) {
    acopioList = acopioList.filter(item => item.id !== id);
    renderAcopioTable();
}