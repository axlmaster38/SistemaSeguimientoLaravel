@extends('layouts.app')

@section('title', 'Procesos historicos | SME')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h1 class="h3 mb-1">Procesos historicos</h1><div class="text-muted">Listado historico migrado desde Django.</div></div>
    <div class="d-flex gap-2"><a href="{{ route('reportes.procesos-historicos.exportar-csv', request()->query()) }}" class="btn btn-outline-success">Exportar CSV</a><a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">Volver</a></div>
</div>

<div class="card border-0 shadow-sm mb-4"><div class="card-body">
    <form method="GET" action="{{ route('reportes.procesos-historicos') }}" class="row g-2">
        <div class="col-12 col-lg-3"><select name="estudiante_id" class="form-select"><option value="">Todos los estudiantes</option>@foreach ($estudiantesFiltro as $estudiante)<option value="{{ $estudiante->id }}" @selected((string) ($filtros['estudiante_id'] ?? '') === (string) $estudiante->id)>{{ $estudiante->codigo_estu }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}</option>@endforeach</select></div>
        <div class="col-12 col-md-2"><select name="proceso_id" class="form-select"><option value="">Todos los procesos</option>@foreach ($procesosFiltro as $proceso)<option value="{{ $proceso->id }}" @selected((string) ($filtros['proceso_id'] ?? '') === (string) $proceso->id)>#{{ $proceso->id }}</option>@endforeach</select></div>
        <div class="col-12 col-md-2"><select name="denuncia_id" class="form-select"><option value="">Todas las denuncias</option>@foreach ($denunciasFiltro as $denuncia)<option value="{{ $denuncia->id }}" @selected((string) ($filtros['denuncia_id'] ?? '') === (string) $denuncia->id)>#{{ $denuncia->id }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><select name="estado_proceso" class="form-select"><option value="">Todos los estados</option>@foreach ($estadosProceso as $estado)<option value="{{ $estado }}" @selected(($filtros['estado_proceso'] ?? '') === $estado)>{{ $estado }}</option>@endforeach</select></div>
        <div class="col-12 col-md-2"><select name="clasificacion_falta" class="form-select"><option value="">Clasificacion</option>@foreach ($clasificacionesFalta as $clasificacion)<option value="{{ $clasificacion }}" @selected(($filtros['clasificacion_falta'] ?? '') === $clasificacion)>{{ $clasificacion }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><select name="programa_id" class="form-select"><option value="">Todos los programas</option>@foreach ($programas as $programa)<option value="{{ $programa->id }}" @selected((string) ($filtros['programa_id'] ?? '') === (string) $programa->id)>{{ $programa->codigo_pro }} - {{ $programa->nombre }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><select name="centro_id" class="form-select"><option value="">Todos los centros</option>@foreach ($centros as $centro)<option value="{{ $centro->id }}" @selected((string) ($filtros['centro_id'] ?? '') === (string) $centro->id)>{{ $centro->centro }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><input type="date" name="fecha_desde" value="{{ $filtros['fecha_desde'] ?? '' }}" class="form-control"></div>
        <div class="col-12 col-md-3"><input type="date" name="fecha_hasta" value="{{ $filtros['fecha_hasta'] ?? '' }}" class="form-control"></div>
        @foreach (['sancionado' => 'Con sancion', 'tiene_decision' => 'Con decision', 'notificado_proceso' => 'Con notificacion proceso', 'notificado_sancion' => 'Con notificacion sancion', 'sin_sancion' => 'Sin sancion', 'sin_decision' => 'Sin decision', 'sin_notificado_proceso' => 'Sin notificacion proceso', 'sin_notificado_sancion' => 'Sin notificacion sancion'] as $campo => $label)
            <div class="col-12 col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="{{ $campo }}" value="1" id="{{ $campo }}" @checked(! empty($filtros[$campo]))><label class="form-check-label" for="{{ $campo }}">{{ $label }}</label></div></div>
        @endforeach
        <div class="col-12 d-flex gap-2"><button class="btn btn-outline-primary">Buscar</button><a href="{{ route('reportes.procesos-historicos') }}" class="btn btn-outline-secondary">Limpiar</a></div>
    </form>
</div></div>

<div class="card border-0 shadow-sm"><div class="card-body">
    <div class="table-responsive"><table class="table align-middle">
        <thead><tr><th>Proceso</th><th>Estudiante</th><th>Programa historico</th><th>Programa actual</th><th>Centro</th><th>Denuncia</th><th>Fecha apertura</th><th>Estado</th><th>Dias restantes</th><th>Decisiones</th><th>Sanciones</th><th>Notificaciones</th><th>Apelaciones</th><th></th></tr></thead>
        <tbody>@forelse ($procesos as $proceso)
            @php
                $estudiante = $proceso->denuncia?->estudiante;
                $reglas = $proceso->reglas_negocio ?? [];
                $colorDias = $reglas['color_dias_restantes'] ?? null;
            @endphp
            <tr>
                <td class="fw-semibold">#{{ $proceso->id }}</td>
                <td>{{ $estudiante?->codigo_estu }} - {{ $estudiante?->nombre }} {{ $estudiante?->apellido }}</td>
                <td>{{ $proceso->historicos->first()?->programa?->nombre ?? 'N/A' }}</td>
                <td>{{ $estudiante?->programa?->nombre ?? 'N/A' }}</td>
                <td>{{ $estudiante?->centro?->centro ?? 'N/A' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($proceso->denuncia?->descripcion, 60) }}</td>
                <td>{{ $proceso->fecha_apertura?->format('Y-m-d') ?? $proceso->fecha_registro?->format('Y-m-d') }}</td>
                <td>{{ $proceso->estado_proceso }}</td>
                <td style="{{ $colorDias ? 'background-color: '.$colorDias.';' : '' }}">{{ $reglas['texto_dias_restantes'] ?? 'Proceso sin notificar' }}</td>
                <td>{{ $proceso->decisiones->count() }}</td>
                <td>{{ $proceso->decisiones->flatMap->sanciones->count() }}</td>
                <td>{{ $proceso->notificaciones->count() + $proceso->decisiones->flatMap->sanciones->flatMap->notificaciones->count() }}</td>
                <td>{{ $proceso->apelaciones->count() }}</td>
                <td><a href="{{ route('reportes.procesos-historicos.show', $proceso) }}" class="btn btn-sm btn-outline-secondary">Ver</a></td>
            </tr>
        @empty<tr><td colspan="14" class="text-center text-muted py-4">No hay procesos historicos para los filtros seleccionados.</td></tr>@endforelse</tbody>
    </table></div>
    <div class="mt-3">{{ $procesos->links() }}</div>
</div></div>
@endsection
