@extends('layouts.app')

@section('title') MVJ Reviews | 403 - Prohibido @endsection

@section('publics')
    <meta name="description" content="Acceso no autorizado. Forbidden. 403">
@endsection

@section('content')
    <h1 class="tittle">Acceso no autorizado</h1>
    <p class="description">No posee los permisos para visitar esta pagina.</p>
    <p><a href="{{route('home')}}">Volver al Home</a></p>
@endsection
