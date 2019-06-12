@extends('layouts.app')

@section('title') Home | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="content">
        <section class="films-populares">

            <h3> Peliculas Populares</h3>
            <section class="peliculas">
              @foreach($peliculas as $pelicula)

                  <div class="cuadro-film">
                    <a href="/films/{{$pelicula['id']}}">
                        <img class="poster" src="data:image/png;base64,{{$pelicula['portada']}}">
                    </a>
                    <div> {{$pelicula['puntaje']}}</div>
                    <p class="titulo-film">{{ $pelicula['titulo']}}</p>
                  </div>

              @endforeach
            </section>
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
          <div class="ranking">
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
                              <td>{{$user['username']}}</td>
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
