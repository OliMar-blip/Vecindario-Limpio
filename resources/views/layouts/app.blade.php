<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoBarrio Los Olivos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Barra Lateral -->
        <aside class="w-full md:w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 border-r border-slate-800">
            <div class="p-6 flex items-center gap-3 border-b border-slate-800/80">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i data-lucide="trees" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="block text-base font-black text-white tracking-tight">EcoBarrio</span>
                    <span class="block text-xs font-bold text-emerald-400">Sede Los Olivos</span>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1.5">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-extrabold transition {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'hover:bg-slate-800/70 hover:text-white' }}">
                    <i data-lucide="layout-grid" class="w-4 h-4"></i> Panel General
                </a>

                <a href="{{ route('acopio') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-extrabold transition {{ request()->routeIs('acopio') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'hover:bg-slate-800/70 hover:text-white' }}">
                    <i data-lucide="recycle" class="w-4 h-4"></i> Puntos de Acopio
                </a>

                <a href="{{ route('vecinos') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-extrabold transition {{ request()->routeIs('vecinos') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'hover:bg-slate-800/70 hover:text-white' }}">
                    <i data-lucide="trophy" class="w-4 h-4"></i> Ranking EcoColaboradores
                </a>

                <a href="{{ route('rutas') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-extrabold transition {{ request()->routeIs('rutas') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'hover:bg-slate-800/70 hover:text-white' }}">
                    <i data-lucide="truck" class="w-4 h-4"></i> Rutas y Camiones
                </a>

                <a href="{{ route('reportes') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-extrabold transition {{ request()->routeIs('reportes') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'hover:bg-slate-800/70 hover:text-white' }}">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Impacto y Reportes
                </a>
            </nav>

            <!-- Usuario activo y Cerrar Sesión seguro -->
            <div class="p-4 border-t border-slate-800/80 space-y-3">
                @if(session('ecobarrio_auth_user'))
                    <div class="px-2">
                        <p class="text-xs font-extrabold text-white truncate">{{ session('ecobarrio_auth_user.nombre') }}</p>
                        <p class="text-[11px] text-emerald-400 truncate">{{ session('ecobarrio_auth_user.rol') }}</p>
                    </div>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2.5 px-3 rounded-xl bg-rose-500/15 hover:bg-rose-600 text-rose-300 hover:text-white text-xs font-extrabold transition flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <div class="flex-1 flex flex-col min-w-0">
            <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>

            <footer class="bg-slate-900 text-slate-400 text-center py-4 text-xs border-t border-slate-800">
                © {{ date('Y') }} EcoBarrio Los Olivos - Sede Los Olivos. Todos los derechos reservados.
            </footer>
        </div>
    </div>

    <!-- Escudo Global Anti-XSS: neutraliza cualquier etiqueta <script> o HTML inyectado en el DOM -->
    <script>
        (function () {
            const limpiarXSS = (html) => {
                if (typeof html !== 'string') return html;
                return html
                    .replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '')
                    .replace(/\son\w+\s*=\s*(['"]).*?\1/gi, '')
                    .replace(/javascript:/gi, '');
            };

            const descriptorOriginal = Object.getOwnPropertyDescriptor(Element.prototype, 'innerHTML');
            if (descriptorOriginal && descriptorOriginal.set) {
                Object.defineProperty(Element.prototype, 'innerHTML', {
                    set: function (valor) {
                        return descriptorOriginal.set.call(this, limpiarXSS(valor));
                    },
                    get: function () {
                        return descriptorOriginal.get.call(this);
                    }
                });
            }
        })();

        if (typeof lucide !== 'undefined') lucide.createIcons();
    </script>
</body>
</html>