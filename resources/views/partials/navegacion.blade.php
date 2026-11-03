<aside id="sidebar" class="w-full md:w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col justify-between hidden md:flex transition-all duration-300 z-30">
    <div>
        <!-- Logotipo de la app -->
        <div class="p-5 flex items-center justify-between border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-600 text-white rounded-xl shadow-lg">
                    <i data-lucide="trees" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-base leading-tight">EcoBarrio</h2>
                    <p class="text-xs text-emerald-400 font-medium">Sede Los Olivos</p>
                </div>
            </div>
        </div>

        <!-- Menú de Enlaces con Estado Activo Dinámico -->
        <nav class="p-4 space-y-1.5">
            <!-- Panel General -->
            <a href="{{ url('/dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition-all {{ Request::is('dashboard') ? 'bg-emerald-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Panel General</span>
            </a>

            <!-- Puntos de Acopio -->
            <a href="{{ url('/acopio') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition-all {{ Request::is('acopio') ? 'bg-emerald-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i data-lucide="recycle" class="w-5 h-5"></i>
                <span>Puntos de Acopio</span>
            </a>

            <!-- Ranking EcoColaboradores -->
            <a href="{{ url('/vecinos') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition-all {{ Request::is('vecinos') ? 'bg-emerald-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i data-lucide="trophy" class="w-5 h-5"></i>
                <span>Ranking EcoColaboradores</span>
            </a>

            <!-- Rutas y Camiones -->
            <a href="{{ url('/rutas') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition-all {{ Request::is('rutas') ? 'bg-emerald-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i data-lucide="truck" class="w-5 h-5"></i>
                <span>Rutas y Camiones</span>
            </a>

            <!-- Impacto y Reportes -->
            <a href="{{ url('/reportes') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition-all {{ Request::is('reportes') ? 'bg-emerald-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                <span>Impacto y Reportes</span>
            </a>
        </nav>
    </div>
</aside>