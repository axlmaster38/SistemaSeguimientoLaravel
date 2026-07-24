@extends('layouts.app')

@section('title', 'Nuevo usuario | SME')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Nuevo usuario</h1>
            <div class="text-muted">Crea una cuenta de acceso al sistema.</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('usuarios.store') }}">
                @include('usuarios._form')
            </form>
        </div>
    </div>
@endsection
