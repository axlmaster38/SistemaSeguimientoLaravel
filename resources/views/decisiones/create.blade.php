@extends('layouts.app')
@section('title', 'Nueva decision | SME')
@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Nueva decision</h1></div>
<div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('decisiones.store') }}" enctype="multipart/form-data">@include('decisiones._form')</form></div></div>
@endsection
