<?php

namespace App\Http\Controllers;

use App\Models\Apelacion;
use App\Models\Denuncia;
use App\Models\Estudiante;
use App\Models\Notificacion;
use App\Models\ProcesoDisciplinario;
use App\Models\Sancion;
use App\Services\AlertaDashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly AlertaDashboardService $alertaDashboardService)
    {
    }

    public function index(): View
    {
        return view('dashboard.index', [
            'conteos' => [
                'estudiantes' => Estudiante::count(),
                'denuncias' => Denuncia::count(),
                'procesos_disciplinarios' => ProcesoDisciplinario::count(),
                'sanciones' => Sancion::count(),
                'apelaciones' => Apelacion::count(),
                'notificaciones' => Notificacion::count(),
            ],
            'alertas' => $this->alertaDashboardService->obtenerAlertas(),
        ]);
    }
}
