<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDecisionRequest;
use App\Http\Requests\UpdateDecisionRequest;
use App\Models\Decision;
use App\Models\ProcesoDisciplinario;
use App\Services\DecisionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DecisionController extends Controller
{
    private const TIPOS_DECISION = ['Apertura de proceso disciplinario', 'Primera Instancia', 'Segunda Instancia'];
    private const CLASIFICACIONES_FALTA = ['Leve', 'Grave', 'Gravisima'];

    public function __construct(private readonly DecisionService $decisionService) {}

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->estado($request->input('estado_registro', 'Activo'));
        $tipoDecision = $this->opcion($request->input('tipo_decision', 'Todos'), self::TIPOS_DECISION);
        $clasificacionFalta = $this->opcion($request->input('clasificacion_falta', 'Todos'), self::CLASIFICACIONES_FALTA);
        $procesoId = $request->filled('proceso_disciplinario_id') ? (int) $request->input('proceso_disciplinario_id') : null;
        $decisiones = $this->decisionService->listar($buscar, $estadoRegistro, $tipoDecision, $clasificacionFalta, $procesoId);
        $procesos = ProcesoDisciplinario::with('denuncia.estudiante')->orderByDesc('id')->get();

        return view('decisiones.index', compact('decisiones', 'buscar', 'estadoRegistro', 'tipoDecision', 'clasificacionFalta', 'procesoId', 'procesos') + [
            'tiposDecision' => self::TIPOS_DECISION,
            'clasificacionesFalta' => self::CLASIFICACIONES_FALTA,
        ]);
    }

    public function create(): View
    {
        return view('decisiones.create', $this->formData(new Decision()));
    }

    public function store(StoreDecisionRequest $request): RedirectResponse
    {
        $this->decisionService->crear($request->validated(), $request->file('archivo'));
        return redirect()->route('decisiones.index')->with('success', 'Decision creada correctamente.');
    }

    public function show(Decision $decision): View
    {
        $decision->load(['procesoDisciplinario.denuncia.estudiante', 'usuarioRegistra', 'usuarioActualiza'])->loadCount('sanciones');
        return view('decisiones.show', compact('decision'));
    }

    public function edit(Decision $decision): View
    {
        return view('decisiones.edit', $this->formData($decision));
    }

    public function update(UpdateDecisionRequest $request, Decision $decision): RedirectResponse
    {
        $this->decisionService->actualizar($decision, $request->validated(), $request->file('archivo'));
        return redirect()->route('decisiones.index')->with('success', 'Decision actualizada correctamente.');
    }

    public function destroy(Decision $decision): RedirectResponse
    {
        $resultado = $this->decisionService->alternarEstadoRegistro($decision);
        return redirect()->route('decisiones.index')->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    public function descargarArchivo(Decision $decision): StreamedResponse|RedirectResponse
    {
        if (! $decision->archivo || ! Storage::disk('public')->exists($decision->archivo)) {
            return redirect()->route('decisiones.show', $decision)->with('error', 'El archivo no está disponible.');
        }
        return Storage::disk('public')->download($decision->archivo);
    }

    private function formData(Decision $decision): array
    {
        return [
            'decision' => $decision,
            'procesos' => ProcesoDisciplinario::with('denuncia.estudiante')
                ->where('estado_registro', 'Activo')
                ->orWhere('id', $decision->proceso_disciplinario_id)
                ->orderByDesc('id')
                ->get(),
            'tiposDecision' => self::TIPOS_DECISION,
            'clasificacionesFalta' => self::CLASIFICACIONES_FALTA,
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
