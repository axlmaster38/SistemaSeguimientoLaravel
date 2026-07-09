<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramaRequest;
use App\Http\Requests\UpdateProgramaRequest;
use App\Models\Escuela;
use App\Models\Programa;
use App\Services\ProgramaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramaController extends Controller
{
    public function __construct(private readonly ProgramaService $programaService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstado((string) $request->input('estado_registro', 'Activo'));
        $programas = $this->programaService->listar($buscar, $estadoRegistro);

        return view('programas.index', compact('programas', 'buscar', 'estadoRegistro'));
    }

    public function create(): View
    {
        return view('programas.create', [
            'programa' => new Programa(),
            'escuelas' => Escuela::where('estado_registro', 'Activo')->orderBy('nombre')->get(),
        ]);
    }

    public function store(StoreProgramaRequest $request): RedirectResponse
    {
        $this->programaService->crear($request->validated());

        return redirect()->route('programas.index')->with('success', 'Programa creado correctamente.');
    }

    public function show(Programa $programa): View
    {
        $programa->load('escuela')->loadCount('estudiantes');

        return view('programas.show', compact('programa'));
    }

    public function edit(Programa $programa): View
    {
        return view('programas.edit', [
            'programa' => $programa,
            'escuelas' => Escuela::where('estado_registro', 'Activo')->orWhere('id', $programa->escuela_id)->orderBy('nombre')->get(),
        ]);
    }

    public function update(UpdateProgramaRequest $request, Programa $programa): RedirectResponse
    {
        $this->programaService->actualizar($programa, $request->validated());

        return redirect()->route('programas.index')->with('success', 'Programa actualizado correctamente.');
    }

    public function destroy(Programa $programa): RedirectResponse
    {
        $resultado = $this->programaService->alternarEstadoRegistro($programa);

        return redirect()
            ->route('programas.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstado(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }
}
