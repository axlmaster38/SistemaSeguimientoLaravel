@extends('layouts.app')

@section('title', 'Denuncias | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Denuncias</h1>
            <div class="text-muted">Gestion de denuncias registradas.</div>
        </div>
        <a href="{{ route('denuncias.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('denuncias.index') }}" class="row g-2 mb-3">
                <div class="col-12 col-lg-4"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar por estudiante, descripcion o justificacion"></div>
                <div class="col-12 col-md-4 col-lg-2">
                    <select name="estado_denuncia" class="form-select">
                        <option value="Todos" @selected($estadoDenuncia === 'Todos')>Todos los estados</option>
                        @foreach ($estadosDenuncia as $estado)
                            <option value="{{ $estado }}" @selected($estadoDenuncia === $estado)>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 col-lg-2">
                    <select name="estado_registro" class="form-select">
                        @foreach (['Activo', 'Inactivo', 'Todos'] as $estado)
                            <option value="{{ $estado }}" @selected($estadoRegistro === $estado)>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 col-lg-2">
                    <select name="denuncia_antigua" class="form-select">
                        @foreach (['Todos', 'Si', 'No'] as $opcion)
                            <option value="{{ $opcion }}" @selected($denunciaAntigua === $opcion)>Antigua: {{ $opcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-2">
                    <select name="estudiante_id" class="form-select">
                        <option value="">Todos los estudiantes</option>
                        @foreach ($estudiantes as $estudiante)
                            <option value="{{ $estudiante->id }}" @selected($estudianteId === $estudiante->id)>{{ $estudiante->codigo_estu }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Buscar</button>
                    <a href="{{ route('denuncias.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Estudiante</th><th>Codigo</th><th>Estado denuncia</th><th>Fecha creacion</th><th>Antigua</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
                    <tbody>
                        @forelse ($denuncias as $denuncia)
                            <tr>
                                <td>{{ $denuncia->estudiante?->nombre }} {{ $denuncia->estudiante?->apellido }}</td>
                                <td class="fw-semibold">{{ $denuncia->estudiante?->codigo_estu }}</td>
                                <td>{{ $denuncia->estado_denuncia }}</td>
                                <td>{{ $denuncia->fecha_creacion?->format('Y-m-d') ?? 'N/A' }}</td>
                                <td><span class="badge text-bg-{{ $denuncia->denuncia_antigua ? 'warning' : 'light' }}">{{ $denuncia->denuncia_antigua ? 'Si' : 'No' }}</span></td>
                                <td><span class="badge text-bg-{{ $denuncia->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $denuncia->estado_registro }}</span></td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('denuncias.show', $denuncia) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye me-1"></i>Ver</a>
                                        <a href="{{ route('denuncias.edit', $denuncia) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a>
                                        @if (session('rol_usuario') === 'Administrador')
                                            <form method="POST" action="{{ route('denuncias.destroy', $denuncia) }}" class="status-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $denuncia->estado_registro === 'Activo' ? 'danger' : 'success' }}"><i class="fa-solid {{ $denuncia->estado_registro === 'Activo' ? 'fa-ban' : 'fa-circle-check' }} me-1"></i>{{ $denuncia->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">No hay denuncias registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $denuncias->links() }}</div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('partials.confirm-status')
@endpush
