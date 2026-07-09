<?php

namespace App\Services;

use App\Models\Programa;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProgramaService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo'): LengthAwarePaginator
    {
        return Programa::query()
            ->with('escuela')
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('codigo_pro', 'like', "%{$buscar}%")
                        ->orWhere('nombre', 'like', "%{$buscar}%")
                        ->orWhereHas('escuela', function ($escuelaQuery) use ($buscar): void {
                            $escuelaQuery->where('nombre', 'like', "%{$buscar}%")
                                ->orWhere('sigla', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Programa
    {
        $datos['estado_registro'] = 'Activo';

        return Programa::create($datos);
    }

    public function actualizar(Programa $programa, array $datos): bool
    {
        unset($datos['estado_registro']);

        return $programa->update($datos);
    }

    public function alternarEstadoRegistro(Programa $programa): array
    {
        if ($programa->estado_registro === 'Activo' && $programa->estudiantesActivos()->exists()) {
            return [
                'ok' => false,
                'message' => 'No se puede cambiar el estado del programa porque tiene estudiantes activos.',
            ];
        }

        $programa->update([
            'estado_registro' => $programa->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
        ]);

        return [
            'ok' => true,
            'message' => $programa->estado_registro === 'Activo'
                ? 'Programa activado correctamente.'
                : 'Programa inactivado correctamente.',
        ];
    }
}
