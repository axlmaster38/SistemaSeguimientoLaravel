<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZonaRequest;
use App\Http\Requests\UpdateZonaRequest;
use App\Models\Zona;
use App\Services\ZonaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ZonaController extends Controller
{
    public function __construct(private readonly ZonaService $zonaService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstado((string) $request->input('estado_registro', 'Activo'));
        $zonas = $this->zonaService->listar($buscar, $estadoRegistro);

        return view('zonas.index', compact('zonas', 'buscar', 'estadoRegistro'));
    }

    public function create(): View
    {
        return view('zonas.create', ['zona' => new Zona()]);
    }

    public function store(StoreZonaRequest $request): RedirectResponse
    {
        $this->zonaService->crear($request->validated());

        return redirect()->route('zonas.index')->with('success', 'Zona creada correctamente.');
    }

    public function show(Zona $zona): View
    {
        $zona->loadCount('centros');

        return view('zonas.show', compact('zona'));
    }

    public function edit(Zona $zona): View
    {
        return view('zonas.edit', compact('zona'));
    }

    public function update(UpdateZonaRequest $request, Zona $zona): RedirectResponse
    {
        $this->zonaService->actualizar($zona, $request->validated());

        return redirect()->route('zonas.index')->with('success', 'Zona actualizada correctamente.');
    }

    public function destroy(Zona $zona): RedirectResponse
    {
        $resultado = $this->zonaService->alternarEstadoRegistro($zona);

        return redirect()
            ->route('zonas.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstado(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }
}
