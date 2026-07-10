<?php

namespace App\Services;

use App\Models\Apelacion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApelacionService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo', string $tipoApelacion = 'Todos', ?int $procesoId = null): LengthAwarePaginator
    {
        return Apelacion::query()
            ->with(['procesoDisciplinario.denuncia.estudiante'])
            ->withCount('pruebas')
            ->when($estadoRegistro !== 'Todos', fn ($q) => $q->where('estado_registro', $estadoRegistro))
            ->when($tipoApelacion !== 'Todos', fn ($q) => $q->where('tipo_apelacion', $tipoApelacion))
            ->when($procesoId !== null, fn ($q) => $q->where('proceso_disciplinario_id', $procesoId))
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('motivo', 'like', "%{$buscar}%")
                        ->orWhere('tipo_apelacion', 'like', "%{$buscar}%")
                        ->orWhere('proceso_disciplinario_id', 'like', "%{$buscar}%")
                        ->orWhereHas('procesoDisciplinario.denuncia.estudiante', fn ($eq) => $eq->where('codigo_estu', 'like', "%{$buscar}%")->orWhere('nombre', 'like', "%{$buscar}%")->orWhere('apellido', 'like', "%{$buscar}%"));
                });
            })
            ->orderByDesc('fecha_registro')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Apelacion
    {
        $datos['estado_registro'] = 'Activo';
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;

        return Apelacion::create($datos);
    }

    public function actualizar(Apelacion $apelacion, array $datos): bool
    {
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');

        return $apelacion->update($datos);
    }

    public function alternarEstadoRegistro(Apelacion $apelacion): array
    {
        if ($apelacion->estado_registro === 'Activo' && $apelacion->pruebas()->where('estado_registro', 'Activo')->exists()) {
            return ['ok' => false, 'message' => 'No se puede inactivar la apelación porque tiene pruebas activas asociadas.'];
        }

        $apelacion->update([
            'estado_registro' => $apelacion->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $apelacion->estado_registro === 'Activo' ? 'Apelación activada correctamente.' : 'Apelación inactivada correctamente.',
        ];
    }
}
