<?php

namespace App\Services;

use App\Models\Zona;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ZonaService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo'): LengthAwarePaginator
    {
        return Zona::query()
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where('nombre', 'like', "%{$buscar}%");
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Zona
    {
        $datos['estado_registro'] = 'Activo';

        return Zona::create($datos);
    }

    public function actualizar(Zona $zona, array $datos): bool
    {
        unset($datos['estado_registro']);

        return $zona->update($datos);
    }

    public function alternarEstadoRegistro(Zona $zona): array
    {
        if ($zona->estado_registro === 'Activo' && $zona->centrosActivos()->exists()) {
            return [
                'ok' => false,
                'message' => 'No se puede cambiar el estado de la zona porque tiene centros activos.',
            ];
        }

        $zona->update([
            'estado_registro' => $zona->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
        ]);

        return [
            'ok' => true,
            'message' => $zona->estado_registro === 'Activo'
                ? 'Zona activada correctamente.'
                : 'Zona inactivada correctamente.',
        ];
    }
}
