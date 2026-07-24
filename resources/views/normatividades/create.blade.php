@extends('layouts.app')

@section('title', 'Nueva normatividad | SME')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Nueva normatividad</h1>
        <div class="text-muted">Registra una norma o acuerdo institucional.</div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('normatividades.store') }}">
                @include('normatividades._form')
            </form>
        </div>
    </div>
@endsection
