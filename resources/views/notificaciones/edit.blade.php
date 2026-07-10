@extends('layouts.app')
@section('title', 'Editar notificacion | SME')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Editar notificacion</h1><div class="text-muted">{{ $notificacion->nombre }}</div></div>
<div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('notificaciones.update', $notificacion) }}" enctype="multipart/form-data">@method('PUT') @include('notificaciones._form')</form></div></div>
@endsection
