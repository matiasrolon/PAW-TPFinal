@extends('layouts.app')

@section('title') Perfil | MVJ Reviews @endsection

@section('content')
            <div class="content">
                <div class="title m-b-md">
                     {{-- @guest = persona no logeada en la pagina.  (Y asi se comenta en blade) --}}

                    @if ((@auth) && (Auth::user()->username == $user['username']))
                      <button> EDITAR PERFIL</button>(SIN FUNCIONALIDAD)
                    @else
                      <p> Estas en el perfil del usuario {{$user['username']}} </p>
                    @endif
                      <div >
                        <h2>Datos usuario</h2>
                        <br>
                        @if ($user['poster']==null)
                          <img class="avatar" src="{{asset('images/default_avatar.png')}}">
                        @else
                          <img class="avatar" src="data:image/png;base64,{{$user['avatar']}}">
                        @endif

                        {{$user}}
                      </div>
                      <div >
                        <h2>Reviews (Definir si mostrar recientes o todas ) </h2>

                        @if (count($reviews)>0)
                            @foreach ($reviews as $review)
                              <div class="review-user">
                                <label for=""> <b> Review: </b> {{ $review['titulo'] }}</label>
                                <label for=""> <b> Puntos review: </b> {{ $review['puntaje_total'] }} </label>
                                <label for=""> <b> Pelicula: </b> {{ $review['pelicula'] }}</label>
                                <img class="poster" src="data:image/png;base64,{{$review['poster']}}">
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
