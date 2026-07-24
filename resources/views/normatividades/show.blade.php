@extends('layouts.app')

@section('title', 'Detalle normatividad | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Detalle normatividad</h1>
            <div class="text-muted">{{ $normatividad->no_acuerdo }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('normatividades.index') }}" class="btn btn-outline-secondary">Volver</a>
            <a href="{{ route('normatividades.edit', $normatividad) }}" class="btn btn-primary">
                <i class="fa-solid fa-pen-to-square me-1"></i>Editar
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Número de acuerdo</dt>
                <dd class="col-sm-9">{{ $normatividad->no_acuerdo }}</dd>

                <dt class="col-sm-3">Fecha norma</dt>
                <dd class="col-sm-9">{{ $normatividad->fecha_norma ? \Illuminate\Support\Carbon::parse($normatividad->fecha_norma)->format('Y-m-d') : '' }}</dd>

                <dt class="col-sm-3">Descripción</dt>
                <dd class="col-sm-9">{{ $normatividad->descripcion ?: 'Sin descripción' }}</dd>

                <dt class="col-sm-3">Artículos asociados</dt>
                <dd class="col-sm-9">{{ $normatividad->articulos_count }}</dd>

                <dt class="col-sm-3">Estado registro</dt>
                <dd class="col-sm-9">
                    <span class="badge text-bg-{{ $normatividad->estado_registro === 'Activo' ? 'success' : 'secondary' }}">
                        {{ $normatividad->estado_registro }}
                    </span>
                </dd>

                <dt class="col-sm-3">Registrado por</dt>
                <dd class="col-sm-9">{{ $normatividad->usuarioRegistra?->usuario ?: 'No registrado' }}</dd>

                <dt class="col-sm-3">Actualizado por</dt>
                <dd class="col-sm-9">{{ $normatividad->usuarioActualiza?->usuario ?: 'No registrado' }}</dd>
            </dl>
        </div>
    </div>
@endsection
