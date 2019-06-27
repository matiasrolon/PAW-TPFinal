@extends('layouts.app')

@section('title') Ranking Films | MVJ Reviews @endsection

@section('publics')
  <!-- <link href="{{ asset('css/home.css') }}" rel="stylesheet"> -->
  <link href="{{ asset('css/ranking_films.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="rank">
  <h2>Ranking de criticos de MVJ:</h2>
  <table class="tabla-rank">
    <thead>
      <th>Titulo</th>
      <th>Categoria</th>
      <th>Estreno</th>
      <th>Pais</th>
      <th>Puntaje</th>
    </thead>
    <tbody>
      @foreach($films as $film)
        <tr>
            <!-- <div class="tupla-film"> -->
          <td> <a href="{{ route('film_profile', $film['id']) }}"> {{ $film['titulo'] }} </a></td>
          <td>{{ $film['categoria'] }}</td>
          <td>{{ $film['fecha_estreno'] }}</td>
          <td>{{ $film['pais'] }}</td>
          <td>{{ number_format($film['puntaje'], 2) }}</td>
            <!-- </div> -->
        </tr>
      @endforeach
      </tbody>
  </table>
</section>

@endsection
