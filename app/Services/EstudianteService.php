<?php

namespace App\Services;

use App\Models\Estudiante;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EstudianteService
{
    private const ESTADOS_INACTIVOS_DENUNCIA = ['Inactivo', 'Cerrada', 'Cerrado', 'Finalizada', 'Finalizado', 'Archivada', 'Archivado'];
    private const ESTADOS_INACTIVOS_PROCESO = ['Inactivo', 'Cerrado', 'Finalizado', 'Archivado'];

    public function listar(string $buscar = '', string $estadoRegistro = 'Activo', string $estadoAcademico = 'Todos'): LengthAwarePaginator
    {
        return Estudiante::query()
            ->with(['programa', 'centro'])
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($estadoAcademico !== 'Todos', function ($query) use ($estadoAcademico): void {
                $query->where('estado_academico', $estadoAcademico);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('codigo_estu', 'like', "%{$buscar}%")
                        ->orWhere('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%")
                        ->orWhere('email_institucional', 'like', "%{$buscar}%")
                        ->orWhere('email_personal', 'like', "%{$buscar}%")
                        ->orWhereHas('programa', function ($programaQuery) use ($buscar): void {
                            $programaQuery->where('nombre', 'like', "%{$buscar}%")
                                ->orWhere('codigo_pro', 'like', "%{$buscar}%");
                        });
                });
            })
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Estudiante
    {
        $datos['estado_registro'] = 'Activo';
        $datos['usuario_registra_id'] = session('usuario_id');
        $datos['usuario_actualiza_id'] = null;

        return Estudiante::create($datos);
    }

    public function actualizar(Estudiante $estudiante, array $datos): bool
    {
        unset($datos['estado_registro']);
        $datos['usuario_actualiza_id'] = session('usuario_id');

        return $estudiante->update($datos);
    }

    public function alternarEstadoRegistro(Estudiante $estudiante): array
    {
        if ($estudiante->estado_registro === 'Activo' && $this->tieneDenunciasActivas($estudiante)) {
            return [
                'ok' => false,
                'message' => 'No se puede inactivar el estudiante porque tiene denuncias activas.',
            ];
        }

        if ($estudiante->estado_registro === 'Activo' && $this->tieneProcesosActivos($estudiante)) {
            return [
                'ok' => false,
                'message' => 'No se puede inactivar el estudiante porque tiene procesos disciplinarios activos.',
            ];
        }

        $estudiante->update([
            'estado_registro' => $estudiante->estado_registro === 'Activo' ? 'Inactivo' : 'Activo',
            'usuario_actualiza_id' => session('usuario_id'),
        ]);

        return [
            'ok' => true,
            'message' => $estudiante->estado_registro === 'Activo'
                ? 'Estudiante activado correctamente.'
                : 'Estudiante inactivado correctamente.',
        ];
    }

    private function tieneDenunciasActivas(Estudiante $estudiante): bool
    {
        return $estudiante->denuncias()
            ->whereNotIn('estado_denuncia', self::ESTADOS_INACTIVOS_DENUNCIA)
            ->exists();
    }

    private function tieneProcesosActivos(Estudiante $estudiante): bool
    {
        return $estudiante->denuncias()
            ->whereHas('procesos', function ($query): void {
                $query->whereNotIn('estado_proceso', self::ESTADOS_INACTIVOS_PROCESO);
            })
            ->exists();
    }
}
