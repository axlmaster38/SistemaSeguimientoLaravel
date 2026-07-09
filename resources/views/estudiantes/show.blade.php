@extends('layouts.app')

@section('title', 'Detalle estudiante | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Detalle de estudiante</h1><div class="text-muted">{{ $estudiante->codigo_estu }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}</div></div>
        <div class="d-flex gap-2"><a href="{{ route('estudiantes.edit', $estudiante) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a><a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a></div>
    </div>
    <div class="card border-0 shadow-sm"><div class="card-body"><dl class="row mb-0">
        <dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $estudiante->id }}</dd>
        <dt class="col-sm-3">Codigo</dt><dd class="col-sm-9">{{ $estudiante->codigo_estu }}</dd>
        <dt class="col-sm-3">Nombre completo</dt><dd class="col-sm-9">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</dd>
        <dt class="col-sm-3">Estado academico</dt><dd class="col-sm-9">{{ $estudiante->estado_academico }}</dd>
        <dt class="col-sm-3">Programa</dt><dd class="col-sm-9">{{ $estudiante->programa?->codigo_pro }} - {{ $estudiante->programa?->nombre }}</dd>
        <dt class="col-sm-3">Centro</dt><dd class="col-sm-9">{{ $estudiante->centro?->centro }}</dd>
        <dt class="col-sm-3">Email institucional</dt><dd class="col-sm-9">{{ $estudiante->email_institucional }}</dd>
        <dt class="col-sm-3">Email personal</dt><dd class="col-sm-9">{{ $estudiante->email_personal }}</dd>
        <dt class="col-sm-3">Email alternativo</dt><dd class="col-sm-9">{{ $estudiante->email_alternativo ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Telefono</dt><dd class="col-sm-9">{{ $estudiante->telefono ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Direccion</dt><dd class="col-sm-9">{{ $estudiante->direccion ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Estado</dt><dd class="col-sm-9"><span class="badge text-bg-{{ $estudiante->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $estudiante->estado_registro }}</span></dd>
        <dt class="col-sm-3">Denuncias</dt><dd class="col-sm-9">{{ $estudiante->denuncias_count }}</dd>
        <dt class="col-sm-3">Historicos</dt><dd class="col-sm-9">{{ $estudiante->historicos_count }}</dd>
    </dl></div></div>
@endsection
