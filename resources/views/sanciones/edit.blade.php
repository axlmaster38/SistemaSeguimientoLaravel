@extends('layouts.app')
@section('title', 'Editar sancion | SME')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Editar sancion</h1><div class="text-muted">Sancion #{{ $sancion->id }}</div></div>
<div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('sanciones.update', $sancion) }}">@method('PUT') @include('sanciones._form')</form></div></div>
@endsection
