@extends('layouts.app')

@section('title', 'Editar artículo | SME')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar artículo</h1>
        <div class="text-muted">{{ $articulo->no_articulo }}</div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('articulos.update', $articulo) }}">
                @method('PUT')
                @include('articulos._form')
            </form>
        </div>
    </div>
@endsection
