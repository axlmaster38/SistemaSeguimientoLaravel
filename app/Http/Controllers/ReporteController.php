<?php

namespace App\Http\Controllers;

use App\Models\ProcesoDisciplinario;
use App\Services\ReporteService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteController extends Controller
{
    public function __construct(private readonly ReporteService $reporteService)
    {
    }

    public function index(): View
    {
        return view('reportes.index');
    }

    public function antecedentesEstudiante(Request $request): View
    {
        $filtros = $this->filtros($request);
        $estudiantes = $this->reporteService->antecedentesEstudiante($filtros);

        return view('reportes.antecedentes_estudiante', $this->reporteService->opciones() + compact('estudiantes', 'filtros'));
    }

    public function procesosHistoricos(Request $request): View
    {
        $filtros = $this->filtros($request);
        $procesos = $this->reporteService->procesosHistoricos($filtros);

        return view('reportes.procesos_historicos', $this->reporteService->opciones() + compact('procesos', 'filtros'));
    }

    public function procesoHistoricoDetalle(ProcesoDisciplinario $proceso): View
    {
        $proceso = $this->reporteService->detalleProcesoHistorico($proceso);

        return view('reportes.proceso_historico_detalle', compact('proceso'));
    }

    public function exportarProcesosHistoricosCsv(Request $request): StreamedResponse
    {
        $filtros = $this->filtros($request);
        $procesos = $this->reporteService->procesosHistoricosParaExportar($filtros);
        $headers = [
            'ID Proceso',
            'Fecha Apertura',
            'Estado Proceso',
            'Estudiante Codigo',
            'Estudiante Nombre',
            'Estudiante Apellido',
            'Denuncia - Descripcion',
            'Denuncia - Justificacion',
            'Tipologias de Falta',
            'Articulos aplicados',
            'Decisiones',
            'Sanciones',
            'Notificaciones y evidencias',
            'Descargos',
            'Apelaciones',
            'Pruebas',
        ];

        return response()->streamDownload(function () use ($procesos, $headers): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            foreach ($procesos as $proceso) {
                $estudiante = $proceso->denuncia?->estudiante;
                $decisiones = $proceso->decisiones->map(fn ($decision) => "Decision ({$decision->tipo_decision}) - {$decision->resultado}")->implode("\n") ?: 'Sin decisiones';
                $sanciones = $proceso->decisiones->flatMap->sanciones->map(fn ($sancion) => "{$sancion->tipo_sancion} - ".($sancion->descripcion ?? ''))->implode("\n") ?: 'Sin sanciones';
                $notificaciones = $proceso->notificaciones->concat($proceso->decisiones->flatMap->sanciones->flatMap->notificaciones)
                    ->map(fn ($notificacion) => "Notificacion de {$notificacion->tipo_notificacion} - {$notificacion->fecha_registro?->format('Y-m-d H:i')}")
                    ->implode("\n") ?: 'Sin notificaciones';

                fputcsv($handle, [
                    $proceso->id,
                    $proceso->fecha_apertura?->format('Y-m-d') ?: $proceso->fecha_registro?->format('Y-m-d H:i'),
                    $proceso->estado_proceso,
                    $estudiante?->codigo_estu,
                    $estudiante?->nombre,
                    $estudiante?->apellido,
                    $proceso->denuncia?->descripcion,
                    $proceso->denuncia?->justificacion,
                    $proceso->tipologiasFalta->pluck('nombre')->implode(', '),
                    $proceso->articulos->map(fn ($articulo) => "{$articulo->no_articulo} ({$articulo->capitulo})")->implode(', '),
                    $decisiones,
                    $sanciones,
                    $notificaciones,
                    $proceso->descargos->pluck('descripcion')->filter()->implode("\n") ?: 'Sin descargos',
                    $proceso->apelaciones->pluck('motivo')->filter()->implode("\n") ?: 'Sin apelaciones',
                    $proceso->pruebas->map(fn ($prueba) => "Prueba de {$prueba->procedencia} - {$prueba->tipo_prueba}")->implode("\n") ?: 'Sin pruebas',
                ]);
            }

            fclose($handle);
        }, 'historico_procesos.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filtros(Request $request): array
    {
        return [
            'estudiante_id' => $request->input('estudiante_id'),
            'codigo' => trim((string) $request->input('codigo')),
            'programa_id' => $request->input('programa_id'),
            'centro_id' => $request->input('centro_id'),
            'proceso_id' => $request->input('proceso_id'),
            'denuncia_id' => $request->input('denuncia_id'),
            'estado_proceso' => $request->input('estado_proceso'),
            'estado_sancion' => trim((string) $request->input('estado_sancion')),
            'clasificacion_falta' => $request->input('clasificacion_falta'),
            'fecha_desde' => $request->input('fecha_desde'),
            'fecha_hasta' => $request->input('fecha_hasta'),
            'sancionado' => $request->boolean('sancionado'),
            'tiene_decision' => $request->boolean('tiene_decision'),
            'notificado_proceso' => $request->boolean('notificado_proceso'),
            'notificado_sancion' => $request->boolean('notificado_sancion'),
            'sin_sancion' => $request->boolean('sin_sancion'),
            'sin_decision' => $request->boolean('sin_decision'),
            'sin_notificado_proceso' => $request->boolean('sin_notificado_proceso'),
            'sin_notificado_sancion' => $request->boolean('sin_notificado_sancion'),
        ];
    }
}
