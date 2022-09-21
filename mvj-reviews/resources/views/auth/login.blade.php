@extends('layouts.app')

@section('publics')
    <meta name="description" content="Logueate para poder escribir y puntuar criticas">
    <link href="{{ asset('css/login.css',true) }}" rel="stylesheet">
@endsection

@section('content')
<div class="welcome-card">
    <h2 class="tittle">
        BIENVENIDO A MVJ REVIEWS
    </h2>

    <p class="description"> Sitio especializado en criticas de contenido audiovisual.</p>
    <p> Aqui podras ver lo mas destacado en la actualidad sobre: </p>
    <ul>
        <li>Peliculas, series, cortometrajes, etc.</li>
        <li>Estrenos</li>
        <li>Noticias del ambiente</li>
        <li>Premios y Festibales</li>
        <li>Las mejroes criticas amateurs</li>
    </ul>
    <div class="register-link-desktop">
        ¿Todavia no sos un critico?
        <a class="btn btn-link" href="{{ route('register') }}">
          <button class="btn-mvj register" type="button" name="button">
              Crear Cuenta
          </button>
        </a>
    </div>
</div>
<div class="login-card">
    <div class="login-card-header">{{ __('Iniciar Sesión') }}</div>

    <div class="login-card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label for="username" >{{ __('Usuario') }}</label>

                <div>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="field">
                <label for="password" >{{ __('Contraseña') }}</label>

                <div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Recordarme') }}
                </label>
            </div>

            <div >
                <div class="login-btn-cnt" >
                    <button type="submit" class="btn-mvj login">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>
                <div class="register-link-mobile">
                    ¿Todavia no sos un critico?
                    <a class="btn btn-link" href="{{ route('register') }}">
                      <button class="btn-mvj register" type="button" name="button">
                          Crear Cuenta
                      </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
