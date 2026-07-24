<?php

namespace App\Services;

use App\Models\ProcesoDisciplinario;
use App\Models\Sancion;
use Illuminate\Support\Collection;

class AlertaDashboardService
{
    private const LIMITE_ALERTAS = 5;

    private const ESTADOS_PROCESO_EXCLUIDOS = [
        'Proceso Cerrado',
        'Sanción cumplida',
        'Sancion cumplida',
        'Cerrado',
        'Finalizado',
        'Archivado',
    ];

    private const ESTADOS_SANCION_EXCLUIDOS = [
        'Finalizada',
        'Finalizado',
        'Inactiva',
        'Inactivo',
    ];

    public function __construct(private readonly ReglasNegocioDisciplinarioService $reglasNegocio)
    {
    }

    public function obtenerAlertas(): array
    {
        $procesos = $this->procesosProximosAVencer();
        $apelaciones = $this->apelacionesProximasAVencer();
        $sanciones = $this->sancionesProximasAFinalizar();

        return [
            'procesos' => $procesos,
            'apelaciones' => $apelaciones,
            'sanciones' => $sanciones,
            'totales' => [
                'procesos' => $procesos->count(),
                'apelaciones' => $apelaciones->count(),
                'sanciones' => $sanciones->count(),
                'general' => $procesos->count() + $apelaciones->count() + $sanciones->count(),
            ],
            'apelaciones_regla_definida' => false,
            'apelaciones_mensaje' => 'No existe una regla de plazo de apelaciones definida en los servicios, modelos o documentación actual.',
        ];
    }

    private function procesosProximosAVencer(): Collection
    {
        return ProcesoDisciplinario::query()
            ->with(['denuncia.estudiante'])
            ->where('estado_registro', 'Activo')
            ->whereNotIn('estado_proceso', self::ESTADOS_PROCESO_EXCLUIDOS)
            ->whereHas('notificaciones')
            ->orderByDesc('fecha_registro')
            ->limit(80)
            ->get()
            ->map(function (ProcesoDisciplinario $proceso): ?array {
                $reglas = $this->reglasNegocio->calcularProceso($proceso);
                $diasRestantes = $reglas['dias_restantes'];

                if ($diasRestantes === null || $diasRestantes > 3) {
                    return null;
                }

                return [
                    'id' => $proceso->id,
                    'proceso' => $proceso,
                    'estudiante' => $proceso->denuncia?->estudiante,
                    'estado' => $proceso->estado_proceso,
                    'dias_restantes' => $diasRestantes,
                    'fecha_limite' => $reglas['fecha_limite'],
                    'url' => route('procesos.show', $proceso),
                ];
            })
            ->filter()
            ->sortBy([
                ['dias_restantes', 'asc'],
                ['fecha_limite', 'asc'],
            ])
            ->take(self::LIMITE_ALERTAS)
            ->values();
    }

    private function apelacionesProximasAVencer(): Collection
    {
        return collect();
    }

    private function sancionesProximasAFinalizar(): Collection
    {
        return Sancion::query()
            ->with([
                'decision.procesoDisciplinario.denuncia.estudiante',
                'periodoFinalSancion',
                'notificaciones',
            ])
            ->where('estado_registro', 'Activo')
            ->whereNotIn('estado_sancion', self::ESTADOS_SANCION_EXCLUIDOS)
            ->whereNotNull('periodo_final_sancion_id')
            ->orderByDesc('fecha_registro')
            ->limit(80)
            ->get()
            ->map(function (Sancion $sancion): ?array {
                $reglas = $this->reglasNegocio->calcularSancion($sancion);
                $mesesRestantes = $reglas['meses_restantes'];

                if ($mesesRestantes === null || $mesesRestantes > 1) {
                    return null;
                }

                $proceso = $sancion->decision?->procesoDisciplinario;

                return [
                    'id' => $sancion->id,
                    'sancion' => $sancion,
                    'proceso' => $proceso,
                    'estudiante' => $proceso?->denuncia?->estudiante,
                    'tipo_sancion' => $sancion->tipo_sancion,
                    'estado_sancion' => $sancion->estado_sancion,
                    'meses_restantes' => $mesesRestantes,
                    'fecha_final' => $sancion->periodoFinalSancion?->fecha_inicio,
                    'url' => route('sanciones.show', $sancion),
                ];
            })
            ->filter()
            ->sortBy([
                ['meses_restantes', 'asc'],
                ['fecha_final', 'asc'],
            ])
            ->take(self::LIMITE_ALERTAS)
            ->values();
    }
}
