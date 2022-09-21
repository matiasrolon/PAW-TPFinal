@extends('layouts.app')

@section('title') MVJ Reviews | Club de cine @endsection

@section('publics')
    <meta name="description" content="Foro club de cine para cinefilos. Lea sobre novedades, criticas y opiniones sobre cine y series de television">
    <meta name="keywords" content="Cine, Series, TV, Foro, Club, Criticas, Reviews, Cinefilos, Novedades, Noticias, Debate">
    <link href="{{ asset('css/home.css', false) }}" rel="stylesheet">
    <script src="{{ asset('js/peliculasGenero.js', false) }}" charset="utf-8"></script>
    <script src="{{ asset('js/filmCardData.js', false) }}" charset="utf-8"></script>
    <script src="{{ asset('js/home.js', false) }}" charset="utf-8"></script>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            FilmCardData.modificarPuntajeClase();
            Home.iniciarPagina();
            PeliculaGenero.load();
        });
    </script>
@endsection

@section('content')
    <div class="content">
        <div class="generos-container">
            {{-- Icono de volver atras para celulares (responsive) --}}
            <i class="fas fa-angle-left icon-angle"></i>
            <ul class="generos">
                @foreach ($generos as $genero)
                    <li value="{{ $genero['id'] }}"
                        onclick="PeliculaGenero.setGenre({{ $genero['id'] }})">
                        {{ $genero['nombre'] }}
                    </li>
                @endforeach
            </ul>
            {{-- Icono de ir adelante para celulares (responsive) --}}
            <i class="fas fa-angle-right icon-angle"></i>
        </div>

        <section id="container1" class="films-populares">
            <div id="spinner-genre" class="loading-spin no-visible"></div>
            @if($genreId == null)
                <h3 id="movies-title">Peliculas Populares</h3>
            @else
                <h3 id="movies-title">Top de Peliculas de {{ $generos[$genreId-1]->nombre }}</h3>
            @endif
            <div class="container-peliculas">
                <section id="section-peliculas" class="peliculas">
                    @foreach ($peliculas as $pelicula)
                        <div class="flip-card">
                            <a style="display:block" href="/films/{{ $pelicula['id'] }}">
                                <div class="cuadro-film flip-card-inner">
                                    <div class="flip-card-front">
                                        <p class="puntuacion">{{ number_format($pelicula['puntaje'], 1) }}</p>
                                        @if ($pelicula['portada'] == null)
                                            <img class="poster" src="images/noimage.jpg">
                                        @else
                                            <img class="poster" src="data:image/png;base64,{{ $pelicula['portada'] }}">
                                        @endif
                                    </div>
                                    <!-- <a style="display:block" href="/films/{{ $pelicula['id'] }}"> -->
                                    <div class="flip-card-back">
                                        <p>{{ date('d-m-Y', strtotime($pelicula['fecha_estreno'])) }}</p>
                                        <p class="titulo-film">{{ $pelicula['titulo'] }}</p>
                                        <p>{{ str_limit($pelicula['sinopsis'], $limit = 100, $end = '...') }}</p>
                                    </div>
                                    <!-- </a> -->
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <button id="btn-fetch-movies" class="btn-fetch"
                        onclick="PeliculaGenero.fetchFilms('Pelicula')">
                    Cargar más
                </button>
            <br>
            @if($genreId == null)
                <h3 id="series-title">Series Populares</h3>
            @else
                <h3 id="series-title">Top de Series de {{ $generos[$genreId-1]->nombre }}</h3>
            @endif
            <div class="container-series">
                <section id="section-series" class="peliculas">
                    @foreach ($series as $serie)
                        <div class="flip-card">
                            <a style="display:block" href="/films/{{ $serie['id'] }}">
                                <div class="cuadro-film flip-card-inner">
                                    <div class="flip-card-front">
                                        <p class="puntuacion">{{ number_format($serie['puntuacion'], 1) }}</p>
                                        <img class="poster" src="data:image/png;base64,{{ $serie['portada'] }}">
                                    </div>
                                    <div class="flip-card-back">
                                        <p>{{ date('d-m-Y', strtotime($serie['fecha_estreno'])) }}</p>
                                        <p class="titulo-film">{{ $serie['titulo'] }}</p>
                                        <p>{{ str_limit($serie['sinopsis'], $limit = 150, $end = '...') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </section>
                <button id="btn-fetch-series" class="btn-fetch"
                        onclick="PeliculaGenero.fetchFilms('Serie')">
                    Cargar más
                </button>
            </div>
        </section>

        <section class="users-populares">
            <div class="ranking-tabla">
                <h3>Ranking Usuarios</h3>
                <table>
                    <thead>
                        <th>Usuario</th>
                        <th>Reviews</th>
                        <th>Puntos</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="username"><a href="/users/{{ $user['username'] }}"> {{ $user['username'] }}</a>
                                </td>
                                <td>{{ $user['cantReviews'] }}</td>
                                <td>{{ number_format($user['puntos'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="container101">
                <ul class="ultimas-reviews-container">
                    @foreach ($reviews as $review)
                        <li review_id="{{ $review['review_id'] }}">
                            <p>@<a href="/users/{{ $review['username'] }}">{{ $review['username'] }}</a> dijo:</p>
                            <div class="comment">
                                <div class="comment-inner">
                                    <h3>{{ $review['review_titulo'] }}</h3>
                                    <p>"{{ str_limit($review['review_descripcion'], $limit = 100, $end = '...') }}..."</p>
                                    <p>Sobre: <a href="/films/{{ $review['film_id'] }}">{{ $review['film_titulo'] }}</a>
                                    </p>
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
