@extends('layouts.app')

@section('title', 'Detalle escuela | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Detalle de escuela</h1>
            <div class="text-muted">{{ $escuela->sigla }} - {{ $escuela->nombre }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('escuelas.edit', $escuela) }}" class="btn btn-primary">
                <i class="fa-solid fa-pen-to-square me-1"></i>Editar
            </a>
            <a href="{{ route('escuelas.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>Volver
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $escuela->id }}</dd>

                <dt class="col-sm-3">Sigla</dt>
                <dd class="col-sm-9">{{ $escuela->sigla }}</dd>

                <dt class="col-sm-3">Nombre</dt>
                <dd class="col-sm-9">{{ $escuela->nombre }}</dd>

                <dt class="col-sm-3">Estado del registro</dt>
                <dd class="col-sm-9">
                    <span class="badge text-bg-{{ $escuela->estado_registro === 'Activo' ? 'success' : 'secondary' }}">
                        {{ $escuela->estado_registro }}
                    </span>
                </dd>

                <dt class="col-sm-3">Programas asociados</dt>
                <dd class="col-sm-9">{{ $escuela->programas_count }}</dd>
            </dl>
        </div>
    </div>
@endsection
