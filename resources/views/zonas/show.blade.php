@extends('layouts.app')

@section('title', 'Detalle zona | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Detalle de zona</h1>
            <div class="text-muted">{{ $zona->nombre }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('zonas.edit', $zona) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a>
            <a href="{{ route('zonas.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $zona->id }}</dd>
                <dt class="col-sm-3">Nombre</dt><dd class="col-sm-9">{{ $zona->nombre }}</dd>
                <dt class="col-sm-3">Estado</dt><dd class="col-sm-9"><span class="badge text-bg-{{ $zona->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $zona->estado_registro }}</span></dd>
                <dt class="col-sm-3">Centros asociados</dt><dd class="col-sm-9">{{ $zona->centros_count }}</dd>
            </dl>
        </div>
    </div>
@endsection
