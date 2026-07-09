@extends('layouts.app')

@section('title', 'Estudiantes | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Estudiantes</h1>
            <div class="text-muted">Gestion de estudiantes.</div>
        </div>
        <a href="{{ route('estudiantes.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('estudiantes.index') }}" class="row g-2 mb-3">
                <div class="col-12 col-lg"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar por codigo, nombre, email o programa"></div>
                <div class="col-12 col-md-3 col-lg-2">
                    <select name="estado_registro" class="form-select">
                        @foreach (['Activo', 'Inactivo', 'Todos'] as $estado)
                            <option value="{{ $estado }}" @selected($estadoRegistro === $estado)>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3 col-lg-2">
                    <select name="estado_academico" class="form-select">
                        <option value="Todos" @selected($estadoAcademico === 'Todos')>Todos</option>
                        @foreach ($estadosAcademicos as $estado)
                            <option value="{{ $estado }}" @selected($estadoAcademico === $estado)>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Buscar</button>
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Codigo</th><th>Nombre completo</th><th>Programa</th><th>Centro</th><th>Estado academico</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
                    <tbody>
                        @forelse ($estudiantes as $estudiante)
                            <tr>
                                <td class="fw-semibold">{{ $estudiante->codigo_estu }}</td>
                                <td>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</td>
                                <td>{{ $estudiante->programa?->nombre }}</td>
                                <td>{{ $estudiante->centro?->centro }}</td>
                                <td>{{ $estudiante->estado_academico }}</td>
                                <td><span class="badge text-bg-{{ $estudiante->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $estudiante->estado_registro }}</span></td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('estudiantes.show', $estudiante) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye me-1"></i>Ver</a>
                                        <a href="{{ route('estudiantes.edit', $estudiante) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a>
                                        @if (session('rol_usuario') === 'Administrador')
                                            <form method="POST" action="{{ route('estudiantes.destroy', $estudiante) }}" class="status-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $estudiante->estado_registro === 'Activo' ? 'danger' : 'success' }}"><i class="fa-solid {{ $estudiante->estado_registro === 'Activo' ? 'fa-ban' : 'fa-circle-check' }} me-1"></i>{{ $estudiante->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">No hay estudiantes registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $estudiantes->links() }}</div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('partials.confirm-status')
@endpush
