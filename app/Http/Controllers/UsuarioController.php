<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use App\Services\UsuarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function __construct(private readonly UsuarioService $usuarioService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $rol = (string) $request->input('rol', 'Todos');
        $estado = (string) $request->input('estado', 'Todos');
        $estadoRegistro = (string) $request->input('estado_registro', 'Activo');

        if (! in_array($rol, ['Administrador', 'Operador', 'Todos'], true)) {
            $rol = 'Todos';
        }

        if (! in_array($estado, ['Activo', 'Inactivo', 'Todos'], true)) {
            $estado = 'Todos';
        }

        if (! in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true)) {
            $estadoRegistro = 'Activo';
        }

        $usuarios = $this->usuarioService->listar($buscar, $rol, $estado, $estadoRegistro);

        return view('usuarios.index', compact('usuarios', 'buscar', 'rol', 'estado', 'estadoRegistro'));
    }

    public function create(): View
    {
        return view('usuarios.create', [
            'usuario' => new Usuario(),
        ]);
    }

    public function store(StoreUsuarioRequest $request): RedirectResponse
    {
        $this->usuarioService->crear($request->validated());

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(Usuario $usuario): View
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario): View
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario): RedirectResponse
    {
        $this->usuarioService->actualizar($usuario, $request->validated());

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        $estadoAnterior = $usuario->estado_registro;

        $this->usuarioService->alternarEstadoRegistro($usuario);

        $mensaje = $estadoAnterior === 'Activo'
            ? 'Usuario inactivado correctamente.'
            : 'Usuario activado correctamente.';

        return redirect()
            ->route('usuarios.index')
            ->with('success', $mensaje);
    }
}
