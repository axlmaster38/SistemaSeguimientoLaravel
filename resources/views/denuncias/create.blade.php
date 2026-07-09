@extends('layouts.app')

@section('title', 'Nueva denuncia | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Nueva denuncia</h1><div class="text-muted">Registra una denuncia para un estudiante activo.</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('denuncias.store') }}">@include('denuncias._form')</form></div></div>
@endsection
