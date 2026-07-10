@extends('layouts.app')

@section('title', 'Notificaciones | SME')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h1 class="h3 mb-1">Notificaciones</h1><div class="text-muted">Gestion de notificaciones de procesos y sanciones.</div></div>
    <a href="{{ route('notificaciones.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
</div>
@if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
<div class="card border-0 shadow-sm"><div class="card-body">
    <form method="GET" action="{{ route('notificaciones.index') }}" class="row g-2 mb-3">
        <div class="col-12 col-lg-3"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar estudiante, descripcion o nombre"></div>
        <div class="col-12 col-md-2"><select name="tipo_notificacion" class="form-select"><option value="Todos">Tipos</option>@foreach ($tiposNotificacion as $tipo)<option value="{{ $tipo }}" @selected($tipoNotificacion === $tipo)>{{ $tipo }}</option>@endforeach</select></div>
        <div class="col-12 col-md-2"><select name="instancia" class="form-select"><option value="Todos">Instancias</option>@foreach ($instancias as $item)<option value="{{ $item }}" @selected($instancia === $item)>{{ $item }}</option>@endforeach</select></div>
        <div class="col-12 col-md-2"><select name="estado_registro" class="form-select">@foreach (['Activo', 'Inactivo', 'Todos'] as $estado)<option value="{{ $estado }}" @selected($estadoRegistro === $estado)>{{ $estado }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><select name="proceso_disciplinario_id" class="form-select"><option value="">Todos los procesos</option>@foreach ($procesos as $proceso)<option value="{{ $proceso->id }}" @selected($procesoId === $proceso->id)>#{{ $proceso->id }} - {{ $proceso->denuncia?->estudiante?->codigo_estu }}</option>@endforeach</select></div>
        <div class="col-12 col-md-3"><select name="sancion_id" class="form-select"><option value="">Todas las sanciones</option>@foreach ($sanciones as $sancion)<option value="{{ $sancion->id }}" @selected($sancionId === $sancion->id)>#{{ $sancion->id }} - {{ $sancion->tipo_sancion }}</option>@endforeach</select></div>
        <div class="col-12 d-flex gap-2"><button type="submit" class="btn btn-outline-primary">Buscar</button><a href="{{ route('notificaciones.index') }}" class="btn btn-outline-secondary">Limpiar</a></div>
    </form>
    <div class="table-responsive"><table class="table align-middle">
        <thead><tr><th>Nombre</th><th>Tipo</th><th>Instancia</th><th>Proceso</th><th>Sancion</th><th>Estudiante</th><th>Archivo</th><th>Fecha</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
        <tbody>@forelse ($notificaciones as $notificacion)
            @php
                $proceso = $notificacion->procesoDisciplinario ?: $notificacion->sancion?->decision?->procesoDisciplinario;
                $estudiante = $proceso?->denuncia?->estudiante;
            @endphp
            <tr>
                <td class="fw-semibold">{{ $notificacion->nombre }}</td><td>{{ $notificacion->tipo_notificacion }}</td><td>{{ $notificacion->instancia }}</td><td>{{ $proceso ? '#'.$proceso->id : 'N/A' }}</td><td>{{ $notificacion->sancion_id ? '#'.$notificacion->sancion_id : 'N/A' }}</td>
                <td>{{ $estudiante?->codigo_estu }} - {{ $estudiante?->nombre }} {{ $estudiante?->apellido }}</td>
                <td>@if ($notificacion->archivo)<a href="{{ route('notificaciones.archivo', $notificacion) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-download me-1"></i>Descargar</a>@else N/A @endif</td>
                <td>{{ $notificacion->fecha_registro?->format('Y-m-d') ?? 'N/A' }}</td>
                <td><span class="badge text-bg-{{ $notificacion->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $notificacion->estado_registro }}</span></td>
                <td><div class="d-flex justify-content-end gap-2"><a href="{{ route('notificaciones.show', $notificacion) }}" class="btn btn-sm btn-outline-secondary">Ver</a><a href="{{ route('notificaciones.edit', $notificacion) }}" class="btn btn-sm btn-outline-primary">Editar</a>@if (session('rol_usuario') === 'Administrador')<form method="POST" action="{{ route('notificaciones.destroy', $notificacion) }}" class="status-form">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-{{ $notificacion->estado_registro === 'Activo' ? 'danger' : 'success' }}">{{ $notificacion->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button></form>@endif</div></td>
            </tr>
        @empty<tr><td colspan="10" class="text-center text-muted py-4">No hay notificaciones registradas.</td></tr>@endforelse</tbody>
    </table></div><div class="mt-3">{{ $notificaciones->links() }}</div>
</div></div>
@endsection

@push('scripts') @include('partials.confirm-status') @endpush
