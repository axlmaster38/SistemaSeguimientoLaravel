@extends('layouts.app')

@section('title', 'Detalle proceso disciplinario | SME')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div><h1 class="h3 mb-1">Detalle de proceso disciplinario</h1><div class="text-muted">Proceso #{{ $proceso->id }} - {{ $proceso->estado_proceso }}</div></div>
        <div class="d-flex gap-2"><a href="{{ route('procesos.edit', $proceso) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-1"></i>Editar</a><a href="{{ route('procesos.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Volver</a></div>
    </div>
    <div class="card border-0 shadow-sm mb-4"><div class="card-body"><dl class="row mb-0">
        <dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $proceso->id }}</dd>
        <dt class="col-sm-3">Denuncia</dt><dd class="col-sm-9">#{{ $proceso->denuncia_id }} - {{ $proceso->denuncia?->estado_denuncia }}</dd>
        <dt class="col-sm-3">Estudiante</dt><dd class="col-sm-9">{{ $proceso->denuncia?->estudiante?->codigo_estu }} - {{ $proceso->denuncia?->estudiante?->nombre }} {{ $proceso->denuncia?->estudiante?->apellido }}</dd>
        <dt class="col-sm-3">Fecha apertura</dt><dd class="col-sm-9">{{ $proceso->fecha_apertura?->format('Y-m-d') ?? 'N/A' }}</dd>
        <dt class="col-sm-3">Estado proceso</dt><dd class="col-sm-9">{{ $proceso->estado_proceso }}</dd>
        <dt class="col-sm-3">Proceso antiguo</dt><dd class="col-sm-9">{{ $proceso->proceso_antiguo ? 'Si' : 'No' }}</dd>
        <dt class="col-sm-3">Estado registro</dt><dd class="col-sm-9"><span class="badge text-bg-{{ $proceso->estado_registro === 'Activo' ? 'success' : 'secondary' }}">{{ $proceso->estado_registro }}</span></dd>
        <dt class="col-sm-3">Usuario registra</dt><dd class="col-sm-9">{{ $proceso->usuarioRegistra?->nombre }} {{ $proceso->usuarioRegistra?->apellido }}</dd>
        <dt class="col-sm-3">Usuario actualiza</dt><dd class="col-sm-9">{{ $proceso->usuarioActualiza?->nombre }} {{ $proceso->usuarioActualiza?->apellido }}</dd>
    </dl></div></div>

    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <h2 class="h6">Tipologias de falta</h2>
                <ul class="mb-0">
                    @forelse ($proceso->tipologiasFalta as $tipologia)
                        <li>{{ $tipologia->nombre }}</li>
                    @empty
                        <li class="text-muted">Sin tipologias registradas.</li>
                    @endforelse
                </ul>
            </div></div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <h2 class="h6">Articulos</h2>
                <ul class="mb-0">
                    @forelse ($proceso->articulos as $articulo)
                        <li>{{ $articulo->no_articulo }} - {{ $articulo->normatividad?->no_acuerdo }}</li>
                    @empty
                        <li class="text-muted">Sin articulos registrados.</li>
                    @endforelse
                </ul>
            </div></div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <h2 class="h6">Historico estudiante</h2>
                <ul class="mb-0">
                    @forelse ($proceso->historicos as $historico)
                        <li>{{ $historico->programa?->codigo_pro }} - {{ $historico->programa?->nombre }}</li>
                    @empty
                        <li class="text-muted">Sin historico registrado.</li>
                    @endforelse
                </ul>
            </div></div>
        </div>
    </div>
@endsection
