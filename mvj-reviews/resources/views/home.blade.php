@extends('layouts.app')

@section('title') Home | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="content">
        <section class="films-populares">

            <h3> Peliculas Populares</h3>
            <div class="container-peliculas-populares">
              <section class="peliculas">
                @foreach($peliculas as $pelicula)
                <div class="flip-card">
                    <div class="cuadro-film flip-card-inner">
                      <div class="flip-card-front">
                        <p class="puntuacion puntuacion-muy-buena">{{$pelicula['puntaje']}}</p>
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
              </section>
            </div>
            <br>
            <h3> Series Populares</h3>
            <section class="series">
                  @foreach($series as $serie)
                        <div class="cuadro-film">
                            <a href="/films/{{$serie['id']}}">
                                <img class="poster" src="data:image/png;base64,{{$serie['portada']}}">
                            </a>
                            <div> {{$serie['puntaje']}}</div>
                            <p class="titulo-film">{{ $serie['titulo']}}</p>
                        </div>

                  @endforeach
            </section>
        </section>

        <section class="users-populares">
          <div class="ranking tabla">
            <h3> Ranking Usuarios</h3>
            <table>
                      <tr>
                        <td>Usuario</td>
                        <td>Reviews</td>
                        <td>Puntos</td>
                      </tr>
                @foreach($users as $user)
                      <tr>
                          <div class="tupla-user">
                              <td><a href="/users/{{$user['username']}}"> {{$user['username']}}</a></td>
                              <td>100</td> <!--aca irian las reviews totales del user-->
                              <td>{{$user['puntos']}}</td>
                          </div>
                      </tr>
                @endforeach
            </table>
          </div>
        </section>
    </div>

  @endsection
