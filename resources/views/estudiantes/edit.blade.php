@extends('layouts.app')

@section('title', 'Editar estudiante | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Editar estudiante</h1><div class="text-muted">{{ $estudiante->codigo_estu }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('estudiantes.update', $estudiante) }}">@method('PUT') @include('estudiantes._form')</form></div></div>
@endsection
