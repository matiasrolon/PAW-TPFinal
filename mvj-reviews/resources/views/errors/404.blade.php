@extends('layouts.app')

@section('title') 404 No encontrada | MVJ Reviews @endsection

@section('publics')
    <link href="{{ asset('css/errors.css') }}" rel="stylesheet">
@endsection

@section('content')
<h1 class="tittle"> Pagina no encontrada </h1>
<p class="description"> El archivo al que quiere acceder no se encuentra disponible.</p>
<p> <a href="{{route('home')}}"> Volver al Home</a> </p>

@endsection
