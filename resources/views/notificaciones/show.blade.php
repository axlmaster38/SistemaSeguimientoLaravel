@extends('layouts.app')
@section('title', 'Detalle notificacion | SME')
@section('content')
@php
    $proceso = $notificacion->procesoDisciplinario ?: $notificacion->sancion?->decision?->procesoDisciplinario;
    $estudiante = $proceso?->denuncia?->estudiante;
@endphp
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4"><div><h1 class="h3 mb-1">Detalle de notificacion</h1><div class="text-muted">{{ $notificacion->nombre }}</div></div><div><a href="{{ route('notificaciones.edit', $notificacion) }}" class="btn btn-primary">Editar</a> <a href="{{ route('notificaciones.index') }}" class="btn btn-outline-secondary">Volver</a></div></div>
@if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
<div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0">
<dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $notificacion->id }}</dd><dt class="col-sm-3">Nombre</dt><dd class="col-sm-9">{{ $notificacion->nombre }}</dd><dt class="col-sm-3">Tipo</dt><dd class="col-sm-9">{{ $notificacion->tipo_notificacion }}</dd><dt class="col-sm-3">Instancia</dt><dd class="col-sm-9">{{ $notificacion->instancia }}</dd>
<dt class="col-sm-3">Proceso</dt><dd class="col-sm-9">{{ $proceso ? '#'.$proceso->id : 'N/A' }}</dd><dt class="col-sm-3">Sancion</dt><dd class="col-sm-9">{{ $notificacion->sancion_id ? '#'.$notificacion->sancion_id : 'N/A' }}</dd><dt class="col-sm-3">Estudiante</dt><dd class="col-sm-9">{{ $estudiante?->codigo_estu }} - {{ $estudiante?->nombre }} {{ $estudiante?->apellido }}</dd>
<dt class="col-sm-3">Segunda notificacion</dt><dd class="col-sm-9">{{ $notificacion->fecha_2da_notificacion?->format('Y-m-d H:i') ?? 'N/A' }}</dd><dt class="col-sm-3">Archivo</dt><dd class="col-sm-9">@if ($notificacion->archivo)<a href="{{ route('notificaciones.archivo', $notificacion) }}" class="btn btn-sm btn-outline-secondary">Descargar</a>@else N/A @endif</dd><dt class="col-sm-3">Estado registro</dt><dd class="col-sm-9">{{ $notificacion->estado_registro }}</dd>
<dt class="col-sm-3">Descripcion</dt><dd class="col-sm-9">{{ $notificacion->descripcion }}</dd><dt class="col-sm-3">Usuario registra</dt><dd class="col-sm-9">{{ $notificacion->usuarioRegistra?->nombre }} {{ $notificacion->usuarioRegistra?->apellido }}</dd><dt class="col-sm-3">Usuario actualiza</dt><dd class="col-sm-9">{{ $notificacion->usuarioActualiza?->nombre }} {{ $notificacion->usuarioActualiza?->apellido }}</dd>
</dl></div></div>
@endsection
