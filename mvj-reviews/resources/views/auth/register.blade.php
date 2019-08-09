@extends('layouts.app')
@section('publics')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection

@section('content')
            <div class="register-card">
                <div class="register-card-header">{{ __('Registrarme') }}</div>

                <div class="register-card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="field">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                            <div class="value">
                                <input id="name" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="field">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('nickname') }}</label>
                            <div class="value">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="field">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="value">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div  class="field">
                            <label for="password" >{{ __('Contraseña') }}</label>
                            <div class="value">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="field" >
                            <label for="password-confirm" >{{ __('Confirmar contra') }}</label>

                            <div class="value">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="btn-register">
                              <button type="submit" class="btn-mvj register">
                                  {{ __('Registrarme') }}
                              </button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="welcome-card">
                <h2 class="tittle">
                    ¿Porque unirse a esta Comunidad?
                </h2>

                <p class="description"> La reputacion de una obra la hacemos entre todos, no solo una elite</p>
                <div class="images">
                          <img class="field avatar" src="{{asset('images/votar-review.png')}}">
                          <img class="field avatar" src="{{asset('images/votar-film.png')}}">
                          <img class="field avatar" src="{{asset('images/buscador.png')}}">
                </div>
                <p>Puntua films, likea Reviews, encontra info de cualquier film</p>
                <p class="final-msj"> Registrate y disfruta la mejor interaccion con el mundo cinefilo!</p>
@endsection
