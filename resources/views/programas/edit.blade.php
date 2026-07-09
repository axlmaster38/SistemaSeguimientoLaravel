@extends('layouts.app')

@section('title', 'Editar programa | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Editar programa</h1><div class="text-muted">{{ $programa->codigo_pro }} - {{ $programa->nombre }}</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('programas.update', $programa) }}">@method('PUT') @include('programas._form')</form></div></div>
@endsection
