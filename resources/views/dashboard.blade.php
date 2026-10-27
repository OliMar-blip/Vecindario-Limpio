@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- 1. Tarjetas de Métricas Principales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Reciclado -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Reciclado</p>
                <h3 id="stat-total-tons" class="text-2xl font-extrabold text-slate-900 mt-1">54.2 Ton</h3>
                <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +18% este mes
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                <i data-lucide="scale" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- EcoColaboradores -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">EcoColaboradores</p>
                <h3 id="stat-total-ecosocios" class="text-2xl font-extrabold text-slate-900 mt-1">1,890</h3>
                <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> 45 nuevos hoy
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Puntos Críticos -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Puntos Críticos</p>
                <h3 id="stat-critical-points" class="text-2xl font-extrabold text-amber-600 mt-1">2 Puntos</h3>
                <p class="text-xs text-amber-600 font-medium mt-1">Contenedores > 80% capacidad</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- EcoPuntos Canjeados -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">EcoPuntos Canjeados</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">12,650 pts</h3>
                <p class="text-xs text-purple-600 font-medium mt-1">Descuentos en arbitrios y plantas</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- 2. Gráficos y Alertas de Puntos Críticos -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Gráfico interactivo -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-slate-800 font-heading">Recolección Semanal en Los Olivos</h3>
                    <p class="text-xs text-slate-500">Volumen acumulado por zonas clave (Covida, Sol de Oro, Pro, Mercurio, Villa Sol)</p>
                </div>
                <select id="chart-filter" onchange="updateChartData()" class="text-xs border border-slate-300 rounded-lg px-2.5 py-1.5 font-medium outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="all">Todos los Residuos</option>
                    <option value="pet">Solo PET / Plástico</option>
                    <option value="carton">Solo Cartón y Papel</option>
                    <option value="compost">Compost Orgánico</option>
                </select>
            </div>
            <div class="h-64 sm:h-72 w-full">
                <canvas id="recyclingChart"></canvas>
            </div>
        </div>

        <!-- Estado Rápido de Puntos Críticos -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-slate-800 font-heading">Alertas de Contenedores</h3>
                    <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full font-semibold">Atención</span>
                </div>
                <div id="dashboard-critical-list" class="space-y-3">
                    <!-- Se llena dinámicamente vía app.js -->
                </div>
            </div>
            <a href="{{ url('/acopio') }}" class="w-full mt-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-xs rounded-xl transition flex items-center justify-center gap-1">
                Gestionar Contenedores <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush