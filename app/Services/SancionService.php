<?php

namespace App\Services;

use App\Models\Sancion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class SancionService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo', string $tipoSancion = 'Todos', string $estadoSancion = 'Todos', ?int $periodoInicialId = null, ?int $periodoFinalId = null, ?int $decisionId = null): LengthAwarePaginator
    {
        return Sancion::query()
            ->with(['decision.procesoDisciplinario.denuncia.estudiante', 'periodoInicialSancion', 'periodoFinalSancion'])
            ->when($estadoRegistro !== 'Todos', fn ($q) => $q->where('estado_registro', $estadoRegistro))
            ->when($tipoSancion !== 'Todos', fn ($q) => $q->where('tipo_sancion', $tipoSancion))
            ->when($estadoSancion !== 'Todos', fn ($q) => $q->where('estado_sancion', $estadoSancion))
            ->when($periodoInicialId !== null, fn ($q) => $q->where('periodo_inicial_sancion_id', $periodoInicialId))
            ->when($periodoFinalId !== null, fn ($q) => $q->where('periodo_final_sancion_id', $periodoFinalId))
            ->when($decisionId !== null, fn ($q) => $q->where('decision_id', $decisionId))
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('tipo_sancion', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%")
                        ->orWhereHas('decision', fn ($dq) => $dq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhereHas('procesoDisciplinario.denuncia.estudiante', fn ($eq) => $eq->where('codigo_estu', 'like', "%{$buscar}%")->orWhere('nombre', 'like', "%{$buscar}%")->orWhere('apellido', 'like', "%{$buscar}%"))
                            ->orWhereHas('procesoDisciplinario', fn ($pq) => $pq->where('id', 'like', "%{$buscar}%")));
                });
            })
            ->orderByDesc('fecha_registro')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Sancion
    {
        $datos['estado_registro'] = 'Activo';
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;
        $sancion = Sancion::create($datos);
        $this->actualizarEstadoProceso($sancion);

        return $sancion;
    }

    public function actualizar(Sancion $sancion, array $datos): bool
    {
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');
        $actualizado = $sancion->update($datos);
        $this->actualizarEstadoProceso($sancion->refresh());

        return $actualizado;
    }

    public function alternarEstadoRegistro(Sancion $sancion): array
    {
        $notificaciones = $sancion->notificaciones();
        $tieneNotificacionesActivas = Schema::hasColumn('notificaciones', 'estado_registro')
            ? $notificaciones->where('estado_registro', 'Activo')->exists()
            : $notificaciones->exists();

        if ($sancion->estado_registro === 'Activo' && $tieneNotificacionesActivas) {
            return ['ok' => false, 'message' => 'No se puede inactivar la sancion porque tiene notificaciones asociadas.'];
        }

        $sancion->update([
            'estado_registro' => $sancion->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $sancion->estado_registro === 'Activo' ? 'Sancion activada correctamente.' : 'Sancion inactivada correctamente.',
        ];
    }

    private function actualizarEstadoProceso(Sancion $sancion): void
    {
        $proceso = $sancion->decision?->procesoDisciplinario;
        if (! $proceso) {
            return;
        }

        if ($sancion->tipo_sancion === 'Primera Instancia') {
            $proceso->update(['estado_proceso' => 'Fallo en primera instancia']);
        }

        if ($sancion->tipo_sancion === 'Segunda Instancia') {
            $proceso->update(['estado_proceso' => 'Fallo en segunda instancia']);
        }
    }
}
