// CRUD PUNTOS DE ACOPIO
function renderAcopioTable() {
    const tbody = document.getElementById('acopio-table-body');
    if (!tbody) return;
    tbody.innerHTML = '';

    acopioList.forEach(item => {
        // Asegurar que el nivel esté entre 0 y 100
        const safeLevel = Math.min(100, Math.max(0, Number(item.level) || 0));

        let badgeClass = "bg-emerald-100 text-emerald-800";
        let statusLabel = "Óptimo";

        if (safeLevel >= 80) {
            badgeClass = "bg-red-100 text-red-800 font-bold";
            statusLabel = "Crítico";
        } else if (safeLevel >= 50) {
            badgeClass = "bg-amber-100 text-amber-800";
            statusLabel = "Normal";
        }

        const tr = document.createElement('tr');
        tr.className = "hover:bg-slate-50 transition";
        tr.innerHTML = `
            <td class="p-4">
                <div class="font-bold text-slate-900">${typeof escapeHtml === 'function' ? escapeHtml(item.name) : item.name}</div>
                <div class="text-xs text-slate-500">${typeof escapeHtml === 'function' ? escapeHtml(item.sector) : item.sector}</div>
            </td>
            <td class="p-4 text-xs font-medium text-slate-700">${typeof escapeHtml === 'function' ? escapeHtml(item.type) : item.type}</td>
            <td class="p-4">
                <div class="w-full bg-slate-200 rounded-full h-2.5 max-w-[120px]">
                    <div class="bg-emerald-600 h-2.5 rounded-full transition-all duration-300" style="width: ${safeLevel}%"></div>
                </div>
            </td>
            <td class="p-4">
                <span class="px-2.5 py-1 rounded-full text-xs ${badgeClass}">
                    ${safeLevel}% (${statusLabel})
                </span>
            </td>
            <td class="p-4 text-right space-x-2">
                <button onclick="editAcopio(${item.id})" class="p-1.5 hover:bg-slate-200 text-slate-600 rounded-lg transition" title="Editar">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                </button>
                <button onclick="deleteAcopio(${item.id})" class="p-1.5 hover:bg-red-100 text-red-600 rounded-lg transition" title="Eliminar">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    if (typeof renderDashboardCriticals === 'function') renderDashboardCriticals();
    if (window.lucide && typeof lucide.createIcons === 'function') lucide.createIcons();
}

function openAcopioModal(editId = null) {
    const modal = document.getElementById('modal-acopio');
    const form = document.getElementById('form-acopio');
    if (!modal || !form) return;
    
    form.reset();

    if (editId) {
        const item = acopioList.find(a => a.id === editId);
        if (item) {
            document.getElementById('modal-acopio-title').innerText = 'Editar Punto de Acopio';
            document.getElementById('acopio-id').value = item.id;
            document.getElementById('acopio-name').value = item.name || '';
            document.getElementById('acopio-sector').value = item.sector || '';
            document.getElementById('acopio-type').value = item.type || '';
            document.getElementById('acopio-level').value = item.level ?? 0;
        }
    } else {
        document.getElementById('modal-acopio-title').innerText = 'Nuevo Punto de Acopio';
        document.getElementById('acopio-id').value = '';
    }

    modal.classList.remove('hidden');
}

function closeAcopioModal() {
    const modal = document.getElementById('modal-acopio');
    if (modal) modal.classList.add('hidden');
}

function saveAcopio(e) {
    e.preventDefault();
    const id = document.getElementById('acopio-id').value;
    const name = document.getElementById('acopio-name').value.trim();
    const sector = document.getElementById('acopio-sector').value.trim();
    const type = document.getElementById('acopio-type').value.trim();
    
    let rawLevel = parseInt(document.getElementById('acopio-level').value, 10);
    const level = isNaN(rawLevel) ? 0 : Math.min(100, Math.max(0, rawLevel));

    // Consistencia en 3 niveles de estado
    let status = 'Óptimo';
    if (level >= 80) status = 'Crítico';
    else if (level >= 50) status = 'Normal';

    if (id) {
        const index = acopioList.findIndex(a => a.id == id);
        if (index !== -1) {
            acopioList[index] = { id: parseInt(id, 10), name, sector, type, level, status };
            if (typeof showToast === 'function') showToast('Punto de acopio actualizado', 'success');
        }
    } else {
        acopioList.push({
            id: Date.now(),
            name,
            sector,
            type,
            level,
            status
        });
        if (typeof showToast === 'function') showToast('Nuevo punto de acopio registrado', 'success');
    }

    // Persistir solo al mutar los datos
    if (typeof saveAcopioData === 'function') saveAcopioData();

    closeAcopioModal();
    renderAcopioTable();
}

function editAcopio(id) {
    openAcopioModal(id);
}

function deleteAcopio(id) {
    if (confirm('¿Deseas eliminar este punto de acopio?')) {
        acopioList = acopioList.filter(a => a.id !== id);
        
        // Persistir al eliminar
        if (typeof saveAcopioData === 'function') saveAcopioData();
        
        renderAcopioTable();
        if (typeof showToast === 'function') showToast('Punto de acopio eliminado', 'info');
    }
}