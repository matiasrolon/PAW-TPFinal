@extends('layouts.app')

@section('title') pelicula | MVJ Reviews @endsection

@section('content')
            <div class="content">
                <div class="title m-b-md">
                  <b>Info pelicula:</b>
                  {{ $film['titulo'] }}
                  {{ $film['fecha_estreno'] }}
                  {{ $film['pais'] }}
                  {{ $film['sinopsis'] }}
                  {{ $film['categoria'] }}
                  <!-- AGREGAR DEMAS CAMPOS. -->

                  <br>
                  <b>reviews:</b>

                </div>
              </div>

  @endsection
