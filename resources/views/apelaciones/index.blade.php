@extends('layouts.app')

@section('title', 'Apelaciones | SME')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h1 class="h3 mb-1">Apelaciones</h1><div class="text-muted">Gestion de apelaciones asociadas a procesos disciplinarios.</div></div>
    <a href="{{ route('apelaciones.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
</div>
@if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
<div class="card border-0 shadow-sm"><div class="card-body">
    <form method="GET" action="{{ route('apelaciones.index') }}" class="row g-2 mb-3">
        <div class="col-12 col-lg-4"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar motivo, estudiante o proceso"></div>
        <div class="col-12 col-md-3"><select name="tipo_apelacion" class="form-select"><option value="Todos">Tipos</option>@foreach ($tiposApelacion as $tipo)<option value="{{ $tipo }}" @selected($tipoApelacion === $tipo)>{{ $tipo }}</option>@endforeach</select></div>
        <div class="col-12 col-md-2"><select name="estado_registro" class="form-select">@foreach (['Activo', 'Inactivo', 'Todos'] as $estado)<option value="{{ $estado }}" @selected($estadoRegistro === $estado)>{{ $estado }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><select name="proceso_disciplinario_id" class="form-select"><option value="">Todos los procesos</option>@foreach ($procesos as $proceso)<option value="{{ $proceso->id }}" @selected($procesoId === $proceso->id)>#{{ $proceso->id }} - {{ $proceso->denuncia?->estudiante?->codigo_estu }}</option>@endforeach</select></div>
        <div class="col-12 d-flex gap-2"><button type="submit" class="btn btn-outline-primary">Buscar</button><a href="{{ route('apelaciones.index') }}" class="btn btn-outline-secondary">Limpiar</a></div>
    </form>
    <div class="table-responsive"><table class="table align-middle">
        <thead><tr><th>ID</th><th>Proceso</th><th>Estudiante</th><th>Tipo</th><th>Motivo</th><th>Pruebas</th><th>Fecha</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
        <tbody>@forelse ($apelaciones as $apelacion)
            @php $estudiante = $apelacion->procesoDisciplinario?->denuncia?->estudiante; @endphp
            <tr>
                <td class="fw-semibold">#{{ $apelacion->id }}</td><td>#{{ $apelacion->proceso_disciplinario_id }}</td><td>{{ $estudiante?->codigo_estu }} - {{ $estudiante?->nombre }} {{ $estudiante?->apellido }}</td><td>{{ $apelacion->tipo_apelacion }}</td><td>{{ \Illuminate\Support\Str::limit($apelacion->motivo, 70) }}</td><td>{{ $apelacion->pruebas_count ?? $apelacion->pruebas()->count() }}</td><td>{{ $apelacion->fecha_registro?->format('Y-m-d') ?? 'N/A' }}</td>
                <td><span class="badge text-bg-{{ $apelacion->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $apelacion->estado_registro }}</span></td>
                <td><div class="d-flex justify-content-end gap-2"><a href="{{ route('apelaciones.show', $apelacion) }}" class="btn btn-sm btn-outline-secondary">Ver</a><a href="{{ route('apelaciones.edit', $apelacion) }}" class="btn btn-sm btn-outline-primary">Editar</a>@if (session('rol_usuario') === 'Administrador')<form method="POST" action="{{ route('apelaciones.destroy', $apelacion) }}" class="status-form">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-{{ $apelacion->estado_registro === 'Activo' ? 'danger' : 'success' }}">{{ $apelacion->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button></form>@endif</div></td>
            </tr>
        @empty<tr><td colspan="9" class="text-center text-muted py-4">No hay apelaciones registradas.</td></tr>@endforelse</tbody>
    </table></div><div class="mt-3">{{ $apelaciones->links() }}</div>
</div></div>
@endsection

@push('scripts') @include('partials.confirm-status') @endpush
