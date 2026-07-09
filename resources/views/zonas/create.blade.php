@extends('layouts.app')

@section('title', 'Nueva zona | SME')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Nueva zona</h1>
        <div class="text-muted">Registra una zona academica.</div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('zonas.store') }}">
                @include('zonas._form')
            </form>
        </div>
    </div>
@endsection
