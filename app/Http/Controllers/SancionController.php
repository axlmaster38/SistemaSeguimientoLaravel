<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSancionRequest;
use App\Http\Requests\UpdateSancionRequest;
use App\Models\Decision;
use App\Models\PeriodoAcademico;
use App\Models\Sancion;
use App\Services\SancionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SancionController extends Controller
{
    private const TIPOS_SANCION = ['Primera Instancia', 'Segunda Instancia'];
    private const ESTADOS_SANCION = ['En proceso', 'Finalizada'];

    public function __construct(private readonly SancionService $sancionService) {}

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->estado($request->input('estado_registro', 'Activo'));
        $tipoSancion = $this->opcion($request->input('tipo_sancion', 'Todos'), self::TIPOS_SANCION);
        $estadoSancion = $this->opcion($request->input('estado_sancion', 'Todos'), self::ESTADOS_SANCION);
        $periodoInicialId = $request->filled('periodo_inicial_sancion_id') ? (int) $request->input('periodo_inicial_sancion_id') : null;
        $periodoFinalId = $request->filled('periodo_final_sancion_id') ? (int) $request->input('periodo_final_sancion_id') : null;
        $decisionId = $request->filled('decision_id') ? (int) $request->input('decision_id') : null;
        $sanciones = $this->sancionService->listar($buscar, $estadoRegistro, $tipoSancion, $estadoSancion, $periodoInicialId, $periodoFinalId, $decisionId);

        return view('sanciones.index', $this->sharedData() + compact('sanciones', 'buscar', 'estadoRegistro', 'tipoSancion', 'estadoSancion', 'periodoInicialId', 'periodoFinalId', 'decisionId'));
    }

    public function create(): View
    {
        return view('sanciones.create', $this->formData(new Sancion()));
    }

    public function store(StoreSancionRequest $request): RedirectResponse
    {
        $this->sancionService->crear($request->validated());
        return redirect()->route('sanciones.index')->with('success', 'Sancion creada correctamente.');
    }

    public function show(Sancion $sancion): View
    {
        $sancion->load(['decision.procesoDisciplinario.denuncia.estudiante', 'periodoInicialSancion', 'periodoFinalSancion', 'usuarioRegistra', 'usuarioActualiza'])->loadCount('notificaciones');
        return view('sanciones.show', compact('sancion'));
    }

    public function edit(Sancion $sancion): View
    {
        return view('sanciones.edit', $this->formData($sancion));
    }

    public function update(UpdateSancionRequest $request, Sancion $sancion): RedirectResponse
    {
        $this->sancionService->actualizar($sancion, $request->validated());
        return redirect()->route('sanciones.index')->with('success', 'Sancion actualizada correctamente.');
    }

    public function destroy(Sancion $sancion): RedirectResponse
    {
        $resultado = $this->sancionService->alternarEstadoRegistro($sancion);
        return redirect()->route('sanciones.index')->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function formData(Sancion $sancion): array
    {
        return $this->sharedData() + [
            'sancion' => $sancion,
            'decisionesActivas' => Decision::with('procesoDisciplinario.denuncia.estudiante')
                ->where('estado_registro', 'Activo')
                ->orWhere('id', $sancion->decision_id)
                ->orderByDesc('id')
                ->get(),
        ];
    }

    private function sharedData(): array
    {
        return [
            'tiposSancion' => self::TIPOS_SANCION,
            'estadosSancion' => self::ESTADOS_SANCION,
            'periodos' => PeriodoAcademico::where('estado_registro', 'Activo')->orderBy('anio')->orderBy('periodo')->get(),
            'decisiones' => Decision::with('procesoDisciplinario.denuncia.estudiante')->orderByDesc('id')->get(),
        ];
    }

    private function estado(string $estado): string
    {
        return in_array($estado, ['Activo', 'Inactivo', 'Todos'], true) ? $estado : 'Activo';
    }

    private function opcion(string $valor, array $opciones): string
    {
        return in_array($valor, array_merge(['Todos'], $opciones), true) ? $valor : 'Todos';
    }
}
