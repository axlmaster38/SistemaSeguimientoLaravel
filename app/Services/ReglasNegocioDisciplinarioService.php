<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\ProcesoDisciplinario;
use App\Models\Sancion;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class ReglasNegocioDisciplinarioService
{
    public function sumarDiasHabiles(CarbonInterface $fecha, int $diasHabiles): CarbonInterface
    {
        $diasSumados = 0;
        $fechaActual = $fecha->copy()->startOfDay();

        while ($diasSumados < $diasHabiles) {
            $fechaActual = $fechaActual->addDay();

            if ($fechaActual->isWeekday()) {
                $diasSumados++;
            }
        }

        return $fechaActual;
    }

    public function contarDiasHabiles(CarbonInterface $inicio, CarbonInterface $fin): int
    {
        $diasHabiles = 0;
        $diaActual = $inicio->copy()->startOfDay();
        $fechaFin = $fin->copy()->startOfDay();

        while ($diaActual->lt($fechaFin)) {
            if ($diaActual->isWeekday()) {
                $diasHabiles++;
            }

            $diaActual = $diaActual->addDay();
        }

        return $diasHabiles;
    }

    public function calcularProceso(ProcesoDisciplinario $proceso): array
    {
        $hoy = Carbon::today();
        $notificacion = Notificacion::query()
            ->where('proceso_disciplinario_id', $proceso->id)
            ->orderByDesc('fecha_registro')
            ->first();
        $decision = $proceso->decisiones()->orderByDesc('fecha_registro')->first();
        $sancion = Sancion::query()
            ->whereHas('decision', fn ($query) => $query->where('proceso_disciplinario_id', $proceso->id))
            ->orderByDesc('fecha_registro')
            ->first();

        $diasCorridos = null;
        if ($sancion?->fecha_registro) {
            $diasCorridos = $sancion->fecha_registro->startOfDay()->diffInDays($hoy, false);
        } elseif ($decision?->fecha_registro) {
            $diasCorridos = $decision->fecha_registro->startOfDay()->diffInDays($hoy, false);
        } elseif ($proceso->fecha_registro) {
            $diasCorridos = $proceso->fecha_registro->startOfDay()->diffInDays($hoy, false);
        }

        $fechaBase = null;
        if ($notificacion?->fecha_2da_notificacion) {
            $fechaBase = $notificacion->fecha_2da_notificacion;
        } elseif ($notificacion?->fecha_registro) {
            $fechaBase = $notificacion->fecha_registro;
        }

        $diasRestantes = null;
        $fechaLimite = null;
        if ($fechaBase) {
            $fechaLimite = $this->sumarDiasHabiles($fechaBase, 10);
            $diasRestantes = $this->contarDiasHabiles($hoy, $fechaLimite);
        }

        return [
            'dias_corridos' => $diasCorridos,
            'dias_restantes' => $diasRestantes,
            'fecha_limite' => $fechaLimite,
            'instancia' => $notificacion?->instancia,
            'color_estado' => $this->colorEstadoProceso($proceso->estado_proceso),
            'color_dias_restantes' => $this->colorDiasRestantesProceso($diasRestantes),
            'texto_dias_restantes' => $this->textoDiasRestantesProceso($diasRestantes, $notificacion?->instancia),
        ];
    }

    public function calcularSancion(Sancion $sancion): array
    {
        $hoy = Carbon::today();
        $notificacion = $sancion->notificaciones()->orderByDesc('fecha_registro')->first();
        $mesesRestantes = null;

        if ($sancion->periodoFinalSancion?->fecha_inicio) {
            $fechaFinal = $sancion->periodoFinalSancion->fecha_inicio->copy()->startOfDay();
            $mesesRestantes = (($hoy->year - $fechaFinal->year) * -12) + ($fechaFinal->month - $hoy->month);

            if ($fechaFinal->day > $hoy->day) {
                $mesesRestantes++;
            }
        }

        $fechaNotificacion = $notificacion?->fecha_2da_notificacion ?: $notificacion?->fecha_registro;

        return [
            'meses_restantes' => $mesesRestantes,
            'instancia' => $notificacion?->instancia,
            'fecha_notificacion' => $fechaNotificacion,
            'color_meses_restantes' => $this->colorMesesRestantesSancion($mesesRestantes),
            'texto_notificacion' => $notificacion
                ? ($sancion->tipo_sancion === 'Primera Instancia' ? 'Notificado en primera instancia' : 'Notificado en segunda instancia')
                : 'Sin notificar',
        ];
    }

    public function colorEstadoProceso(?string $estadoProceso): ?string
    {
        return match ($estadoProceso) {
            'Proceso Abierto' => 'rgb(0, 242, 255)',
            'Fallo en primera instancia', 'Fallo en segunda instancia', 'Cumpliendo Sanción' => 'rgb(0, 153, 255)',
            'Proceso Cerrado', 'Sanción cumplida' => 'rgb(17, 0, 255)',
            default => null,
        };
    }

    private function colorDiasRestantesProceso(?int $diasRestantes): ?string
    {
        if ($diasRestantes === null) {
            return null;
        }

        if ($diasRestantes <= 2) {
            return 'rgb(250, 124, 124)';
        }

        if ($diasRestantes <= 5) {
            return 'rgb(250, 239, 124)';
        }

        return null;
    }

    private function colorMesesRestantesSancion(?int $mesesRestantes): ?string
    {
        if ($mesesRestantes === null) {
            return null;
        }

        if ($mesesRestantes <= 1 && $mesesRestantes >= 0) {
            return 'rgb(250, 124, 124)';
        }

        if ($mesesRestantes <= 4 && $mesesRestantes >= 2) {
            return 'rgb(250, 239, 124)';
        }

        return null;
    }

    private function textoDiasRestantesProceso(?int $diasRestantes, ?string $instancia): string
    {
        if ($diasRestantes === null) {
            return 'Proceso sin notificar';
        }

        $texto = "{$diasRestantes}";

        if ($instancia === 'Primera Notificación') {
            return "{$texto} dias a vencer a partir de la primera notificación";
        }

        if ($instancia === 'Segunda Notificación') {
            return "{$texto} dias a vencer a partir de la segunda notificación";
        }

        return $texto;
    }
}
