<?php

namespace App\Services;

use App\Models\HistoricoEstudiante;
use App\Models\ProcesoDisciplinario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProcesoDisciplinarioService
{
    public function listar(
        string $buscar = '',
        string $estadoRegistro = 'Activo',
        string $estadoProceso = 'Todos',
        string $procesoAntiguo = 'Todos',
        ?int $denunciaId = null
    ): LengthAwarePaginator {
        return ProcesoDisciplinario::query()
            ->with(['denuncia.estudiante'])
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($estadoProceso !== 'Todos', function ($query) use ($estadoProceso): void {
                $query->where('estado_proceso', $estadoProceso);
            })
            ->when($procesoAntiguo !== 'Todos', function ($query) use ($procesoAntiguo): void {
                $query->where('proceso_antiguo', $procesoAntiguo === 'Si');
            })
            ->when($denunciaId !== null, function ($query) use ($denunciaId): void {
                $query->where('denuncia_id', $denunciaId);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('estado_proceso', 'like', "%{$buscar}%")
                        ->orWhereHas('denuncia', function ($denunciaQuery) use ($buscar): void {
                            $denunciaQuery->where('descripcion', 'like', "%{$buscar}%")
                                ->orWhereHas('estudiante', function ($estudianteQuery) use ($buscar): void {
                                    $estudianteQuery->where('codigo_estu', 'like', "%{$buscar}%")
                                        ->orWhere('nombre', 'like', "%{$buscar}%")
                                        ->orWhere('apellido', 'like', "%{$buscar}%");
                                });
                        });
                });
            })
            ->orderByDesc('fecha_apertura')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): ProcesoDisciplinario
    {
        return DB::transaction(function () use ($datos): ProcesoDisciplinario {
            $tipologias = $datos['tipologias_faltas'];
            $articulos = $datos['articulos'];
            unset($datos['tipologias_faltas'], $datos['articulos']);

            $datos['proceso_antiguo'] = (bool) ($datos['proceso_antiguo'] ?? false);
            $datos['estado_registro'] = 'Activo';
            $datos['usuario_registra_id'] = session('usuario_id');
            $datos['usuario_actualiza_id'] = null;

            $proceso = ProcesoDisciplinario::create($datos);
            $proceso->tipologiasFalta()->sync($tipologias);
            $proceso->articulos()->sync($articulos);
            $this->guardarHistorico($proceso);

            return $proceso;
        });
    }

    public function actualizar(ProcesoDisciplinario $proceso, array $datos): bool
    {
        return DB::transaction(function () use ($proceso, $datos): bool {
            $tipologias = $datos['tipologias_faltas'];
            $articulos = $datos['articulos'];
            unset($datos['tipologias_faltas'], $datos['articulos'], $datos['estado_registro']);

            $datos['proceso_antiguo'] = (bool) ($datos['proceso_antiguo'] ?? false);
            $datos['usuario_actualiza_id'] = session('usuario_id');

            $actualizado = $proceso->update($datos);
            $proceso->tipologiasFalta()->sync($tipologias);
            $proceso->articulos()->sync($articulos);
            $this->guardarHistorico($proceso->refresh());

            return $actualizado;
        });
    }

    public function alternarEstadoRegistro(ProcesoDisciplinario $proceso): array
    {
        $proceso->update([
            'estado_registro' => $proceso->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $proceso->estado_registro === 'Activo'
                ? 'Proceso disciplinario activado correctamente.'
                : 'Proceso disciplinario inactivado correctamente.',
        ];
    }

    private function guardarHistorico(ProcesoDisciplinario $proceso): void
    {
        $proceso->loadMissing('denuncia.estudiante');
        $estudiante = $proceso->denuncia?->estudiante;

        if (! $estudiante) {
            return;
        }

        HistoricoEstudiante::updateOrCreate(
            [
                'estudiante_id' => $estudiante->id,
                'proceso_disciplinario_id' => $proceso->id,
            ],
            [
                'programa_id' => $estudiante->programa_id,
            ]
        );
    }
}
