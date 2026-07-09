@extends('layouts.app')

@section('title', 'Editar zona | SME')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar zona</h1>
        <div class="text-muted">{{ $zona->nombre }}</div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('zonas.update', $zona) }}">
                @method('PUT')
                @include('zonas._form')
            </form>
        </div>
    </div>
@endsection
