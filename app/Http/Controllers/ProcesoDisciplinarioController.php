<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProcesoDisciplinarioRequest;
use App\Http\Requests\UpdateProcesoDisciplinarioRequest;
use App\Models\Articulo;
use App\Models\Denuncia;
use App\Models\ProcesoDisciplinario;
use App\Models\TipologiaFalta;
use App\Services\ProcesoDisciplinarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProcesoDisciplinarioController extends Controller
{
    private const ESTADOS_PROCESO = ['En estudio', 'Abierto', 'Cerrado', 'Archivado'];

    public function __construct(private readonly ProcesoDisciplinarioService $procesoDisciplinarioService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstado((string) $request->input('estado_registro', 'Activo'));
        $estadoProceso = $this->normalizarEstadoProceso((string) $request->input('estado_proceso', 'Todos'));
        $procesoAntiguo = $this->normalizarProcesoAntiguo((string) $request->input('proceso_antiguo', 'Todos'));
        $denunciaId = $request->filled('denuncia_id') ? (int) $request->input('denuncia_id') : null;
        $procesos = $this->procesoDisciplinarioService->listar($buscar, $estadoRegistro, $estadoProceso, $procesoAntiguo, $denunciaId);
        $denuncias = $this->denunciasParaFiltro();
        $estadosProceso = self::ESTADOS_PROCESO;

        return view('procesos.index', compact(
            'procesos',
            'buscar',
            'estadoRegistro',
            'estadoProceso',
            'procesoAntiguo',
            'denunciaId',
            'denuncias',
            'estadosProceso'
        ));
    }

    public function create(): View
    {
        return view('procesos.create', [
            'proceso' => new ProcesoDisciplinario(['estado_proceso' => 'En estudio']),
            'denuncias' => $this->denunciasActivasSinProcesoActivo(),
            'tipologiasFaltas' => TipologiaFalta::orderBy('nombre')->get(),
            'articulos' => Articulo::with('normatividad')->orderBy('no_articulo')->get(),
            'estadosProceso' => self::ESTADOS_PROCESO,
        ]);
    }

    public function store(StoreProcesoDisciplinarioRequest $request): RedirectResponse
    {
        $this->procesoDisciplinarioService->crear($request->validated());

        return redirect()->route('procesos.index')->with('success', 'Proceso disciplinario creado correctamente.');
    }

    public function show(ProcesoDisciplinario $proceso): View
    {
        $proceso->load([
            'denuncia.estudiante',
            'tipologiasFalta',
            'articulos.normatividad',
            'usuarioRegistra',
            'usuarioActualiza',
            'historicos.programa',
        ]);

        return view('procesos.show', compact('proceso'));
    }

    public function edit(ProcesoDisciplinario $proceso): View
    {
        $proceso->load(['tipologiasFalta', 'articulos']);

        return view('procesos.edit', [
            'proceso' => $proceso,
            'denuncias' => $this->denunciasActivasSinProcesoActivo($proceso),
            'tipologiasFaltas' => TipologiaFalta::orderBy('nombre')->get(),
            'articulos' => Articulo::with('normatividad')->orderBy('no_articulo')->get(),
            'estadosProceso' => self::ESTADOS_PROCESO,
        ]);
    }

    public function update(UpdateProcesoDisciplinarioRequest $request, ProcesoDisciplinario $proceso): RedirectResponse
    {
        $this->procesoDisciplinarioService->actualizar($proceso, $request->validated());

        return redirect()->route('procesos.index')->with('success', 'Proceso disciplinario actualizado correctamente.');
    }

    public function destroy(ProcesoDisciplinario $proceso): RedirectResponse
    {
        $resultado = $this->procesoDisciplinarioService->alternarEstadoRegistro($proceso);

        return redirect()
            ->route('procesos.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstado(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }

    private function normalizarEstadoProceso(string $estadoProceso): string
    {
        return in_array($estadoProceso, array_merge(['Todos'], self::ESTADOS_PROCESO), true)
            ? $estadoProceso
            : 'Todos';
    }

    private function normalizarProcesoAntiguo(string $procesoAntiguo): string
    {
        return in_array($procesoAntiguo, ['Si', 'No', 'Todos'], true) ? $procesoAntiguo : 'Todos';
    }

    private function denunciasActivasSinProcesoActivo(?ProcesoDisciplinario $proceso = null)
    {
        return Denuncia::with('estudiante')
            ->where('estado_registro', 'Activo')
            ->where(function ($query) use ($proceso): void {
                $query->whereDoesntHave('procesos', function ($procesoQuery): void {
                    $procesoQuery->where('estado_registro', 'Activo');
                });

                if ($proceso) {
                    $query->orWhere('id', $proceso->denuncia_id);
                }
            })
            ->orderByDesc('id')
            ->get();
    }

    private function denunciasParaFiltro()
    {
        return Denuncia::with('estudiante')
            ->orderByDesc('id')
            ->get();
    }
}
