@extends('layouts.app')

@section('title', 'Programas | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Programas</h1>
            <div class="text-muted">Gestion de programas academicos.</div>
        </div>
        <a href="{{ route('programas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('programas.index') }}" class="row g-2 mb-3">
                <div class="col-12 col-md"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar por codigo, nombre o escuela"></div>
                <div class="col-12 col-md-3">
                    <select name="estado_registro" class="form-select">
                        @foreach (['Activo', 'Inactivo', 'Todos'] as $estado)
                            <option value="{{ $estado }}" @selected($estadoRegistro === $estado)>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Buscar</button>
                    <a href="{{ route('programas.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Codigo</th><th>Nombre</th><th>Escuela</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
                    <tbody>
                        @forelse ($programas as $programa)
                            <tr>
                                <td class="fw-semibold">{{ $programa->codigo_pro }}</td>
                                <td>{{ $programa->nombre }}</td>
                                <td>{{ $programa->escuela?->sigla }} - {{ $programa->escuela?->nombre }}</td>
                                <td><span class="badge text-bg-{{ $programa->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $programa->estado_registro }}</span></td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('programas.show', $programa) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye me-1"></i>Ver</a>
                                        <a href="{{ route('programas.edit', $programa) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a>
                                        @if (session('rol_usuario') === 'Administrador')
                                            <form method="POST" action="{{ route('programas.destroy', $programa) }}" class="status-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $programa->estado_registro === 'Activo' ? 'danger' : 'success' }}"><i class="fa-solid {{ $programa->estado_registro === 'Activo' ? 'fa-ban' : 'fa-circle-check' }} me-1"></i>{{ $programa->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No hay programas registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $programas->links() }}</div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('partials.confirm-status')
@endpush
