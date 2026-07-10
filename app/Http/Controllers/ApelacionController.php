<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApelacionRequest;
use App\Http\Requests\UpdateApelacionRequest;
use App\Models\Apelacion;
use App\Models\ProcesoDisciplinario;
use App\Services\ApelacionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApelacionController extends Controller
{
    private const TIPOS_APELACION = [
        'Recurso de reposición',
        'Recurso de reposición en subsidio de apelación',
        'Apelación',
    ];

    public function __construct(private readonly ApelacionService $apelacionService) {}

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->estado($request->input('estado_registro', 'Activo'));
        $tipoApelacion = $this->opcion($request->input('tipo_apelacion', 'Todos'));
        $procesoId = $request->filled('proceso_disciplinario_id') ? (int) $request->input('proceso_disciplinario_id') : null;
        $apelaciones = $this->apelacionService->listar($buscar, $estadoRegistro, $tipoApelacion, $procesoId);

        return view('apelaciones.index', $this->sharedData() + compact('apelaciones', 'buscar', 'estadoRegistro', 'tipoApelacion', 'procesoId'));
    }

    public function create(): View
    {
        return view('apelaciones.create', $this->formData(new Apelacion()));
    }

    public function store(StoreApelacionRequest $request): RedirectResponse
    {
        $this->apelacionService->crear($request->validated());

        return redirect()->route('apelaciones.index')->with('success', 'Apelación creada correctamente.');
    }

    public function show(Apelacion $apelacion): View
    {
        $apelacion->load(['procesoDisciplinario.denuncia.estudiante', 'usuarioRegistra', 'usuarioActualiza', 'pruebas']);

        return view('apelaciones.show', compact('apelacion'));
    }

    public function edit(Apelacion $apelacion): View
    {
        return view('apelaciones.edit', $this->formData($apelacion));
    }

    public function update(UpdateApelacionRequest $request, Apelacion $apelacion): RedirectResponse
    {
        $this->apelacionService->actualizar($apelacion, $request->validated());

        return redirect()->route('apelaciones.index')->with('success', 'Apelación actualizada correctamente.');
    }

    public function destroy(Apelacion $apelacion): RedirectResponse
    {
        $resultado = $this->apelacionService->alternarEstadoRegistro($apelacion);

        return redirect()->route('apelaciones.index')->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function formData(Apelacion $apelacion): array
    {
        return $this->sharedData() + [
            'apelacion' => $apelacion,
            'procesosActivos' => ProcesoDisciplinario::with('denuncia.estudiante')
                ->where('estado_registro', 'Activo')
                ->when($apelacion->proceso_disciplinario_id, fn ($q) => $q->orWhere('id', $apelacion->proceso_disciplinario_id))
                ->orderByDesc('id')
                ->get(),
        ];
    }

    private function sharedData(): array
    {
        return [
            'tiposApelacion' => self::TIPOS_APELACION,
            'procesos' => ProcesoDisciplinario::with('denuncia.estudiante')->orderByDesc('id')->get(),
        ];
    }

    private function estado(string $estado): string
    {
        return in_array($estado, ['Activo', 'Inactivo', 'Todos'], true) ? $estado : 'Activo';
    }

    private function opcion(string $valor): string
    {
        return in_array($valor, array_merge(['Todos'], self::TIPOS_APELACION), true) ? $valor : 'Todos';
    }
}
