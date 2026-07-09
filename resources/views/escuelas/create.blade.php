@extends('layouts.app')

@section('title', 'Nueva escuela | SME')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Nueva escuela</h1>
        <div class="text-muted">Registra una escuela academica.</div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('escuelas.store') }}">
                @include('escuelas._form')
            </form>
        </div>
    </div>
@endsection
