<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDenunciaRequest;
use App\Http\Requests\UpdateDenunciaRequest;
use App\Models\Denuncia;
use App\Models\Estudiante;
use App\Services\DenunciaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DenunciaController extends Controller
{
    private const ESTADOS_DENUNCIA = ['Recibida', 'En evaluación', 'Admitida', 'Rechazada', 'Archivada'];

    public function __construct(private readonly DenunciaService $denunciaService)
    {
    }

    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estadoRegistro = $this->normalizarEstado((string) $request->input('estado_registro', 'Activo'));
        $estadoDenuncia = $this->normalizarEstadoDenuncia((string) $request->input('estado_denuncia', 'Todos'));
        $denunciaAntigua = $this->normalizarDenunciaAntigua((string) $request->input('denuncia_antigua', 'Todos'));
        $estudianteId = $request->filled('estudiante_id') ? (int) $request->input('estudiante_id') : null;
        $denuncias = $this->denunciaService->listar($buscar, $estadoRegistro, $estadoDenuncia, $denunciaAntigua, $estudianteId);
        $estudiantes = $this->estudiantesParaFiltro();
        $estadosDenuncia = self::ESTADOS_DENUNCIA;

        return view('denuncias.index', compact(
            'denuncias',
            'buscar',
            'estadoRegistro',
            'estadoDenuncia',
            'denunciaAntigua',
            'estudianteId',
            'estudiantes',
            'estadosDenuncia'
        ));
    }

    public function create(): View
    {
        return view('denuncias.create', [
            'denuncia' => new Denuncia(['estado_denuncia' => 'Recibida']),
            'estudiantes' => $this->estudiantesActivos(),
            'estadosDenuncia' => self::ESTADOS_DENUNCIA,
        ]);
    }

    public function store(StoreDenunciaRequest $request): RedirectResponse
    {
        $this->denunciaService->crear($request->validated());

        return redirect()->route('denuncias.index')->with('success', 'Denuncia creada correctamente.');
    }

    public function show(Denuncia $denuncia): View
    {
        $denuncia->load(['estudiante', 'usuarioRegistraEvalua', 'usuarioActualiza'])->loadCount('procesos');

        return view('denuncias.show', compact('denuncia'));
    }

    public function edit(Denuncia $denuncia): View
    {
        return view('denuncias.edit', [
            'denuncia' => $denuncia,
            'estudiantes' => Estudiante::where('estado_registro', 'Activo')
                ->orWhere('id', $denuncia->estudiante_id)
                ->orderBy('apellido')
                ->orderBy('nombre')
                ->get(),
            'estadosDenuncia' => self::ESTADOS_DENUNCIA,
        ]);
    }

    public function update(UpdateDenunciaRequest $request, Denuncia $denuncia): RedirectResponse
    {
        $this->denunciaService->actualizar($denuncia, $request->validated());

        return redirect()->route('denuncias.index')->with('success', 'Denuncia actualizada correctamente.');
    }

    public function destroy(Denuncia $denuncia): RedirectResponse
    {
        $resultado = $this->denunciaService->alternarEstadoRegistro($denuncia);

        return redirect()
            ->route('denuncias.index')
            ->with($resultado['ok'] ? 'success' : 'error', $resultado['message']);
    }

    private function normalizarEstado(string $estadoRegistro): string
    {
        return in_array($estadoRegistro, ['Activo', 'Inactivo', 'Todos'], true) ? $estadoRegistro : 'Activo';
    }

    private function normalizarEstadoDenuncia(string $estadoDenuncia): string
    {
        return in_array($estadoDenuncia, array_merge(['Todos'], self::ESTADOS_DENUNCIA), true)
            ? $estadoDenuncia
            : 'Todos';
    }

    private function normalizarDenunciaAntigua(string $denunciaAntigua): string
    {
        return in_array($denunciaAntigua, ['Si', 'No', 'Todos'], true) ? $denunciaAntigua : 'Todos';
    }

    private function estudiantesActivos()
    {
        return Estudiante::where('estado_registro', 'Activo')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();
    }

    private function estudiantesParaFiltro()
    {
        return Estudiante::orderBy('apellido')
            ->orderBy('nombre')
            ->get();
    }
}
