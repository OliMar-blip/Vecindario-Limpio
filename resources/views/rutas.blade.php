@extends('layouts.app')

@section('content')
<div class="space-y-6 pb-8">
    <!-- Encabezado y Botones -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Programación de Camiones y Brigadas en Los Olivos</h1>
            <p class="text-sm text-slate-500 mt-0.5">Horarios, rutas de recolección diferenciada y despacho de unidades compactadoras en tiempo real.</p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <button onclick="restaurarRutasPorDefecto()" title="Restaurar rutas iniciales" class="px-3 py-2.5 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-xs font-bold rounded-xl transition inline-flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Restaurar
            </button>
            <button onclick="abrirModalRuta()" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-extrabold rounded-xl shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Nueva Ruta / Camión
            </button>
        </div>
    </div>

    <!-- KPIs de Flota y Despacho -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Flota Asignada</p>
                <h3 id="stat-flota-total" class="text-2xl font-black text-slate-900 mt-0.5">4</h3>
            </div>
            <div class="p-2.5 bg-slate-100 text-slate-700 rounded-xl"><i data-lucide="truck" class="w-5 h-5"></i></div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">En Ruta Activa</p>
                <h3 id="stat-en-ruta" class="text-2xl font-black text-emerald-600 mt-0.5">2</h3>
            </div>
            <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl"><i data-lucide="navigation" class="w-5 h-5"></i></div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Carga en Tránsito</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5"><span id="stat-carga-transito">4,350</span> <span class="text-xs font-bold text-slate-400">kg</span></h3>
            </div>
            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl"><i data-lucide="package" class="w-5 h-5"></i></div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Viajes Completados</p>
                <h3 id="stat-completados" class="text-2xl font-black text-purple-600 mt-0.5">1</h3>
            </div>
            <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl"><i data-lucide="check-circle-2" class="w-5 h-5"></i></div>
        </div>
    </div>

    <!-- Filtros por Estado y Buscador -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-md">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" id="buscar-ruta" onkeyup="renderizarRutas()" placeholder="Buscar por ruta, avenida, camión o brigadista..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button onclick="cambiarFiltroRuta('todos', this)" class="filtro-ruta-btn px-3 py-1.5 rounded-lg text-xs font-extrabold bg-slate-900 text-white transition cursor-pointer">Todas</button>
            <button onclick="cambiarFiltroRuta('En Ruta', this)" class="filtro-ruta-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer">En Ruta</button>
            <button onclick="cambiarFiltroRuta('Programado', this)" class="filtro-ruta-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer">Programados</button>
            <button onclick="cambiarFiltroRuta('Completado', this)" class="filtro-ruta-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer">Completados</button>
        </div>
    </div>

    <!-- Grid de Tarjetas de Camiones y Brigadas -->
    <div id="grid-rutas-camiones" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-5">
        <!-- Renderizado dinámico por JS -->
    </div>

    <!-- Notificación Toast de Sincronización con Acopio -->
    <div id="toast-ruta" class="fixed bottom-5 right-5 bg-slate-900 text-white px-4 py-3 rounded-xl shadow-xl border border-slate-700 text-xs font-bold hidden items-center gap-2.5 z-50">
        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
        <span id="toast-ruta-texto"></span>
    </div>
</div>

<!-- Modal: Registrar Nueva Ruta / Camión -->
<div id="modal-ruta" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-black text-slate-900">Programar Nueva Ruta / Camión</h3>
            <button onclick="cerrarModalRuta()" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form onsubmit="guardarNuevaRuta(event)" class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1">Código Unidad</label>
                    <input type="text" id="ruta-camion" required placeholder="Ej. Camión #05" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1">Sector Asignado</label>
                    <select id="ruta-sector" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="Covida">Covida</option>
                        <option value="Sol de Oro">Sol de Oro</option>
                        <option value="Sector Pro">Sector Pro</option>
                        <option value="Mercurio">Mercurio</option>
                        <option value="Villa Sol">Villa Sol</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1">Nombre / Recorrido de la Ruta</label>
                <input type="text" id="ruta-titulo" required placeholder="Ej. Ruta Naranjal: Av. Naranjal / Huandoy" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <!-- Chips seleccionables para días de recolección -->
            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1.5">Días de Recolección <span class="text-slate-400 font-normal">(Clic para marcar)</span></label>
                <div class="flex flex-wrap gap-1.5" id="chips-dias-container">
                    <button type="button" data-dia="Lun" onclick="toggleChipDia(this)" class="chip-dia px-2.5 py-1 rounded-lg text-xs font-extrabold border border-emerald-500 bg-emerald-50 text-emerald-700 cursor-pointer">✓ Lun</button>
                    <button type="button" data-dia="Mar" onclick="toggleChipDia(this)" class="chip-dia px-2.5 py-1 rounded-lg text-xs font-bold border border-slate-200 bg-slate-50 text-slate-600 cursor-pointer">+ Mar</button>
                    <button type="button" data-dia="Mié" onclick="toggleChipDia(this)" class="chip-dia px-2.5 py-1 rounded-lg text-xs font-extrabold border border-emerald-500 bg-emerald-50 text-emerald-700 cursor-pointer">✓ Mié</button>
                    <button type="button" data-dia="Jue" onclick="toggleChipDia(this)" class="chip-dia px-2.5 py-1 rounded-lg text-xs font-bold border border-slate-200 bg-slate-50 text-slate-600 cursor-pointer">+ Jue</button>
                    <button type="button" data-dia="Vie" onclick="toggleChipDia(this)" class="chip-dia px-2.5 py-1 rounded-lg text-xs font-extrabold border border-emerald-500 bg-emerald-50 text-emerald-700 cursor-pointer">✓ Vie</button>
                    <button type="button" data-dia="Sáb" onclick="toggleChipDia(this)" class="chip-dia px-2.5 py-1 rounded-lg text-xs font-bold border border-slate-200 bg-slate-50 text-slate-600 cursor-pointer">+ Sáb</button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1">Horario</label>
                    <input type="text" id="ruta-horario" value="07:30 AM - 11:30 AM" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1">Brigadista a cargo</label>
                    <input type="text" id="ruta-brigadista" required placeholder="Ej. L. Paredes" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="cerrarModalRuta()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl cursor-pointer">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-extrabold rounded-xl shadow-sm cursor-pointer">Guardar Ruta</button>
            </div>
        </form>
    </div>
</div>

<script>
    const STORAGE_KEY_RUTAS = 'ecobarrio_rutas_camiones_v1';
    const STORAGE_KEY_ACOPIO = 'ecobarrio_puntos_acopio_v1';

    const rutasIniciales = [
        {
            id: 1,
            sector: 'Covida',
            camion: 'Camión #01',
            placa: 'EGP-412',
            titulo: 'Ruta Covida: Av. Antúnez de Mayolo / Las Palmeras',
            dias: 'Lun - Mié - Vie',
            horario: '07:00 AM - 11:00 AM',
            brigadista: 'C. Mendoza',
            estado: 'En Ruta',
            cargaActual: 1850,
            capacidadMax: 3000
        },
        {
            id: 2,
            sector: 'Sol de Oro',
            camion: 'Camión #02',
            placa: 'EGP-518',
            titulo: 'Ruta Sol de Oro: Ca. Los Alisos / Av. Angélica Gamarra',
            dias: 'Mar - Jue - Sáb',
            horario: '08:00 AM - 12:00 PM',
            brigadista: 'R. Flores',
            estado: 'En Ruta',
            cargaActual: 2500,
            capacidadMax: 3000
        },
        {
            id: 3,
            sector: 'Sector Pro',
            camion: 'Camión #03',
            placa: 'EGP-609',
            titulo: 'Ruta Pro: Av. Alfredo Mendiola / Mercado Unicachi',
            dias: 'Diario',
            horario: '08:00 PM - 11:00 PM',
            brigadista: 'M. Quispe',
            estado: 'Programado',
            cargaActual: 0,
            capacidadMax: 3500
        },
        {
            id: 4,
            sector: 'Mercurio',
            camion: 'Camión #04',
            placa: 'EGP-724',
            titulo: 'Ruta Universitaria: Av. Universitaria / UPN',
            dias: 'Mar - Sáb',
            horario: '02:00 PM - 06:00 PM',
            brigadista: 'J. Carlos',
            estado: 'Completado',
            cargaActual: 2950,
            capacidadMax: 3000
        }
    ];

    function cargarRutasGuardadas() {
        try {
            const guardado = localStorage.getItem(STORAGE_KEY_RUTAS);
            if (guardado) {
                const parsed = JSON.parse(guardado);
                if (Array.isArray(parsed)) return parsed;
            }
        } catch (e) {}
        return JSON.parse(JSON.stringify(rutasIniciales));
    }

    function guardarRutasStorage() {
        localStorage.setItem(STORAGE_KEY_RUTAS, JSON.stringify(listaRutas));
    }

    let listaRutas = cargarRutasGuardadas();
    let filtroEstadoRuta = 'todos';

    function mostrarToastRuta(mensaje) {
        const toast = document.getElementById('toast-ruta');
        document.getElementById('toast-ruta-texto').textContent = mensaje;
        toast.classList.remove('hidden');
        toast.classList.add('flex');
        setTimeout(() => {
            toast.classList.add('hidden');
            toast.classList.remove('flex');
        }, 3500);
    }

    function restaurarRutasPorDefecto() {
        listaRutas = JSON.parse(JSON.stringify(rutasIniciales));
        guardarRutasStorage();
        renderizarRutas();
    }

    function cambiarFiltroRuta(estado, btn) {
        filtroEstadoRuta = estado;
        document.querySelectorAll('.filtro-ruta-btn').forEach(b => {
            b.className = 'filtro-ruta-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer';
        });
        btn.className = 'filtro-ruta-btn px-3 py-1.5 rounded-lg text-xs font-extrabold bg-slate-900 text-white transition cursor-pointer';
        renderizarRutas();
    }

    function toggleChipDia(btn) {
        const activo = btn.classList.contains('border-emerald-500');
        const dia = btn.getAttribute('data-dia');
        if (activo) {
            btn.className = 'chip-dia px-2.5 py-1 rounded-lg text-xs font-bold border border-slate-200 bg-slate-50 text-slate-600 cursor-pointer';
            btn.textContent = '+ ' + dia;
        } else {
            btn.className = 'chip-dia px-2.5 py-1 rounded-lg text-xs font-extrabold border border-emerald-500 bg-emerald-50 text-emerald-700 cursor-pointer';
            btn.textContent = '✓ ' + dia;
        }
    }

    function renderizarRutas() {
        const texto = document.getElementById('buscar-ruta').value.toLowerCase();

        // Actualizar KPIs
        const enRuta = listaRutas.filter(r => r.estado === 'En Ruta');
        const completados = listaRutas.filter(r => r.estado === 'Completado');
        const cargaTransito = enRuta.reduce((acc, r) => acc + r.cargaActual, 0);

        document.getElementById('stat-flota-total').textContent = listaRutas.length;
        document.getElementById('stat-en-ruta').textContent = enRuta.length;
        document.getElementById('stat-carga-transito').textContent = cargaTransito.toLocaleString();
        document.getElementById('stat-completados').textContent = completados.length;

        const filtradas = listaRutas.filter(r => {
            const coincideTexto = r.titulo.toLowerCase().includes(texto) || r.sector.toLowerCase().includes(texto) || r.camion.toLowerCase().includes(texto) || r.brigadista.toLowerCase().includes(texto);
            if (!coincideTexto) return false;
            if (filtroEstadoRuta !== 'todos' && r.estado !== filtroEstadoRuta) return false;
            return true;
        });

        const grid = document.getElementById('grid-rutas-camiones');
        if (filtradas.length === 0) {
            grid.innerHTML = `<div class="col-span-full bg-white p-10 rounded-2xl border border-slate-200 text-center text-xs font-bold text-slate-400">No hay camiones o rutas con ese filtro.</div>`;
            return;
        }

        const coloresSector = {
            'Covida': 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'Sol de Oro': 'bg-blue-50 text-blue-700 border-blue-200',
            'Sector Pro': 'bg-purple-50 text-purple-700 border-purple-200',
            'Mercurio': 'bg-amber-50 text-amber-700 border-amber-200',
            'Villa Sol': 'bg-teal-50 text-teal-700 border-teal-200'
        };

        grid.innerHTML = filtradas.map(r => {
            const pctCarga = Math.min(100, Math.round((r.cargaActual / r.capacidadMax) * 100));
            const tagSector = coloresSector[r.sector] || 'bg-slate-100 text-slate-700 border-slate-200';

            let badgeEstado = `<span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span> En Ruta</span>`;
            if (r.estado === 'Programado') {
                badgeEstado = `<span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200">🕒 Programado</span>`;
            } else if (r.estado === 'Completado') {
                badgeEstado = `<span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-slate-100 text-slate-700 border border-slate-200">✓ Completado</span>`;
            }

            return `
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between gap-4">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-lg border text-xs font-extrabold ${tagSector}">${r.sector}</span>
                                <span class="text-xs font-bold text-slate-400">${r.camion} • ${r.placa}</span>
                            </div>
                            ${badgeEstado}
                        </div>

                        <h3 class="text-base font-black text-slate-900 leading-snug">${r.titulo}</h3>

                        <div class="mt-3 grid grid-cols-2 gap-2 text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <div><span class="text-slate-400 font-semibold">Días:</span> <strong class="text-slate-800">${r.dias}</strong></div>
                            <div><span class="text-slate-400 font-semibold">Horario:</span> <strong class="text-slate-800">${r.horario}</strong></div>
                        </div>

                        <!-- Barra de Carga del Camión -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-bold text-slate-500">Carga en tolva compactadora</span>
                                <span class="font-extrabold text-slate-800">${r.cargaActual.toLocaleString()} / ${r.capacidadMax.toLocaleString()} kg (${pctCarga}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-300" style="width: ${pctCarga}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
                        <div class="text-xs">
                            <span class="text-slate-400">Brigadista:</span>
                            <strong class="text-slate-900 ml-1">${r.brigadista}</strong>
                        </div>

                        <div class="flex items-center gap-1.5">
                            ${r.estado !== 'En Ruta' ? `
                                <button onclick="cambiarEstadoRuta(${r.id}, 'En Ruta')" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-extrabold rounded-lg transition cursor-pointer">
                                    Iniciar Ruta
                                </button>
                            ` : ''}
                            ${r.estado !== 'Completado' ? `
                                <button onclick="completarYVaciarSector(${r.id})" title="Completar ruta y vaciar puntos de acopio de este sector" class="px-2.5 py-1.5 bg-slate-900 hover:bg-emerald-600 text-white text-xs font-bold rounded-lg transition cursor-pointer inline-flex items-center gap-1">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i> Completar y Recoger
                                </button>
                            ` : ''}
                            <button onclick="eliminarRuta(${r.id})" title="Eliminar ruta" class="p-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 rounded-lg transition cursor-pointer">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function cambiarEstadoRuta(id, nuevoEstado) {
        const ruta = listaRutas.find(r => r.id === id);
        if (ruta) {
            ruta.estado = nuevoEstado;
            if (nuevoEstado === 'En Ruta' && ruta.cargaActual === 0) {
                ruta.cargaActual = 1200;
            }
            guardarRutasStorage();
            renderizarRutas();
        }
    }

    function completarYVaciarSector(id) {
        const ruta = listaRutas.find(r => r.id === id);
        if (!ruta) return;

        // Sincronizar con Puntos de Acopio: recoger y vaciar los contenedores de ese sector
        let kilosRecogidos = 0;
        try {
            const guardadoAcopio = localStorage.getItem(STORAGE_KEY_ACOPIO);
            if (guardadoAcopio) {
                const puntos = JSON.parse(guardadoAcopio);
                if (Array.isArray(puntos)) {
                    puntos.forEach(p => {
                        if (p.sector === ruta.sector && p.actual > 0) {
                            kilosRecogidos += p.actual;
                            p.actual = 0;
                        }
                    });
                    localStorage.setItem(STORAGE_KEY_ACOPIO, JSON.stringify(puntos));
                }
            }
        } catch (e) {}

        ruta.estado = 'Completado';
        if (kilosRecogidos > 0) {
            ruta.cargaActual = Math.min(ruta.capacidadMax, ruta.cargaActual + kilosRecogidos);
            mostrarToastRuta(`Ruta completada: ${kilosRecogidos.toLocaleString()} kg recogidos y contenedores de ${ruta.sector} vaciados.`);
        } else {
            mostrarToastRuta(`Ruta de ${ruta.sector} marcada como Completada.`);
        }

        guardarRutasStorage();
        renderizarRutas();
    }

    function eliminarRuta(id) {
        listaRutas = listaRutas.filter(r => r.id !== id);
        guardarRutasStorage();
        renderizarRutas();
    }

    function abrirModalRuta() {
        document.getElementById('modal-ruta').classList.remove('hidden');
        document.getElementById('modal-ruta').classList.add('flex');
    }

    function cerrarModalRuta() {
        document.getElementById('modal-ruta').classList.add('hidden');
        document.getElementById('modal-ruta').classList.remove('flex');
    }

    function guardarNuevaRuta(e) {
        e.preventDefault();
        const camion = document.getElementById('ruta-camion').value;
        const sector = document.getElementById('ruta-sector').value;
        const titulo = document.getElementById('ruta-titulo').value;
        const horario = document.getElementById('ruta-horario').value;
        const brigadista = document.getElementById('ruta-brigadista').value;

        const diasActivos = Array.from(document.querySelectorAll('.chip-dia.border-emerald-500'))
            .map(b => b.getAttribute('data-dia'));
        const diasTexto = diasActivos.length > 0 ? diasActivos.join(' - ') : 'Lun - Mié - Vie';

        listaRutas.push({
            id: Date.now(),
            sector,
            camion,
            placa: 'EGP-' + Math.floor(100 + Math.random() * 899),
            titulo,
            dias: diasTexto,
            horario,
            brigadista,
            estado: 'Programado',
            cargaActual: 0,
            capacidadMax: 3000
        });

        guardarRutasStorage();
        e.target.reset();
        cerrarModalRuta();
        renderizarRutas();
    }

    window.addEventListener('load', renderizarRutas);
</script>
@endsection