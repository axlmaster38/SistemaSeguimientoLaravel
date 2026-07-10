@extends('layouts.app')

@section('title', 'Detalle prueba | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Detalle de prueba</h1><div class="text-muted">{{ $prueba->nombre }}</div></div>
        <div class="d-flex gap-2"><a href="{{ route('pruebas.edit', $prueba) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a><a href="{{ route('pruebas.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a></div>
    </div>
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0">
        <dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $prueba->id }}</dd>
        <dt class="col-sm-3">Nombre</dt><dd class="col-sm-9">{{ $prueba->nombre }}</dd>
        <dt class="col-sm-3">Tipo prueba</dt><dd class="col-sm-9">{{ $prueba->tipo_prueba }}</dd>
        <dt class="col-sm-3">Procedencia</dt><dd class="col-sm-9">{{ $prueba->procedencia }}</dd>
        <dt class="col-sm-3">Proceso</dt><dd class="col-sm-9">{{ $prueba->proceso_disciplinario_id ? '#'.$prueba->proceso_disciplinario_id : 'N/A' }}</dd>
        <dt class="col-sm-3">Descargo</dt><dd class="col-sm-9">{{ $prueba->descargo_id ? '#'.$prueba->descargo_id : 'N/A' }}</dd>
        <dt class="col-sm-3">Apelacion</dt><dd class="col-sm-9">{{ $prueba->apelacion_id ? '#'.$prueba->apelacion_id : 'N/A' }}</dd>
        <dt class="col-sm-3">Estudiante</dt><dd class="col-sm-9">{{ $prueba->procesoDisciplinario?->denuncia?->estudiante?->codigo_estu }} - {{ $prueba->procesoDisciplinario?->denuncia?->estudiante?->nombre }} {{ $prueba->procesoDisciplinario?->denuncia?->estudiante?->apellido }}</dd>
        <dt class="col-sm-3">Archivo</dt><dd class="col-sm-9">@if ($prueba->archivo)<a href="{{ route('pruebas.archivo', $prueba) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-download me-1"></i>Descargar</a>@else N/A @endif</dd>
        <dt class="col-sm-3">Estado registro</dt><dd class="col-sm-9"><span class="badge text-bg-{{ $prueba->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $prueba->estado_registro }}</span></dd>
        <dt class="col-sm-3">Descripcion</dt><dd class="col-sm-9">{{ $prueba->descripcion ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Usuario registra</dt><dd class="col-sm-9">{{ $prueba->usuarioRegistra?->nombre }} {{ $prueba->usuarioRegistra?->apellido }}</dd>
        <dt class="col-sm-3">Usuario actualiza</dt><dd class="col-sm-9">{{ $prueba->usuarioActualiza?->nombre }} {{ $prueba->usuarioActualiza?->apellido }}</dd>
    </dl></div></div>
@endsection
