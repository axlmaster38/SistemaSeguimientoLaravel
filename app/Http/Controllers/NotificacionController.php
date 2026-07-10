<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificacionRequest;
use App\Http\Requests\UpdateNotificacionRequest;
use App\Models\Notificacion;
use App\Models\ProcesoDisciplinario;
use App\Models\Sancion;
use App\Services\NotificacionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NotificacionController extends Controller
{
    private const TIPOS_NOTIFICACION = ['Sancion', 'Proceso'];
    private const INSTANCIAS = ['Primera Notificación', 'Segunda Notificación'];

    public function __construct(private readonly NotificacionService $notificacionService) {}

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->estado($request->input('estado_registro', 'Activo'));
        $tipoNotificacion = $this->opcion($request->input('tipo_notificacion', 'Todos'), self::TIPOS_NOTIFICACION);
        $instancia = $this->opcion($request->input('instancia', 'Todos'), self::INSTANCIAS);
        $procesoId = $request->filled('proceso_disciplinario_id') ? (int) $request->input('proceso_disciplinario_id') : null;
        $sancionId = $request->filled('sancion_id') ? (int) $request->input('sancion_id') : null;
        $notificaciones = $this->notificacionService->listar($buscar, $estadoRegistro, $tipoNotificacion, $instancia, $procesoId, $sancionId);

        return view('notificaciones.index', $this->sharedData() + compact('notificaciones', 'buscar', 'estadoRegistro', 'tipoNotificacion', 'instancia', 'procesoId', 'sancionId'));
    }

    public function create(): View
    {
        return view('notificaciones.create', $this->formData(new Notificacion()));
    }

    public function store(StoreNotificacionRequest $request): RedirectResponse
    {
        $this->notificacionService->crear($request->validated(), $request->file('archivo'));

        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
    }

    public function show(Notificacion $notificacion): View
    {
        $notificacion->load(['procesoDisciplinario.denuncia.estudiante', 'sancion.decision.procesoDisciplinario.denuncia.estudiante', 'usuarioRegistra', 'usuarioActualiza']);

        return view('notificaciones.show', compact('notificacion'));
    }

    public function edit(Notificacion $notificacion): View
    {
        return view('notificaciones.edit', $this->formData($notificacion));
    }

    public function update(UpdateNotificacionRequest $request, Notificacion $notificacion): RedirectResponse
    {
        $this->notificacionService->actualizar($notificacion, $request->validated(), $request->file('archivo'));

        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada correctamente.');
    }

    public function destroy(Notificacion $notificacion): RedirectResponse
    {
        $resultado = $this->notificacionService->alternarEstadoRegistro($notificacion);

        return redirect()->route('notificaciones.index')->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    public function descargarArchivo(Notificacion $notificacion): StreamedResponse|RedirectResponse
    {
        if (! $notificacion->archivo || ! Storage::disk('public')->exists($notificacion->archivo)) {
            return redirect()->route('notificaciones.show', $notificacion)->with('error', 'El archivo no está disponible.');
        }

        return Storage::disk('public')->download($notificacion->archivo);
    }

    private function formData(Notificacion $notificacion): array
    {
        return $this->sharedData() + [
            'notificacion' => $notificacion,
            'procesosActivos' => ProcesoDisciplinario::with('denuncia.estudiante')
                ->where('estado_registro', 'Activo')
                ->when($notificacion->proceso_disciplinario_id, fn ($q) => $q->orWhere('id', $notificacion->proceso_disciplinario_id))
                ->orderByDesc('id')
                ->get(),
            'sancionesActivas' => Sancion::with('decision.procesoDisciplinario.denuncia.estudiante')
                ->where('estado_registro', 'Activo')
                ->when($notificacion->sancion_id, fn ($q) => $q->orWhere('id', $notificacion->sancion_id))
                ->orderByDesc('id')
                ->get(),
        ];
    }

    private function sharedData(): array
    {
        return [
            'tiposNotificacion' => self::TIPOS_NOTIFICACION,
            'instancias' => self::INSTANCIAS,
            'procesos' => ProcesoDisciplinario::with('denuncia.estudiante')->orderByDesc('id')->get(),
            'sanciones' => Sancion::with('decision.procesoDisciplinario.denuncia.estudiante')->orderByDesc('id')->get(),
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
