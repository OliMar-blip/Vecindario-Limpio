@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Métricas de Impacto -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="font-heading font-bold text-slate-900 text-lg">Métricas de Eco-Impacto Los Olivos</h3>
                <p class="text-xs text-slate-500">Ahorro de recursos y reducción de la huella ecológica en el distrito</p>
            </div>
            <button onclick="showToast('Generando reporte PDF para la Municipalidad de Los Olivos...', 'success')" class="bg-slate-900 hover:bg-slate-800 text-white text-xs px-4 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition">
                <i data-lucide="download" class="w-4 h-4"></i> Exportar Informe (PDF)
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Beneficio Ambiental Acumulado -->
            <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                <h4 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                    <i data-lucide="trees" class="w-5 h-5 text-emerald-600"></i> Beneficio Ambiental Acumulado
                </h4>
                <ul class="text-xs space-y-2 text-slate-600">
                    <li class="flex justify-between border-b pb-1 border-slate-200"><span>Árboles Salvados (por reciclaje de cartón):</span> <strong class="text-slate-800">320 árboles</strong></li>
                    <li class="flex justify-between border-b pb-1 border-slate-200"><span>Agua Potable Conservada:</span> <strong class="text-slate-800">65,000 Litros</strong></li>
                    <li class="flex justify-between"><span>Emisiones de CO2 Evitadas:</span> <strong class="text-emerald-600 font-bold">14.8 Toneladas</strong></li>
                </ul>
            </div>

            <!-- Impacto Comunitario y Beneficios -->
            <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                <h4 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                    <i data-lucide="coins" class="w-5 h-5 text-amber-600"></i> Impacto Comunitario y Beneficios
                </h4>
                <ul class="text-xs space-y-2 text-slate-600">
                    <li class="flex justify-between border-b pb-1 border-slate-200"><span>Compost Entregado para Áreas Verdes:</span> <strong class="text-slate-800">2,400 kg</strong></li>
                    <li class="flex justify-between border-b pb-1 border-slate-200"><span>Vales de Descuento en Arbitrios Emitidos:</span> <strong class="text-slate-800">312 Vales</strong></li>
                    <li class="flex justify-between"><span>Efectividad en Segregación de Origen:</span> <strong class="text-emerald-600 font-bold">94.2%</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/reportes.js') }}"></script>
@endpush