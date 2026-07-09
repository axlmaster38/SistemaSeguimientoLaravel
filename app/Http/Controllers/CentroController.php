<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCentroRequest;
use App\Http\Requests\UpdateCentroRequest;
use App\Models\Centro;
use App\Models\Zona;
use App\Services\CentroService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CentroController extends Controller
{
    public function __construct(private readonly CentroService $centroService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstado((string) $request->input('estado_registro', 'Activo'));
        $centros = $this->centroService->listar($buscar, $estadoRegistro);

        return view('centros.index', compact('centros', 'buscar', 'estadoRegistro'));
    }

    public function create(): View
    {
        return view('centros.create', [
            'centro' => new Centro(),
            'zonas' => Zona::where('estado_registro', 'Activo')->orderBy('nombre')->get(),
        ]);
    }

    public function store(StoreCentroRequest $request): RedirectResponse
    {
        $this->centroService->crear($request->validated());

        return redirect()->route('centros.index')->with('success', 'Centro creado correctamente.');
    }

    public function show(Centro $centro): View
    {
        $centro->load('zona')->loadCount('estudiantes');

        return view('centros.show', compact('centro'));
    }

    public function edit(Centro $centro): View
    {
        return view('centros.edit', [
            'centro' => $centro,
            'zonas' => Zona::where('estado_registro', 'Activo')->orWhere('id', $centro->zona_id)->orderBy('nombre')->get(),
        ]);
    }

    public function update(UpdateCentroRequest $request, Centro $centro): RedirectResponse
    {
        $this->centroService->actualizar($centro, $request->validated());

        return redirect()->route('centros.index')->with('success', 'Centro actualizado correctamente.');
    }

    public function destroy(Centro $centro): RedirectResponse
    {
        $resultado = $this->centroService->alternarEstadoRegistro($centro);

        return redirect()
            ->route('centros.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstado(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }
}
