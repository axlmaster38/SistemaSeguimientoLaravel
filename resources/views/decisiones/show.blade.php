@extends('layouts.app')
@section('title', 'Detalle decision | SME')
@section('content')
<div class="d-flex justify-content-between mb-4"><div><h1 class="h3 mb-1">Detalle de decision</h1><div class="text-muted">{{ $decision->nombre }}</div></div><div><a href="{{ route('decisiones.edit', $decision) }}" class="btn btn-primary">Editar</a> <a href="{{ route('decisiones.index') }}" class="btn btn-outline-secondary">Volver</a></div></div>
@if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
<div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0">
<dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $decision->id }}</dd><dt class="col-sm-3">Proceso</dt><dd class="col-sm-9">#{{ $decision->proceso_disciplinario_id }}</dd><dt class="col-sm-3">Estudiante</dt><dd class="col-sm-9">{{ $decision->procesoDisciplinario?->denuncia?->estudiante?->codigo_estu }} - {{ $decision->procesoDisciplinario?->denuncia?->estudiante?->nombre }} {{ $decision->procesoDisciplinario?->denuncia?->estudiante?->apellido }}</dd>
<dt class="col-sm-3">Tipo</dt><dd class="col-sm-9">{{ $decision->tipo_decision }}</dd><dt class="col-sm-3">Fecha sesion</dt><dd class="col-sm-9">{{ $decision->fecha_sesion?->format('Y-m-d') }}</dd><dt class="col-sm-3">Clasificacion</dt><dd class="col-sm-9">{{ $decision->clasificacion_falta ?? 'N/A' }}</dd><dt class="col-sm-3">Archivo</dt><dd class="col-sm-9">@if ($decision->archivo)<a href="{{ route('decisiones.archivo', $decision) }}" class="btn btn-sm btn-outline-secondary">Descargar</a>@else N/A @endif</dd>
<dt class="col-sm-3">Estado registro</dt><dd class="col-sm-9">{{ $decision->estado_registro }}</dd><dt class="col-sm-3">Resultado</dt><dd class="col-sm-9">{{ $decision->resultado ?? 'N/A' }}</dd><dt class="col-sm-3">Observaciones</dt><dd class="col-sm-9">{{ $decision->observaciones ?? 'N/A' }}</dd><dt class="col-sm-3">Sanciones</dt><dd class="col-sm-9">{{ $decision->sanciones_count }}</dd>
</dl></div></div>
@endsection
