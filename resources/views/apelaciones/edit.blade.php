@extends('layouts.app')
@section('title', 'Editar apelacion | SME')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Editar apelacion</h1><div class="text-muted">Apelacion #{{ $apelacion->id }}</div></div>
<div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('apelaciones.update', $apelacion) }}">@method('PUT') @include('apelaciones._form')</form></div></div>
@endsection
