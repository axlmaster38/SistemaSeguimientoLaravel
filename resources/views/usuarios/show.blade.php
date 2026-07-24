@extends('layouts.app')

@section('title', 'Detalle usuario | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Detalle usuario</h1>
            <div class="text-muted">{{ $usuario->usuario }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                Volver
            </a>
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-primary">
                <i class="fa-solid fa-pen-to-square me-1"></i>Editar
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Usuario</dt>
                <dd class="col-sm-9">{{ $usuario->usuario }}</dd>

                <dt class="col-sm-3">Nombre</dt>
                <dd class="col-sm-9">{{ trim($usuario->nombre . ' ' . $usuario->apellido) }}</dd>

                <dt class="col-sm-3">Correo</dt>
                <dd class="col-sm-9">{{ $usuario->email }}</dd>

                <dt class="col-sm-3">Rol</dt>
                <dd class="col-sm-9">{{ $usuario->rol }}</dd>

                <dt class="col-sm-3">Estado</dt>
                <dd class="col-sm-9">
                    <span class="badge text-bg-{{ $usuario->estado === 'Activo' ? 'success' : 'secondary' }}">
                        {{ $usuario->estado }}
                    </span>
                </dd>

                <dt class="col-sm-3">Estado registro</dt>
                <dd class="col-sm-9">
                    <span class="badge text-bg-{{ $usuario->estado_registro === 'Activo' ? 'success' : 'secondary' }}">
                        {{ $usuario->estado_registro }}
                    </span>
                </dd>

                <dt class="col-sm-3">Fecha registro</dt>
                <dd class="col-sm-9">{{ optional($usuario->fecha_registro)->format('Y-m-d H:i') }}</dd>

                <dt class="col-sm-3">Fecha actualiza</dt>
                <dd class="col-sm-9">{{ optional($usuario->fecha_actualiza)->format('Y-m-d H:i') }}</dd>
            </dl>
        </div>
    </div>
@endsection
