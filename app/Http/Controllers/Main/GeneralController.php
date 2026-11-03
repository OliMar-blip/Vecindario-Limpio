<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function vecinos()
    {
        return view('vecinos');
    }

    public function acopio()
    {
        return view('acopio');
    }

    public function rutas()
    {
        return view('rutas');
    }

    public function reportes()
    {
        return view('reportes');
    }
}