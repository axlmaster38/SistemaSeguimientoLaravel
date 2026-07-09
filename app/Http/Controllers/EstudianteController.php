<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstudianteRequest;
use App\Http\Requests\UpdateEstudianteRequest;
use App\Models\Centro;
use App\Models\Estudiante;
use App\Models\Programa;
use App\Services\EstudianteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstudianteController extends Controller
{
    public function __construct(private readonly EstudianteService $estudianteService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstado((string) $request->input('estado_registro', 'Activo'));
        $estadoAcademico = trim((string) $request->input('estado_academico', 'Todos')) ?: 'Todos';
        $estudiantes = $this->estudianteService->listar($buscar, $estadoRegistro, $estadoAcademico);
        $estadosAcademicos = Estudiante::query()
            ->select('estado_academico')
            ->distinct()
            ->orderBy('estado_academico')
            ->pluck('estado_academico');

        return view('estudiantes.index', compact('estudiantes', 'buscar', 'estadoRegistro', 'estadoAcademico', 'estadosAcademicos'));
    }

    public function create(): View
    {
        return view('estudiantes.create', [
            'estudiante' => new Estudiante(),
            'centros' => Centro::where('estado_registro', 'Activo')->orderBy('centro')->get(),
            'programas' => Programa::where('estado_registro', 'Activo')->orderBy('nombre')->get(),
            'estadosAcademicos' => $this->estadosAcademicosFormulario(),
        ]);
    }

    public function store(StoreEstudianteRequest $request): RedirectResponse
    {
        $this->estudianteService->crear($request->validated());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado correctamente.');
    }

    public function show(Estudiante $estudiante): View
    {
        $estudiante->load(['centro', 'programa'])->loadCount(['denuncias', 'historicos']);

        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante): View
    {
        return view('estudiantes.edit', [
            'estudiante' => $estudiante,
            'centros' => Centro::where('estado_registro', 'Activo')->orWhere('id', $estudiante->centro_id)->orderBy('centro')->get(),
            'programas' => Programa::where('estado_registro', 'Activo')->orWhere('id', $estudiante->programa_id)->orderBy('nombre')->get(),
            'estadosAcademicos' => $this->estadosAcademicosFormulario(),
        ]);
    }

    public function update(UpdateEstudianteRequest $request, Estudiante $estudiante): RedirectResponse
    {
        $this->estudianteService->actualizar($estudiante, $request->validated());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy(Estudiante $estudiante): RedirectResponse
    {
        $resultado = $this->estudianteService->alternarEstadoRegistro($estudiante);

        return redirect()
            ->route('estudiantes.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstado(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }

    private function estadosAcademicosFormulario(): array
    {
        return ['Activo', 'Inactivo', 'Graduado', 'Retirado', 'Suspendido'];
    }
}
