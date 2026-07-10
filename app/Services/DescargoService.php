<?php

namespace App\Services;

use App\Models\Descargo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DescargoService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo', ?int $procesoId = null): LengthAwarePaginator
    {
        return Descargo::query()
            ->with('procesoDisciplinario.denuncia.estudiante')
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($procesoId !== null, function ($query) use ($procesoId): void {
                $query->where('proceso_disciplinario_id', $procesoId);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('descripcion', 'like', "%{$buscar}%")
                        ->orWhere('proceso_disciplinario_id', 'like', "%{$buscar}%")
                        ->orWhereHas('procesoDisciplinario.denuncia.estudiante', function ($estudianteQuery) use ($buscar): void {
                            $estudianteQuery->where('codigo_estu', 'like', "%{$buscar}%")
                                ->orWhere('nombre', 'like', "%{$buscar}%")
                                ->orWhere('apellido', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderByDesc('fecha_registro')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Descargo
    {
        $datos['estado_registro'] = 'Activo';
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;

        return Descargo::create($datos);
    }

    public function actualizar(Descargo $descargo, array $datos): bool
    {
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');

        return $descargo->update($datos);
    }

    public function alternarEstadoRegistro(Descargo $descargo): array
    {
        if ($descargo->estado_registro === 'Activo' && $descargo->pruebas()->where('estado_registro', 'Activo')->exists()) {
            return [
                'ok' => false,
                'message' => 'No se puede inactivar el descargo porque tiene pruebas activas asociadas.',
            ];
        }

        $descargo->update([
            'estado_registro' => $descargo->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $descargo->estado_registro === 'Activo'
                ? 'Descargo activado correctamente.'
                : 'Descargo inactivado correctamente.',
        ];
    }
}
