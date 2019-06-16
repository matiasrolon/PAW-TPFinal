@extends('layouts.app')

@section('title') pelicula | MVJ Reviews @endsection

@section('content')
            <div class="content">
                <div class="title m-b-md">
                  <h2>Info pelicula:</h2>
                  <img class="poster" src="data:image/png;base64,{{$film['poster']}}">
                  <div>{{ $film['titulo'] }}</div>
                  <div>{{ $film['fecha_estreno'] }}</div>
                  <div>{{ $film['pais'] }}</div>
                  <div>{{ $film['sinopsis'] }}</div>
                  <div>{{ $film['categoria'] }}</div>

                  <!-- AGREGAR MAS CAMPOS ;SI ES NECESARIO. -->

                  <br>
                  <h2>reviews:</h2>
                  @if (count($reviews)>0)
                    @foreach ($reviews as $review)
                      <b>usuario: <b> <a href="{{ route('user_profile', $review['username']) }}">{{ $review['username'] }}</a>
                      <b>Fecha: <b>{{ $review['created_at'] }}
                      <b>titulo: <b>{{ $review['titulo'] }}
                      <b>descripcion:<b> {{ $review['descripcion'] }}
                      <b>Likes: <b> {{ $review['positivos'] }}
                      <b>Dislikes: <b> {{ $review['negativos'] }}
                      <br>
                    @endforeach
                @else
                    <p>Aun no hay reviews hechas para este film. </p>
                @endif
                </div>
              </div>

  @endsection
