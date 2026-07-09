@extends('layouts.app')

@section('title', 'Editar proceso disciplinario | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Editar proceso disciplinario</h1><div class="text-muted">Proceso #{{ $proceso->id }} - {{ $proceso->estado_proceso }}</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('procesos.update', $proceso) }}">@method('PUT') @include('procesos._form')</form></div></div>
@endsection
