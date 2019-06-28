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
                          <p>{{ str_limit($pelicula['sinopsis'], $limit = 150, $end = '...') }}</p>
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
                              <img class="poster" src="data:image/png;base64,{{$serie['portada']}}">
                            </div>
                            <a style="display:block" href="/films/{{$serie['id']}}">
                              <div class="flip-card-back">
                                <p>{{ $serie['fecha_estreno']}}</p>
                                <p class="titulo-film">{{ $serie['titulo']}}</p>
                                <p>{{ str_limit($serie['sinopsis'], $limit = 150, $end = '...') }}</p>
                              </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
              </section>
            </div>
        </section>

        <section class="users-populares">
          <!-- <div class="ranking tabla"> -->
          <div class="ranking-tabla">
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
                          <td>{{ $user['cantReviews'] }}</td> 
                          <td>{{ number_format($user['puntos'], 2) }}</td>
                      <!-- </div> -->
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div id="container101">
            <ul class="ultimas-reviews-container">
              @foreach($reviews as $review)
                <li>
                  <p>@<a href="/users/{{$review['username']}}">{{ $review['username'] }}</a> dijo:</p>
                  <div class="comment">
                    <div class="comment-inner">
                    <h3><a href="/films/{{$review['film_id']}}">{{ $review['review_titulo'] }}</a></h3>
                    <p>"{{ str_limit($review['review_descripcion'], $limit = 100, $end = '...')  }}..."</p>
                    <p>Sobre: <a href="/films/{{$review['film_id']}}">{{ $review['film_titulo'] }} ({{ $review['film_fecha_estreno'] }})</a></p>
                    </div>
                  </div>

                </li>
              @endforeach
            </ul>
          </div>
        </section>

        <section class="ultimas-reviews">
    </div>

  @endsection
