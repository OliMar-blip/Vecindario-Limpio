<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\GeneralController;

// Rutas principales del sistema gestionadas mediante MVC (GeneralController)
Route::get('/', [GeneralController::class, 'index'])->name('inicio');
Route::get('/dashboard', [GeneralController::class, 'dashboard'])->name('dashboard');
Route::get('/vecinos', [GeneralController::class, 'vecinos'])->name('vecinos');
Route::get('/acopio', [GeneralController::class, 'acopio'])->name('acopio');
Route::get('/rutas', [GeneralController::class, 'rutas'])->name('rutas');
Route::get('/reportes', [GeneralController::class, 'reportes'])->name('reportes');