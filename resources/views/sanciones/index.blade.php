@extends('layouts.app')

@section('title', 'Sanciones | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Sanciones</h1><div class="text-muted">Gestion de sanciones asociadas a decisiones.</div></div>
        <a href="{{ route('sanciones.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="GET" action="{{ route('sanciones.index') }}" class="row g-2 mb-3">
            <div class="col-12 col-lg-3"><input type="search" name="buscar" value="{{ $buscar }}" class="form-control" placeholder="Buscar sancion, estudiante o decision"></div>
            <div class="col-12 col-md-2"><select name="tipo_sancion" class="form-select"><option value="Todos">Tipos</option>@foreach ($tiposSancion as $tipo)<option value="{{ $tipo }}" @selected($tipoSancion === $tipo)>{{ $tipo }}</option>@endforeach</select></div>
            <div class="col-12 col-md-2"><select name="estado_sancion" class="form-select"><option value="Todos">Estados</option>@foreach ($estadosSancion as $estado)<option value="{{ $estado }}" @selected($estadoSancion === $estado)>{{ $estado }}</option>@endforeach</select></div>
            <div class="col-12 col-md-2"><select name="estado_registro" class="form-select">@foreach (['Activo', 'Inactivo', 'Todos'] as $estado)<option value="{{ $estado }}" @selected($estadoRegistro === $estado)>{{ $estado }}</option>@endforeach</select></div>
            <div class="col-12 col-md-3"><select name="decision_id" class="form-select"><option value="">Todas las decisiones</option>@foreach ($decisiones as $decision)<option value="{{ $decision->id }}" @selected($decisionId === $decision->id)>#{{ $decision->id }} - {{ $decision->nombre }}</option>@endforeach</select></div>
            <div class="col-12 col-md-3"><select name="periodo_inicial_sancion_id" class="form-select"><option value="">Periodo inicial</option>@foreach ($periodos as $periodo)<option value="{{ $periodo->id }}" @selected($periodoInicialId === $periodo->id)>{{ $periodo->anio }} - {{ $periodo->periodo }}</option>@endforeach</select></div>
            <div class="col-12 col-md-3"><select name="periodo_final_sancion_id" class="form-select"><option value="">Periodo final</option>@foreach ($periodos as $periodo)<option value="{{ $periodo->id }}" @selected($periodoFinalId === $periodo->id)>{{ $periodo->anio }} - {{ $periodo->periodo }}</option>@endforeach</select></div>
            <div class="col-12 d-flex gap-2"><button type="submit" class="btn btn-outline-primary">Buscar</button><a href="{{ route('sanciones.index') }}" class="btn btn-outline-secondary">Limpiar</a></div>
        </form>
        <div class="table-responsive"><table class="table align-middle">
            <thead><tr><th>ID</th><th>Decision</th><th>Proceso</th><th>Estudiante</th><th>Tipo</th><th>Periodos</th><th>Inicial</th><th>Final</th><th>Notificacion</th><th>Meses faltantes</th><th>Estado sancion</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>@forelse ($sanciones as $sancion)
                @php
                    $reglas = $sancion->reglas_negocio ?? [];
                    $colorMeses = $reglas['color_meses_restantes'] ?? null;
                    $mesesRestantes = $reglas['meses_restantes'] ?? null;
                @endphp
                <tr>
                <td class="fw-semibold">{{ $sancion->id }}</td><td>#{{ $sancion->decision_id }} - {{ $sancion->decision?->nombre }}</td><td>#{{ $sancion->decision?->proceso_disciplinario_id }}</td>
                <td>{{ $sancion->decision?->procesoDisciplinario?->denuncia?->estudiante?->codigo_estu }} - {{ $sancion->decision?->procesoDisciplinario?->denuncia?->estudiante?->nombre }}</td>
                <td>{{ $sancion->tipo_sancion }}</td><td>{{ $sancion->numero_periodos }}</td><td>{{ $sancion->periodoInicialSancion?->anio }} {{ $sancion->periodoInicialSancion?->periodo }}</td><td>{{ $sancion->periodoFinalSancion?->anio }} {{ $sancion->periodoFinalSancion?->periodo }}</td>
                <td>{{ $reglas['texto_notificacion'] ?? 'Sin notificar' }} @if ($reglas['fecha_notificacion'] ?? null) el {{ $reglas['fecha_notificacion']->format('Y-m-d') }} @endif</td>
                <td style="{{ $colorMeses ? 'background-color: '.$colorMeses.';' : '' }}">{{ $mesesRestantes !== null && $mesesRestantes >= 0 ? $mesesRestantes : 'Sancion finalizada' }}</td><td>{{ $sancion->estado_sancion }}</td>
                <td><span class="badge text-bg-{{ $sancion->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $sancion->estado_registro }}</span></td>
                <td><div class="d-flex justify-content-end gap-2"><a href="{{ route('sanciones.show', $sancion) }}" class="btn btn-sm btn-outline-secondary">Ver</a><a href="{{ route('sanciones.edit', $sancion) }}" class="btn btn-sm btn-outline-primary">Editar</a>@if (session('rol_usuario') === 'Administrador')<form method="POST" action="{{ route('sanciones.destroy', $sancion) }}" class="status-form">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-{{ $sancion->estado_registro === 'Activo' ? 'danger' : 'success' }}">{{ $sancion->estado_registro === 'Activo' ? 'Inactivar' : 'Activar' }}</button></form>@endif</div></td>
            </tr>@empty<tr><td colspan="13" class="text-center text-muted py-4">No hay sanciones registradas.</td></tr>@endforelse</tbody>
        </table></div><div class="mt-3">{{ $sanciones->links() }}</div>
    </div></div>
@endsection

@push('scripts') @include('partials.confirm-status') @endpush
