<?php

namespace App\Services;

use App\Models\Articulo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticuloService
{
    public function listar(
        string $buscar = '',
        string $estadoRegistro = 'Activo',
        ?int $normatividadId = null
    ): LengthAwarePaginator {
        return Articulo::query()
            ->with('normatividad')
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($normatividadId !== null, function ($query) use ($normatividadId): void {
                $query->where('normatividad_id', $normatividadId);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('no_articulo', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%")
                        ->orWhere('capitulo', 'like', "%{$buscar}%")
                        ->orWhere('literal', 'like', "%{$buscar}%")
                        ->orWhereHas('normatividad', function ($normatividadQuery) use ($buscar): void {
                            $normatividadQuery->where('no_acuerdo', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderBy('normatividad_id')
            ->orderBy('no_articulo')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Articulo
    {
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;

        $articulo = Articulo::create($datos);
        $articulo->estado_registro = 'Activo';
        $articulo->save();

        return $articulo;
    }

    public function actualizar(Articulo $articulo, array $datos): bool
    {
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');

        return $articulo->update($datos);
    }

    public function alternarEstadoRegistro(Articulo $articulo): array
    {
        $articulo->estado_registro = $articulo->estado_registro === 'Activo' ? 'Inactivo' : 'Activo';
        $articulo->usuario_actualiza_id = session('usuario_id');
        $articulo->save();

        return [
            'ok' => true,
            'message' => $articulo->estado_registro === 'Activo'
                ? 'Artículo activado correctamente.'
                : 'Artículo inactivado correctamente.',
        ];
    }
}
