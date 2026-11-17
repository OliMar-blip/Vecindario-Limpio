<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Redirección inicial: si está logueado va al dashboard, si no al login
Route::get('/', function (Request $request) {
    return $request->session()->has('ecobarrio_auth_user')
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Vista de Login
Route::get('/login', function (Request $request) {
    if ($request->session()->has('ecobarrio_auth_user')) {
        return redirect()->route('dashboard');
    }
    return view('index');
})->name('login');

// Procesar inicio de sesión validando credenciales reales + Límite de 5 intentos por minuto
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ], [
        'email.required' => 'Ingresa tu correo institucional o vecinal.',
        'email.email' => 'El formato del correo no es válido.',
        'password.required' => 'Ingresa tu contraseña de acceso.',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
    ]);

    $email = strtolower(trim($request->input('email')));
    $password = $request->input('password');

    $cuentasAutorizadas = [
        'admin@losolivos.gob.pe' => [
            'nombre' => 'Administrador Municipal',
            'rol' => 'Coordinador Ambiental',
            'password' => 'olivos2026',
        ],
        'brigada@losolivos.gob.pe' => [
            'nombre' => 'Supervisor de Ruta',
            'rol' => 'Jefe de Brigada',
            'password' => 'brigada2026',
        ],
    ];

    $usuariosRegistrados = $request->session()->get('ecobarrio_usuarios_extra', []);
    $todasLasCuentas = array_merge($cuentasAutorizadas, $usuariosRegistrados);

    if (!isset($todasLasCuentas[$email]) || $todasLasCuentas[$email]['password'] !== $password) {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['credenciales' => 'Correo o contraseña incorrectos. Acceso denegado.']);
    }

    // Regenerar ID de sesión por seguridad (evita Session Fixation)
    $request->session()->regenerate();
    $request->session()->put('ecobarrio_auth_user', [
        'email' => $email,
        'nombre' => $todasLasCuentas[$email]['nombre'],
        'rol' => $todasLasCuentas[$email]['rol'],
    ]);

    return redirect()->route('dashboard');
})->middleware('throttle:5,1')->name('login.post');

// Registrar nueva cuenta desde el modal de registro del Login
Route::post('/register-user', function (Request $request) {
    $request->validate([
        'nombre' => 'required|string|min:3|max:80',
        'email' => 'required|email|max:100',
        'password' => 'required|min:6|max:60',
    ]);

    $email = strtolower(trim($request->input('email')));
    $extras = $request->session()->get('ecobarrio_usuarios_extra', []);
    $extras[$email] = [
        'nombre' => strip_tags(trim($request->input('nombre'))),
        'rol' => 'EcoOperador Los Olivos',
        'password' => $request->input('password'),
    ];
    $request->session()->put('ecobarrio_usuarios_extra', $extras);

    return back()->with('registro_ok', 'Cuenta creada correctamente. Ahora inicia sesión con tus credenciales.');
})->middleware('throttle:5,1')->name('register.post');

// Cerrar sesión de forma segura
Route::post('/logout', function (Request $request) {
    $request->session()->forget('ecobarrio_auth_user');
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Rutas protegidas: bloquean acceso directo por URL si no hay sesión activa
$verificarSesion = function (Request $request, string $vista) {
    if (!$request->session()->has('ecobarrio_auth_user')) {
        return redirect()->route('login')->withErrors([
            'credenciales' => 'Debes iniciar sesión para acceder al sistema EcoBarrio.',
        ]);
    }
    return view($vista, ['usuarioActivo' => $request->session()->get('ecobarrio_auth_user')]);
};

Route::get('/dashboard', fn (Request $r) => $verificarSesion($r, 'dashboard'))->name('dashboard');
Route::get('/acopio', fn (Request $r) => $verificarSesion($r, 'acopio'))->name('acopio');
Route::get('/vecinos', fn (Request $r) => $verificarSesion($r, 'vecinos'))->name('vecinos');
Route::get('/rutas', fn (Request $r) => $verificarSesion($r, 'rutas'))->name('rutas');
Route::get('/reportes', fn (Request $r) => $verificarSesion($r, 'reportes'))->name('reportes');