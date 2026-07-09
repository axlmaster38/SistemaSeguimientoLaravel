@extends('layouts.app')

@section('title', 'Nuevo periodo academico | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Nuevo periodo academico</h1><div class="text-muted">Registra un periodo academico.</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('periodos-academicos.store') }}">@include('periodos_academicos._form')</form></div></div>
@endsection
