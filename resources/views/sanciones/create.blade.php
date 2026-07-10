@extends('layouts.app')
@section('title', 'Nueva sancion | SME')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Nueva sancion</h1></div>
<div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('sanciones.store') }}">@include('sanciones._form')</form></div></div>
@endsection
