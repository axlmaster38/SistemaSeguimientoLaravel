<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePruebaRequest;
use App\Http\Requests\UpdatePruebaRequest;
use App\Models\Apelacion;
use App\Models\Descargo;
use App\Models\ProcesoDisciplinario;
use App\Models\Prueba;
use App\Services\PruebaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PruebaController extends Controller
{
    public function __construct(private readonly PruebaService $pruebaService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstado((string) $request->input('estado_registro', 'Activo'));
        $tipoPrueba = trim((string) $request->input('tipo_prueba', 'Todos')) ?: 'Todos';
        $procedencia = trim((string) $request->input('procedencia', 'Todos')) ?: 'Todos';
        $procesoId = $request->filled('proceso_disciplinario_id') ? (int) $request->input('proceso_disciplinario_id') : null;
        $pruebas = $this->pruebaService->listar($buscar, $estadoRegistro, $tipoPrueba, $procedencia, $procesoId);
        $procesos = $this->procesosParaSelect();
        $tiposPrueba = Prueba::select('tipo_prueba')->distinct()->orderBy('tipo_prueba')->pluck('tipo_prueba');
        $procedencias = Prueba::select('procedencia')->distinct()->orderBy('procedencia')->pluck('procedencia');

        return view('pruebas.index', compact('pruebas', 'buscar', 'estadoRegistro', 'tipoPrueba', 'procedencia', 'procesoId', 'procesos', 'tiposPrueba', 'procedencias'));
    }

    public function create(Request $request): View
    {
        $apelacion = $request->filled('apelacion_id')
            ? Apelacion::where('estado_registro', 'Activo')->find($request->integer('apelacion_id'))
            : null;
        $prueba = new Prueba([
            'apelacion_id' => $apelacion?->id,
            'proceso_disciplinario_id' => $apelacion?->proceso_disciplinario_id,
            'procedencia' => $apelacion ? 'Apelacion' : null,
        ]);

        return view('pruebas.create', [
            'prueba' => $prueba,
            'procesos' => $this->procesosActivos(),
            'descargos' => collect(),
            'apelaciones' => $this->apelacionesActivas($prueba),
        ]);
    }

    public function store(StorePruebaRequest $request): RedirectResponse
    {
        $this->pruebaService->crear($request->validated(), $request->file('archivo'));

        return redirect()->route('pruebas.index')->with('success', 'Prueba creada correctamente.');
    }

    public function show(Prueba $prueba): View
    {
        $prueba->load(['procesoDisciplinario.denuncia.estudiante', 'descargo', 'apelacion', 'usuarioRegistra', 'usuarioActualiza']);

        return view('pruebas.show', compact('prueba'));
    }

    public function edit(Prueba $prueba): View
    {
        return view('pruebas.edit', [
            'prueba' => $prueba,
            'procesos' => $this->procesosActivos($prueba),
            'descargos' => Descargo::where('proceso_disciplinario_id', $prueba->proceso_disciplinario_id)
                ->where(function ($query) use ($prueba): void {
                    $query->where('estado_registro', 'Activo')
                        ->orWhere('id', $prueba->descargo_id);
                })
                ->orderByDesc('id')
                ->get(),
            'apelaciones' => $this->apelacionesActivas($prueba),
        ]);
    }

    public function update(UpdatePruebaRequest $request, Prueba $prueba): RedirectResponse
    {
        $this->pruebaService->actualizar($prueba, $request->validated(), $request->file('archivo'));

        return redirect()->route('pruebas.index')->with('success', 'Prueba actualizada correctamente.');
    }

    public function destroy(Prueba $prueba): RedirectResponse
    {
        $resultado = $this->pruebaService->alternarEstadoRegistro($prueba);

        return redirect()
            ->route('pruebas.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    public function descargarArchivo(Prueba $prueba): StreamedResponse|RedirectResponse
    {
        if (! $prueba->archivo || ! Storage::disk('public')->exists($prueba->archivo)) {
            return redirect()->route('pruebas.show', $prueba)->with('error', 'El archivo no está disponible.');
        }

        return Storage::disk('public')->download($prueba->archivo);
    }

    private function normalizarEstado(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }

    private function procesosActivos(?Prueba $prueba = null)
    {
        return ProcesoDisciplinario::with('denuncia.estudiante')
            ->where('estado_registro', 'Activo')
            ->when($prueba, function ($query) use ($prueba): void {
                $query->orWhere('id', $prueba->proceso_disciplinario_id);
            })
            ->orderByDesc('id')
            ->get();
    }

    private function procesosParaSelect()
    {
        return ProcesoDisciplinario::with('denuncia.estudiante')
            ->orderByDesc('id')
            ->get();
    }

    private function apelacionesActivas(?Prueba $prueba = null)
    {
        return Apelacion::with('procesoDisciplinario.denuncia.estudiante')
            ->where('estado_registro', 'Activo')
            ->when($prueba?->apelacion_id, function ($query) use ($prueba): void {
                $query->orWhere('id', $prueba->apelacion_id);
            })
            ->orderByDesc('id')
            ->get();
    }
}
