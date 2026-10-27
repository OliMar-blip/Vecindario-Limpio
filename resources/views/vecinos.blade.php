@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Encabezado de Sección y Botón de Registro -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-900 font-heading">Ranking de EcoColaboradores Destacados</h2>
            <p class="text-xs text-slate-500">Clasificación vecinal según EcoPuntos ganados por segregación en origen y reciclaje</p>
        </div>
        <button onclick="openVecinoModal()" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-md transition flex items-center justify-center gap-2">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Registrar Nuevo EcoColaborador
        </button>
    </div>

    <!-- TOP 3 PODIO DE ECOCOLABORADORES -->
    <div id="podium-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Renderizado dinámicamente con vecinos.js -->
    </div>

    <!-- Filtro y Búsqueda -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" id="search-vecinos" onkeyup="filterVecinos()" placeholder="Buscar en la tabla por Nombre, DNI o Sector..." class="w-full pl-9 pr-4 py-2 text-sm border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
    </div>

    <!-- Tabla de Ranking de EcoColaboradores -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-semibold text-xs uppercase border-b border-slate-200">
                        <th class="p-4 text-center">Posición</th>
                        <th class="p-4">EcoColaborador</th>
                        <th class="p-4">DNI / Sector</th>
                        <th class="p-4">Rol / Insignia</th>
                        <th class="p-4 font-bold text-emerald-700">Puntaje Total</th>
                        <th class="p-4 text-right">Sumar Puntos</th>
                    </tr>
                </thead>
                <tbody id="vecinos-table-body" class="divide-y divide-slate-100 text-sm">
                    <!-- Renderizado dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL VECINO / ECOCOLABORADOR -->
<div id="modal-vecino" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
            <h3 class="font-heading font-bold text-slate-900 text-base">Registrar Nuevo EcoColaborador</h3>
            <button onclick="closeVecinoModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="form-vecino" onsubmit="saveVecino(event)" class="space-y-3 text-xs">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Nombre Completo</label>
                <input type="text" id="vecino-name" required placeholder="Ej. Lucía Mendoza" class="w-full p-2.5 border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">DNI</label>
                    <input type="text" id="vecino-dni" required maxlength="8" placeholder="71234567" class="w-full p-2.5 border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Sector (Los Olivos)</label>
                    <select id="vecino-sector" class="w-full p-2.5 border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="Covida">Covida</option>
                        <option value="Sol de Oro">Sol de Oro</option>
                        <option value="Pro">Pro</option>
                        <option value="Mercurio">Mercurio</option>
                        <option value="Villa Sol">Villa Sol</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Rol / Insignia</label>
                    <select id="vecino-badge" class="w-full p-2.5 border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="EcoVecino">EcoVecino</option>
                        <option value="Líder Verde">Líder Verde</option>
                        <option value="Brigadista VIP">Brigadista VIP</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Puntos Iniciales</label>
                    <input type="number" id="vecino-points" required min="0" value="100" class="w-full p-2.5 border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
            <div class="pt-3 flex gap-2">
                <button type="button" onclick="closeVecinoModal()" class="w-1/2 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition">Cancelar</button>
                <button type="submit" class="w-1/2 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-md transition">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/vecinos.js') }}"></script>
@endpush