<?php

namespace App\Services;

use App\Models\Escuela;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EscuelaService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo'): LengthAwarePaginator
    {
        return Escuela::query()
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('sigla', 'like', "%{$buscar}%")
                        ->orWhere('nombre', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Escuela
    {
        $datos['estado_registro'] = 'Activo';

        return Escuela::create($datos);
    }

    public function actualizar(Escuela $escuela, array $datos): bool
    {
        unset($datos['estado_registro']);

        return $escuela->update($datos);
    }

    public function alternarEstadoRegistro(Escuela $escuela): bool
    {
        $nuevoEstado = $escuela->estado_registro === 'Activo' ? 'Inactivo' : 'Activo';

        return $escuela->update([
            'estado_registro' => $nuevoEstado,
        ]);
    }
}
