@extends('layouts.app')

@section('title', 'Antecedentes por estudiante | SME')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h1 class="h3 mb-1">Antecedentes por estudiante</h1><div class="text-muted">Consulta consolidada de antecedentes disciplinarios.</div></div>
    <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">Volver</a>
</div>

<div class="card border-0 shadow-sm mb-4"><div class="card-body">
    <form method="GET" action="{{ route('reportes.antecedentes-estudiante') }}" class="row g-2">
        <div class="col-12 col-lg-3"><select name="estudiante_id" class="form-select"><option value="">Todos los estudiantes</option>@foreach ($estudiantesFiltro as $estudiante)<option value="{{ $estudiante->id }}" @selected((string) ($filtros['estudiante_id'] ?? '') === (string) $estudiante->id)>{{ $estudiante->codigo_estu }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><input type="search" name="codigo" value="{{ $filtros['codigo'] ?? '' }}" class="form-control" placeholder="Codigo estudiante"></div>
        <div class="col-12 col-md-3"><select name="programa_id" class="form-select"><option value="">Todos los programas</option>@foreach ($programas as $programa)<option value="{{ $programa->id }}" @selected((string) ($filtros['programa_id'] ?? '') === (string) $programa->id)>{{ $programa->codigo_pro }} - {{ $programa->nombre }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><select name="centro_id" class="form-select"><option value="">Todos los centros</option>@foreach ($centros as $centro)<option value="{{ $centro->id }}" @selected((string) ($filtros['centro_id'] ?? '') === (string) $centro->id)>{{ $centro->centro }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><select name="estado_proceso" class="form-select"><option value="">Todos los estados proceso</option>@foreach ($estadosProceso as $estado)<option value="{{ $estado }}" @selected(($filtros['estado_proceso'] ?? '') === $estado)>{{ $estado }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><input type="search" name="estado_sancion" value="{{ $filtros['estado_sancion'] ?? '' }}" class="form-control" placeholder="Estado sancion"></div>
        <div class="col-12 col-md-3"><input type="date" name="fecha_desde" value="{{ $filtros['fecha_desde'] ?? '' }}" class="form-control"></div>
        <div class="col-12 col-md-3"><input type="date" name="fecha_hasta" value="{{ $filtros['fecha_hasta'] ?? '' }}" class="form-control"></div>
        <div class="col-12 d-flex gap-2"><button class="btn btn-outline-primary">Buscar</button><a href="{{ route('reportes.antecedentes-estudiante') }}" class="btn btn-outline-secondary">Limpiar</a></div>
    </form>
</div></div>

@forelse ($estudiantes as $estudiante)
    <div class="card border-0 shadow-sm mb-3"><div class="card-body">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-2 mb-3">
            <div>
                <h2 class="h5 mb-1">{{ $estudiante->codigo_estu }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}</h2>
                <div class="text-muted">{{ $estudiante->programa?->codigo_pro }} - {{ $estudiante->programa?->nombre }} | {{ $estudiante->centro?->centro }}</div>
            </div>
            <div><span class="badge text-bg-primary">Antecedentes: {{ $estudiante->total_antecedentes }}</span> <span class="badge text-bg-secondary">Historicos: {{ $estudiante->historicos_count }}</span></div>
        </div>
        <div class="table-responsive"><table class="table align-middle">
            <thead><tr><th>Denuncia</th><th>Proceso</th><th>Estado proceso</th><th>Decisiones</th><th>Sanciones</th><th>Notificaciones</th><th>Apelaciones</th><th>Historico programas</th></tr></thead>
            <tbody>
            @foreach ($estudiante->denuncias as $denuncia)
                @forelse ($denuncia->procesos as $proceso)
                    <tr>
                        <td>#{{ $denuncia->id }}<div class="small text-muted">{{ \Illuminate\Support\Str::limit($denuncia->descripcion, 80) }}</div></td>
                        <td>#{{ $proceso->id }}</td>
                        <td>{{ $proceso->estado_proceso }}</td>
                        <td>{{ $proceso->decisiones->count() }}</td>
                        <td>{{ $proceso->decisiones->flatMap->sanciones->count() }}</td>
                        <td>{{ $proceso->notificaciones->count() + $proceso->decisiones->flatMap->sanciones->flatMap->notificaciones->count() }}</td>
                        <td>{{ $proceso->apelaciones->count() }}</td>
                        <td>{{ $estudiante->historicos->pluck('programa.nombre')->filter()->unique()->implode(', ') ?: 'N/A' }}</td>
                    </tr>
                @empty
                    <tr><td>#{{ $denuncia->id }}</td><td colspan="7" class="text-muted">Denuncia sin proceso disciplinario.</td></tr>
                @endforelse
            @endforeach
            </tbody>
        </table></div>
    </div></div>
@empty
    <div class="alert alert-info">No hay antecedentes para los filtros seleccionados.</div>
@endforelse

<div class="mt-3">{{ $estudiantes->links() }}</div>
@endsection
