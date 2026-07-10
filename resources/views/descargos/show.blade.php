@extends('layouts.app')

@section('title', 'Detalle descargo | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Detalle de descargo</h1><div class="text-muted">Descargo #{{ $descargo->id }}</div></div>
        <div class="d-flex gap-2"><a href="{{ route('descargos.edit', $descargo) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a><a href="{{ route('descargos.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a></div>
    </div>
    <div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0">
        <dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $descargo->id }}</dd>
        <dt class="col-sm-3">Proceso</dt><dd class="col-sm-9">#{{ $descargo->proceso_disciplinario_id }}</dd>
        <dt class="col-sm-3">Estudiante</dt><dd class="col-sm-9">{{ $descargo->procesoDisciplinario?->denuncia?->estudiante?->codigo_estu }} - {{ $descargo->procesoDisciplinario?->denuncia?->estudiante?->nombre }} {{ $descargo->procesoDisciplinario?->denuncia?->estudiante?->apellido }}</dd>
        <dt class="col-sm-3">Estado registro</dt><dd class="col-sm-9"><span class="badge text-bg-{{ $descargo->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $descargo->estado_registro }}</span></dd>
        <dt class="col-sm-3">Descripcion</dt><dd class="col-sm-9">{{ $descargo->descripcion ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Pruebas asociadas</dt><dd class="col-sm-9">{{ $descargo->pruebas_count }}</dd>
        <dt class="col-sm-3">Usuario registra</dt><dd class="col-sm-9">{{ $descargo->usuarioRegistra?->nombre }} {{ $descargo->usuarioRegistra?->apellido }}</dd>
        <dt class="col-sm-3">Usuario actualiza</dt><dd class="col-sm-9">{{ $descargo->usuarioActualiza?->nombre }} {{ $descargo->usuarioActualiza?->apellido }}</dd>
    </dl></div></div>
@endsection
