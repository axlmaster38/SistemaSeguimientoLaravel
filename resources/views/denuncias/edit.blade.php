@extends('layouts.app')

@section('title', 'Editar denuncia | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Editar denuncia</h1><div class="text-muted">{{ $denuncia->estudiante?->codigo_estu }} - {{ $denuncia->estado_denuncia }}</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('denuncias.update', $denuncia) }}">@method('PUT') @include('denuncias._form')</form></div></div>
@endsection
