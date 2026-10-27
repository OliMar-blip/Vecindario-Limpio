// VISTA DASHBOARD: PUNTOS CRÍTICOS
function renderDashboardCriticals() {
    const container = document.getElementById('dashboard-critical-list');
    container.innerHTML = '';

    const criticals = acopioList.filter(a => a.level >= 80);
    document.getElementById('stat-critical-points').innerText = `${criticals.length} Puntos`;

    if (criticals.length === 0) {
        container.innerHTML = '<p class="text-xs text-slate-500 italic">Todos los contenedores operan dentro de niveles normales.</p>';
        return;
    }

    criticals.forEach(item => {
        const card = document.createElement('div');
        card.className = "p-3 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between";
        card.innerHTML = `
            <div>
                <h5 class="font-bold text-xs text-amber-900">${escapeHtml(item.name)}</h5>
                <p class="text-[11px] text-amber-700">${escapeHtml(item.sector)}</p>
            </div>
            <span class="text-xs font-black text-red-600 bg-white px-2 py-1 rounded-lg border border-amber-300">${item.level}% Lleno</span>
        `;
        container.appendChild(card);
    });
}

// Contador de EcoColaboradores del dashboard (en el original lo actualizaba renderVecinosRanking)
function renderDashboardStats() {
    document.getElementById('stat-total-ecosocios').innerText = vecinosList.length;
    saveAcopioData();
    saveVecinosData();
}

let myChart = null;

// GRÁFICO CON CHART.JS
function initChart() {
    const ctx = document.getElementById('recyclingChart').getContext('2d');
    if (myChart) myChart.destroy();

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
    const filter = document.getElementById('chart-filter').value;
    let newData = [1420, 1180, 1650, 890, 1050];

    if (filter === 'pet') newData = [620, 540, 710, 410, 480];
    else if (filter === 'carton') newData = [500, 420, 600, 300, 390];
    else if (filter === 'compost') newData = [300, 220, 340, 180, 180];

    myChart.data.datasets[0].data = newData;
    myChart.update();
}
