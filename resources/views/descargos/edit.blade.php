@extends('layouts.app')

@section('title', 'Editar descargo | SME')

@section('content')
    <div class="mb-4"><h1 class="h3 mb-1">Editar descargo</h1><div class="text-muted">Descargo #{{ $descargo->id }}</div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('descargos.update', $descargo) }}">@method('PUT') @include('descargos._form')</form></div></div>
@endsection
