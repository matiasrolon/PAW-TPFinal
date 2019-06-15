@extends('layouts.app')

@section('title') Ranking Films | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h2>Ranking de criticos de MVJ:</h2>
    <table>
              <tr>
                <td>Titutlo</td>
                <td>Categoria</td>
                <td>Estreno</td>
                <td>Pais</td>
                <td>Puntaje</td>
              </tr>
        @foreach($films as $film)
              <tr>
                  <div class="tupla-film">
                      <td>
                          <a href="{{ route('film_profile', $film['id']) }}">
                             {{ $film['titulo'] }}</td>
                          </a>
                      <td>{{ $film['categoria'] }}</td>
                      <td>{{ $film['fecha_estreno'] }}</td>
                      <td>{{ $film['pais'] }}</td>
                      <td>{{ $film['puntaje'] }}</td>
                  </div>
              </tr>
        @endforeach
    </table>
@endsection
