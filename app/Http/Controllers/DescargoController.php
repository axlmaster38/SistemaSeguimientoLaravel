<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDescargoRequest;
use App\Http\Requests\UpdateDescargoRequest;
use App\Models\Descargo;
use App\Models\ProcesoDisciplinario;
use App\Services\DescargoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DescargoController extends Controller
{
    public function __construct(private readonly DescargoService $descargoService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstado((string) $request->input('estado_registro', 'Activo'));
        $procesoId = $request->filled('proceso_disciplinario_id') ? (int) $request->input('proceso_disciplinario_id') : null;
        $descargos = $this->descargoService->listar($buscar, $estadoRegistro, $procesoId);
        $procesos = $this->procesosParaSelect();

        return view('descargos.index', compact('descargos', 'buscar', 'estadoRegistro', 'procesoId', 'procesos'));
    }

    public function create(): View
    {
        return view('descargos.create', [
            'descargo' => new Descargo(),
            'procesos' => $this->procesosActivos(),
        ]);
    }

    public function store(StoreDescargoRequest $request): RedirectResponse
    {
        $this->descargoService->crear($request->validated());

        return redirect()->route('descargos.index')->with('success', 'Descargo creado correctamente.');
    }

    public function show(Descargo $descargo): View
    {
        $descargo->load(['procesoDisciplinario.denuncia.estudiante', 'usuarioRegistra', 'usuarioActualiza'])->loadCount('pruebas');

        return view('descargos.show', compact('descargo'));
    }

    public function edit(Descargo $descargo): View
    {
        return view('descargos.edit', [
            'descargo' => $descargo,
            'procesos' => ProcesoDisciplinario::with('denuncia.estudiante')
                ->where('estado_registro', 'Activo')
                ->orWhere('id', $descargo->proceso_disciplinario_id)
                ->orderByDesc('id')
                ->get(),
        ]);
    }

    public function update(UpdateDescargoRequest $request, Descargo $descargo): RedirectResponse
    {
        $this->descargoService->actualizar($descargo, $request->validated());

        return redirect()->route('descargos.index')->with('success', 'Descargo actualizado correctamente.');
    }

    public function destroy(Descargo $descargo): RedirectResponse
    {
        $resultado = $this->descargoService->alternarEstadoRegistro($descargo);

        return redirect()
            ->route('descargos.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstado(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }

    private function procesosActivos()
    {
        return ProcesoDisciplinario::with('denuncia.estudiante')
            ->where('estado_registro', 'Activo')
            ->orderByDesc('id')
            ->get();
    }

    private function procesosParaSelect()
    {
        return ProcesoDisciplinario::with('denuncia.estudiante')
            ->orderByDesc('id')
            ->get();
    }
}
