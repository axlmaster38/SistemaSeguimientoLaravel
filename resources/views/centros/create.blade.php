@extends('layouts.app')

@section('title', 'Nuevo centro | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Nuevo centro</h1><div class="text-muted">Registra un centro academico.</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('centros.store') }}">@include('centros._form')</form></div></div>
@endsection
