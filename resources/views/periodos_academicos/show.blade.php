@extends('layouts.app')

@section('title', 'Detalle periodo academico | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Detalle de periodo academico</h1><div class="text-muted">{{ $periodoAcademico->periodo }} - {{ $periodoAcademico->anio }}</div></div>
        <div class="d-flex gap-2"><a href="{{ route('periodos-academicos.edit', $periodoAcademico) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a><a href="{{ route('periodos-academicos.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a></div>
    </div>
    <div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0">
        <dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $periodoAcademico->id }}</dd>
        <dt class="col-sm-3">Codigo</dt><dd class="col-sm-9">{{ $periodoAcademico->codigo ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Periodo</dt><dd class="col-sm-9">{{ $periodoAcademico->periodo }}</dd>
        <dt class="col-sm-3">Anio</dt><dd class="col-sm-9">{{ $periodoAcademico->anio }}</dd>
        <dt class="col-sm-3">Fecha inicio</dt><dd class="col-sm-9">{{ $periodoAcademico->fecha_inicio?->format('Y-m-d') ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Fecha fin</dt><dd class="col-sm-9">{{ $periodoAcademico->fecha_fin?->format('Y-m-d') ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Estado</dt><dd class="col-sm-9"><span class="badge text-bg-{{ $periodoAcademico->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $periodoAcademico->estado_registro }}</span></dd>
        <dt class="col-sm-3">Sanciones iniciales</dt><dd class="col-sm-9">{{ $periodoAcademico->sanciones_como_periodo_inicial_count }}</dd>
        <dt class="col-sm-3">Sanciones finales</dt><dd class="col-sm-9">{{ $periodoAcademico->sanciones_como_periodo_final_count }}</dd>
    </dl></div></div>
@endsection
