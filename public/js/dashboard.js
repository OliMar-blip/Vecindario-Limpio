// VISTA DASHBOARD: PUNTOS CRÍTICOS
function renderDashboardCriticals() {
    const container = document.getElementById('dashboard-critical-list');
    const statCounter = document.getElementById('stat-critical-points');
    if (!container) return;

    container.innerHTML = '';

    const list = Array.isArray(acopioList) ? acopioList : [];
    const criticals = list.filter(a => Number(a.level) >= 80);

    if (statCounter) {
        statCounter.innerText = `${criticals.length} Puntos`;
    }

    if (criticals.length === 0) {
        container.innerHTML = '<p class="text-xs text-slate-500 italic">Todos los contenedores operan dentro de niveles normales.</p>';
        return;
    }

    criticals.forEach(item => {
        const safeName = typeof escapeHtml === 'function' ? escapeHtml(item.name) : (item.name || '');
        const safeSector = typeof escapeHtml === 'function' ? escapeHtml(item.sector) : (item.sector || '');
        const safeLevel = Math.min(100, Math.max(0, Number(item.level) || 0));

        const card = document.createElement('div');
        card.className = "p-3 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between";
        card.innerHTML = `
            <div>
                <h5 class="font-bold text-xs text-amber-900">${safeName}</h5>
                <p class="text-[11px] text-amber-700">${safeSector}</p>
            </div>
            <span class="text-xs font-black text-red-600 bg-white px-2 py-1 rounded-lg border border-amber-300">
                ${safeLevel}% Lleno
            </span>
        `;
        container.appendChild(card);
    });
}

// CONTADOR DE ECOSOCIOS (Solo lectura y render)
function renderDashboardStats() {
    const statElement = document.getElementById('stat-total-ecosocios');
    if (statElement) {
        const totalSocios = Array.isArray(vecinosList) ? vecinosList.length : 0;
        statElement.innerText = totalSocios;
    }
    // Se eliminaron saveAcopioData() y saveVecinosData() de aquí
}

let myChart = null;

// GRÁFICO CON CHART.JS
function initChart() {
    const canvas = document.getElementById('recyclingChart');
    if (!canvas || typeof Chart === 'undefined') return;

    const ctx = canvas.getContext('2d');
    if (myChart) {
        myChart.destroy();
    }

    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Covida', 'Sol de Oro', 'Pro', 'Mercurio', 'Villa Sol'],
            datasets: [{
                label: 'Kilos de Residuos Reciclados (kg)',
                data: [1420, 1180, 1650, 890, 1050],
                backgroundColor: [
                    '#16a34a',
                    '#22c55e',
                    '#15803d',
                    '#4ade80',
                    '#86efac'
                ],
                borderRadius: 10,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [4, 4] }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

function updateChartData() {
    if (!myChart) return;

    const filterEl = document.getElementById('chart-filter');
    const filter = filterEl ? filterEl.value : 'all';

    let newData = [1420, 1180, 1650, 890, 1050];
    let newLabel = 'Total Residuos Reciclados (kg)';

    if (filter === 'pet') {
        newData = [620, 540, 710, 410, 480];
        newLabel = 'Plástico PET Reciclado (kg)';
    } else if (filter === 'carton') {
        newData = [500, 420, 600, 300, 390];
        newLabel = 'Cartón y Papel Reciclado (kg)';
    } else if (filter === 'compost') {
        newData = [300, 220, 340, 180, 180];
        newLabel = 'Compost Orgánico (kg)';
    }

    myChart.data.datasets[0].data = newData;
    myChart.data.datasets[0].label = newLabel;
    myChart.update();
}