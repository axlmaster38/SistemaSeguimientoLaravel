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
@endsection
