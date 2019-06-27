@extends('layouts.app')

@section('title') Home | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
  <script src="{{ asset('js/peliculasGenero.js') }}" charset="utf-8"></script>
  <script src="{{ asset('js/filmCardData.js') }}" charset="utf-8"></script>
  <script>
    FilmCardData.modificarPuntajeClase();
  </script>
@endsection

@section('content')
    <div class="content">
        <ul class="generos">
          @foreach($generos as $genero)
            <li><div value="{{ $genero['id'] }}" onclick="PeliculaGenero.initialize({{ $genero['id'] }}, 'pelicula', 'container1')"><p>{{ $genero['nombre'] }}</p></div></li>
          @endforeach
        </ul>

        <section id="container1" class="films-populares">

            <h3> Peliculas Populares</h3>
            <div class="container-peliculas-populares">
              <section class="peliculas">
                @foreach($peliculas as $pelicula)
                <div class="flip-card">
                    <div class="cuadro-film flip-card-inner">
                      <div class="flip-card-front">
                        <p class="puntuacion">{{number_format($pelicula['puntaje'],1)}}</p>
                        <img class="poster" src="data:image/png;base64,{{$pelicula['portada']}}">
                      </div>
                      <a style="display:block" href="/films/{{$pelicula['id']}}">
                        <div class="flip-card-back">
                          <p>{{ $pelicula['fecha_estreno']}}</p>
                          <p class="titulo-film">{{ $pelicula['titulo']}}</p>
                          <p>{{ $pelicula['sinopsis']}}</p>
                        </div>
                      </a>
                    </div>
                  </div>

                @endforeach
            </div>
            <br>
            <h3> Series Populares</h3>
            <div class="container-peliculas-populares">
              <section class="peliculas">
                    @foreach($series as $serie)
                    <div class="flip-card">
                        <div class="cuadro-film flip-card-inner">
                            <div class="flip-card-front">
                              <p class="puntuacion">{{ number_format($serie['puntuacion'], 1)}}</p>
                              <img class="poster" src="data:image/png;base64,{{$pelicula['portada']}}">
                            </div>
                            <a style="display:block" href="/films/{{$serie['id']}}">
                              <div class="flip-card-back">
                                <p>{{ $serie['fecha_estreno']}}</p>
                                <p class="titulo-film">{{ $serie['titulo']}}</p>
                                <p>{{ $serie['sinopsis']}}</p>
                              </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
              </section>
            </div>
        </section>

        <section class="users-populares">
          <div class="ranking tabla">
            <h3> Ranking Usuarios</h3>
            <table>
              <thead>
                <th>Usuario</th>
                <th>Reviews</th>
                <th>Puntos</th>
              </thead>
              <tbody>
                @foreach($users as $user)
                  <tr>
                      <!-- <div class="tupla-user"> -->
                          <td><a href="/users/{{$user['username']}}"> {{$user['username']}}</a></td>
                          <td>FALTA</td> <!--aca irian las reviews totales del user-->
                          <td>{{ number_format($user['puntos'], 2) }}</td>
                      <!-- </div> -->
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </section>
    </div>

  @endsection
