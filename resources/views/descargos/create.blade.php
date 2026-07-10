@extends('layouts.app')

@section('title', 'Nuevo descargo | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Nuevo descargo</h1><div class="text-muted">Registra un descargo para un proceso activo.</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('descargos.store') }}">@include('descargos._form')</form></div></div>
@endsection
