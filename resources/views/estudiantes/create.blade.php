@extends('layouts.app')

@section('title', 'Nuevo estudiante | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Nuevo estudiante</h1><div class="text-muted">Registra un estudiante.</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('estudiantes.store') }}">@include('estudiantes._form')</form></div></div>
@endsection
