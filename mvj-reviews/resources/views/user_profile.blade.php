@extends('layouts.app')

@section('title') {{$user['username']}} | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/user_profile.css') }}" rel="stylesheet">
@endsection

@section('content')
            <div class="content">
                <div class="title m-b-md">
                     {{-- @guest = persona no logeada en la pagina.  (Y asi se comenta en blade) --}}

                    @guest
                      <p> Estas en el perfil del usuario {{$user['username']}} </p>
                    @else
                        @if (Auth::user()->username == $user['username'])
                          <button> EDITAR PERFIL</button>(SIN FUNCIONALIDAD)
                        @else
                          <p> Estas en el perfil del usuario {{$user['username']}} </p>
                        @endif
                    @endguest

                      <div class="planilla-usuario" >
                        <h2>Datos usuario</h2>
                        <br>
                        @if ($user['poster']==null)
                          <img class="avatar" src="{{asset('images/default_avatar.png')}}">
                        @else
                          <img class="avatar" src="data:image/png;base64,{{$user['avatar']}}">
                        @endif
                        <div class="info-usuario">
                            <label class="dato-usuario" for=""><b>Username: </b>{{$user['username']}}</label>
                            <label class="dato-usuario" for=""><b>Rango:</b>{{$user['rango']}}</label>
                            <label class="dato-usuario" for=""><b>Puntos:</b>{{$user['puntos']}}</label>
                            <label class="dato-usuario" for=""><b>Nombre :</b>{{$user['nombre']}}</label>
                            <label class="dato-usuario" for=""><b>Bio:</b>{{$user['Biografia']}}</label>
                            <label class="dato-usuario" for=""><b>Email:</b>{{$user['email']}}</label>
                        </div>
                        <div class="info-favoritos">
                            <label class="titulo-favoritos"> Favoritos </label>
                            <label class="dato-favorito" for=""><b>Genero </b>{{$user['genero_fav']}}</label>
                            <label class="dato-favorito" for=""><b>Pelicula </b>{{$user['pelicula_fav']}}</label>
                            <label class="dato-favorito" for=""><b>Serie </b>{{$user['serie_fav']}}</label>
                        </div>
                      </div>
                                              <h2>Reviews Recientes </h2>
                      <div class="container-reviews">

                        @if (count($reviews)>0)
                            @foreach ($reviews as $review)
                              <div class="review-user">
                                <a href="/films/{{$review['film_id']}}">
                                    <div class="info-review-user">
                                      <label class="info-review" for=""> <b> Review: </b> {{ $review['titulo'] }}</label>
                                      <label class="info-review" for=""> <b> Puntos review: </b> {{ $review['puntaje_total'] }} </label>
                                      <label class="info-review" for=""> <b> Pelicula: </b> {{ $review['pelicula'] }}</label>
                                    </div>
                                    <img class="poster" src="data:image/png;base64,{{$review['poster']}}">
                                </a>
                              </div>
                              <br>
                            @endforeach
                        @else
                            <p>Aun no hay reviews hechas para este film. </p>
                        @endif
                      </div>

                </div>
              </div>

  @endsection
