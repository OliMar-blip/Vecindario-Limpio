// RANKING Y PADRÓN DE ECOCOLABORADORES
function renderVecinosRanking() {
    // Ordenar por EcoPuntos descendente para generar ranking
    vecinosList.sort((a, b) => b.points - a.points);

    // Render Podio Top 3
    renderPodium();

    // Render Tabla Completa
    const tbody = document.getElementById('vecinos-table-body');
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

    saveVecinosData();
    const statEco = document.getElementById('stat-total-ecosocios');
    if (statEco) statEco.innerText = vecinosList.length;
    lucide.createIcons();
}

function renderPodium() {
    const podium = document.getElementById('podium-container');
    podium.innerHTML = '';

    const top3 = vecinosList.slice(0, 3);
    if (top3.length === 0) return;

    const order = [top3[1], top3[0], top3[2]]; // Visual: 2do, 1ro, 3ro

    order.forEach((item, idx) => {
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

function addPoints(id) {
    const index = vecinosList.findIndex(v => v.id === id);
    if (index !== -1) {
        vecinosList[index].points += 50;
        // Actualizar insignias según puntaje acumulado
        if (vecinosList[index].points >= 1000) vecinosList[index].badge = 'Líder Verde';
        else if (vecinosList[index].points >= 800) vecinosList[index].badge = 'Brigadista VIP';

        renderVecinosRanking();
        showToast(`+50 EcoPuntos asignados a ${vecinosList[index].name}`, 'success');
    }
}

function filterVecinos() {
    const query = document.getElementById('search-vecinos').value.toLowerCase();
    const rows = document.querySelectorAll('#vecinos-table-body tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        if (text.includes(query)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function openVecinoModal() {
    document.getElementById('form-vecino').reset();
    document.getElementById('modal-vecino').classList.remove('hidden');
}

function closeVecinoModal() {
    document.getElementById('modal-vecino').classList.add('hidden');
}

function saveVecino(e) {
    e.preventDefault();
    const name = document.getElementById('vecino-name').value;
    const dni = document.getElementById('vecino-dni').value;
    const sector = document.getElementById('vecino-sector').value;
    const badge = document.getElementById('vecino-badge').value;
    const points = parseInt(document.getElementById('vecino-points').value) || 0;

    vecinosList.push({
        id: Date.now(),
        name, dni, sector, badge, points,
        avatar: `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=22c55e&color=fff`
    });

    closeVecinoModal();
    renderVecinosRanking();
    showToast('EcoColaborador registrado exitosamente en el ranking', 'success');
}
