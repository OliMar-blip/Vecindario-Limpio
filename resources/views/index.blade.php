<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoBarrio Los Olivos — Acceso Seguro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen flex flex-col justify-between bg-slate-950 relative overflow-x-hidden antialiased selection:bg-emerald-500 selection:text-white">
    <!-- Imagen de fondo ecológica con capa oscura elegante -->
    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1920&q=80"
             alt="EcoBarrio Los Olivos"
             class="w-full h-full object-cover object-center opacity-45">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/75 via-slate-950/60 to-slate-950/90"></div>
    </div>

    <div class="h-4"></div>

    <!-- Tarjeta Central de Autenticación -->
    <main class="relative z-10 w-full max-w-md mx-auto px-4 my-6">
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/40 p-7 sm:p-8">
            <!-- Logo y Título -->
            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center mx-auto mb-3 shadow-xs">
                    <i data-lucide="shield-check" class="w-7 h-7"></i>
                </div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">EcoBarrio Los Olivos</h1>
                <p class="text-xs font-medium text-slate-500 mt-1">Sistema Comunitario de Vecindarios Limpios</p>
            </div>

            <!-- Pestañas: Iniciar Sesión / Registrarse -->
            <div class="grid grid-cols-2 bg-slate-100 p-1 rounded-xl mb-6 border border-slate-200/70">
                <button type="button" id="tab-login" onclick="cambiarTab('login')"
                        class="py-2 text-xs font-extrabold rounded-lg bg-white text-slate-900 shadow-xs transition cursor-pointer">
                    Iniciar Sesión
                </button>
                <button type="button" id="tab-register" onclick="cambiarTab('register')"
                        class="py-2 text-xs font-bold rounded-lg text-slate-500 hover:text-slate-800 transition cursor-pointer">
                    Registrarse
                </button>
            </div>

            <!-- Alertas de Seguridad / Validación -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold flex items-start gap-2.5">
                    <i data-lucide="shield-alert" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            @if (session('registro_ok'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold flex items-start gap-2.5">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                    <div>{{ session('registro_ok') }}</div>
                </div>
            @endif

            <!-- PANEL 1: FORMULARIO DE INICIO DE SESIÓN ESTRICTO -->
            <div id="panel-login">
                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1.5">
                            Correo Electrónico Institucional
                        </label>
                        <div class="relative">
                            <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="email" id="input-email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                   placeholder="usuario@losolivos.gob.pe"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1.5">
                            Contraseña
                        </label>
                        <div class="relative">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="password" id="input-password" name="password" required minlength="6" autocomplete="current-password"
                                   placeholder="••••••••••"
                                   class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            <button type="button" onclick="togglePass()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 cursor-pointer">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 active:scale-[0.99] text-white text-xs font-extrabold rounded-xl shadow-lg shadow-emerald-600/25 transition flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="log-in" class="w-4 h-4"></i> Ingresar a la Plataforma
                    </button>
                </form>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-center gap-2 text-[11px] text-slate-400 font-semibold">
                    <i data-lucide="lock-keyhole" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>Conexión protegida • Máximo 5 intentos por minuto</span>
                </div>
            </div>

            <!-- PANEL 2: FORMULARIO DE REGISTRO DE OPERADOR -->
            <div id="panel-register" class="hidden">
                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1.5">
                            Nombre Completo
                        </label>
                        <div class="relative">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="text" name="nombre" required minlength="3" placeholder="Ej. Camila Torres"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1.5">
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="email" name="email" required placeholder="vecino@losolivos.gob.pe"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-wider mb-1.5">
                            Crear Contraseña (mínimo 6 caracteres)
                        </label>
                        <div class="relative">
                            <i data-lucide="key-round" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="password" name="password" required minlength="6" placeholder="••••••••••"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-3 bg-slate-900 hover:bg-slate-800 active:scale-[0.99] text-white text-xs font-extrabold rounded-xl shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="user-plus" class="w-4 h-4 text-emerald-400"></i> Crear Cuenta Autorizada
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Pie de página -->
    <footer class="relative z-10 text-center py-4 px-4 text-[11px] text-slate-300/80 font-medium">
        © {{ date('Y') }} EcoBarrio Los Olivos - Sede Los Olivos. Todos los derechos reservados.
    </footer>

    <script>
        lucide.createIcons();

        function cambiarTab(tab) {
            const panelLogin = document.getElementById('panel-login');
            const panelRegister = document.getElementById('panel-register');
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');

            if (tab === 'login') {
                panelLogin.classList.remove('hidden');
                panelRegister.classList.add('hidden');
                tabLogin.className = 'py-2 text-xs font-extrabold rounded-lg bg-white text-slate-900 shadow-xs transition cursor-pointer';
                tabRegister.className = 'py-2 text-xs font-bold rounded-lg text-slate-500 hover:text-slate-800 transition cursor-pointer';
            } else {
                panelLogin.classList.add('hidden');
                panelRegister.classList.remove('hidden');
                tabRegister.className = 'py-2 text-xs font-extrabold rounded-lg bg-white text-slate-900 shadow-xs transition cursor-pointer';
                tabLogin.className = 'py-2 text-xs font-bold rounded-lg text-slate-500 hover:text-slate-800 transition cursor-pointer';
            }
        }

        function togglePass() {
            const input = document.getElementById('input-password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>