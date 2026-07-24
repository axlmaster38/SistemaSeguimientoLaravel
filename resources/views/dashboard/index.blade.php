@extends('layouts.app')

@section('title', 'Resumen General | SME')

@section('content')
    <style>
        .dashboard-card-link {
            display: block;
            height: 100%;
        }

        .dashboard-card {
            cursor: pointer;
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .dashboard-card-link:hover .dashboard-card {
            transform: translateY(-3px);
            box-shadow: 0 .65rem 1.25rem rgba(0, 0, 0, .12) !important;
        }

        .dashboard-card-link:focus-visible {
            outline: none;
        }

        .dashboard-card-link:focus-visible .dashboard-card {
            outline: 3px solid rgba(13, 110, 253, .35);
            outline-offset: 3px;
            box-shadow: 0 .65rem 1.25rem rgba(0, 0, 0, .12) !important;
        }

        .dashboard-card-arrow {
            color: rgba(108, 117, 125, .7);
            transition: transform .22s ease, color .22s ease;
        }

        .dashboard-card-link:hover .dashboard-card-arrow,
        .dashboard-card-link:focus-visible .dashboard-card-arrow {
            color: rgba(33, 37, 41, .9);
            transform: translateX(3px);
        }

        .dashboard-alert-card {
            border: 0;
            box-shadow: 0 .45rem 1rem rgba(15, 23, 42, .08);
        }

        .dashboard-alert-icon {
            width: 2.35rem;
            height: 2.35rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: .75rem;
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Resumen General</h1>
            <div class="text-muted">Resumen inicial del sistema disciplinario.</div>
        </div>
    </div>

    <div class="row g-3">
        @php
            $cards = [
                ['label' => 'Estudiantes', 'value' => $conteos['estudiantes'], 'icon' => 'fa-user-graduate', 'color' => 'primary', 'route' => route('estudiantes.index'), 'aria' => 'Ir al módulo de Estudiantes'],
                ['label' => 'Denuncias', 'value' => $conteos['denuncias'], 'icon' => 'fa-file-circle-exclamation', 'color' => 'danger', 'route' => route('denuncias.index'), 'aria' => 'Ir al módulo de Denuncias'],
                ['label' => 'Procesos disciplinarios', 'value' => $conteos['procesos_disciplinarios'], 'icon' => 'fa-folder-open', 'color' => 'warning', 'route' => route('procesos.index'), 'aria' => 'Ir al módulo de Procesos disciplinarios'],
                ['label' => 'Sanciones', 'value' => $conteos['sanciones'], 'icon' => 'fa-triangle-exclamation', 'color' => 'dark', 'route' => route('sanciones.index'), 'aria' => 'Ir al módulo de Sanciones'],
                ['label' => 'Apelaciones', 'value' => $conteos['apelaciones'], 'icon' => 'fa-scale-unbalanced-flip', 'color' => 'info', 'route' => route('apelaciones.index'), 'aria' => 'Ir al módulo de Apelaciones'],
                ['label' => 'Notificaciones', 'value' => $conteos['notificaciones'], 'icon' => 'fa-envelope-open-text', 'color' => 'success', 'route' => route('notificaciones.index'), 'aria' => 'Ir al módulo de Notificaciones'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="col-12 col-sm-6 col-xl-4">
                <a href="{{ $card['route'] }}" class="dashboard-card-link text-decoration-none text-reset" aria-label="{{ $card['aria'] }}">
                    <div class="card border-0 shadow-sm h-100 dashboard-card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded bg-{{ $card['color'] }} bg-opacity-10 text-{{ $card['color'] }} p-3">
                                <i class="fa-solid {{ $card['icon'] }} fa-xl"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="text-muted small">{{ $card['label'] }}</div>
                                <div class="h3 mb-0">{{ number_format($card['value']) }}</div>
                            </div>
                            <i class="fa-solid fa-arrow-right dashboard-card-arrow"></i>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <section class="mt-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
            <div>
                <h2 class="h4 mb-1">Alertas y vencimientos próximos</h2>
                <div class="text-muted">Registros que requieren revisión por vencimiento cercano.</div>
            </div>
            @if (($alertas['totales']['general'] ?? 0) > 0)
                <span class="badge text-bg-danger fs-6">
                    {{ $alertas['totales']['general'] }} alertas pendientes
                </span>
            @endif
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-4">
                <div class="card dashboard-alert-card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="dashboard-alert-icon bg-danger bg-opacity-10 text-danger">
                            <i class="fa-solid fa-clock"></i>
                        </span>
                        <div>
                            <div class="text-muted small">Procesos próximos a vencer</div>
                            <div class="h4 mb-0">{{ $alertas['totales']['procesos'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card dashboard-alert-card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="dashboard-alert-icon bg-secondary bg-opacity-10 text-secondary">
                            <i class="fa-solid fa-scale-unbalanced-flip"></i>
                        </span>
                        <div>
                            <div class="text-muted small">Apelaciones próximas a vencer</div>
                            <div class="h4 mb-0">{{ $alertas['totales']['apelaciones'] ?? 0 }}</div>
                            @if (! ($alertas['apelaciones_regla_definida'] ?? false))
                                <div class="small text-muted">Regla pendiente de definición</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card dashboard-alert-card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="dashboard-alert-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </span>
                        <div>
                            <div class="text-muted small">Sanciones próximas a finalizar</div>
                            <div class="h4 mb-0">{{ $alertas['totales']['sanciones'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-xl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-semibold">
                        <i class="fa-solid fa-folder-open text-danger me-2"></i>Procesos disciplinarios
                    </div>
                    <div class="card-body">
                        @if (($alertas['procesos'] ?? collect())->isEmpty())
                            <div class="text-muted">No hay alertas próximas.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Proceso</th>
                                            <th>Estudiante</th>
                                            <th>Estado</th>
                                            <th>Días</th>
                                            <th>Fecha límite</th>
                                            <th class="text-end">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alertas['procesos'] as $alerta)
                                            <tr>
                                                <td>#{{ $alerta['id'] }}</td>
                                                <td>
                                                    {{ trim(($alerta['estudiante']?->nombre ?? '') . ' ' . ($alerta['estudiante']?->apellido ?? '')) ?: 'Sin estudiante' }}
                                                </td>
                                                <td>{{ $alerta['estado'] }}</td>
                                                <td>
                                                    <span class="badge text-bg-{{ $alerta['dias_restantes'] <= 0 ? 'danger' : 'warning' }}">
                                                        {{ $alerta['dias_restantes'] <= 0 ? 'Hoy' : $alerta['dias_restantes'] . ' días' }}
                                                    </span>
                                                </td>
                                                <td>{{ $alerta['fecha_limite'] ? \Illuminate\Support\Carbon::parse($alerta['fecha_limite'])->format('Y-m-d') : '' }}</td>
                                                <td class="text-end">
                                                    <a href="{{ $alerta['url'] }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-semibold">
                        <i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>Sanciones
                    </div>
                    <div class="card-body">
                        @if (($alertas['sanciones'] ?? collect())->isEmpty())
                            <div class="text-muted">No hay alertas próximas.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Sanción</th>
                                            <th>Estudiante</th>
                                            <th>Tipo</th>
                                            <th>Finaliza</th>
                                            <th>Tiempo</th>
                                            <th class="text-end">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alertas['sanciones'] as $alerta)
                                            <tr>
                                                <td>#{{ $alerta['id'] }}</td>
                                                <td>
                                                    {{ trim(($alerta['estudiante']?->nombre ?? '') . ' ' . ($alerta['estudiante']?->apellido ?? '')) ?: 'Sin estudiante' }}
                                                </td>
                                                <td>{{ $alerta['tipo_sancion'] }}</td>
                                                <td>{{ $alerta['fecha_final'] ? \Illuminate\Support\Carbon::parse($alerta['fecha_final'])->format('Y-m-d') : '' }}</td>
                                                <td>
                                                    <span class="badge text-bg-{{ $alerta['meses_restantes'] < 0 ? 'danger' : 'warning' }}">
                                                        {{ $alerta['meses_restantes'] < 0 ? 'Vencida' : 'Menos de 1 mes' }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ $alerta['url'] }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-semibold">
                        <i class="fa-solid fa-scale-unbalanced-flip text-secondary me-2"></i>Apelaciones
                    </div>
                    <div class="card-body">
                        @if (! ($alertas['apelaciones_regla_definida'] ?? false))
                            <div class="alert alert-secondary mb-0">
                                {{ $alertas['apelaciones_mensaje'] }}
                            </div>
                        @elseif (($alertas['apelaciones'] ?? collect())->isEmpty())
                            <div class="text-muted">No hay alertas próximas.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
