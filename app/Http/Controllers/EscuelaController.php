<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEscuelaRequest;
use App\Http\Requests\UpdateEscuelaRequest;
use App\Models\Escuela;
use App\Services\EscuelaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EscuelaController extends Controller
{
    public function __construct(private readonly EscuelaService $escuelaService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = (string) $request->input('estado_registro', 'Activo');

        if (! in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true)) {
            $estadoRegistro = 'Activo';
        }

        $escuelas = $this->escuelaService->listar($buscar, $estadoRegistro);

        return view('escuelas.index', compact('escuelas', 'buscar', 'estadoRegistro'));
    }

    public function create(): View
    {
        return view('escuelas.create', [
            'escuela' => new Escuela(),
        ]);
    }

    public function store(StoreEscuelaRequest $request): RedirectResponse
    {
        $this->escuelaService->crear($request->validated());

        return redirect()
            ->route('escuelas.index')
            ->with('success', 'Escuela creada correctamente.');
    }

    public function show(Escuela $escuela): View
    {
        $escuela->loadCount('programas');

        return view('escuelas.show', compact('escuela'));
    }

    public function edit(Escuela $escuela): View
    {
        return view('escuelas.edit', compact('escuela'));
    }

    public function update(UpdateEscuelaRequest $request, Escuela $escuela): RedirectResponse
    {
        $this->escuelaService->actualizar($escuela, $request->validated());

        return redirect()
            ->route('escuelas.index')
            ->with('success', 'Escuela actualizada correctamente.');
    }

    public function destroy(Escuela $escuela): RedirectResponse
    {
        $estadoAnterior = $escuela->estado_registro;

        $this->escuelaService->alternarEstadoRegistro($escuela);

        $mensaje = $estadoAnterior === 'Activo'
            ? 'Escuela inactivada correctamente.'
            : 'Escuela activada correctamente.';

        return redirect()
            ->route('escuelas.index')
            ->with('success', $mensaje);
    }
}
