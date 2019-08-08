@extends('layouts.app')

@section('title') 403 Prohibido | MVJ Reviews @endsection

@section('publics')
    <link href="{{ asset('css/errors.css') }}" rel="stylesheet">
@endsection

@section('content')
<h1 class="tittle"> Acceso no autorizado </h1>
<p class="description"> No posee los permisos para visitar esta pagina. </p>
<p> <a href="{{route('home')}}"> Volver al Home</a> </p>

@endsection
