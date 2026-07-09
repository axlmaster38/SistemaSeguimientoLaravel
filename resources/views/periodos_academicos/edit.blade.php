@extends('layouts.app')

@section('title', 'Editar periodo academico | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Editar periodo academico</h1><div class="text-muted">{{ $periodoAcademico->periodo }} - {{ $periodoAcademico->anio }}</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('periodos-academicos.update', $periodoAcademico) }}">@method('PUT') @include('periodos_academicos._form')</form></div></div>
@endsection
