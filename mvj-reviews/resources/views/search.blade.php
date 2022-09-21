@extends('layouts.app')

@section('title') MVJ Reviews | {{$searchText}} @endsection

@section('publics')
    <meta name="description" content="Resultados de busqueda para {{$searchText}} en MVJ Reviews">
@endsection

@section('content')
    <h2>Resultados para "{{$searchText}}"</h2>
    @if (count($results) > 0)
        <ul id="resultados">
            @foreach ($results as $result)
            <li><a href="/films/{{$result['id']}}">{{ $result['titulo'] }}</a></li>
            @endforeach
        </ul>
    @else
        <h2>No se encontraron resultados para "{{$searchText}}"</h2>
    @endif
@endsection
