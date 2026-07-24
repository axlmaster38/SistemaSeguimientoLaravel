@extends('layouts.app')

@section('title', 'Editar normatividad | SME')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar normatividad</h1>
        <div class="text-muted">{{ $normatividad->no_acuerdo }}</div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('normatividades.update', $normatividad) }}">
                @method('PUT')
                @include('normatividades._form')
            </form>
        </div>
    </div>
@endsection
