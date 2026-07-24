<?php

namespace App\Services;

use App\Models\Normatividad;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NormatividadService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo'): LengthAwarePaginator
    {
        return Normatividad::query()
            ->withCount('articulos')
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('no_acuerdo', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })
            ->orderByDesc('fecha_norma')
            ->orderBy('no_acuerdo')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Normatividad
    {
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;

        $normatividad = Normatividad::create($datos);
        $normatividad->estado_registro = 'Activo';
        $normatividad->save();

        return $normatividad;
    }

    public function actualizar(Normatividad $normatividad, array $datos): bool
    {
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');

        return $normatividad->update($datos);
    }

    public function alternarEstadoRegistro(Normatividad $normatividad): array
    {
        if ($normatividad->estado_registro === 'Activo' && $this->tieneArticulosActivos($normatividad)) {
            return [
                'ok' => false,
                'message' => 'No se puede inactivar la normatividad porque tiene artículos activos asociados. Primero inactive sus artículos.',
            ];
        }

        $normatividad->estado_registro = $normatividad->estado_registro === 'Activo' ? 'Inactivo' : 'Activo';
        $normatividad->usuario_actualiza_id = session('usuario_id');
        $normatividad->save();

        return [
            'ok' => true,
            'message' => $normatividad->estado_registro === 'Activo'
                ? 'Normatividad activada correctamente.'
                : 'Normatividad inactivada correctamente.',
        ];
    }

    private function tieneArticulosActivos(Normatividad $normatividad): bool
    {
        return $normatividad->articulos()
            ->where('estado_registro', 'Activo')
            ->exists();
    }
}
