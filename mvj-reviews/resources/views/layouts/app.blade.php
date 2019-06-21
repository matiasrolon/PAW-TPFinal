<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title')</title>


    @yield('publics')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/navApp.js') }}"></script>
    <script>NavPrincipal.iniciarNavPrincipal("app");</script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="nav-principal">
            <div class="navseccion icono">
                <a class="" href="{{ url('/') }}">
                  MVJ Reviews
                </a>
                <button class="" type="button" aria-label="{{ __('Toggle navigation') }}">
                    <span class=""></span>
                </button>
            </div>
            <div class="navseccion buscador">
                    <input id="buscador" class="buscador" name="buscar" placeholder="buscar film">
            </div>
            <div class="navseccion autenticacion">
                        @guest
                          <ul class="opciones-guest">
                                    <a class="" href="{{ route('login') }}">{{ __('Login') }}</a>
                                  |
                              @if (Route::has('register'))
                                    <a class="" href="{{ route('register') }}">{{ __('Register') }}</a>
                              @endif
                          </ul>
                        @else
                                <li class="">
                                    <a class="" href="#">
                                        {{ Auth::user()->username }} <span class=""></span>
                                        <button class="boton-opciones-login" type="button" name="button"> > </button>
                                    </a>

                                      <ul class="opciones-login no-visible">
                                          <li>
                                            <a class="" href="{{ route('user_profile', Auth::user()->username) }}">
                                                {{ __('perfil') }}
                                            </a>
                                          </li>
                                          <li>
                                                <a class="" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                    {{ __('Salir') }}
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                          </li>
                                      </ul>
                               </li>
                        @endguest
            </div>
        </nav>

        <nav class="menus">
            <div class="seccion-menu">
                  <a href="{{ route('home') }}">Home</a>
            </div>

            <div class="seccion-menu">
                  <a href="{{ route('ranking-films') }}">Ranking films</a>
            </div>

            <div class="seccion-menu">
                  <a href="{{ route('ranking-users') }}">Ranking Criticos</a>
            </div>

            <div class="seccion-menu">
                  <a href=""> Novedades </a>
            </div>
            @auth
                @if ( Auth::isAdmin() )
                  <div class="seccion-menu">
                      <a href=""> Admin Films </a>
                  </div>
                  <div class="seccion-menu">
                      <a href=""> Admin Novedades </a>
                  </div>
                  @endif
            @endauth
        </nav>
        <main id="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
