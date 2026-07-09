<?php

namespace App\Services;

use App\Models\Denuncia;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DenunciaService
{
    private const ESTADOS_INACTIVOS_PROCESO = ['Inactivo', 'Cerrado', 'Finalizado', 'Archivado'];

    public function listar(
        string $buscar = '',
        string $estadoRegistro = 'Activo',
        string $estadoDenuncia = 'Todos',
        string $denunciaAntigua = 'Todos',
        ?int $estudianteId = null
    ): LengthAwarePaginator {
        return Denuncia::query()
            ->with('estudiante')
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($estadoDenuncia !== 'Todos', function ($query) use ($estadoDenuncia): void {
                $query->where('estado_denuncia', $estadoDenuncia);
            })
            ->when($denunciaAntigua !== 'Todos', function ($query) use ($denunciaAntigua): void {
                $query->where('denuncia_antigua', $denunciaAntigua === 'Si');
            })
            ->when($estudianteId !== null, function ($query) use ($estudianteId): void {
                $query->where('estudiante_id', $estudianteId);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('descripcion', 'like', "%{$buscar}%")
                        ->orWhere('justificacion', 'like', "%{$buscar}%")
                        ->orWhereHas('estudiante', function ($estudianteQuery) use ($buscar): void {
                            $estudianteQuery->where('codigo_estu', 'like', "%{$buscar}%")
                                ->orWhere('nombre', 'like', "%{$buscar}%")
                                ->orWhere('apellido', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderByDesc('fecha_creacion')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Denuncia
    {
        $datos['denuncia_antigua'] = (bool) ($datos['denuncia_antigua'] ?? false);
        $datos['estado_registro'] = 'Activo';
        $datos['usuario_registra_evalua_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;

        return Denuncia::create($datos);
    }

    public function actualizar(Denuncia $denuncia, array $datos): bool
    {
        unset($datos['estado_registro']);
        $datos['denuncia_antigua'] = (bool) ($datos['denuncia_antigua'] ?? false);
        $datos['usuario_actualiza_id'] = session('usuario_id');

        return $denuncia->update($datos);
    }

    public function alternarEstadoRegistro(Denuncia $denuncia): array
    {
        if ($denuncia->estado_registro === 'Activo' && $this->tieneProcesosActivos($denuncia)) {
            return [
                'ok' => false,
                'message' => 'No se puede inactivar la denuncia porque tiene procesos disciplinarios activos asociados.',
            ];
        }

        $denuncia->update([
            'estado_registro' => $denuncia->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $denuncia->estado_registro === 'Activo'
                ? 'Denuncia activada correctamente.'
                : 'Denuncia inactivada correctamente.',
        ];
    }

    private function tieneProcesosActivos(Denuncia $denuncia): bool
    {
        return $denuncia->procesos()
            ->whereNotIn('estado_proceso', self::ESTADOS_INACTIVOS_PROCESO)
            ->exists();
    }
}
