@extends('layouts.app')

@section('title', 'Detalle denuncia | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Detalle de denuncia</h1><div class="text-muted">{{ $denuncia->estudiante?->codigo_estu }} - {{ $denuncia->estado_denuncia }}</div></div>
        <div class="d-flex gap-2"><a href="{{ route('denuncias.edit', $denuncia) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a><a href="{{ route('denuncias.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a></div>
    </div>
    <div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0">
        <dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $denuncia->id }}</dd>
        <dt class="col-sm-3">Estudiante</dt><dd class="col-sm-9">{{ $denuncia->estudiante?->codigo_estu }} - {{ $denuncia->estudiante?->nombre }} {{ $denuncia->estudiante?->apellido }}</dd>
        <dt class="col-sm-3">Fecha creacion</dt><dd class="col-sm-9">{{ $denuncia->fecha_creacion?->format('Y-m-d') ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Estado denuncia</dt><dd class="col-sm-9">{{ $denuncia->estado_denuncia }}</dd>
        <dt class="col-sm-3">Denuncia antigua</dt><dd class="col-sm-9">{{ $denuncia->denuncia_antigua ? 'Si' : 'No' }}</dd>
        <dt class="col-sm-3">Estado registro</dt><dd class="col-sm-9"><span class="badge text-bg-{{ $denuncia->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $denuncia->estado_registro }}</span></dd>
        <dt class="col-sm-3">Descripcion</dt><dd class="col-sm-9">{{ $denuncia->descripcion ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Justificacion</dt><dd class="col-sm-9">{{ $denuncia->justificacion ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Usuario registra/evalua</dt><dd class="col-sm-9">{{ $denuncia->usuarioRegistraEvalua?->nombre }} {{ $denuncia->usuarioRegistraEvalua?->apellido }}</dd>
        <dt class="col-sm-3">Usuario actualiza</dt><dd class="col-sm-9">{{ $denuncia->usuarioActualiza?->nombre }} {{ $denuncia->usuarioActualiza?->apellido }}</dd>
        <dt class="col-sm-3">Procesos asociados</dt><dd class="col-sm-9">{{ $denuncia->procesos_count }}</dd>
    </dl></div></div>
@endsection
