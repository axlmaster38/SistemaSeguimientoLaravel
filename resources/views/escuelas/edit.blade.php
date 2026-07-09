@extends('layouts.app')

@section('title', 'Editar escuela | SME')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar escuela</h1>
        <div class="text-muted">{{ $escuela->sigla }} - {{ $escuela->nombre }}</div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('escuelas.update', $escuela) }}">
                @method('PUT')
                @include('escuelas._form')
            </form>
        </div>
    </div>
@endsection
