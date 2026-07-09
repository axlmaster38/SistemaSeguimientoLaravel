@extends('layouts.app')

@section('title', 'Nuevo proceso disciplinario | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Nuevo proceso disciplinario</h1><div class="text-muted">Registra un proceso desde una denuncia activa.</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('procesos.store') }}">@include('procesos._form')</form></div></div>
@endsection
