<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\ProcesoDisciplinario;
use App\Models\Zona;
use Illuminate\Http\JsonResponse;

class AjaxController extends Controller
{
    public function centrosPorZona(Zona $zona): JsonResponse
    {
        $centros = $zona->centros()
            ->where('estado_registro', 'Activo')
            ->orderBy('centro')
            ->get(['id', 'centro']);

        return response()->json($centros);
    }

    public function programasPorEscuela(Escuela $escuela): JsonResponse
    {
        $programas = $escuela->programas()
            ->where('estado_registro', 'Activo')
            ->orderBy('nombre')
            ->get(['id', 'codigo_pro', 'nombre']);

        return response()->json($programas);
    }

    public function descargosPorProceso(ProcesoDisciplinario $proceso): JsonResponse
    {
        $descargos = $proceso->descargos()
            ->where('estado_registro', 'Activo')
            ->orderByDesc('id')
            ->get(['id', 'descripcion']);

        return response()->json($descargos);
    }
}
