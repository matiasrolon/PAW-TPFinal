@extends('layouts.app')

@section('title') {{$user['username']}} | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/user_profile.css') }}" rel="stylesheet">
  <script src="{{ asset('js/user_profile.js') }}" charset="utf-8"></script>
  <script>
    User.startProfile();
  </script>
@endsection

@section('content')
            <div class="content">

                    <h2 class="tittle-name">{{$user['username']}}</h2>
                    {{-- @guest = persona no logeada en la pagina.  (Y asi se comenta en blade) --}}
                   @guest
                   @else
                       @if (Auth::user()->username == $user['username'])
                         <button class="EditProfile"> Editar Perfil</button>
                       @else
                       @endif
                   @endguest
                      <div class="data-user" >
                        <br>
  <form action="{{ route('updateUser',$user['username']) }}" name="updateUser" method="POST" enctype="multipart/form-data">
        @csrf
                        <div class="info-avatar">
                            @if ($user['avatar']==null)
                              <img class="field avatar" src="{{asset('images/default_avatar.png')}}">
                            @else
                              <img class="field avatar" src="data:image/png;base64,{{$user['avatar']}}">
                            @endif
                            <input name="avatar" class="editable avatar no-visible" type="file">
                        </div>
                        <div class="info-personal">
                            <h3 class="tittle">Informacion personal</h3>
                            <!-- <label class="dato-usuario" for=""><b>Username: </b>{{$user['username']}}</label> -->
                            <label class="field personal name" for=""><b>Nombre: </b>
                                <input readonly type="text" name="name" value="{{$user['nombre']}}" required>
                            </label>
                            <label class="field personal email" for=""><b>Email: </b>
                                <input readonly type="text" name="email" value="{{$user['email']}}">
                            </label>
                            <label class="field personal birth_date" for=""><b>Fecha Nacimiento: </b>
                                <input readonly type="text" name="birth_date" value="{{$user['fecha_nacim']}}">
                            </label>
                        </div>
                        <div class="info-favourites">
                            <h3 class="tittle">Favoritos</h3>
                            <label class="field favourite genre" for=""><b>Genero: </b>
                                <input readonly type="text" name="genre_fav" value="{{$user['genero_fav']}}">
                            </label>
                            <label class="field favourite movie_fav" for=""><b>Pelicula: </b>
                                <input readonly type="text" name="movie_fav" value="{{$user['pelicula_fav']}}">
                            </label>
                            <label class="field favourite tv-series" for=""><b>Serie: </b>
                                <input readonly type="text" name="tvseries_fav" value="{{$user['serie_fav']}}">
                            </label>
                        </div>
                      </div>

                      <label class="field personal range" for=""><b>Rango: </b>
                          {{$user['rango']}}
                      </label>
                      <label class="field personal score" for=""><b>Puntos: </b>
                          {{$user['puntos']}}
                      </label>

                      <label class="field personal biography" for=""><h3>Biografia</h3>
                          <input readonly type="text" name="biography" value="{{$user['biografia']}}">
                      </label>

                      <div class="edit-options">
                        <input class="option btnSaveChanges no-visible" type="submit" value="Guardar" name="buttonSave">
                        <input class="option btnCancelChanges no-visible" type="button" value="Cancelar" name="buttonCancel">
                      </div>
      </form>
                      <h3>Reviews Recientes </h3>
                        @if (count($reviews)>0)
                          <div class="container-reviews">
                            @foreach ($reviews as $review)
                              <div class="review-user">
                                <a href="/films/{{$review['film_id']}}/{{$review['id']}}">
                                  <img class="poster" src="data:image/png;base64,{{$review['poster']}}">
                                  <div class="info-review-user">
                                    <label class="info-review" for=""> <b> Review: </b> {{ $review['titulo'] }}</label>
                                    <!-- <label class="info-review" for=""> <b> Puntos: </b> {{ $review['puntaje_total'] }} </label> -->
                                    <label class="info-review" for=""> <b> Likes: </b> {{ $review['puntaje_total'] }} </label>
                                    <!-- <label class="info-review" for=""> <b> Pelicula: </b> {{ $review['pelicula'] }}</label> -->
                                  </div>
                                </a>
                              </div>
                            @endforeach
                          </div>
                        @else
                            <p>Este critico aun no ha hecho reviews.</p>
                        @endif

                <!-- </div> -->
              </div>

  @endsection
