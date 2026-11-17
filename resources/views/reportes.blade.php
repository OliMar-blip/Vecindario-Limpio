@extends('layouts.app')

@section('content')
<style>
    @media print {
        aside, nav, footer, .no-print { display: none !important; }
        main, body { background: #ffffff !important; padding: 0 !important; margin: 0 !important; }
        .print-card { box-shadow: none !important; border: 1px solid #cbd5e1 !important; break-inside: avoid; }
    }
</style>

<div class="space-y-6 pb-8">
    <!-- Encabezado y Botón de Exportación PDF -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-extrabold mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Datos Consolidados en Tiempo Real
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Métricas de Eco-Impacto Los Olivos</h1>
            <p class="text-sm text-slate-500 mt-0.5">Ahorro de recursos, reducción de huella ecológica y balance consolidado por sector del distrito.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 no-print">
            <button onclick="window.print()" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-extrabold rounded-xl shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4 text-emerald-400"></i> Exportar Informe (PDF)
            </button>
        </div>
    </div>

    <!-- Tarjetas Superiores: Beneficio Ambiental + Impacto Comunitario (Sincronizadas) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tarjeta Izquierda: Beneficio Ambiental Acumulado -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm print-card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl"><i data-lucide="trees" class="w-4 h-4"></i></span>
                    Beneficio Ambiental Acumulado
                </h2>
                <span class="text-[11px] font-bold text-slate-400">Calculado desde Acopio</span>
            </div>
            <div class="divide-y divide-slate-100 text-sm">
                <div class="py-3 flex items-center justify-between">
                    <span class="text-slate-600 font-medium">Árboles Salvados (por reciclaje de cartón):</span>
                    <strong id="rep-arboles" class="text-slate-900 font-black">320 árboles</strong>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-slate-600 font-medium">Agua Potable Conservada:</span>
                    <strong id="rep-agua" class="text-slate-900 font-black">65,000 Litros</strong>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-slate-600 font-medium">Emisiones de CO₂ Evitadas:</span>
                    <strong id="rep-co2" class="text-emerald-600 font-black">14.8 Toneladas</strong>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-slate-600 font-medium">Desmonte y Escombros Recuperados:</span>
                    <strong id="rep-desmonte" class="text-amber-700 font-black">12.50 Toneladas</strong>
                </div>
            </div>
        </div>

        <!-- Tarjeta Derecha: Impacto Comunitario y Beneficios -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm print-card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <span class="p-2 bg-amber-50 text-amber-600 rounded-xl"><i data-lucide="award" class="w-4 h-4"></i></span>
                    Impacto Comunitario y Beneficios
                </h2>
                <span class="text-[11px] font-bold text-slate-400">Vinculado a Ranking y Rutas</span>
            </div>
            <div class="divide-y divide-slate-100 text-sm">
                <div class="py-3 flex items-center justify-between">
                    <span class="text-slate-600 font-medium">Compost Entregado para Áreas Verdes:</span>
                    <strong id="rep-compost" class="text-slate-900 font-black">2,400 kg</strong>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-slate-600 font-medium">Vales de Descuento en Arbitrios Emitidos:</span>
                    <strong id="rep-vales" class="text-slate-900 font-black">312 Vales</strong>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-slate-600 font-medium">EcoPuntos Acumulados por Vecinos Activos:</span>
                    <strong id="rep-ecopuntos-vecinos" class="text-blue-600 font-black">11,120 pts</strong>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <span class="text-slate-600 font-medium">Efectividad en Segregación de Origen:</span>
                    <strong id="rep-efectividad" class="text-emerald-600 font-black">94.2%</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila Central: Gráfico de Composición + Balance Consolidado por Sector -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Gráfico Dona de Composición de Residuos -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm print-card flex flex-col justify-between">
            <div>
                <h2 class="text-base font-extrabold text-slate-900">Composición Total Recuperada</h2>
                <p class="text-xs text-slate-500 mb-4">Distribución porcentual por categoría de residuo</p>
                <div class="relative h-56 w-full flex items-center justify-center">
                    <canvas id="composicionChart"></canvas>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 font-semibold">Volumen Total Auditado:</span>
                <strong id="rep-volumen-total" class="text-slate-900 font-black text-sm">66.70 Ton</strong>
            </div>
        </div>

        <!-- Tabla Consolidada por Sector (2 columnas) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden print-card flex flex-col justify-between">
            <div>
                <div class="p-6 pb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900">Balance Consolidado por Sector — Los Olivos</h2>
                        <p class="text-xs text-slate-500">Cruce en vivo entre Puntos de Acopio, Ranking Vecinal y Rutas de Recolección</p>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-extrabold rounded-lg">5 Sectores</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-y border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                                <th class="py-3 px-5">Sector</th>
                                <th class="py-3 px-5">Recuperado</th>
                                <th class="py-3 px-5">Contenedores</th>
                                <th class="py-3 px-5">Carga Actual</th>
                                <th class="py-3 px-5 text-right">EcoPuntos Sector</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-consolidado-sectores" class="divide-y divide-slate-100 text-xs">
                            <!-- Renderizado dinámico -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-4 bg-slate-50/70 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-500">
                <span>Flota municipal operativa: <strong id="rep-flota-resumen" class="text-slate-800">4 unidades asignadas</strong></span>
                <span class="font-semibold text-emerald-700">✓ Reporte listo para auditoría ambiental</span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const STORAGE_KEY_ACOPIO = 'ecobarrio_puntos_acopio_v1';
    const STORAGE_KEY_EXTRAS_GRAFICO = 'ecobarrio_cargas_grafico_v1';
    const STORAGE_KEY_VECINOS = 'ecobarrio_vecinos_ranking_v1';
    const STORAGE_KEY_RUTAS = 'ecobarrio_rutas_camiones_v1';

    const sectoresLista = ['Covida', 'Sol de Oro', 'Sector Pro', 'Mercurio', 'Villa Sol'];

    function generarReporteConsolidado() {
        const base = {
            plastico: [6.4, 5.1, 4.8, 4.2, 3.5],
            carton:   [5.0, 4.3, 3.7, 3.4, 3.1],
            vidrio:   [2.8, 2.4, 2.0, 1.8, 1.7],
            desmonte: [3.2, 2.5, 2.9, 2.1, 1.8]
        };

        let extras = null;
        try { extras = JSON.parse(localStorage.getItem(STORAGE_KEY_EXTRAS_GRAFICO)); } catch (e) {}

        const totPlastico = base.plastico.reduce((acc, v, i) => acc + v + (extras?.plastico?.[sectoresLista[i]] || 0), 0);
        const totCarton   = base.carton.reduce((acc, v, i)   => acc + v + (extras?.carton?.[sectoresLista[i]] || 0), 0);
        const totVidrio   = base.vidrio.reduce((acc, v, i)   => acc + v + (extras?.vidrio?.[sectoresLista[i]] || 0), 0);
        const totDesmonte = base.desmonte.reduce((acc, v, i) => acc + v + (extras?.desmonte?.[sectoresLista[i]] || 0), 0);
        const totGeneral  = totPlastico + totCarton + totVidrio + totDesmonte;

        let puntos = [
            { sector: 'Sector Pro', actual: 1104, maximo: 1200 },
            { sector: 'Covida', actual: 456, maximo: 1200 },
            { sector: 'Sol de Oro', actual: 690, maximo: 1200 },
            { sector: 'Mercurio', actual: 200, maximo: 1200 },
            { sector: 'Villa Sol', actual: 360, maximo: 1200 }
        ];
        try {
            const pGuardados = JSON.parse(localStorage.getItem(STORAGE_KEY_ACOPIO));
            if (Array.isArray(pGuardados)) puntos = pGuardados;
        } catch (e) {}

        let vecinos = [
            { sector: 'Sol de Oro', puntos: 2480 },
            { sector: 'Covida', puntos: 2150 },
            { sector: 'Sector Pro', puntos: 1890 },
            { sector: 'Mercurio', puntos: 1540 },
            { sector: 'Villa Sol', puntos: 1320 },
            { sector: 'Covida', puntos: 980 },
            { sector: 'Sol de Oro', puntos: 760 }
        ];
        try {
            const vGuardados = JSON.parse(localStorage.getItem(STORAGE_KEY_VECINOS));
            if (Array.isArray(vGuardados)) vecinos = vGuardados;
        } catch (e) {}

        let rutas = [];
        try {
            const rGuardadas = JSON.parse(localStorage.getItem(STORAGE_KEY_RUTAS));
            if (Array.isArray(rGuardadas)) rutas = rGuardadas;
        } catch (e) {}

        const arbolesSalvados = Math.round(totCarton * 16.4);
        const aguaLitros = Math.round(totGeneral * 975);
        const co2Toneladas = (totGeneral * 0.222).toFixed(1);
        const totalEcoPuntos = vecinos.reduce((acc, v) => acc + v.puntos, 0);
        const valesEmitidos = Math.max(312, Math.round(totalEcoPuntos / 35));

        document.getElementById('rep-arboles').textContent = `${arbolesSalvados.toLocaleString()} árboles`;
        document.getElementById('rep-agua').textContent = `${aguaLitros.toLocaleString()} Litros`;
        document.getElementById('rep-co2').textContent = `${co2Toneladas} Toneladas`;
        document.getElementById('rep-desmonte').textContent = `${totDesmonte.toFixed(2)} Toneladas`;
        document.getElementById('rep-ecopuntos-vecinos').textContent = `${totalEcoPuntos.toLocaleString()} pts`;
        document.getElementById('rep-vales').textContent = `${valesEmitidos} Vales`;
        document.getElementById('rep-volumen-total').textContent = `${totGeneral.toFixed(2)} Ton`;

        if (rutas.length > 0) {
            const completadas = rutas.filter(r => r.estado === 'Completado').length;
            document.getElementById('rep-flota-resumen').textContent = `${rutas.length} camiones (${completadas} rutas completadas)`;
        }

        const tbody = document.getElementById('tabla-consolidado-sectores');
        tbody.innerHTML = sectoresLista.map((sec, idx) => {
            const tonSector = (
                base.plastico[idx] + (extras?.plastico?.[sec] || 0) +
                base.carton[idx]   + (extras?.carton?.[sec] || 0) +
                base.vidrio[idx]   + (extras?.vidrio?.[sec] || 0) +
                base.desmonte[idx] + (extras?.desmonte?.[sec] || 0)
            ).toFixed(2);

            const puntosSec = puntos.filter(p => p.sector === sec);
            const kgActualSec = puntosSec.reduce((a, p) => a + p.actual, 0);
            const kgMaxSec = puntosSec.reduce((a, p) => a + p.maximo, 0);
            const ecopuntosSec = vecinos.filter(v => v.sector === sec).reduce((a, v) => a + v.puntos, 0);

            return `
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-3.5 px-5 font-extrabold text-slate-900">${sec}</td>
                    <td class="py-3.5 px-5 font-black text-emerald-600">${tonSector} Ton</td>
                    <td class="py-3.5 px-5 font-semibold text-slate-600">${puntosSec.length} puntos</td>
                    <td class="py-3.5 px-5 text-slate-700 font-bold">${kgActualSec.toLocaleString()} <span class="text-slate-400 font-normal">/ ${kgMaxSec.toLocaleString()} kg</span></td>
                    <td class="py-3.5 px-5 text-right font-extrabold text-blue-600">${ecopuntosSec.toLocaleString()} pts</td>
                </tr>
            `;
        }).join('');

        const ctx = document.getElementById('composicionChart');
        if (ctx && typeof Chart !== 'undefined') {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Plástico PET', 'Papel/Cartón', 'Vidrio/Metal', 'Desmonte'],
                    datasets: [{
                        data: [
                            Number(totPlastico.toFixed(2)),
                            Number(totCarton.toFixed(2)),
                            Number(totVidrio.toFixed(2)),
                            Number(totDesmonte.toFixed(2))
                        ],
                        backgroundColor: ['#3b82f6', '#f59e0b', '#8b5cf6', '#78716c'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false,
                    cutout: '64%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 10, font: { size: 11, weight: 'bold' }, color: '#334155' }
                        }
                    }
                }
            });
        }

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    window.addEventListener('load', generarReporteConsolidado);
</script>
@endsection