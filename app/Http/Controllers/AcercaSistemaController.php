<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AcercaSistemaController extends Controller
{
    public function index(): View
    {
        return view('administracion.acerca');
    }
}
