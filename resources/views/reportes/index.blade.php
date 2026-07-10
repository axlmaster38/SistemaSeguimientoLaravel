@extends('layouts.app')

@section('title', 'Reportes | SME')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-1">Reportes</h1>
    <div class="text-muted">Consultas historicas migradas desde Django.</div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-6">
        <a href="{{ route('reportes.antecedentes-estudiante') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-reset">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded bg-primary bg-opacity-10 text-primary p-3"><i class="fa-solid fa-user-clock fa-xl"></i></div>
                <div><h2 class="h5 mb-1">Antecedentes por estudiante</h2><div class="text-muted">Denuncias, procesos, decisiones, sanciones y notificaciones por estudiante.</div></div>
            </div>
        </a>
    </div>
    <div class="col-12 col-lg-6">
        <a href="{{ route('reportes.procesos-historicos') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-reset">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded bg-success bg-opacity-10 text-success p-3"><i class="fa-solid fa-clock-rotate-left fa-xl"></i></div>
                <div><h2 class="h5 mb-1">Procesos historicos</h2><div class="text-muted">Listado historico con filtros y semaforizacion.</div></div>
            </div>
        </a>
    </div>
</div>
@endsection
