@extends('layouts.app')

@section('title', 'Detalle artículo | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Detalle artículo</h1>
            <div class="text-muted">{{ $articulo->no_articulo }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('articulos.index') }}" class="btn btn-outline-secondary">Volver</a>
            <a href="{{ route('articulos.edit', $articulo) }}" class="btn btn-primary">
                <i class="fa-solid fa-pen-to-square me-1"></i>Editar
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Número de artículo</dt>
                <dd class="col-sm-9">{{ $articulo->no_articulo }}</dd>

                <dt class="col-sm-3">Capítulo</dt>
                <dd class="col-sm-9">{{ $articulo->capitulo }}</dd>

                <dt class="col-sm-3">Normatividad</dt>
                <dd class="col-sm-9">{{ $articulo->normatividad?->no_acuerdo }}</dd>

                <dt class="col-sm-3">Descripción</dt>
                <dd class="col-sm-9">{{ $articulo->descripcion ?: 'Sin descripción' }}</dd>

                <dt class="col-sm-3">Literal</dt>
                <dd class="col-sm-9">{{ $articulo->literal ?: 'Sin literal' }}</dd>

                <dt class="col-sm-3">Procesos asociados</dt>
                <dd class="col-sm-9">{{ $articulo->procesos_disciplinarios_count }}</dd>

                <dt class="col-sm-3">Estado registro</dt>
                <dd class="col-sm-9">
                    <span class="badge text-bg-{{ $articulo->estado_registro === 'Activo' ? 'success' : 'secondary' }}">
                        {{ $articulo->estado_registro }}
                    </span>
                </dd>

                <dt class="col-sm-3">Registrado por</dt>
                <dd class="col-sm-9">{{ $articulo->usuarioRegistra?->usuario ?: 'No registrado' }}</dd>

                <dt class="col-sm-3">Actualizado por</dt>
                <dd class="col-sm-9">{{ $articulo->usuarioActualiza?->usuario ?: 'No registrado' }}</dd>
            </dl>
        </div>
    </div>
@endsection
