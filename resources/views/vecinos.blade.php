@extends('layouts.app')

@section('content')
<div class="space-y-6 pb-8">
    <!-- Encabezado y Acciones -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Ranking de EcoColaboradores Destacados</h1>
            <p class="text-sm text-slate-500 mt-0.5">Clasificación vecinal según EcoPuntos ganados por segregación en origen y reciclaje en Los Olivos.</p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <button onclick="restaurarVecinosPorDefecto()" title="Restaurar vecinos iniciales" class="px-3 py-2.5 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-xs font-bold rounded-xl transition inline-flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Restaurar
            </button>
            <button onclick="abrirModalVecino()" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-extrabold rounded-xl shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
                <i data-lucide="user-plus" class="w-4 h-4"></i> Registrar Nuevo EcoColaborador
            </button>
        </div>
    </div>

    <!-- Podio Top 3 EcoColaboradores -->
    <div id="podio-top3" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Renderizado dinámico por JS -->
    </div>

    <!-- Barra de Búsqueda y Filtro por Sector -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-lg">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" id="buscar-vecino" onkeyup="renderizarRanking()" placeholder="Buscar en la tabla por Nombre, DNI o Sector..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div class="flex items-center gap-2">
            <select id="filtro-sector-vecino" onchange="renderizarRanking()" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                <option value="todos">Todos los Sectores</option>
                <option value="Covida">Covida</option>
                <option value="Sol de Oro">Sol de Oro</option>
                <option value="Sector Pro">Sector Pro</option>
                <option value="Mercurio">Mercurio</option>
                <option value="Villa Sol">Villa Sol</option>
            </select>
        </div>
    </div>

    <!-- Tabla Principal de Ranking -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                        <th class="py-3.5 px-5 w-24">Posición</th>
                        <th class="py-3.5 px-5">EcoColaborador</th>
                        <th class="py-3.5 px-5">DNI / Sector</th>
                        <th class="py-3.5 px-5">Rol / Insignia</th>
                        <th class="py-3.5 px-5 text-emerald-600">Puntaje Total</th>
                        <th class="py-3.5 px-5 text-right">Sumar Puntos</th>
                    </tr>
                </thead>
                <tbody id="tabla-vecinos-body" class="divide-y divide-slate-100 text-sm">
                    <!-- Renderizado dinámico por JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal 1: Registrar Nuevo EcoColaborador -->
<div id="modal-vecino" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-black text-slate-900">Registrar Nuevo EcoColaborador</h3>
            <button onclick="cerrarModalVecino()" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form onsubmit="guardarNuevoVecino(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1">Nombre Completo del Vecino</label>
                <input type="text" id="vecino-nombre" required placeholder="Ej. Carlos Alberto Mendoza" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1">DNI (8 dígitos)</label>
                    <input type="text" id="vecino-dni" required maxlength="8" pattern="[0-9]{8}" placeholder="74829104" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1">Sector</label>
                    <select id="vecino-sector" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="Covida">Covida</option>
                        <option value="Sol de Oro">Sol de Oro</option>
                        <option value="Sector Pro">Sector Pro</option>
                        <option value="Mercurio">Mercurio</option>
                        <option value="Villa Sol">Villa Sol</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1">EcoPuntos Iniciales</label>
                <input type="number" id="vecino-puntos" value="100" min="0" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="cerrarModalVecino()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl cursor-pointer">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-extrabold rounded-xl shadow-sm cursor-pointer">Registrar Vecino</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Sumar EcoPuntos Personalizados -->
<div id="modal-sumar-puntos" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-slate-200">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-base font-black text-slate-900">Asignar EcoPuntos</h3>
            <button onclick="cerrarModalPuntos()" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <p id="puntos-nombre-vecino" class="text-xs font-bold text-emerald-700 mb-4"></p>
        <form onsubmit="confirmarSumaPuntos(event)" class="space-y-4">
            <input type="hidden" id="puntos-vecino-id">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 mb-1">EcoPuntos a sumar (10 pts = 1 kg reciclado)</label>
                <input type="number" id="puntos-cantidad-sumar" value="100" min="1" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="flex justify-end gap-2 pt-1">
                <button type="button" onclick="cerrarModalPuntos()" class="px-3.5 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl cursor-pointer">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-extrabold rounded-xl shadow-sm cursor-pointer">Sumar Puntos</button>
            </div>
        </form>
    </div>
</div>

<script>
    const STORAGE_KEY_VECINOS = 'ecobarrio_vecinos_ranking_v1';

    const vecinosIniciales = [
        { id: 1, nombre: 'María Elena Gutiérrez', dni: '45891234', sector: 'Sol de Oro', puntos: 2480 },
        { id: 2, nombre: 'Jorge Carlos Quispe', dni: '41209876', sector: 'Covida', puntos: 2150 },
        { id: 3, nombre: 'Lucía Fernanda Paredes', dni: '72940182', sector: 'Sector Pro', puntos: 1890 },
        { id: 4, nombre: 'Roberto Ángel Huamán', dni: '46782310', sector: 'Mercurio', puntos: 1540 },
        { id: 5, nombre: 'Ana Sofía Villalobos', dni: '70129384', sector: 'Villa Sol', puntos: 1320 },
        { id: 6, nombre: 'Diego Armando Salazar', dni: '48392011', sector: 'Covida', puntos: 980 },
        { id: 7, nombre: 'Carmen Rosa Espinoza', dni: '09847123', sector: 'Sol de Oro', puntos: 760 }
    ];

    function cargarVecinosGuardados() {
        try {
            const guardado = localStorage.getItem(STORAGE_KEY_VECINOS);
            if (guardado) {
                const parsed = JSON.parse(guardado);
                if (Array.isArray(parsed)) return parsed;
            }
        } catch (e) {}
        return JSON.parse(JSON.stringify(vecinosIniciales));
    }

    function guardarVecinosStorage() {
        localStorage.setItem(STORAGE_KEY_VECINOS, JSON.stringify(listaVecinos));
    }

    let listaVecinos = cargarVecinosGuardados();

    function restaurarVecinosPorDefecto() {
        listaVecinos = JSON.parse(JSON.stringify(vecinosIniciales));
        guardarVecinosStorage();
        renderizarRanking();
    }

    function obtenerInsignia(puntos) {
        if (puntos >= 2000) return { label: 'Embajador Verde', clase: 'bg-emerald-50 text-emerald-700 border-emerald-200' };
        if (puntos >= 1300) return { label: 'EcoLíder Distrital', clase: 'bg-blue-50 text-blue-700 border-blue-200' };
        if (puntos >= 800)  return { label: 'Reciclador Activo', clase: 'bg-amber-50 text-amber-700 border-amber-200' };
        return { label: 'EcoVecino Inicial', clase: 'bg-slate-100 text-slate-600 border-slate-200' };
    }

    function obtenerIniciales(nombre) {
        return nombre.split(' ').slice(0, 2).map(n => n[0]).join('').toUpperCase();
    }

    function renderizarRanking() {
        // Ordenar siempre de mayor a menor puntaje
        listaVecinos.sort((a, b) => b.puntos - a.puntos);

        // Renderizar Podio Top 3
        const podioContainer = document.getElementById('podio-top3');
        const top3 = listaVecinos.slice(0, 3);
        const estilosPodio = [
            { borde: 'border-amber-300 bg-gradient-to-br from-amber-50/90 to-white', medalla: '🥇 1° Puesto', badge: 'bg-amber-500 text-white' },
            { borde: 'border-slate-300 bg-gradient-to-br from-slate-50 to-white', medalla: '🥈 2° Puesto', badge: 'bg-slate-700 text-white' },
            { borde: 'border-orange-200 bg-gradient-to-br from-orange-50/70 to-white', medalla: '🥉 3° Puesto', badge: 'bg-orange-600 text-white' }
        ];

        podioContainer.innerHTML = top3.map((v, idx) => {
            const st = estilosPodio[idx];
            return `
                <div class="p-4 rounded-2xl border ${st.borde} shadow-sm flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-sm shrink-0">
                            ${obtenerIniciales(v.nombre)}
                        </div>
                        <div>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold ${st.badge}">${st.medalla}</span>
                            <h3 class="text-sm font-black text-slate-900 mt-1">${v.nombre}</h3>
                            <p class="text-xs text-slate-500">${v.sector} • DNI ${v.dni}</p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-xl font-black text-emerald-600">${v.puntos.toLocaleString()}</div>
                        <div class="text-[10px] font-bold uppercase text-slate-400">EcoPuntos</div>
                    </div>
                </div>
            `;
        }).join('');

        // Filtrar para la tabla
        const texto = document.getElementById('buscar-vecino').value.toLowerCase();
        const sectorFiltro = document.getElementById('filtro-sector-vecino').value;

        const filtrados = listaVecinos
            .map((v, indexReal) => ({ ...v, posicion: indexReal + 1 }))
            .filter(v => {
                const coincideTexto = v.nombre.toLowerCase().includes(texto) || v.dni.includes(texto) || v.sector.toLowerCase().includes(texto);
                const coincideSector = sectorFiltro === 'todos' || v.sector === sectorFiltro;
                return coincideTexto && coincideSector;
            });

        const tbody = document.getElementById('tabla-vecinos-body');
        if (filtrados.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="py-10 text-center text-xs font-bold text-slate-400">No se encontraron EcoColaboradores con ese criterio.</td></tr>`;
            return;
        }

        tbody.innerHTML = filtrados.map(v => {
            const insignia = obtenerInsignia(v.puntos);
            let posBadge = `<span class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 font-extrabold text-xs inline-flex items-center justify-center">#${v.posicion}</span>`;
            if (v.posicion === 1) posBadge = `<span class="px-2.5 py-1 rounded-lg bg-amber-100 text-amber-800 font-black text-xs">🥇 #1</span>`;
            if (v.posicion === 2) posBadge = `<span class="px-2.5 py-1 rounded-lg bg-slate-200 text-slate-800 font-black text-xs">🥈 #2</span>`;
            if (v.posicion === 3) posBadge = `<span class="px-2.5 py-1 rounded-lg bg-orange-100 text-orange-800 font-black text-xs">🥉 #3</span>`;

            return `
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-3.5 px-5">${posBadge}</td>
                    <td class="py-3.5 px-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 font-black text-xs flex items-center justify-center shrink-0">
                                ${obtenerIniciales(v.nombre)}
                            </div>
                            <div class="font-extrabold text-slate-900 text-sm">${v.nombre}</div>
                        </div>
                    </td>
                    <td class="py-3.5 px-5">
                        <div class="text-xs font-bold text-slate-700">DNI: ${v.dni}</div>
                        <div class="text-[11px] text-slate-400 font-semibold">${v.sector}</div>
                    </td>
                    <td class="py-3.5 px-5">
                        <span class="px-2.5 py-1 rounded-lg border text-[11px] font-extrabold ${insignia.clase}">
                            ${insignia.label}
                        </span>
                    </td>
                    <td class="py-3.5 px-5">
                        <span class="text-base font-black text-emerald-600">${v.puntos.toLocaleString()}</span>
                        <span class="text-xs font-bold text-slate-400">pts</span>
                    </td>
                    <td class="py-3.5 px-5 text-right">
                        <div class="inline-flex items-center justify-end gap-1.5">
                            <button onclick="sumarPuntosRapido(${v.id}, 50)" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-extrabold rounded-lg transition cursor-pointer">
                                +50 pts
                            </button>
                            <button onclick="abrirModalPuntos(${v.id})" title="Asignar otra cantidad" class="px-2.5 py-1.5 bg-slate-900 hover:bg-slate-700 text-white text-xs font-bold rounded-lg transition cursor-pointer inline-flex items-center gap-1">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Otro
                            </button>
                            <button onclick="eliminarVecino(${v.id})" title="Eliminar vecino" class="p-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 rounded-lg transition cursor-pointer">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function sumarPuntosRapido(id, cantidad) {
        const vecino = listaVecinos.find(v => v.id === id);
        if (vecino) {
            vecino.puntos += cantidad;
            guardarVecinosStorage();
            renderizarRanking();
        }
    }

    function abrirModalPuntos(id) {
        const vecino = listaVecinos.find(v => v.id === id);
        if (!vecino) return;
        document.getElementById('puntos-vecino-id').value = vecino.id;
        document.getElementById('puntos-nombre-vecino').textContent = `${vecino.nombre} • Actual: ${vecino.puntos.toLocaleString()} pts`;
        document.getElementById('modal-sumar-puntos').classList.remove('hidden');
        document.getElementById('modal-sumar-puntos').classList.add('flex');
    }

    function cerrarModalPuntos() {
        document.getElementById('modal-sumar-puntos').classList.add('hidden');
        document.getElementById('modal-sumar-puntos').classList.remove('flex');
    }

    function confirmarSumaPuntos(e) {
        e.preventDefault();
        const id = parseInt(document.getElementById('puntos-vecino-id').value, 10);
        const cantidad = parseInt(document.getElementById('puntos-cantidad-sumar').value, 10);
        if (cantidad > 0) {
            sumarPuntosRapido(id, cantidad);
        }
        cerrarModalPuntos();
    }

    function eliminarVecino(id) {
        listaVecinos = listaVecinos.filter(v => v.id !== id);
        guardarVecinosStorage();
        renderizarRanking();
    }

    function abrirModalVecino() {
        document.getElementById('modal-vecino').classList.remove('hidden');
        document.getElementById('modal-vecino').classList.add('flex');
    }

    function cerrarModalVecino() {
        document.getElementById('modal-vecino').classList.add('hidden');
        document.getElementById('modal-vecino').classList.remove('flex');
    }

    function guardarNuevoVecino(e) {
        e.preventDefault();
        const nombre = document.getElementById('vecino-nombre').value;
        const dni = document.getElementById('vecino-dni').value;
        const sector = document.getElementById('vecino-sector').value;
        const puntos = parseInt(document.getElementById('vecino-puntos').value, 10);

        listaVecinos.push({
            id: Date.now(),
            nombre,
            dni,
            sector,
            puntos
        });

        guardarVecinosStorage();
        e.target.reset();
        cerrarModalVecino();
        renderizarRanking();
    }

    window.addEventListener('load', renderizarRanking);
</script>
@endsection