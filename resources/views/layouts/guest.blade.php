<!DOCTYPE html>
<html lang="es" class="h-full">

@include('partials.header')

<body class="h-full font-sans antialiased text-slate-800">

    <!-- FONDOS Y CENTRADO ABSOLUTO -->
    <div class="min-h-screen w-full flex items-center justify-center p-4 bg-cover bg-center bg-no-repeat relative" 
         style="background-image: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)), url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=1920&auto=format&fit=crop');">
        
        <!-- CONTENIDO DEL INDEX (TARJETA DE LOGIN) -->
        <main class="w-full flex justify-center z-10">
            @yield('content')
        </main>

        <!-- FOOTER DISCRETO EN LA PORTADA -->
        <div class="absolute bottom-4 text-center w-full text-slate-300 text-xs z-10">
            <p>&copy; 2026 EcoBarrio Los Olivos - Sede Los Olivos. Todos los derechos reservados.</p>
        </div>
    </div>

    <!-- Scripts Globales -->
    <script src="{{ asset('js/state.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>

    @stack('scripts')
</body>
</html>