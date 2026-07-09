<?php

namespace App\Services;

use App\Models\Centro;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CentroService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo'): LengthAwarePaginator
    {
        return Centro::query()
            ->with('zona')
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('centro', 'like', "%{$buscar}%")
                        ->orWhereHas('zona', function ($zonaQuery) use ($buscar): void {
                            $zonaQuery->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderBy('centro')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Centro
    {
        $datos['estado_registro'] = 'Activo';

        return Centro::create($datos);
    }

    public function actualizar(Centro $centro, array $datos): bool
    {
        unset($datos['estado_registro']);

        return $centro->update($datos);
    }

    public function alternarEstadoRegistro(Centro $centro): array
    {
        if ($centro->estado_registro === 'Activo' && $centro->estudiantesActivos()->exists()) {
            return [
                'ok' => false,
                'message' => 'No se puede cambiar el estado del centro porque tiene estudiantes activos.',
            ];
        }

        $centro->update([
            'estado_registro' => $centro->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
        ]);

        return [
            'ok' => true,
            'message' => $centro->estado_registro === 'Activo'
                ? 'Centro activado correctamente.'
                : 'Centro inactivado correctamente.',
        ];
    }
}
