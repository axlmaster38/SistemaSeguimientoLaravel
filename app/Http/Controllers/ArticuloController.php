<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticuloRequest;
use App\Http\Requests\UpdateArticuloRequest;
use App\Models\Articulo;
use App\Models\Normatividad;
use App\Services\ArticuloService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticuloController extends Controller
{
    public function __construct(private readonly ArticuloService $articuloService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstadoRegistro((string) $request->input('estado_registro', 'Activo'));
        $normatividadId = $request->filled('normatividad_id') ? (int) $request->input('normatividad_id') : null;
        $articulos = $this->articuloService->listar($buscar, $estadoRegistro, $normatividadId);
        $normatividades = $this->normatividadesParaFiltro();

        return view('articulos.index', compact(
            'articulos',
            'buscar',
            'estadoRegistro',
            'normatividadId',
            'normatividades'
        ));
    }

    public function create(): View
    {
        return view('articulos.create', [
            'articulo' => new Articulo(),
            'normatividades' => $this->normatividadesActivas(),
        ]);
    }

    public function store(StoreArticuloRequest $request): RedirectResponse
    {
        $this->articuloService->crear($request->validated());

        return redirect()
            ->route('articulos.index')
            ->with('success', 'Artículo creado correctamente.');
    }

    public function show(Articulo $articulo): View
    {
        $articulo->load(['normatividad', 'usuarioRegistra', 'usuarioActualiza'])
            ->loadCount('procesosDisciplinarios');

        return view('articulos.show', compact('articulo'));
    }

    public function edit(Articulo $articulo): View
    {
        return view('articulos.edit', [
            'articulo' => $articulo,
            'normatividades' => Normatividad::query()
                ->where('estado_registro', 'Activo')
                ->orWhere('id', $articulo->normatividad_id)
                ->orderBy('no_acuerdo')
                ->get(),
        ]);
    }

    public function update(UpdateArticuloRequest $request, Articulo $articulo): RedirectResponse
    {
        $this->articuloService->actualizar($articulo, $request->validated());

        return redirect()
            ->route('articulos.index')
            ->with('success', 'Artículo actualizado correctamente.');
    }

    public function destroy(Articulo $articulo): RedirectResponse
    {
        $resultado = $this->articuloService->alternarEstadoRegistro($articulo);

        return redirect()
            ->route('articulos.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstadoRegistro(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }

    private function normatividadesActivas()
    {
        return Normatividad::query()
            ->where('estado_registro', 'Activo')
            ->orderBy('no_acuerdo')
            ->get();
    }

    private function normatividadesParaFiltro()
    {
        return Normatividad::query()
            ->orderBy('no_acuerdo')
            ->get();
    }
}
