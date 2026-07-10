@extends('layouts.app')

@section('title', 'Descargos | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Descargos</h1><div class="text-muted">Gestion de descargos por proceso disciplinario.</div></div>
        <a href="{{ route('descargos.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="GET" action="{{ route('descargos.index') }}" class="row g-2 mb-3">
            <div class="col-12 col-lg"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar por estudiante, descripcion o ID proceso"></div>
            <div class="col-12 col-md-3">
                <select name="estado_registro" class="form-select">
                    @foreach (['Activo', 'Inactivo', 'Todos'] as $estado)
                        <option value="{{ $estado }}" @selected($estadoRegistro === $estado)>{{ $estado }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <select name="proceso_disciplinario_id" class="form-select">
                    <option value="">Todos los procesos</option>
                    @foreach ($procesos as $proceso)
                        <option value="{{ $proceso->id }}" @selected($procesoId === $proceso->id)>#{{ $proceso->id }} - {{ $proceso->denuncia?->estudiante?->codigo_estu }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-auto d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Buscar</button>
                <a href="{{ route('descargos.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>
        <div class="table-responsive"><table class="table align-middle">
            <thead><tr><th>ID</th><th>Proceso</th><th>Estudiante</th><th>Codigo</th><th>Descripcion</th><th>Fecha registro</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
                @forelse ($descargos as $descargo)
                    <tr>
                        <td class="fw-semibold">{{ $descargo->id }}</td>
                        <td>#{{ $descargo->proceso_disciplinario_id }}</td>
                        <td>{{ $descargo->procesoDisciplinario?->denuncia?->estudiante?->nombre }} {{ $descargo->procesoDisciplinario?->denuncia?->estudiante?->apellido }}</td>
                        <td>{{ $descargo->procesoDisciplinario?->denuncia?->estudiante?->codigo_estu }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($descargo->descripcion, 80) }}</td>
                        <td>{{ $descargo->fecha_registro?->format('Y-m-d') ?? 'N/A' }}</td>
                        <td><span class="badge text-bg-{{ $descargo->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $descargo->estado_registro }}</span></td>
                        <td><div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('descargos.show', $descargo) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye me-1"></i>Ver</a>
                            <a href="{{ route('descargos.edit', $descargo) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a>
                            @if (session('rol_usuario') === 'Administrador')
                                <form method="POST" action="{{ route('descargos.destroy', $descargo) }}" class="status-form">@csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-{{ $descargo->estado_registro === 'Activo' ? 'danger' : 'success' }}"><i class="fa-solid {{ $descargo->estado_registro === 'Activo' ? 'fa-ban' : 'fa-circle-check' }} me-1"></i>{{ $descargo->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button>
                                </form>
                            @endif
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No hay descargos registrados.</td></tr>
                @endforelse
            </tbody>
        </table></div>
        <div class="mt-3">{{ $descargos->links() }}</div>
    </div></div>
@endsection

@push('scripts')
    @include('partials.confirm-status')
@endpush
