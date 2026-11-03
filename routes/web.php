<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\GeneralController;

// Rutas principales del sistema gestionadas mediante MVC (GeneralController)
Route::get('/', [GeneralController::class, 'index']);
Route::get('/dashboard', [GeneralController::class, 'dashboard']);
Route::get('/vecinos', [GeneralController::class, 'vecinos']);
Route::get('/acopio', [GeneralController::class, 'acopio']);
Route::get('/rutas', [GeneralController::class, 'rutas']);
Route::get('/reportes', [GeneralController::class, 'reportes']);