@extends('layouts.app')

@section('title', 'Decisiones | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Decisiones</h1><div class="text-muted">Gestion de decisiones de procesos disciplinarios.</div></div>
        <a href="{{ route('decisiones.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="GET" action="{{ route('decisiones.index') }}" class="row g-2 mb-3">
            <div class="col-12 col-lg-3"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar decision, estudiante o proceso"></div>
            <div class="col-12 col-md-3"><select name="tipo_decision" class="form-select"><option value="Todos">Todos los tipos</option>@foreach ($tiposDecision as $tipo)<option value="{{ $tipo }}" @selected($tipoDecision === $tipo)>{{ $tipo }}</option>@endforeach</select></div>
            <div class="col-12 col-md-2"><select name="clasificacion_falta" class="form-select"><option value="Todos">Todas</option>@foreach ($clasificacionesFalta as $clasificacion)<option value="{{ $clasificacion }}" @selected($clasificacionFalta === $clasificacion)>{{ $clasificacion }}</option>@endforeach</select></div>
            <div class="col-12 col-md-2"><select name="estado_registro" class="form-select">@foreach (['Activo', 'Inactivo', 'Todos'] as $estado)<option value="{{ $estado }}" @selected($estadoRegistro === $estado)>{{ $estado }}</option>@endforeach</select></div>
            <div class="col-12 col-md-2"><select name="proceso_disciplinario_id" class="form-select"><option value="">Todos los procesos</option>@foreach ($procesos as $proceso)<option value="{{ $proceso->id }}" @selected($procesoId === $proceso->id)>#{{ $proceso->id }} - {{ $proceso->denuncia?->estudiante?->codigo_estu }}</option>@endforeach</select></div>
            <div class="col-12 d-flex gap-2"><button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-magnifying-glass me-1"></i>Buscar</button><a href="{{ route('decisiones.index') }}" class="btn btn-outline-secondary">Limpiar</a></div>
        </form>
        <div class="table-responsive"><table class="table align-middle">
            <thead><tr><th>ID</th><th>Nombre</th><th>Proceso</th><th>Estudiante</th><th>Codigo</th><th>Tipo</th><th>Fecha</th><th>Falta</th><th>Archivo</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>@forelse ($decisiones as $decision)<tr>
                <td class="fw-semibold">{{ $decision->id }}</td><td>{{ $decision->nombre }}</td><td>#{{ $decision->proceso_disciplinario_id }}</td>
                <td>{{ $decision->procesoDisciplinario?->denuncia?->estudiante?->nombre }} {{ $decision->procesoDisciplinario?->denuncia?->estudiante?->apellido }}</td>
                <td>{{ $decision->procesoDisciplinario?->denuncia?->estudiante?->codigo_estu }}</td><td>{{ $decision->tipo_decision }}</td><td>{{ $decision->fecha_sesion?->format('Y-m-d') }}</td><td>{{ $decision->clasificacion_falta }}</td>
                <td>@if ($decision->archivo)<a href="{{ route('decisiones.archivo', $decision) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-download"></i></a>@else N/A @endif</td>
                <td><span class="badge text-bg-{{ $decision->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $decision->estado_registro }}</span></td>
                <td><div class="d-flex justify-content-end gap-2"><a href="{{ route('decisiones.show', $decision) }}" class="btn btn-sm btn-outline-secondary">Ver</a><a href="{{ route('decisiones.edit', $decision) }}" class="btn btn-sm btn-outline-primary">Editar</a>@if (session('rol_usuario') === 'Administrador')<form method="POST" action="{{ route('decisiones.destroy', $decision) }}" class="status-form">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-{{ $decision->estado_registro === 'Activo' ? 'danger' : 'success' }}">{{ $decision->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button></form>@endif</div></td>
            </tr>@empty<tr><td colspan="11" class="text-center text-muted py-4">No hay decisiones registradas.</td></tr>@endforelse</tbody>
        </table></div><div class="mt-3">{{ $decisiones->links() }}</div>
    </div></div>
@endsection

@push('scripts') @include('partials.confirm-status') @endpush
