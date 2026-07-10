<?php

namespace App\Services;

use App\Models\Decision;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DecisionService
{
    public function listar(string $buscar = '', string $estadoRegistro = 'Activo', string $tipoDecision = 'Todos', string $clasificacionFalta = 'Todos', ?int $procesoId = null): LengthAwarePaginator
    {
        return Decision::query()
            ->with('procesoDisciplinario.denuncia.estudiante')
            ->when($estadoRegistro !== 'Todos', fn ($q) => $q->where('estado_registro', $estadoRegistro))
            ->when($tipoDecision !== 'Todos', fn ($q) => $q->where('tipo_decision', $tipoDecision))
            ->when($clasificacionFalta !== 'Todos', fn ($q) => $q->where('clasificacion_falta', $clasificacionFalta))
            ->when($procesoId !== null, fn ($q) => $q->where('proceso_disciplinario_id', $procesoId))
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('tipo_decision', 'like', "%{$buscar}%")
                        ->orWhere('clasificacion_falta', 'like', "%{$buscar}%")
                        ->orWhere('resultado', 'like', "%{$buscar}%")
                        ->orWhere('proceso_disciplinario_id', 'like', "%{$buscar}%")
                        ->orWhereHas('procesoDisciplinario.denuncia.estudiante', function ($estudianteQuery) use ($buscar): void {
                            $estudianteQuery->where('codigo_estu', 'like', "%{$buscar}%")
                                ->orWhere('nombre', 'like', "%{$buscar}%")
                                ->orWhere('apellido', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderByDesc('fecha_sesion')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos, ?UploadedFile $archivo): Decision
    {
        $datos['archivo'] = $archivo ? $archivo->store('decisiones', 'public') : '';
        $datos['estado_registro'] = 'Activo';
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;

        return Decision::create($datos);
    }

    public function actualizar(Decision $decision, array $datos, ?UploadedFile $archivo): bool
    {
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');

        if ($archivo) {
            if ($decision->archivo && Storage::disk('public')->exists($decision->archivo)) {
                Storage::disk('public')->delete($decision->archivo);
            }
            $datos['archivo'] = $archivo->store('decisiones', 'public');
        } else {
            unset($datos['archivo']);
        }

        return $decision->update($datos);
    }

    public function alternarEstadoRegistro(Decision $decision): array
    {
        if ($decision->estado_registro === 'Activo' && $decision->sanciones()->where('estado_registro', 'Activo')->exists()) {
            return ['ok' => false, 'message' => 'No se puede inactivar la decision porque tiene sanciones activas asociadas.'];
        }

        $decision->update([
            'estado_registro' => $decision->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $decision->estado_registro === 'Activo' ? 'Decision activada correctamente.' : 'Decision inactivada correctamente.',
        ];
    }
}
