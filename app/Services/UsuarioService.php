<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    public function listar(
        string $buscar = '',
        string $rol = 'Todos',
        string $estado = 'Todos',
        string $estadoRegistro = 'Activo'
    ): LengthAwarePaginator {
        return Usuario::query()
            ->when($estadoRegistro !== 'Todos', function ($query) use ($estadoRegistro): void {
                $query->where('estado_registro', $estadoRegistro);
            })
            ->when($rol !== 'Todos', function ($query) use ($rol): void {
                $query->where('rol', $rol);
            })
            ->when($estado !== 'Todos', function ($query) use ($estado): void {
                $query->where('estado', $estado);
            })
            ->when($buscar !== '', function ($query) use ($buscar): void {
                $query->where(function ($subquery) use ($buscar): void {
                    $subquery->where('usuario', 'like', "%{$buscar}%")
                        ->orWhere('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%")
                        ->orWhere('email', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('nombre')
            ->orderBy('usuario')
            ->paginate(10)
            ->withQueryString();
    }

    public function crear(array $datos): Usuario
    {
        $usuario = new Usuario();
        $this->asignarDatos($usuario, $datos, true);
        $usuario->save();

        return $usuario;
    }

    public function actualizar(Usuario $usuario, array $datos): bool
    {
        $this->asignarDatos($usuario, $datos, false);

        return $usuario->save();
    }

    public function alternarEstadoRegistro(Usuario $usuario): bool
    {
        $usuario->estado_registro = $usuario->estado_registro === 'Activo' ? 'Inactivo' : 'Activo';

        return $usuario->save();
    }

    private function asignarDatos(Usuario $usuario, array $datos, bool $esNuevo): void
    {
        $usuario->usuario = $datos['usuario'];
        $usuario->nombre = $datos['nombre'];
        $usuario->email = $datos['email'];
        $usuario->rol = $datos['rol'];
        $usuario->estado = $datos['estado'];

        if ($esNuevo) {
            $usuario->identificacion = $datos['usuario'];
            $usuario->apellido = '';
            $usuario->telefono = '';
            $usuario->estado_registro = 'Activo';
        }

        if (! empty($datos['contrasena'])) {
            $usuario->contrasena = Hash::make($datos['contrasena']);
        }
    }
}
