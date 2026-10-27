<?php

use Illuminate\Support\Facades\Route;

// Ruta principal (Portada / Landing)
Route::get('/', function () {
    return view('index');
});

// Panel Principal
Route::get('/dashboard', function () {
    return view('dashboard');
});

// Módulos del Sistema
Route::get('/vecinos', function () {
    return view('vecinos');
});

Route::get('/acopio', function () {
    return view('acopio');
});

Route::get('/rutas', function () {
    return view('rutas');
});

Route::get('/reportes', function () {
    return view('reportes');
});