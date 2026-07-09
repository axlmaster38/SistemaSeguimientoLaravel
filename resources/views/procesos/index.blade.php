@extends('layouts.app')

@section('title', 'Procesos disciplinarios | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Procesos disciplinarios</h1>
            <div class="text-muted">Gestion de procesos disciplinarios.</div>
        </div>
        <a href="{{ route('procesos.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('procesos.index') }}" class="row g-2 mb-3">
                <div class="col-12 col-lg-4"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar por estudiante, estado o denuncia"></div>
                <div class="col-12 col-md-4 col-lg-2">
                    <select name="estado_proceso" class="form-select">
                        <option value="Todos" @selected($estadoProceso === 'Todos')>Todos los estados</option>
                        @foreach ($estadosProceso as $estado)
                            <option value="{{ $estado }}" @selected($estadoProceso === $estado)>{{ $estado }}</option>
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
                    <select name="proceso_antiguo" class="form-select">
                        @foreach (['Todos', 'Si', 'No'] as $opcion)
                            <option value="{{ $opcion }}" @selected($procesoAntiguo === $opcion)>Antiguo: {{ $opcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-2">
                    <select name="denuncia_id" class="form-select">
                        <option value="">Todas las denuncias</option>
                        @foreach ($denuncias as $denuncia)
                            <option value="{{ $denuncia->id }}" @selected($denunciaId === $denuncia->id)>#{{ $denuncia->id }} - {{ $denuncia->estudiante?->codigo_estu }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Buscar</button>
                    <a href="{{ route('procesos.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>ID</th><th>Estudiante</th><th>Codigo</th><th>Denuncia</th><th>Fecha apertura</th><th>Estado proceso</th><th>Antiguo</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
                    <tbody>
                        @forelse ($procesos as $proceso)
                            <tr>
                                <td class="fw-semibold">{{ $proceso->id }}</td>
                                <td>{{ $proceso->denuncia?->estudiante?->nombre }} {{ $proceso->denuncia?->estudiante?->apellido }}</td>
                                <td>{{ $proceso->denuncia?->estudiante?->codigo_estu }}</td>
                                <td>#{{ $proceso->denuncia_id }}</td>
                                <td>{{ $proceso->fecha_apertura?->format('Y-m-d') ?? 'N/A' }}</td>
                                <td>{{ $proceso->estado_proceso }}</td>
                                <td><span class="badge text-bg-{{ $proceso->proceso_antiguo ? 'warning' : 'light' }}">{{ $proceso->proceso_antiguo ? 'Si' : 'No' }}</span></td>
                                <td><span class="badge text-bg-{{ $proceso->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $proceso->estado_registro }}</span></td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('procesos.show', $proceso) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye me-1"></i>Ver</a>
                                        <a href="{{ route('procesos.edit', $proceso) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a>
                                        @if (session('rol_usuario') === 'Administrador')
                                            <form method="POST" action="{{ route('procesos.destroy', $proceso) }}" class="status-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $proceso->estado_registro === 'Activo' ? 'danger' : 'success' }}"><i class="fa-solid {{ $proceso->estado_registro === 'Activo' ? 'fa-ban' : 'fa-circle-check' }} me-1"></i>{{ $proceso->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-muted py-4">No hay procesos disciplinarios registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $procesos->links() }}</div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('partials.confirm-status')
@endpush
