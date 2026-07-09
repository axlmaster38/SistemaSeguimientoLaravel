@extends('layouts.app')

@section('title', 'Nuevo programa | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Nuevo programa</h1><div class="text-muted">Registra un programa academico.</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('programas.store') }}">@include('programas._form')</form></div></div>
@endsection
