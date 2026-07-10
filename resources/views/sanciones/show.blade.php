@extends('layouts.app')
@section('title', 'Detalle sancion | SME')
@section('content')
<div class="d-flex justify-content-between mb-4"><div><h1 class="h3 mb-1">Detalle de sancion</h1><div class="text-muted">Sancion #{{ $sancion->id }}</div></div><div><a href="{{ route('sanciones.edit', $sancion) }}" class="btn btn-primary">Editar</a> <a href="{{ route('sanciones.index') }}" class="btn btn-outline-secondary">Volver</a></div></div>
<div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0">
<dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $sancion->id }}</dd><dt class="col-sm-3">Decision</dt><dd class="col-sm-9">#{{ $sancion->decision_id }} - {{ $sancion->decision?->nombre }}</dd><dt class="col-sm-3">Proceso</dt><dd class="col-sm-9">#{{ $sancion->decision?->proceso_disciplinario_id }}</dd><dt class="col-sm-3">Estudiante</dt><dd class="col-sm-9">{{ $sancion->decision?->procesoDisciplinario?->denuncia?->estudiante?->codigo_estu }} - {{ $sancion->decision?->procesoDisciplinario?->denuncia?->estudiante?->nombre }}</dd>
<dt class="col-sm-3">Tipo sancion</dt><dd class="col-sm-9">{{ $sancion->tipo_sancion }}</dd><dt class="col-sm-3">Numero periodos</dt><dd class="col-sm-9">{{ $sancion->numero_periodos }}</dd><dt class="col-sm-3">Periodo inicial</dt><dd class="col-sm-9">{{ $sancion->periodoInicialSancion?->anio }} - {{ $sancion->periodoInicialSancion?->periodo }}</dd><dt class="col-sm-3">Periodo final</dt><dd class="col-sm-9">{{ $sancion->periodoFinalSancion?->anio }} - {{ $sancion->periodoFinalSancion?->periodo }}</dd>
<dt class="col-sm-3">Estado sancion</dt><dd class="col-sm-9">{{ $sancion->estado_sancion }}</dd><dt class="col-sm-3">Estado registro</dt><dd class="col-sm-9">{{ $sancion->estado_registro }}</dd><dt class="col-sm-3">Descripcion</dt><dd class="col-sm-9">{{ $sancion->descripcion ?? 'N/A' }}</dd><dt class="col-sm-3">Notificaciones</dt><dd class="col-sm-9">{{ $sancion->notificaciones_count }}</dd>
</dl></div></div>
@endsection
