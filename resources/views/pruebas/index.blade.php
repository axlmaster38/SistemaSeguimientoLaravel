@extends('layouts.app')

@section('title', 'Pruebas | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Pruebas</h1><div class="text-muted">Gestion de pruebas asociadas a procesos, descargos o apelaciones.</div></div>
        <a href="{{ route('pruebas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="GET" action="{{ route('pruebas.index') }}" class="row g-2 mb-3">
            <div class="col-12 col-lg-3"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar por nombre, tipo, procedencia o estudiante"></div>
            <div class="col-12 col-md-3 col-lg-2">
                <select name="tipo_prueba" class="form-select"><option value="Todos">Todos los tipos</option>@foreach ($tiposPrueba as $tipo)<option value="{{ $tipo }}" @selected($tipoPrueba === $tipo)>{{ $tipo }}</option>@endforeach</select>
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <select name="procedencia" class="form-select"><option value="Todos">Todas las procedencias</option>@foreach ($procedencias as $item)<option value="{{ $item }}" @selected($procedencia === $item)>{{ $item }}</option>@endforeach</select>
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <select name="estado_registro" class="form-select">@foreach (['Activo', 'Inactivo', 'Todos'] as $estado)<option value="{{ $estado }}" @selected($estadoRegistro === $estado)>{{ $estado }}</option>@endforeach</select>
            </div>
            <div class="col-12 col-md-3 col-lg-3">
                <select name="proceso_disciplinario_id" class="form-select"><option value="">Todos los procesos</option>@foreach ($procesos as $proceso)<option value="{{ $proceso->id }}" @selected($procesoId === $proceso->id)>#{{ $proceso->id }} - {{ $proceso->denuncia?->estudiante?->codigo_estu }}</option>@endforeach</select>
            </div>
            <div class="col-12 d-flex gap-2"><button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Buscar</button><a href="{{ route('pruebas.index') }}" class="btn btn-outline-secondary">Limpiar</a></div>
        </form>
        <div class="table-responsive"><table class="table align-middle">
            <thead><tr><th>Nombre</th><th>Tipo</th><th>Procedencia</th><th>Proceso</th><th>Descargo</th><th>Apelacion</th><th>Archivo</th><th>Fecha registro</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
                @forelse ($pruebas as $prueba)
                    <tr>
                        <td class="fw-semibold">{{ $prueba->nombre }}</td>
                        <td>{{ $prueba->tipo_prueba }}</td>
                        <td>{{ $prueba->procedencia }}</td>
                        <td>{{ $prueba->proceso_disciplinario_id ? '#'.$prueba->proceso_disciplinario_id : 'N/A' }}</td>
                        <td>{{ $prueba->descargo_id ? '#'.$prueba->descargo_id : 'N/A' }}</td>
                        <td>{{ $prueba->apelacion_id ? '#'.$prueba->apelacion_id : 'N/A' }}</td>
                        <td>@if ($prueba->archivo)<a href="{{ route('pruebas.archivo', $prueba) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-download me-1"></i>Descargar</a>@else N/A @endif</td>
                        <td>{{ $prueba->fecha_registro?->format('Y-m-d') ?? 'N/A' }}</td>
                        <td><span class="badge text-bg-{{ $prueba->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $prueba->estado_registro }}</span></td>
                        <td><div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pruebas.show', $prueba) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye me-1"></i>Ver</a>
                            <a href="{{ route('pruebas.edit', $prueba) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a>
                            @if (session('rol_usuario') === 'Administrador')
                                <form method="POST" action="{{ route('pruebas.destroy', $prueba) }}" class="status-form">@csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-{{ $prueba->estado_registro === 'Activo' ? 'danger' : 'success' }}"><i class="fa-solid {{ $prueba->estado_registro === 'Activo' ? 'fa-ban' : 'fa-circle-check' }} me-1"></i>{{ $prueba->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button>
                                </form>
                            @endif
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center text-muted py-4">No hay pruebas registradas.</td></tr>
                @endforelse
            </tbody>
        </table></div>
        <div class="mt-3">{{ $pruebas->links() }}</div>
    </div></div>
@endsection

@push('scripts')
    @include('partials.confirm-status')
@endpush
