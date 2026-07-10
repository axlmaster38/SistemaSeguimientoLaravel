@extends('layouts.app')

@section('title', 'Editar prueba | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Editar prueba</h1><div class="text-muted">{{ $prueba->nombre }}</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('pruebas.update', $prueba) }}" enctype="multipart/form-data">@method('PUT') @include('pruebas._form')</form></div></div>
@endsection
