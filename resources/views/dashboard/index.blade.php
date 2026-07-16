@extends('layouts.app')

@section('title', 'Resumen General | Sistema De Monitorieo Estudiantil')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Resumen General</h1>
            <div class="text-muted">Resumen inicial del sistema disciplinario.</div>
        </div>
    </div>

    <div class="row g-3">
        @php
            $cards = [
                ['label' => 'Estudiantes', 'value' => $conteos['estudiantes'], 'icon' => 'fa-user-graduate', 'color' => 'primary'],
                ['label' => 'Denuncias', 'value' => $conteos['denuncias'], 'icon' => 'fa-file-circle-exclamation', 'color' => 'danger'],
                ['label' => 'Procesos disciplinarios', 'value' => $conteos['procesos_disciplinarios'], 'icon' => 'fa-folder-open', 'color' => 'warning'],
                ['label' => 'Sanciones', 'value' => $conteos['sanciones'], 'icon' => 'fa-triangle-exclamation', 'color' => 'dark'],
                ['label' => 'Apelaciones', 'value' => $conteos['apelaciones'], 'icon' => 'fa-scale-unbalanced-flip', 'color' => 'info'],
                ['label' => 'Notificaciones', 'value' => $conteos['notificaciones'], 'icon' => 'fa-envelope-open-text', 'color' => 'success'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded bg-{{ $card['color'] }} bg-opacity-10 text-{{ $card['color'] }} p-3">
                            <i class="fa-solid {{ $card['icon'] }} fa-xl"></i>
                        </div>
                        <div>
                            <div class="text-muted small">{{ $card['label'] }}</div>
                            <div class="h3 mb-0">{{ number_format($card['value']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
