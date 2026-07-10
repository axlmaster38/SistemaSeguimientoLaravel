@extends('layouts.app')
@section('title', 'Nueva apelacion | SME')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Nueva apelacion</h1><div class="text-muted">Registra una apelacion asociada a un proceso activo.</div></div>
<div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('apelaciones.store') }}">@include('apelaciones._form')</form></div></div>
@endsection
