@extends('layouts.app')

@section('title', 'Editar centro | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Editar centro</h1><div class="text-muted">{{ $centro->centro }}</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('centros.update', $centro) }}">@method('PUT') @include('centros._form')</form></div></div>
@endsection
