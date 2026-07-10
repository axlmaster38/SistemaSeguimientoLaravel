@extends('layouts.app')

@section('title', 'Nueva prueba | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Nueva prueba</h1><div class="text-muted">Registra una prueba asociada a un proceso o descargo.</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('pruebas.store') }}" enctype="multipart/form-data">@include('pruebas._form')</form></div></div>
@endsection
