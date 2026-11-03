<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">

@include('partials.header')

<body class="h-full text-slate-800 font-sans antialiased overflow-x-hidden">

    <div id="app-view" class="min-h-screen flex flex-col md:flex-row bg-slate-100">

        <!-- Muestra el sidebar en TODAS las rutas excepto en la portada raíz -->
        @if(!Request::is('/'))
            @include('partials.navegacion')
        @endif

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto w-full">
            @yield('content')
            
            @if(!Request::is('/'))
                @include('partials.footer')
            @endif
        </main>

    </div>

    <!-- Script Oficial de Iconos Lucide (CDN Global) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Scripts Globales del Sistema -->
    <script src="{{ asset('js/state.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/layout.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Inicializador Global de Iconos para evitar que desaparezcan -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>