@extends('layouts.app')

@section('content')
<div class="space-y-6 pb-8">
    <!-- Encabezado y Botón Principal -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Puntos de Acopio EcoVecinales — Los Olivos</h1>
            <p class="text-sm text-slate-500 mt-0.5">Monitoreo de contenedores inteligentes, ubicaciones estratégicas y nivel de llenado en tiempo real.</p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <button onclick="restaurarPuntosPorDefecto()" title="Restaurar datos iniciales" class="px-3 py-2.5 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-xs font-bold rounded-xl transition inline-flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Restaurar
            </button>
            <button onclick="abrirModalAcopio()" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-extrabold rounded-xl shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Nuevo Punto de Acopio
            </button>
        </div>
    </div>

    <!-- Tarjetas de Resumen Operativo -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Puntos Activos</p>
                <h3 id="stat-total" class="text-2xl font-black text-slate-900 mt-0.5">5</h3>
            </div>
            <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl"><i data-lucide="map-pin" class="w-5 h-5"></i></div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Capacidad Instalada</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5"><span id="stat-capacidad">6,000</span> <span class="text-xs font-bold text-slate-400">kg</span></h3>
            </div>
            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl"><i data-lucide="database" class="w-5 h-5"></i></div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">En Estado Crítico</p>
                <h3 id="stat-criticos" class="text-2xl font-black text-rose-600 mt-0.5">1</h3>
            </div>
            <div class="p-2.5 bg-rose-50 text-rose-600 rounded-xl"><i data-lucide="alert-octagon" class="w-5 h-5"></i></div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Próximo Despacho</p>
                <h3 class="text-lg font-black text-slate-900 mt-1">16:00 hrs</h3>
            </div>
            <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl"><i data-lucide="truck" class="w-5 h-5"></i></div>
        </div>
    </div>

    <!-- Barra de Filtros y Búsqueda -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-md">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" id="buscar-punto" onkeyup="filtrarPuntos()" placeholder="Buscar por parque, avenida o sector..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div class="flex items-center gap-2">
            <button onclick="cambiarFiltroEstado('todos', this)" class="filtro-btn px-3 py-1.5 rounded-lg text-xs font-extrabold bg-slate-900 text-white transition cursor-pointer">Todos</button>
            <button onclick="cambiarFiltroEstado('critico', this)" class="filtro-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer">Críticos (&gt;80%)</button>
            <button onclick="cambiarFiltroEstado('normal', this)" class="filtro-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer">Operativos</button>
        </div>
    </div>

    <!-- Tabla Principal de Puntos de Acopio -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                        <th class="py-3.5 px-5">Ubicación / Sector</th>
                        <th class="py-3.5 px-5">Tipos de Residuos</th>
                        <th class="py-3.5 px-5">Capacidad Acumulada</th>
                        <th class="py-3.5 px-5 w-48">Nivel de Llenado</th>
                        <th class="py-3.5 px-5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-puntos-body" class="divide-y divide-slate-100 text-sm">
                    <!-- Renderizado dinámico por JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal 1: Crear Nuevo Punto de Acopio con Etiquetas Seleccionables -->
<div id="modal-acopio" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-black text-slate-900">Registrar Nuevo Punto</h3>
            <button onclick="cerrarModalAcopio()" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form onsubmit="guardarNuevoPunto(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1">Nombre del Punto / Parque</label>
                <input type="text" id="input-nombre" required placeholder="Ej. Parque Naranjal" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1">Sector (Vinculado al Gráfico)</label>
                <select id="input-sector" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="Covida">Covida</option>
                    <option value="Sol de Oro">Sol de Oro</option>
                    <option value="Sector Pro">Sector Pro</option>
                    <option value="Mercurio">Mercurio</option>
                    <option value="Villa Sol">Villa Sol</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1">Capacidad Actual (kg)</label>
                    <input type="number" id="input-actual" value="0" min="0" max="5000" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1">Capacidad Máx. (kg)</label>
                    <input type="number" id="input-capacidad" value="1200" min="100" max="5000" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <!-- Etiquetas seleccionables (Chips) en vez de escribir a mano -->
            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1.5">Residuos Aceptados <span class="text-slate-400 font-normal">(Haz clic para seleccionar)</span></label>
                <div id="chips-residuos-container" class="flex flex-wrap gap-2">
                    <button type="button" data-residuo="Plástico PET" onclick="toggleChipResiduo(this)" class="chip-residuo px-3 py-1.5 rounded-xl text-xs font-extrabold border border-emerald-500 bg-emerald-50 text-emerald-700 transition cursor-pointer">
                        ✓ Plástico PET
                    </button>
                    <button type="button" data-residuo="Cartón" onclick="toggleChipResiduo(this)" class="chip-residuo px-3 py-1.5 rounded-xl text-xs font-extrabold border border-emerald-500 bg-emerald-50 text-emerald-700 transition cursor-pointer">
                        ✓ Cartón
                    </button>
                    <button type="button" data-residuo="Vidrio" onclick="toggleChipResiduo(this)" class="chip-residuo px-3 py-1.5 rounded-xl text-xs font-bold border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                        + Vidrio
                    </button>
                    <button type="button" data-residuo="Metales" onclick="toggleChipResiduo(this)" class="chip-residuo px-3 py-1.5 rounded-xl text-xs font-bold border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                        + Metales
                    </button>
                    <button type="button" data-residuo="Desmonte" onclick="toggleChipResiduo(this)" class="chip-residuo px-3 py-1.5 rounded-xl text-xs font-bold border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                        + Desmonte
                    </button>
                </div>
                <p id="error-chips-residuo" class="text-[11px] font-bold text-rose-600 mt-1 hidden">Selecciona al menos un tipo de residuo.</p>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="cerrarModalAcopio()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl cursor-pointer">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-extrabold rounded-xl shadow-sm cursor-pointer">Guardar Punto</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Registrar Carga Clasificada por Tipo de Residuo -->
<div id="modal-carga" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-slate-200">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-base font-black text-slate-900">Registrar Carga de Residuos</h3>
            <button onclick="cerrarModalCarga()" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <p id="carga-nombre-punto" class="text-xs font-bold text-emerald-700 mb-4"></p>

        <form onsubmit="guardarCargaPunto(event)" class="space-y-4">
            <input type="hidden" id="carga-punto-id">

            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1">¿Con qué residuo se va a cargar?</label>
                <select id="carga-tipo-residuo" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-extrabold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="plastico">🔵 Plástico PET / HDPE</option>
                    <option value="carton">🟡 Papel y Cartón</option>
                    <option value="vidrio">🟣 Vidrio y Metales</option>
                    <option value="desmonte">🟤 Desmonte / Escombros</option>
                </select>
                <p class="text-[11px] text-slate-400 mt-1">Esto actualizará las barras del gráfico en el Panel General.</p>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1">Cantidad a agregar (kg)</label>
                <input type="number" id="carga-kilos-sumar" value="150" min="1" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <p id="carga-max-info" class="text-[11px] text-slate-400 mt-1"></p>
            </div>

            <div class="flex justify-end gap-2 pt-1">
                <button type="button" onclick="cerrarModalCarga()" class="px-3.5 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl cursor-pointer">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-extrabold rounded-xl shadow-sm cursor-pointer">Cargar y Vincular</button>
            </div>
        </form>
    </div>
</div>

<script>
    const STORAGE_KEY_ACOPIO = 'ecobarrio_puntos_acopio_v1';
    const STORAGE_KEY_EXTRAS_GRAFICO = 'ecobarrio_cargas_grafico_v1';

    const puntosIniciales = [
        { id: 1, nombre: 'P.Z. Lloque Yupanqui', direccion: 'Av. Naranjal cdra. 12', sector: 'Sector Pro', residuos: ['Plástico PET', 'Cartón'], actual: 1104, maximo: 1200 },
        { id: 2, nombre: 'Plaza Cívica Covida', direccion: 'Av. Antúnez de Mayolo 890', sector: 'Covida', residuos: ['Plástico PET', 'Cartón', 'Papel'], actual: 456, maximo: 1200 },
        { id: 3, nombre: 'Parque Sol de Oro', direccion: 'Jr. Las Magnolias 240', sector: 'Sol de Oro', residuos: ['Cartón', 'Vidrio'], actual: 690, maximo: 1200 },
        { id: 4, nombre: 'Alameda Mercurio', direccion: 'Av. Universitaria cdra. 34', sector: 'Mercurio', residuos: ['Plástico PET', 'Metales', 'Desmonte'], actual: 200, maximo: 1200 },
        { id: 5, nombre: 'Parque Central Villa Sol', direccion: 'Calle Los Alisos 115', sector: 'Villa Sol', residuos: ['Plástico PET', 'Cartón', 'Vidrio'], actual: 360, maximo: 1200 }
    ];

    function cargarPuntosGuardados() {
        try {
            const guardado = localStorage.getItem(STORAGE_KEY_ACOPIO);
            if (guardado) {
                const parsed = JSON.parse(guardado);
                if (Array.isArray(parsed)) return parsed;
            }
        } catch (e) {}
        return JSON.parse(JSON.stringify(puntosIniciales));
    }

    function guardarEnStorage() {
        localStorage.setItem(STORAGE_KEY_ACOPIO, JSON.stringify(puntosAcopio));
    }

    function registrarKilosEnGraficoDashboard(sector, tipoResiduo, kilos) {
        let extras = {
            plastico: { 'Covida': 0, 'Sol de Oro': 0, 'Sector Pro': 0, 'Mercurio': 0, 'Villa Sol': 0 },
            carton:   { 'Covida': 0, 'Sol de Oro': 0, 'Sector Pro': 0, 'Mercurio': 0, 'Villa Sol': 0 },
            vidrio:   { 'Covida': 0, 'Sol de Oro': 0, 'Sector Pro': 0, 'Mercurio': 0, 'Villa Sol': 0 },
            desmonte: { 'Covida': 0, 'Sol de Oro': 0, 'Sector Pro': 0, 'Mercurio': 0, 'Villa Sol': 0 }
        };
        try {
            const prev = JSON.parse(localStorage.getItem(STORAGE_KEY_EXTRAS_GRAFICO));
            if (prev && prev.plastico) {
                extras = { ...extras, ...prev };
                if (!extras.desmonte) {
                    extras.desmonte = { 'Covida': 0, 'Sol de Oro': 0, 'Sector Pro': 0, 'Mercurio': 0, 'Villa Sol': 0 };
                }
            }
        } catch (e) {}

        const toneladas = kilos / 1000;
        if (extras[tipoResiduo] && extras[tipoResiduo][sector] !== undefined) {
            extras[tipoResiduo][sector] = Number((extras[tipoResiduo][sector] + toneladas).toFixed(3));
        }
        localStorage.setItem(STORAGE_KEY_EXTRAS_GRAFICO, JSON.stringify(extras));
    }

    let puntosAcopio = cargarPuntosGuardados();
    let filtroEstadoActual = 'todos';

    function restaurarPuntosPorDefecto() {
        puntosAcopio = JSON.parse(JSON.stringify(puntosIniciales));
        localStorage.removeItem(STORAGE_KEY_EXTRAS_GRAFICO);
        guardarEnStorage();
        renderizarTabla();
    }

    function toggleChipResiduo(btn) {
        const activo = btn.classList.contains('border-emerald-500');
        const nombre = btn.getAttribute('data-residuo');
        if (activo) {
            btn.className = 'chip-residuo px-3 py-1.5 rounded-xl text-xs font-bold border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100 transition cursor-pointer';
            btn.textContent = '+ ' + nombre;
        } else {
            btn.className = 'chip-residuo px-3 py-1.5 rounded-xl text-xs font-extrabold border border-emerald-500 bg-emerald-50 text-emerald-700 transition cursor-pointer';
            btn.textContent = '✓ ' + nombre;
        }
        document.getElementById('error-chips-residuo').classList.add('hidden');
    }

    function renderizarTabla() {
        const tbody = document.getElementById('tabla-puntos-body');
        const textoBusqueda = document.getElementById('buscar-punto').value.toLowerCase();

        const filtrados = puntosAcopio.filter(p => {
            const pct = Math.min(100, Math.round((p.actual / p.maximo) * 100));
            const coincideTexto = p.nombre.toLowerCase().includes(textoBusqueda) || p.sector.toLowerCase().includes(textoBusqueda) || p.direccion.toLowerCase().includes(textoBusqueda);
            if (!coincideTexto) return false;
            if (filtroEstadoActual === 'critico') return pct >= 80;
            if (filtroEstadoActual === 'normal') return pct < 80;
            return true;
        });

        const capacidadTotal = puntosAcopio.reduce((acc, p) => acc + p.maximo, 0);
        document.getElementById('stat-total').textContent = puntosAcopio.length;
        document.getElementById('stat-capacidad').textContent = capacidadTotal.toLocaleString();
        document.getElementById('stat-criticos').textContent = puntosAcopio.filter(p => (p.actual / p.maximo) >= 0.8).length;

        if (filtrados.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="py-10 text-center text-xs font-bold text-slate-400">No se encontraron puntos de acopio con ese filtro.</td></tr>`;
            return;
        }

        tbody.innerHTML = filtrados.map(p => {
            const pct = Math.min(100, Math.round((p.actual / p.maximo) * 100));
            let barColor = 'bg-emerald-500';
            let badgeColor = 'bg-emerald-50 text-emerald-700 border-emerald-200';
            if (pct >= 80) {
                barColor = 'bg-rose-600';
                badgeColor = 'bg-rose-50 text-rose-700 border-rose-200';
            } else if (pct >= 60) {
                barColor = 'bg-amber-500';
                badgeColor = 'bg-amber-50 text-amber-700 border-amber-200';
            }

            const tagsHtml = p.residuos.map(r => {
                const estiloTag = r === 'Desmonte'
                    ? 'bg-amber-50 text-amber-800 border border-amber-200'
                    : 'bg-slate-100 text-slate-600';
                return `<span class="px-2 py-0.5 ${estiloTag} rounded-md text-[11px] font-semibold">${r}</span>`;
            }).join(' ');

            return `
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="py-4 px-5">
                        <div class="font-extrabold text-slate-900 text-sm">${p.nombre}</div>
                        <div class="text-xs text-slate-400">${p.direccion} • <span class="font-semibold text-slate-600">${p.sector}</span></div>
                    </td>
                    <td class="py-4 px-5">
                        <div class="flex flex-wrap gap-1.5">${tagsHtml}</div>
                    </td>
                    <td class="py-4 px-5">
                        <span class="font-extrabold text-slate-800">${p.actual.toLocaleString()} kg</span>
                        <span class="text-xs text-slate-400"> / ${p.maximo.toLocaleString()} kg</span>
                    </td>
                    <td class="py-4 px-5">
                        <div class="flex items-center justify-between text-xs font-extrabold mb-1">
                            <span class="px-2 py-0.5 rounded-md border ${badgeColor} text-[11px]">${pct}%</span>
                            <span class="text-[11px] text-slate-400">${pct >= 80 ? 'Urgente' : 'Normal'}</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="${barColor} h-full rounded-full transition-all duration-300" style="width: ${pct}%"></div>
                        </div>
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center justify-end gap-1.5">
                            <button onclick="abrirModalCarga(${p.id})" title="Cargar residuos clasificados" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-extrabold rounded-lg transition cursor-pointer inline-flex items-center gap-1">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Carga
                            </button>
                            <button onclick="vaciarContenedor(${p.id})" title="Vaciar contenedor a 0 kg" class="px-2.5 py-1.5 bg-slate-900 hover:bg-slate-700 text-white text-xs font-bold rounded-lg transition cursor-pointer inline-flex items-center gap-1">
                                <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Vaciar
                            </button>
                            <button onclick="eliminarPunto(${p.id})" title="Eliminar punto" class="p-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 rounded-lg transition cursor-pointer">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function vaciarContenedor(id) {
        const punto = puntosAcopio.find(p => p.id === id);
        if (punto) {
            punto.actual = 0;
            guardarEnStorage();
            renderizarTabla();
        }
    }

    function eliminarPunto(id) {
        puntosAcopio = puntosAcopio.filter(p => p.id !== id);
        guardarEnStorage();
        renderizarTabla();
    }

    function abrirModalCarga(id) {
        const punto = puntosAcopio.find(p => p.id === id);
        if (!punto) return;
        const disponible = Math.max(0, punto.maximo - punto.actual);
        document.getElementById('carga-punto-id').value = punto.id;
        document.getElementById('carga-nombre-punto').textContent = `${punto.nombre} • Sector ${punto.sector}`;
        const input = document.getElementById('carga-kilos-sumar');
        input.value = Math.min(200, disponible > 0 ? disponible : 100);
        document.getElementById('carga-max-info').textContent = `Actual: ${punto.actual.toLocaleString()} kg / Máx: ${punto.maximo.toLocaleString()} kg (Espacio libre: ${disponible.toLocaleString()} kg)`;

        document.getElementById('modal-carga').classList.remove('hidden');
        document.getElementById('modal-carga').classList.add('flex');
    }

    function cerrarModalCarga() {
        document.getElementById('modal-carga').classList.add('hidden');
        document.getElementById('modal-carga').classList.remove('flex');
    }

    function guardarCargaPunto(e) {
        e.preventDefault();
        const id = parseInt(document.getElementById('carga-punto-id').value, 10);
        const tipoResiduo = document.getElementById('carga-tipo-residuo').value;
        const kilosSumar = parseInt(document.getElementById('carga-kilos-sumar').value, 10);
        const punto = puntosAcopio.find(p => p.id === id);

        if (punto && kilosSumar > 0) {
            const espacioDisponible = punto.maximo - punto.actual;
            const kilosReales = Math.min(espacioDisponible > 0 ? espacioDisponible : kilosSumar, kilosSumar);
            punto.actual = Math.min(punto.maximo, punto.actual + kilosSumar);

            const nombresEtiqueta = {
                plastico: 'Plástico PET',
                carton: 'Cartón',
                vidrio: 'Vidrio',
                desmonte: 'Desmonte'
            };
            const tag = nombresEtiqueta[tipoResiduo];
            if (tag && !punto.residuos.includes(tag)) {
                punto.residuos.push(tag);
            }

            registrarKilosEnGraficoDashboard(punto.sector, tipoResiduo, kilosReales > 0 ? kilosReales : kilosSumar);

            guardarEnStorage();
            renderizarTabla();
        }
        cerrarModalCarga();
    }

    function filtrarPuntos() { renderizarTabla(); }

    function cambiarFiltroEstado(estado, btn) {
        filtroEstadoActual = estado;
        document.querySelectorAll('.filtro-btn').forEach(b => {
            b.className = 'filtro-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer';
        });
        btn.className = 'filtro-btn px-3 py-1.5 rounded-lg text-xs font-extrabold bg-slate-900 text-white transition cursor-pointer';
        renderizarTabla();
    }

    function abrirModalAcopio() {
        document.getElementById('error-chips-residuo').classList.add('hidden');
        document.getElementById('modal-acopio').classList.remove('hidden');
        document.getElementById('modal-acopio').classList.add('flex');
    }

    function cerrarModalAcopio() {
        document.getElementById('modal-acopio').classList.add('hidden');
        document.getElementById('modal-acopio').classList.remove('flex');
    }

    function guardarNuevoPunto(e) {
        e.preventDefault();
        const chipsActivos = Array.from(document.querySelectorAll('.chip-residuo.border-emerald-500'))
            .map(btn => btn.getAttribute('data-residuo'));

        if (chipsActivos.length === 0) {
            document.getElementById('error-chips-residuo').classList.remove('hidden');
            return;
        }

        const nombre = document.getElementById('input-nombre').value;
        const sector = document.getElementById('input-sector').value;
        const maximo = parseInt(document.getElementById('input-capacidad').value, 10);
        const actual = Math.min(maximo, Math.max(0, parseInt(document.getElementById('input-actual').value, 10)));

        puntosAcopio.unshift({
            id: Date.now(),
            nombre,
            direccion: 'Sede Municipal ' + sector,
            sector,
            residuos: chipsActivos,
            actual,
            maximo
        });

        guardarEnStorage();
        e.target.reset();
        cerrarModalAcopio();
        renderizarTabla();
    }

    window.addEventListener('load', renderizarTabla);
</script>
@endsection