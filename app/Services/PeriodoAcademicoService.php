<?php

namespace App\Services;

use App\Models\PeriodoAcademico;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PeriodoAcademicoService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo'): LengthAwarePaginator
    {
        return PeriodoAcademico::query()
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('codigo', 'like', "%{$buscar}%")
                        ->orWhere('periodo', 'like', "%{$buscar}%")
                        ->orWhere('anio', 'like', "%{$buscar}%");
                });
            })
            ->orderByDesc('anio')
            ->orderBy('periodo')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): PeriodoAcademico
    {
        $datos['estado_registro'] = 'Activo';
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;

        return PeriodoAcademico::create($datos);
    }

    public function actualizar(PeriodoAcademico $periodoAcademico, array $datos): bool
    {
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');

        return $periodoAcademico->update($datos);
    }

    public function alternarEstadoRegistro(PeriodoAcademico $periodoAcademico): array
    {
        $periodoAcademico->update([
            'estado_registro' => $periodoAcademico->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $periodoAcademico->estado_registro === 'Activo'
                ? 'Periodo academico activado correctamente.'
                : 'Periodo academico inactivado correctamente.',
        ];
    }
}
