@extends('layouts.app')

@section('content')
<div class="space-y-6 pb-8">
    <!-- Banner Superior de Bienvenida y Acciones Rápidas -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 rounded-2xl p-6 text-white shadow-lg border border-slate-800 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-bold mb-2.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                Centro de Control Ambiental • En Vivo
            </div>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Panel General — Sede Los Olivos</h1>
            <p class="text-sm text-slate-300 mt-1">Monitoreo operativo de segregación vecinal, capacidad de contenedores y rutas activas.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('acopio') }}" class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 text-xs font-extrabold rounded-xl shadow-md transition inline-flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Registrar Acopio
            </a>
            <a href="{{ route('rutas') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white border border-white/15 text-xs font-bold rounded-xl transition inline-flex items-center gap-2">
                <i data-lucide="truck" class="w-4 h-4 text-emerald-300"></i> Ver Camiones
            </a>
        </div>
    </div>

    <!-- Tarjetas KPI Principales (4 columnas) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        <!-- KPI 1: Total Reciclado -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Total Reciclado</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-1"><span id="kpi-reciclado">66.70</span> <span class="text-base font-bold text-slate-500">Ton</span></h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100">
                    <i data-lucide="recycle" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="font-bold text-emerald-600 flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +18.4% este mes
                </span>
                <span class="text-slate-400 font-medium">Meta: 80 Ton</span>
            </div>
        </div>

        <!-- KPI 2: EcoColaboradores -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">EcoColaboradores</p>
                    <h3 id="kpi-vecinos" class="text-3xl font-black text-slate-900 mt-1">1,890</h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl border border-blue-100">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="font-bold text-blue-600 flex items-center gap-1">
                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> +45 vecinos hoy
                </span>
                <span class="text-slate-400 font-medium">12 sectores</span>
            </div>
        </div>

        <!-- KPI 3: Puntos Críticos (Sincronizado con Acopio) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Puntos Críticos</p>
                    <h3 class="text-3xl font-black text-amber-600 mt-1"><span id="kpi-criticos">1</span> <span class="text-base font-bold text-amber-500">Puntos</span></h3>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl border border-amber-100">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="font-bold text-amber-600 flex items-center gap-1">
                    <i data-lucide="gauge" class="w-3.5 h-3.5"></i> &gt; 80% capacidad
                </span>
                <span class="text-slate-400 font-medium"><span id="kpi-operativos">4</span> operativos</span>
            </div>
        </div>

        <!-- KPI 4: EcoPuntos Canjeados -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">EcoPuntos Canjeados</p>
                    <h3 id="kpi-puntos" class="text-3xl font-black text-slate-900 mt-1">12,650 <span class="text-base font-bold text-slate-500">pts</span></h3>
                </div>
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl border border-purple-100">
                    <i data-lucide="gift" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="font-bold text-purple-600 flex items-center gap-1">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Bonos y arbitrios
                </span>
                <span class="text-slate-400 font-medium">340 canjes</span>
            </div>
        </div>
    </div>

    <!-- Fila Central: Gráfico Interactivo + Alertas de Contenedores -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Gráfico Semanal (2 columnas) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Recolección Semanal en Los Olivos</h2>
                    <p class="text-xs text-slate-500">Volumen acumulado en toneladas por zonas clave (vinculado a cargas de Acopio)</p>
                </div>
                <select id="filtro-residuo" onchange="actualizarGrafico()" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                    <option value="todos">Todos los Residuos</option>
                    <option value="plastico">Plástico PET / HDPE</option>
                    <option value="carton">Papel y Cartón</option>
                    <option value="vidrio">Vidrio y Metales</option>
                    <option value="desmonte">Desmonte / Escombros</option>
                </select>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="recoleccionChart"></canvas>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-500">
                <span>Zona líder de la semana: <strong id="zona-lider-texto" class="text-slate-800">Covida (17.40 Ton)</strong></span>
                <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Sincronizado con Puntos de Acopio
                </span>
            </div>
        </div>

        <!-- Alertas de Contenedores -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-extrabold text-slate-900">Alertas de Contenedores</h2>
                    <span id="badge-alertas-criticos" class="px-2.5 py-1 bg-rose-50 text-rose-600 border border-rose-200 text-[11px] font-extrabold rounded-full">1 Crítico</span>
                </div>
                <div id="lista-alertas-contenedores" class="space-y-3.5">
                    <!-- Renderizado dinámico -->
                </div>
            </div>

            <a href="{{ route('acopio') }}" class="mt-5 w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                Gestionar Contenedores <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    <!-- Fila Inferior: Actividad Reciente + Impacto Ambiental -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Actividad Reciente en Los Olivos</h2>
                    <p class="text-xs text-slate-500">Últimos movimientos de vecinos, compactadoras y canjes</p>
                </div>
                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg">Tiempo real</span>
            </div>
            <div class="divide-y divide-slate-100">
                <div class="py-3.5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black text-xs">ME</div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">María Elena Gutiérrez <span class="font-normal text-slate-500">entregó 14 kg de plástico PET</span></p>
                            <p class="text-xs text-slate-400">Punto Sol de Oro • Hace 12 minutos</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-extrabold rounded-lg shrink-0">+140 pts</span>
                </div>

                <div class="py-3.5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center"><i data-lucide="truck" class="w-5 h-5"></i></div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Unidad Compactadora Eco-02 <span class="font-normal text-slate-500">completó Ruta Mercurio</span></p>
                            <p class="text-xs text-slate-400">2.4 Toneladas trasladadas a planta • Hace 45 minutos</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold rounded-lg shrink-0">Completado</span>
                </div>

                <div class="py-3.5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-black text-xs">JQ</div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Jorge Carlos Quispe <span class="font-normal text-slate-500">canjeó Bono Verde en Arbitrios</span></p>
                            <p class="text-xs text-slate-400">Sector Covida • Hace 2 horas</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-purple-50 text-purple-700 border border-purple-200 text-xs font-extrabold rounded-lg shrink-0">-500 pts</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-extrabold">
                        <i data-lucide="leaf" class="w-3.5 h-3.5"></i> Meta Noviembre
                    </span>
                    <span id="meta-porcentaje" class="text-xs font-black text-emerald-600">83%</span>
                </div>
                <h3 class="text-2xl font-black text-slate-900"><span id="meta-actual-ton">66.70</span> / 80.0 Ton</h3>
                <p class="text-xs text-slate-500 mt-1">Faltan solo <strong id="meta-faltante-ton" class="text-slate-800">13.30 Ton</strong> para superar el récord distrital.</p>

                <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden mt-4 mb-6">
                    <div id="meta-barra" class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full" style="width: 83%"></div>
                </div>

                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-3">Impacto Ambiental Logrado</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 rounded-xl bg-emerald-50/70 border border-emerald-100">
                        <div class="text-xl font-black text-emerald-700">412</div>
                        <div class="text-[11px] font-semibold text-emerald-900">Árboles salvados</div>
                    </div>
                    <div class="p-3 rounded-xl bg-teal-50/70 border border-teal-100">
                        <div class="text-xl font-black text-teal-700">18.4 t</div>
                        <div class="text-[11px] font-semibold text-teal-900">CO₂ evitado</div>
                    </div>
                </div>
            </div>

            <a href="{{ route('reportes') }}" class="mt-5 w-full py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-extrabold rounded-xl transition flex items-center justify-center gap-2">
                Descargar Reporte Mensual <i data-lucide="file-bar-chart" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const STORAGE_KEY_ACOPIO = 'ecobarrio_puntos_acopio_v1';
    const STORAGE_KEY_DASHBOARD_FILTRO = 'ecobarrio_dashboard_filtro_v1';
    const STORAGE_KEY_EXTRAS_GRAFICO = 'ecobarrio_cargas_grafico_v1';

    const sectoresOrden = ['Covida', 'Sol de Oro', 'Sector Pro', 'Mercurio', 'Villa Sol'];

    function obtenerDatosCombinadosGrafico() {
        const base = {
            plastico: [6.4, 5.1, 4.8, 4.2, 3.5],
            carton:   [5.0, 4.3, 3.7, 3.4, 3.1],
            vidrio:   [2.8, 2.4, 2.0, 1.8, 1.7],
            desmonte: [3.2, 2.5, 2.9, 2.1, 1.8]
        };

        let extras = null;
        try {
            extras = JSON.parse(localStorage.getItem(STORAGE_KEY_EXTRAS_GRAFICO));
        } catch (e) {}

        const plastico = base.plastico.map((val, idx) => Number((val + (extras?.plastico?.[sectoresOrden[idx]] || 0)).toFixed(2)));
        const carton   = base.carton.map((val, idx)   => Number((val + (extras?.carton?.[sectoresOrden[idx]] || 0)).toFixed(2)));
        const vidrio   = base.vidrio.map((val, idx)   => Number((val + (extras?.vidrio?.[sectoresOrden[idx]] || 0)).toFixed(2)));
        const desmonte = base.desmonte.map((val, idx) => Number((val + (extras?.desmonte?.[sectoresOrden[idx]] || 0)).toFixed(2)));

        const todos = sectoresOrden.map((_, idx) => Number((plastico[idx] + carton[idx] + vidrio[idx] + desmonte[idx]).toFixed(2)));
        const totalGeneral = todos.reduce((acc, v) => acc + v, 0);
        const metaMensual = 80;

        // Actualizar KPI Total Reciclado y Meta Mensual
        document.getElementById('kpi-reciclado').textContent = totalGeneral.toFixed(2);
        document.getElementById('meta-actual-ton').textContent = totalGeneral.toFixed(2);
        const faltante = Math.max(0, metaMensual - totalGeneral);
        document.getElementById('meta-faltante-ton').textContent = `${faltante.toFixed(2)} Ton`;
        const pctMeta = Math.min(100, Math.round((totalGeneral / metaMensual) * 100));
        document.getElementById('meta-porcentaje').textContent = `${pctMeta}%`;
        document.getElementById('meta-barra').style.width = `${pctMeta}%`;

        function calcularLider(arr) {
            let maxIdx = 0;
            arr.forEach((v, i) => { if (v > arr[maxIdx]) maxIdx = i; });
            return `${sectoresOrden[maxIdx]} (${arr[maxIdx].toFixed(2)} Ton)`;
        }

        return {
            todos:    { label: 'Total Reciclado (Ton)',      data: todos,    color: '#10b981', lider: calcularLider(todos) },
            plastico: { label: 'Plástico PET / HDPE (Ton)',  data: plastico, color: '#3b82f6', lider: calcularLider(plastico) },
            carton:   { label: 'Papel y Cartón (Ton)',       data: carton,   color: '#f59e0b', lider: calcularLider(carton) },
            vidrio:   { label: 'Vidrio y Metales (Ton)',     data: vidrio,   color: '#8b5cf6', lider: calcularLider(vidrio) },
            desmonte: { label: 'Desmonte / Escombros (Ton)', data: desmonte, color: '#78716c', lider: calcularLider(desmonte) }
        };
    }

    function sincronizarAlertasConAcopio() {
        let lista = [
            { id: 1, nombre: 'P.Z. Lloque Yupanqui', sector: 'Sector Pro', actual: 1104, maximo: 1200 },
            { id: 2, nombre: 'Plaza Cívica Covida', sector: 'Covida', actual: 456, maximo: 1200 },
            { id: 3, nombre: 'Parque Sol de Oro', sector: 'Sol de Oro', actual: 690, maximo: 1200 }
        ];
        try {
            const guardado = localStorage.getItem(STORAGE_KEY_ACOPIO);
            if (guardado) {
                const parsed = JSON.parse(guardado);
                if (Array.isArray(parsed)) lista = parsed;
            }
        } catch (e) {}

        const criticos = lista.filter(p => (p.actual / p.maximo) >= 0.8);
        const operativos = lista.filter(p => (p.actual / p.maximo) < 0.8);

        document.getElementById('kpi-criticos').textContent = criticos.length;
        document.getElementById('kpi-operativos').textContent = operativos.length;
        document.getElementById('badge-alertas-criticos').textContent = `${criticos.length} Críticos`;

        const ordenados = [...lista].sort((a, b) => (b.actual / b.maximo) - (a.actual / a.maximo)).slice(0, 3);
        const contenedor = document.getElementById('lista-alertas-contenedores');

        contenedor.innerHTML = ordenados.map(p => {
            const pct = Math.min(100, Math.round((p.actual / p.maximo) * 100));
            if (pct >= 80) {
                return `
                    <div class="p-3.5 rounded-xl bg-rose-50/80 border border-rose-200">
                        <div class="flex items-center justify-between text-xs font-extrabold text-rose-900 mb-1.5">
                            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-600"></i> ${p.nombre}</span>
                            <span class="px-2 py-0.5 bg-rose-600 text-white rounded-md text-[10px]">${pct}%</span>
                        </div>
                        <div class="w-full bg-rose-200/80 h-2 rounded-full overflow-hidden mb-1.5">
                            <div class="bg-rose-600 h-full rounded-full" style="width: ${pct}%"></div>
                        </div>
                        <p class="text-[11px] text-rose-800 font-medium">Capacidad crítica (${p.actual} / ${p.maximo} kg). Recojo urgente.</p>
                    </div>
                `;
            } else if (pct >= 60) {
                return `
                    <div class="p-3.5 rounded-xl bg-amber-50/80 border border-amber-200">
                        <div class="flex items-center justify-between text-xs font-extrabold text-amber-900 mb-1.5">
                            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-amber-600"></i> ${p.nombre}</span>
                            <span class="px-2 py-0.5 bg-amber-500 text-white rounded-md text-[10px]">${pct}%</span>
                        </div>
                        <div class="w-full bg-amber-200/80 h-2 rounded-full overflow-hidden mb-1.5">
                            <div class="bg-amber-500 h-full rounded-full" style="width: ${pct}%"></div>
                        </div>
                        <p class="text-[11px] text-amber-800 font-medium">Nivel moderado-alto (${p.actual} / ${p.maximo} kg). Programado hoy.</p>
                    </div>
                `;
            } else {
                return `
                    <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-200">
                        <div class="flex items-center justify-between text-xs font-extrabold text-emerald-900 mb-1.5">
                            <span class="flex items-center gap-1.5"><i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-600"></i> ${p.nombre}</span>
                            <span class="px-2 py-0.5 bg-emerald-600 text-white rounded-md text-[10px]">${pct}%</span>
                        </div>
                        <div class="w-full bg-emerald-200/80 h-2 rounded-full overflow-hidden mb-1.5">
                            <div class="bg-emerald-500 h-full rounded-full" style="width: ${pct}%"></div>
                        </div>
                        <p class="text-[11px] text-emerald-800 font-medium">Operativo normal (${p.actual} / ${p.maximo} kg).</p>
                    </div>
                `;
            }
        }).join('');
    }

    let datasetsRecoleccion = {};
    let chartInstance = null;

    function initDashboardChart() {
        const ctx = document.getElementById('recoleccionChart');
        if (!ctx || typeof Chart === 'undefined') return;

        datasetsRecoleccion = obtenerDatosCombinadosGrafico();

        const filtroGuardado = localStorage.getItem(STORAGE_KEY_DASHBOARD_FILTRO) || 'todos';
        const selectEl = document.getElementById('filtro-residuo');
        if (selectEl && datasetsRecoleccion[filtroGuardado]) {
            selectEl.value = filtroGuardado;
        }

        const inicial = datasetsRecoleccion[filtroGuardado] || datasetsRecoleccion.todos;
        document.getElementById('zona-lider-texto').textContent = inicial.lider;

        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sectoresOrden,
                datasets: [{
                    label: inicial.label,
                    data: inicial.data,
                    backgroundColor: inicial.color,
                    borderRadius: 10,
                    barThickness: 38
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: (context) => ` ${context.parsed.y} Toneladas`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            font: { size: 11, weight: 'bold' },
                            color: '#64748b',
                            callback: (value) => value + ' t'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 12, weight: 'bold' }, color: '#334155' }
                    }
                }
            }
        });
    }

    function actualizarGrafico() {
        const tipo = document.getElementById('filtro-residuo').value;
        localStorage.setItem(STORAGE_KEY_DASHBOARD_FILTRO, tipo);
        const seleccionado = datasetsRecoleccion[tipo];
        if (chartInstance && seleccionado) {
            chartInstance.data.datasets[0].label = seleccionado.label;
            chartInstance.data.datasets[0].data = seleccionado.data;
            chartInstance.data.datasets[0].backgroundColor = seleccionado.color;
            document.getElementById('zona-lider-texto').textContent = seleccionado.lider;
            chartInstance.update();
        }
    }

    window.addEventListener('load', () => {
        sincronizarAlertasConAcopio();
        initDashboardChart();
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection