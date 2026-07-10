@extends('layouts.app')
@section('title', 'Editar decision | SME')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Editar decision</h1><div class="text-muted">{{ $decision->nombre }}</div></div>
<div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('decisiones.update', $decision) }}" enctype="multipart/form-data">@method('PUT') @include('decisiones._form')</form></div></div>
@endsection
