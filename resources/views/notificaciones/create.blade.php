@extends('layouts.app')
@section('title', 'Nueva notificacion | SME')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Nueva notificacion</h1><div class="text-muted">Registra una notificacion asociada a proceso o sancion.</div></div>
<div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('notificaciones.store') }}" enctype="multipart/form-data">@include('notificaciones._form')</form></div></div>
@endsection
