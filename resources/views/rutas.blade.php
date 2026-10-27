@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Encabezado de la Sección -->
    <div>
        <h2 class="text-lg font-bold text-slate-900 font-heading">Programación de Camiones y Brigadas en Los Olivos</h2>
        <p class="text-xs text-slate-500">Horarios y rutas de recolección diferenciada en el distrito</p>
    </div>

    <!-- Rejilla de Rutas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Tarjeta Sector Covida -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex justify-between items-start">
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-lg">Covida</span>
                <span class="text-xs text-slate-400">Camión #01</span>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-sm">Ruta Covida: Av. Antúnez de Mayolo / Las Palmeras</h4>
                <p class="text-xs text-slate-500 mt-2">Días: <strong class="text-slate-700">Lun - Mié - Vie</strong></p>
                <p class="text-xs text-slate-500">Horario: <strong class="text-slate-700">07:00 AM - 11:00 AM</strong></p>
            </div>
            <div class="pt-3 border-t border-slate-100 flex justify-between items-center text-xs">
                <span class="text-slate-500">Brigadista a cargo:</span>
                <span class="font-semibold text-slate-800">C. Mendoza</span>
            </div>
        </div>

        <!-- Tarjeta Sector Sol de Oro -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex justify-between items-start">
                <span class="px-2.5 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-lg">Sol de Oro</span>
                <span class="text-xs text-slate-400">Camión #02</span>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-sm">Ruta Sol de Oro: Ca. Los Alisos / Av. Angélica Gamarra</h4>
                <p class="text-xs text-slate-500 mt-2">Días: <strong class="text-slate-700">Mar - Jue - Sáb</strong></p>
                <p class="text-xs text-slate-500">Horario: <strong class="text-slate-700">08:00 AM - 12:00 PM</strong></p>
            </div>
            <div class="pt-3 border-t border-slate-100 flex justify-between items-center text-xs">
                <span class="text-slate-500">Brigadista a cargo:</span>
                <span class="font-semibold text-slate-800">R. Flores</span>
            </div>
        </div>

        <!-- Tarjeta Sector Pro -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex justify-between items-start">
                <span class="px-2.5 py-1 bg-purple-100 text-purple-800 text-xs font-bold rounded-lg">Pro</span>
                <span class="text-xs text-slate-400">Camión #03</span>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-sm">Ruta Pro: Av. Alfredo Mendiola / Mercado Unicachi</h4>
                <p class="text-xs text-slate-500 mt-2">Días: <strong class="text-slate-700">Diario</strong></p>
                <p class="text-xs text-slate-500">Horario: <strong class="text-slate-700">08:00 PM - 11:00 PM</strong></p>
            </div>
            <div class="pt-3 border-t border-slate-100 flex justify-between items-center text-xs">
                <span class="text-slate-500">Brigadista a cargo:</span>
                <span class="font-semibold text-slate-800">M. Quispe</span>
            </div>
        </div>

        <!-- Tarjeta Sector Mercurio & Villa Sol -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex justify-between items-start">
                <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-lg">Villa Sol / Mercurio</span>
                <span class="text-xs text-slate-400">Camión #04</span>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-sm">Ruta Universitaria: Av. Universitaria / UPN</h4>
                <p class="text-xs text-slate-500 mt-2">Días: <strong class="text-slate-700">Mar - Sáb</strong></p>
                <p class="text-xs text-slate-500">Horario: <strong class="text-slate-700">02:00 PM - 06:00 PM</strong></p>
            </div>
            <div class="pt-3 border-t border-slate-100 flex justify-between items-center text-xs">
                <span class="text-slate-500">Brigadista a cargo:</span>
                <span class="font-semibold text-slate-800">J. Carlos</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/rutas.js') }}"></script>
@endpush