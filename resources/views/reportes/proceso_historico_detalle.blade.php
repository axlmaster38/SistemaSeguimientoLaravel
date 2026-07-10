@extends('layouts.app')

@section('title', 'Detalle historico proceso | SME')

@section('content')
@php $estudiante = $proceso->denuncia?->estudiante; @endphp
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h1 class="h3 mb-1">Detalle historico del proceso #{{ $proceso->id }}</h1><div class="text-muted">{{ $estudiante?->codigo_estu }} - {{ $estudiante?->nombre }} {{ $estudiante?->apellido }}</div></div>
    <a href="{{ route('reportes.procesos-historicos') }}" class="btn btn-outline-secondary">Volver</a>
</div>

<div class="card border-0 shadow-sm mb-4"><div class="card-body"><dl class="row mb-0">
    <dt class="col-sm-3">Estado</dt><dd class="col-sm-9">{{ $proceso->estado_proceso }}</dd>
    <dt class="col-sm-3">Dias restantes</dt><dd class="col-sm-9">{{ $proceso->reglas_negocio['texto_dias_restantes'] ?? 'Proceso sin notificar' }}</dd>
    <dt class="col-sm-3">Programa historico</dt><dd class="col-sm-9">{{ $proceso->historicos->first()?->programa?->nombre ?? 'N/A' }}</dd>
    <dt class="col-sm-3">Programa actual</dt><dd class="col-sm-9">{{ $estudiante?->programa?->nombre ?? 'N/A' }}</dd>
    <dt class="col-sm-3">Centro</dt><dd class="col-sm-9">{{ $estudiante?->centro?->centro }} | {{ $estudiante?->centro?->zona?->nombre }}</dd>
    <dt class="col-sm-3">Denuncia</dt><dd class="col-sm-9">{{ $proceso->denuncia?->descripcion ?? 'N/A' }}</dd>
</dl></div></div>

@foreach ([
    'Tipologias' => $proceso->tipologiasFalta->pluck('descripcion')->filter(),
    'Articulos' => $proceso->articulos->map(fn ($a) => $a->no_articulo.' - '.$a->descripcion),
    'Descargos' => $proceso->descargos->pluck('descripcion')->filter(),
    'Apelaciones' => $proceso->apelaciones->pluck('motivo')->filter(),
] as $titulo => $items)
    <div class="card border-0 shadow-sm mb-3"><div class="card-body"><h2 class="h5">{{ $titulo }}</h2><ul class="mb-0">@forelse ($items as $item)<li>{{ $item }}</li>@empty<li class="text-muted">Sin registros.</li>@endforelse</ul></div></div>
@endforeach

<div class="card border-0 shadow-sm mb-3"><div class="card-body"><h2 class="h5">Decisiones y sanciones</h2>
    @forelse ($proceso->decisiones as $decision)
        <div class="border rounded p-3 mb-3"><div class="fw-semibold">{{ $decision->tipo_decision }} - {{ $decision->clasificacion_falta }}</div><div>{{ $decision->resultado }}</div>
            <ul class="mt-2 mb-0">@forelse ($decision->sanciones as $sancion)<li>{{ $sancion->tipo_sancion }} - {{ $sancion->estado_sancion }} - {{ $sancion->numero_periodos }} periodos</li>@empty<li class="text-muted">Sin sanciones.</li>@endforelse</ul>
        </div>
    @empty
        <div class="text-muted">Proceso sin decisiones.</div>
    @endforelse
</div></div>

<div class="card border-0 shadow-sm"><div class="card-body"><h2 class="h5">Notificaciones y pruebas</h2>
    <div class="row">
        <div class="col-12 col-lg-6"><h3 class="h6">Notificaciones</h3><ul>@forelse ($proceso->notificaciones as $notificacion)<li>{{ $notificacion->tipo_notificacion }} - {{ $notificacion->instancia }} - {{ $notificacion->fecha_registro?->format('Y-m-d') }}</li>@empty<li class="text-muted">Sin notificaciones de proceso.</li>@endforelse</ul></div>
        <div class="col-12 col-lg-6"><h3 class="h6">Pruebas</h3><ul>@forelse ($proceso->pruebas as $prueba)<li>{{ $prueba->procedencia }} - {{ $prueba->tipo_prueba }}</li>@empty<li class="text-muted">Sin pruebas.</li>@endforelse</ul></div>
    </div>
</div></div>
@endsection
