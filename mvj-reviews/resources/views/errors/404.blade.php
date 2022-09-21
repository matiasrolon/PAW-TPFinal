@extends('layouts.app')

@section('title') MVJ Reviews | 404 - Pagina no encontrada @endsection

@section('publics')
    <meta name="description" content="Pagina no encontrada. Error 404. Not found">
@endsection

@section('content')
    <h1 class="tittle">Pagina no encontrada</h1>
    <p class="description"> El archivo al que quiere acceder no se encuentra disponible.</p>
    <p><a href="{{route('home')}}"> Volver al Home</a></p>
@endsection
