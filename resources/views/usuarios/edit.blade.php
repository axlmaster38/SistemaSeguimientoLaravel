@extends('layouts.app')

@section('title', 'Editar usuario | SME')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Editar usuario</h1>
            <div class="text-muted">{{ $usuario->usuario }}</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
                @method('PUT')
                @include('usuarios._form')
            </form>
        </div>
    </div>
@endsection
