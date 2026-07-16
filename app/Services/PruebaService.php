<?php

namespace App\Services;

use App\Models\Apelacion;
use App\Models\Descargo;
use App\Models\Prueba;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PruebaService
{
    public function listar(
        string $buscar = '',
        string $estadoRegistro = 'Activo',
        string $tipoPrueba = 'Todos',
        string $procedencia = 'Todos',
        ?int $procesoId = null
    ): LengthAwarePaginator {
        return Prueba::query()
            ->with(['procesoDisciplinario.denuncia.estudiante', 'descargo', 'apelacion'])
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($tipoPrueba !== 'Todos', function ($query) use ($tipoPrueba): void {
                $query->where('tipo_prueba', $tipoPrueba);
            })
            ->when($procedencia !== 'Todos', function ($query) use ($procedencia): void {
                $query->where('procedencia', $procedencia);
            })
            ->when($procesoId !== null, function ($query) use ($procesoId): void {
                $query->where('proceso_disciplinario_id', $procesoId);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('tipo_prueba', 'like', "%{$buscar}%")
                        ->orWhere('procedencia', 'like', "%{$buscar}%")
                        ->orWhere('proceso_disciplinario_id', 'like', "%{$buscar}%")
                        ->orWhereHas('procesoDisciplinario.denuncia.estudiante', function ($estudianteQuery) use ($buscar): void {
                            $estudianteQuery->where('codigo_estu', 'like', "%{$buscar}%")
                                ->orWhere('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderByDesc('fecha_registro')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos, ?UploadedFile $archivo): Prueba
    {
        $datos = $this->normalizarAsociacion($datos);
        $datos['archivo'] = $archivo ? $archivo->store('pruebas', 'public') : '';
        $datos['estado_registro'] = 'Activo';
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;

        return Prueba::create($datos);
    }

    public function actualizar(Prueba $prueba, array $datos, ?UploadedFile $archivo): bool
    {
        $datos = $this->normalizarAsociacion($datos);
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');

        if ($archivo) {
            if ($prueba->archivo && Storage::disk('public')->exists($prueba->archivo)) {
                Storage::disk('public')->delete($prueba->archivo);
            }

            $datos['archivo'] = $archivo->store('pruebas', 'public');
        } else {
            unset($datos['archivo']);
        }

        return $prueba->update($datos);
    }

    public function alternarEstadoRegistro(Prueba $prueba): array
    {
        $prueba->update([
            'estado_registro' => $prueba->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $prueba->estado_registro === 'Activo'
                ? 'Prueba activada correctamente.'
                : 'Prueba inactivada correctamente.',
        ];
    }

    private function normalizarAsociacion(array $datos): array
    {
        if (empty($datos['proceso_disciplinario_id']) && ! empty($datos['descargo_id'])) {
            $datos['proceso_disciplinario_id'] = Descargo::whereKey($datos['descargo_id'])->value('proceso_disciplinario_id');
        }

        if (empty($datos['proceso_disciplinario_id']) && ! empty($datos['apelacion_id'])) {
            $datos['proceso_disciplinario_id'] = Apelacion::whereKey($datos['apelacion_id'])->value('proceso_disciplinario_id');
        }

        $datos['proceso_disciplinario_id'] = ! empty($datos['proceso_disciplinario_id']) ? $datos['proceso_disciplinario_id'] : null;
        $datos['descargo_id'] = ! empty($datos['descargo_id']) ? $datos['descargo_id'] : null;
        $datos['apelacion_id'] = ! empty($datos['apelacion_id']) ? $datos['apelacion_id'] : null;

        return $datos;
    }
}
