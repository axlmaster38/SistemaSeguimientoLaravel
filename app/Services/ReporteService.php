<?php

namespace App\Services;

use App\Models\Centro;
use App\Models\Denuncia;
use App\Models\Estudiante;
use App\Models\ProcesoDisciplinario;
use App\Models\Programa;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ReporteService
{
    private const ESTADOS_PROCESO = [
        'Proceso Abierto',
        'Fallo en primera instancia',
        'Fallo en segunda instancia',
        'Cumpliendo Sanción',
        'Proceso Cerrado',
        'Sanción cumplida',
    ];

    private const CLASIFICACIONES_FALTA = ['Leve', 'Grave', 'Gravisima'];

    public function __construct(private readonly ReglasNegocioDisciplinarioService $reglasNegocio)
    {
    }

    public function opciones(): array
    {
        return [
            'estudiantesFiltro' => Estudiante::orderBy('codigo_estu')->get(['id', 'codigo_estu', 'nombre', 'apellido']),
            'procesosFiltro' => ProcesoDisciplinario::orderByDesc('id')->get(['id']),
            'denunciasFiltro' => Denuncia::orderByDesc('id')->get(['id', 'estudiante_id']),
            'programas' => Programa::orderBy('nombre')->get(['id', 'codigo_pro', 'nombre']),
            'centros' => Centro::orderBy('centro')->get(['id', 'centro']),
            'estadosProceso' => self::ESTADOS_PROCESO,
            'clasificacionesFalta' => self::CLASIFICACIONES_FALTA,
        ];
    }

    public function antecedentesEstudiante(array $filtros): LengthAwarePaginator
    {
        $estudiantes = Estudiante::query()
            ->with([
                'programa.escuela',
                'centro.zona',
                'historicos.programa.escuela',
                'denuncias.procesos' => fn ($q) => $q->with([
                    'decisiones.sanciones.notificaciones',
                    'notificaciones',
                    'apelaciones',
                    'historicos.programa',
                ])->orderByDesc('fecha_registro'),
            ])
            ->withCount(['denuncias', 'historicos'])
            ->when($this->filled($filtros, 'estudiante_id'), fn ($q) => $q->where('id', (int) $filtros['estudiante_id']))
            ->when($this->filled($filtros, 'codigo'), fn ($q) => $q->where('codigo_estu', 'like', '%'.$filtros['codigo'].'%'))
            ->when($this->filled($filtros, 'programa_id'), fn ($q) => $q->where('programa_id', (int) $filtros['programa_id']))
            ->when($this->filled($filtros, 'centro_id'), fn ($q) => $q->where('centro_id', (int) $filtros['centro_id']))
            ->when($this->filled($filtros, 'estado_proceso'), function ($q) use ($filtros): void {
                $q->whereHas('denuncias.procesos', fn ($pq) => $pq->where('estado_proceso', 'like', '%'.$filtros['estado_proceso'].'%'));
            })
            ->when($this->filled($filtros, 'estado_sancion'), function ($q) use ($filtros): void {
                $q->whereHas('denuncias.procesos.decisiones.sanciones', fn ($sq) => $sq->where('estado_sancion', 'like', '%'.$filtros['estado_sancion'].'%'));
            })
            ->when($this->filled($filtros, 'fecha_desde'), function ($q) use ($filtros): void {
                $q->whereHas('denuncias.procesos', fn ($pq) => $pq->whereDate('fecha_registro', '>=', $filtros['fecha_desde']));
            })
            ->when($this->filled($filtros, 'fecha_hasta'), function ($q) use ($filtros): void {
                $q->whereHas('denuncias.procesos', fn ($pq) => $pq->whereDate('fecha_registro', '<=', $filtros['fecha_hasta']));
            })
            ->whereHas('denuncias')
            ->orderBy('codigo_estu')
            ->paginate(10)
            ->withQueryString();

        $estudiantes->getCollection()->transform(function (Estudiante $estudiante): Estudiante {
            $estudiante->setAttribute('total_antecedentes', $estudiante->denuncias_count);

            return $estudiante;
        });

        return $estudiantes;
    }

    public function procesosHistoricos(array $filtros, int $perPage = 10): LengthAwarePaginator
    {
        $procesos = $this->consultaProcesosHistoricos($filtros)
            ->paginate($perPage)
            ->withQueryString();

        $procesos->getCollection()->transform(function (ProcesoDisciplinario $proceso): ProcesoDisciplinario {
            $proceso->setAttribute('reglas_negocio', $this->reglasNegocio->calcularProceso($proceso));

            return $proceso;
        });

        return $procesos;
    }

    public function procesosHistoricosParaExportar(array $filtros): Collection
    {
        return $this->consultaProcesosHistoricos($filtros)
            ->limit(2000)
            ->get()
            ->map(function (ProcesoDisciplinario $proceso): ProcesoDisciplinario {
                $proceso->setAttribute('reglas_negocio', $this->reglasNegocio->calcularProceso($proceso));

                return $proceso;
            });
    }

    public function detalleProcesoHistorico(ProcesoDisciplinario $proceso): ProcesoDisciplinario
    {
        $proceso->load([
            'denuncia.estudiante.programa.escuela',
            'denuncia.estudiante.centro.zona',
            'tipologiasFalta',
            'articulos.normatividad',
            'historicos.programa.escuela',
            'decisiones.usuarioRegistra',
            'decisiones.sanciones.periodoInicialSancion',
            'decisiones.sanciones.periodoFinalSancion',
            'decisiones.sanciones.notificaciones',
            'notificaciones',
            'descargos',
            'pruebas',
            'apelaciones.usuarioRegistra',
            'usuarioRegistra',
            'usuarioActualiza',
        ]);
        $proceso->setAttribute('reglas_negocio', $this->reglasNegocio->calcularProceso($proceso));

        return $proceso;
    }

    private function consultaProcesosHistoricos(array $filtros): Builder
    {
        return ProcesoDisciplinario::query()
            ->with([
                'denuncia.estudiante.programa.escuela',
                'denuncia.estudiante.centro.zona',
                'tipologiasFalta',
                'articulos.normatividad',
                'historicos.programa.escuela',
                'decisiones.sanciones.notificaciones',
                'notificaciones',
                'descargos',
                'pruebas',
                'apelaciones',
            ])
            ->when($this->filled($filtros, 'estudiante_id'), fn ($q) => $q->whereHas('denuncia', fn ($dq) => $dq->where('estudiante_id', (int) $filtros['estudiante_id'])))
            ->when($this->filled($filtros, 'proceso_id'), fn ($q) => $q->where('id', (int) $filtros['proceso_id']))
            ->when($this->filled($filtros, 'denuncia_id'), fn ($q) => $q->where('denuncia_id', (int) $filtros['denuncia_id']))
            ->when($this->filled($filtros, 'estado_proceso'), fn ($q) => $q->where('estado_proceso', 'like', '%'.$filtros['estado_proceso'].'%'))
            ->when($this->filled($filtros, 'clasificacion_falta'), function ($q) use ($filtros): void {
                $q->whereHas('decisiones', fn ($dq) => $dq->where('clasificacion_falta', 'like', '%'.$filtros['clasificacion_falta'].'%'));
            })
            ->when($this->filled($filtros, 'programa_id'), function ($q) use ($filtros): void {
                $q->whereHas('denuncia.estudiante', fn ($eq) => $eq->where('programa_id', (int) $filtros['programa_id']));
            })
            ->when($this->filled($filtros, 'centro_id'), function ($q) use ($filtros): void {
                $q->whereHas('denuncia.estudiante', fn ($eq) => $eq->where('centro_id', (int) $filtros['centro_id']));
            })
            ->when($this->filled($filtros, 'fecha_desde'), fn ($q) => $q->whereDate('fecha_registro', '>=', $filtros['fecha_desde']))
            ->when($this->filled($filtros, 'fecha_hasta'), fn ($q) => $q->whereDate('fecha_registro', '<=', $filtros['fecha_hasta']))
            ->when(! empty($filtros['sancionado']), fn ($q) => $q->whereHas('decisiones.sanciones'))
            ->when(! empty($filtros['tiene_decision']), fn ($q) => $q->whereHas('decisiones'))
            ->when(! empty($filtros['notificado_proceso']), fn ($q) => $q->whereHas('notificaciones'))
            ->when(! empty($filtros['notificado_sancion']), fn ($q) => $q->whereHas('decisiones.sanciones.notificaciones'))
            ->when(! empty($filtros['sin_sancion']), fn ($q) => $q->whereDoesntHave('decisiones.sanciones'))
            ->when(! empty($filtros['sin_decision']), fn ($q) => $q->whereDoesntHave('decisiones'))
            ->when(! empty($filtros['sin_notificado_proceso']), fn ($q) => $q->whereDoesntHave('notificaciones'))
            ->when(! empty($filtros['sin_notificado_sancion']), fn ($q) => $q->whereDoesntHave('decisiones.sanciones.notificaciones'))
            ->orderByDesc('fecha_registro');
    }

    private function filled(array $filtros, string $key): bool
    {
        return isset($filtros[$key]) && $filtros[$key] !== '';
    }
}
