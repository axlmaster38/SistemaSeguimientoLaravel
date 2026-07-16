<?php

namespace App\Services;

use App\Models\Notificacion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class NotificacionService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo', string $tipoNotificacion = 'Todos', string $instancia = 'Todos', ?int $procesoId = null, ?int $sancionId = null): LengthAwarePaginator
    {
        return Notificacion::query()
            ->with(['procesoDisciplinario.denuncia.estudiante', 'sancion.decision.procesoDisciplinario.denuncia.estudiante'])
            ->when($estadoRegistro !== 'Todos', fn ($q) => $q->where('estado_registro', $estadoRegistro))
            ->when($tipoNotificacion !== 'Todos', fn ($q) => $q->where('tipo_notificacion', $tipoNotificacion))
            ->when($instancia !== 'Todos', fn ($q) => $q->where('instancia', $instancia))
            ->when($procesoId !== null, function ($q) use ($procesoId): void {
                $q->where(function ($subquery) use ($procesoId): void {
                    $subquery->where('proceso_disciplinario_id', $procesoId)
                        ->orWhereHas('sancion.decision', fn ($dq) => $dq->where('proceso_disciplinario_id', $procesoId));
                });
            })
            ->when($sancionId !== null, fn ($q) => $q->where('sancion_id', $sancionId))
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%")
                        ->orWhere('tipo_notificacion', 'like', "%{$buscar}%")
                        ->orWhere('instancia', 'like', "%{$buscar}%")
                        ->orWhereHas('procesoDisciplinario.denuncia.estudiante', fn ($eq) => $eq->where('codigo_estu', 'like', "%{$buscar}%")->orWhere('nombre', 'like', "%{$buscar}%")->orWhere('apellido', 'like', "%{$buscar}%"))
                        ->orWhereHas('sancion.decision.procesoDisciplinario.denuncia.estudiante', fn ($eq) => $eq->where('codigo_estu', 'like', "%{$buscar}%")->orWhere('nombre', 'like', "%{$buscar}%")->orWhere('apellido', 'like', "%{$buscar}%"));
                });
            })
            ->orderByDesc('fecha_registro')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos, ?UploadedFile $archivo): Notificacion
    {
        $datos = $this->normalizarAsociacion($datos);
        $datos['archivo'] = $archivo ? $archivo->store('notificaciones', 'public') : '';
        $datos['estado_registro'] = 'Activo';
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;
        $this->normalizarFechaSegundaNotificacion($datos);

        $notificacion = Notificacion::create($datos);
        $notificacion->update(['nombre' => $this->nombre($notificacion)]);

        return $notificacion;
    }

    public function actualizar(Notificacion $notificacion, array $datos, ?UploadedFile $archivo): bool
    {
        $datos = $this->normalizarAsociacion($datos);
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');
        $this->normalizarFechaSegundaNotificacion($datos);

        if ($archivo) {
            if ($notificacion->archivo && Storage::disk('public')->exists($notificacion->archivo)) {
                Storage::disk('public')->delete($notificacion->archivo);
            }

            $datos['archivo'] = $archivo->store('notificaciones', 'public');
        } else {
            unset($datos['archivo']);
        }

        $actualizado = $notificacion->update($datos);
        $notificacion->refresh()->update(['nombre' => $this->nombre($notificacion->refresh())]);

        return $actualizado;
    }

    public function alternarEstadoRegistro(Notificacion $notificacion): array
    {
        $notificacion->update([
            'estado_registro' => $notificacion->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $notificacion->estado_registro === 'Activo' ? 'Notificación activada correctamente.' : 'Notificación inactivada correctamente.',
        ];
    }

    private function normalizarAsociacion(array $datos): array
    {
        if (($datos['tipo_notificacion'] ?? '') === 'Proceso') {
            $datos['sancion_id'] = null;
        }

        if (($datos['tipo_notificacion'] ?? '') === 'Sancion') {
            $datos['proceso_disciplinario_id'] = null;
        }

        $datos['proceso_disciplinario_id'] = ! empty($datos['proceso_disciplinario_id']) ? $datos['proceso_disciplinario_id'] : null;
        $datos['sancion_id'] = ! empty($datos['sancion_id']) ? $datos['sancion_id'] : null;

        return $datos;
    }

    private function normalizarFechaSegundaNotificacion(array &$datos): void
    {
        $datos['fecha_2da_notificacion'] = ($datos['instancia'] ?? null) === 'Segunda Notificación' ? now() : null;
    }

    private function nombre(Notificacion $notificacion): string
    {
        if ($notificacion->procesoDisciplinario) {
            $estudiante = $notificacion->procesoDisciplinario->denuncia?->estudiante;
            return 'PR'.($estudiante?->codigo_estu ?? 'SIN')."_{$notificacion->proceso_disciplinario_id}_{$notificacion->id}";
        }

        if ($notificacion->sancion) {
            $estudiante = $notificacion->sancion->decision?->procesoDisciplinario?->denuncia?->estudiante;
            return 'SAN'.($estudiante?->codigo_estu ?? 'SIN')."_{$notificacion->sancion_id}_{$notificacion->id}";
        }

        return "NOT{$notificacion->id}";
    }
}
