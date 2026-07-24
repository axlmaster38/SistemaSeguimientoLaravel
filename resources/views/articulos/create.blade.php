@extends('layouts.app')

@section('title', 'Nuevo artículo | SME')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Nuevo artículo</h1>
        <div class="text-muted">Registra un artículo asociado a una normatividad.</div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('articulos.store') }}">
                @include('articulos._form')
            </form>
        </div>
    </div>
@endsection
