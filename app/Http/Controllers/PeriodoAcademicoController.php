<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeriodoAcademicoRequest;
use App\Http\Requests\UpdatePeriodoAcademicoRequest;
use App\Models\PeriodoAcademico;
use App\Services\PeriodoAcademicoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeriodoAcademicoController extends Controller
{
    public function __construct(private readonly PeriodoAcademicoService $periodoAcademicoService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstado((string) $request->input('estado_registro', 'Activo'));
        $periodosAcademicos = $this->periodoAcademicoService->listar($buscar, $estadoRegistro);

        return view('periodos_academicos.index', compact('periodosAcademicos', 'buscar', 'estadoRegistro'));
    }

    public function create(): View
    {
        return view('periodos_academicos.create', [
            'periodoAcademico' => new PeriodoAcademico(),
        ]);
    }

    public function store(StorePeriodoAcademicoRequest $request): RedirectResponse
    {
        $this->periodoAcademicoService->crear($request->validated());

        return redirect()->route('periodos-academicos.index')->with('success', 'Periodo academico creado correctamente.');
    }

    public function show(PeriodoAcademico $periodoAcademico): View
    {
        $periodoAcademico->loadCount(['sancionesComoPeriodoInicial', 'sancionesComoPeriodoFinal']);

        return view('periodos_academicos.show', compact('periodoAcademico'));
    }

    public function edit(PeriodoAcademico $periodoAcademico): View
    {
        return view('periodos_academicos.edit', compact('periodoAcademico'));
    }

    public function update(UpdatePeriodoAcademicoRequest $request, PeriodoAcademico $periodoAcademico): RedirectResponse
    {
        $this->periodoAcademicoService->actualizar($periodoAcademico, $request->validated());

        return redirect()->route('periodos-academicos.index')->with('success', 'Periodo academico actualizado correctamente.');
    }

    public function destroy(PeriodoAcademico $periodoAcademico): RedirectResponse
    {
        $resultado = $this->periodoAcademicoService->alternarEstadoRegistro($periodoAcademico);

        return redirect()
            ->route('periodos-academicos.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstado(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }
}
