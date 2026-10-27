@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Encabezado de Sección y Botón Nuevo -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-900 font-heading">Puntos de Acopio EcoVecinales - Los Olivos</h2>
            <p class="text-xs text-slate-500">Administra contenedores, ubicaciones y capacidad instalada</p>
        </div>
        <button onclick="openAcopioModal()" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-md transition flex items-center justify-center gap-2">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            Nuevo Punto de Acopio
        </button>
    </div>

    <!-- Tabla de Puntos de Acopio -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-semibold text-xs uppercase border-b border-slate-200">
                        <th class="p-4">Ubicación / Sector</th>
                        <th class="p-4">Tipos de Residuos</th>
                        <th class="p-4">Capacidad Acumulada</th>
                        <th class="p-4">Nivel de Llenado</th>
                        <th class="p-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody id="acopio-table-body" class="divide-y divide-slate-100 text-sm">
                    <!-- Se renderiza dinámicamente con acopio.js -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL ACOPIO (CREAR / EDITAR) -->
<div id="modal-acopio" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
            <h3 id="modal-acopio-title" class="font-heading font-bold text-slate-900 text-base">Nuevo Punto de Acopio</h3>
            <button onclick="closeAcopioModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="form-acopio" onsubmit="saveAcopio(event)" class="space-y-3 text-xs">
            <input type="hidden" id="acopio-id">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Nombre o Lugar del Punto de Acopio</label>
                <input type="text" id="acopio-name" required placeholder="Ej. Punto Limpio Covida" class="w-full p-2.5 border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Sector / Referencia</label>
                <input type="text" id="acopio-sector" required placeholder="Ej. Av. Antúnez de Mayolo CDRA 8" class="w-full p-2.5 border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Tipo de Residuo</label>
                    <select id="acopio-type" class="w-full p-2.5 border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="Plásticos y PET">Plásticos y PET</option>
                        <option value="Cartón y Papel">Cartón y Papel</option>
                        <option value="Vidrio y Orgánicos">Vidrio y Orgánicos</option>
                        <option value="Multiresiduos / RAEE">Multiresiduos / RAEE</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Llenado (%)</label>
                    <input type="number" id="acopio-level" required min="0" max="100" placeholder="85" class="w-full p-2.5 border border-slate-300 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
            <div class="pt-3 flex gap-2">
                <button type="button" onclick="closeAcopioModal()" class="w-1/2 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition">Cancelar</button>
                <button type="submit" class="w-1/2 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-md transition">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/acopio.js') }}"></script>
@endpush