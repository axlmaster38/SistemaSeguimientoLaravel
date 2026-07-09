@extends('layouts.app')

@section('title', 'Detalle programa | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Detalle de programa</h1><div class="text-muted">{{ $programa->codigo_pro }} - {{ $programa->nombre }}</div></div>
        <div class="d-flex gap-2"><a href="{{ route('programas.edit', $programa) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a><a href="{{ route('programas.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a></div>
    </div>
    <div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0">
        <dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $programa->id }}</dd>
        <dt class="col-sm-3">Codigo</dt><dd class="col-sm-9">{{ $programa->codigo_pro }}</dd>
        <dt class="col-sm-3">Nombre</dt><dd class="col-sm-9">{{ $programa->nombre }}</dd>
        <dt class="col-sm-3">Escuela</dt><dd class="col-sm-9">{{ $programa->escuela?->sigla }} - {{ $programa->escuela?->nombre }}</dd>
        <dt class="col-sm-3">Estado</dt><dd class="col-sm-9"><span class="badge text-bg-{{ $programa->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $programa->estado_registro }}</span></dd>
        <dt class="col-sm-3">Estudiantes asociados</dt><dd class="col-sm-9">{{ $programa->estudiantes_count }}</dd>
    </dl></div></div>
@endsection
