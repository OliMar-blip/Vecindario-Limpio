// CRUD PUNTOS DE ACOPIO
function renderAcopioTable() {
    const tbody = document.getElementById('acopio-table-body');
    tbody.innerHTML = '';

    acopioList.forEach(item => {
        let badgeClass = "bg-emerald-100 text-emerald-800";
        if (item.level >= 80) badgeClass = "bg-red-100 text-red-800 font-bold";
        else if (item.level >= 50) badgeClass = "bg-amber-100 text-amber-800";

        const tr = document.createElement('tr');
        tr.className = "hover:bg-slate-50 transition";
        tr.innerHTML = `
            <td class="p-4">
                <div class="font-bold text-slate-900">${escapeHtml(item.name)}</div>
                <div class="text-xs text-slate-500">${escapeHtml(item.sector)}</div>
            </td>
            <td class="p-4 text-xs font-medium text-slate-700">${escapeHtml(item.type)}</td>
            <td class="p-4">
                <div class="w-full bg-slate-200 rounded-full h-2.5 max-w-[120px]">
                    <div class="bg-eco-600 h-2.5 rounded-full" style="width: ${item.level}%"></div>
                </div>
            </td>
            <td class="p-4">
                <span class="px-2.5 py-1 rounded-full text-xs ${badgeClass}">${item.level}% (${item.level >= 80 ? 'Crítico' : item.level >= 50 ? 'Normal' : 'Óptimo'})</span>
            </td>
            <td class="p-4 text-right space-x-2">
                <button onclick="editAcopio(${item.id})" class="p-1.5 hover:bg-slate-200 text-slate-600 rounded-lg transition" title="Editar"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                <button onclick="deleteAcopio(${item.id})" class="p-1.5 hover:bg-red-100 text-red-600 rounded-lg transition" title="Eliminar"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    saveAcopioData();
    if (typeof renderDashboardCriticals === 'function') renderDashboardCriticals();
    lucide.createIcons();
}

function openAcopioModal(editId = null) {
    const modal = document.getElementById('modal-acopio');
    const form = document.getElementById('form-acopio');
    form.reset();

    if (editId) {
        const item = acopioList.find(a => a.id === editId);
        if (item) {
            document.getElementById('modal-acopio-title').innerText = 'Editar Punto de Acopio';
            document.getElementById('acopio-id').value = item.id;
            document.getElementById('acopio-name').value = item.name;
            document.getElementById('acopio-sector').value = item.sector;
            document.getElementById('acopio-type').value = item.type;
            document.getElementById('acopio-level').value = item.level;
        }
    } else {
        document.getElementById('modal-acopio-title').innerText = 'Nuevo Punto de Acopio';
        document.getElementById('acopio-id').value = '';
    }

    modal.classList.remove('hidden');
}

function closeAcopioModal() {
    document.getElementById('modal-acopio').classList.add('hidden');
}

function saveAcopio(e) {
    e.preventDefault();
    const id = document.getElementById('acopio-id').value;
    const name = document.getElementById('acopio-name').value;
    const sector = document.getElementById('acopio-sector').value;
    const type = document.getElementById('acopio-type').value;
    const level = parseInt(document.getElementById('acopio-level').value);

    if (id) {
        const index = acopioList.findIndex(a => a.id == id);
        if (index !== -1) {
            acopioList[index] = { id: parseInt(id), name, sector, type, level, status: level >= 80 ? 'Crítico' : 'Normal' };
            showToast('Punto de acopio actualizado', 'success');
        }
    } else {
        acopioList.push({
            id: Date.now(),
            name, sector, type, level, status: level >= 80 ? 'Crítico' : 'Normal'
        });
        showToast('Nuevo punto de acopio registrado', 'success');
    }

    closeAcopioModal();
    renderAcopioTable();
}

function editAcopio(id) {
    openAcopioModal(id);
}

function deleteAcopio(id) {
    if (confirm('¿Deseas eliminar este punto de acopio?')) {
        acopioList = acopioList.filter(a => a.id !== id);
        renderAcopioTable();
        showToast('Punto de acopio eliminado', 'info');
    }
}
