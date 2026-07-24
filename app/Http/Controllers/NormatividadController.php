<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNormatividadRequest;
use App\Http\Requests\UpdateNormatividadRequest;
use App\Models\Normatividad;
use App\Services\NormatividadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NormatividadController extends Controller
{
    public function __construct(private readonly NormatividadService $normatividadService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstadoRegistro((string) $request->input('estado_registro', 'Activo'));
        $normatividades = $this->normatividadService->listar($buscar, $estadoRegistro);

        return view('normatividades.index', compact('normatividades', 'buscar', 'estadoRegistro'));
    }

    public function create(): View
    {
        return view('normatividades.create', [
            'normatividad' => new Normatividad(),
        ]);
    }

    public function store(StoreNormatividadRequest $request): RedirectResponse
    {
        $this->normatividadService->crear($request->validated());

        return redirect()
            ->route('normatividades.index')
            ->with('success', 'Normatividad creada correctamente.');
    }

    public function show(Normatividad $normatividad): View
    {
        $normatividad->load(['usuarioRegistra', 'usuarioActualiza'])
            ->loadCount('articulos');

        return view('normatividades.show', compact('normatividad'));
    }

    public function edit(Normatividad $normatividad): View
    {
        return view('normatividades.edit', compact('normatividad'));
    }

    public function update(UpdateNormatividadRequest $request, Normatividad $normatividad): RedirectResponse
    {
        $this->normatividadService->actualizar($normatividad, $request->validated());

        return redirect()
            ->route('normatividades.index')
            ->with('success', 'Normatividad actualizada correctamente.');
    }

    public function destroy(Normatividad $normatividad): RedirectResponse
    {
        $resultado = $this->normatividadService->alternarEstadoRegistro($normatividad);

        return redirect()
            ->route('normatividades.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstadoRegistro(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }
}
