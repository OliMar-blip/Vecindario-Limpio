@extends('layouts.guest')

@section('content')
<div class="w-full max-w-md bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-2xl border border-slate-100 my-8">
    <div class="text-center mb-6">
        <div class="inline-flex p-3 bg-emerald-100 text-emerald-600 rounded-2xl mb-3">
            <i data-lucide="trees" class="w-8 h-8"></i>
        </div>
        <h2 class="text-2xl font-bold font-heading text-slate-900">EcoBarrio Los Olivos</h2>
        <p class="text-xs text-slate-500 mt-1">Sistema Comunitario de Vecindarios Limpios</p>
    </div>

    <!-- Pestañas -->
    <div class="flex bg-slate-100 p-1 rounded-xl mb-6 text-xs font-semibold">
        <button type="button" class="flex-1 py-2 rounded-lg bg-white shadow-sm text-slate-800">Iniciar Sesión</button>
        <button type="button" onclick="alert('Módulo de registro próximamente')" class="flex-1 py-2 rounded-lg text-slate-500 hover:text-slate-800 transition">Registrarse</button>
    </div>

    <!-- Formulario de Login -->
    <form onsubmit="handleLogin(event)" class="space-y-4 text-xs">
        <div>
            <label for="login-email" class="block font-bold text-slate-700 uppercase mb-1">Correo Electrónico / DNI</label>
            <div class="relative">
                <i data-lucide="mail" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="login-email" name="login" autocomplete="username" placeholder="admin@losolivos.gob.pe" class="w-full pl-9 pr-3 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>

        <div>
            <label for="login-password" class="block font-bold text-slate-700 uppercase mb-1">Contraseña</label>
            <div class="relative">
                <i data-lucide="lock" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="password" id="login-password" name="password" autocomplete="current-password" placeholder="••••••••" class="w-full pl-9 pr-3 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>

        <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition flex items-center justify-center gap-2">
            <i data-lucide="log-in" class="w-4 h-4"></i>
            Ingresar a la Plataforma
        </button>
    </form>

    <!-- ACCESO RÁPIDO / MODO DEMO -->
    <div class="mt-8 pt-6 border-t border-slate-100 text-center">
        <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400 block mb-3">Acceso Rápido / Modo Demo</span>
        
        <div class="flex gap-2 justify-center">
            <button type="button" onclick="loginDemo('admin')" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/60 text-xs rounded-xl font-semibold transition flex items-center gap-1.5">
                👑 Admin
            </button>

            <button type="button" onclick="loginDemo('brigadista')" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200/60 text-xs rounded-xl font-semibold transition flex items-center gap-1.5">
                🚜 Brigadista
            </button>

            <button type="button" onclick="loginDemo('vecino')" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/60 text-xs rounded-xl font-semibold transition flex items-center gap-1.5">
                🌱 Vecino
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth.js') }}?v={{ time() }}"></script>
@endpush