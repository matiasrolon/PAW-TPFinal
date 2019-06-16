@extends('layouts.app')

@section('title') pelicula | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/film_profile.js') }}"></script>
    <script>Pagina.iniciarPagina("content");</script>
      <link href="{{ asset('css/film_profile.css') }}" rel="stylesheet">
@endsection

@section('content')
            <div class="content">
                <section class="info-film">
                  <h2>Info pelicula:</h2>
                    <img class="poster" src="data:image/png;base64,{{$film['poster']}}">
                    <div>{{ $film['titulo'] }}</div>
                    <div>{{ $film['fecha_estreno'] }}</div>
                    <div>{{ $film['pais'] }}</div>
                    <div>{{ $film['sinopsis'] }}</div>
                    <div>{{ $film['categoria'] }}</div>
                  <!-- AGREGAR MAS CAMPOS ;SI ES NECESARIO. -->
                  <br>
                </section>

                <section class="opciones-film">
                      <div class="acciones">
                          <!-- QUITAR ESTA PARTE, HACERLA CON JAVASCRIPT -->
                          <!--para pruebas con AJAX por ahora el puntaje sera mandado mediante un input comun-->>
                          <form class="" action="/rate-film" method="post">
                            <input type="number" name="puntos" min=0 max=10 value="" placeholder="">
                            <button type="button" name="button">Puntuar {{ $film['categoria'] }}</button>
                          </form>
                          <!-- ___________________________________________________________________________   -->
                      </div><!-- fin div acciones-film -->

                      <div class="container">
                          <nav class="menu">
                              <div class="item trailer">
                                trailer
                              </div>
                              <div class="item reviews">
                                  reviews
                              </div>
                              <div class="item agregarReview">
                                  AgregarReview
                              </div>
                          </nav>

                          <div class="opcion reviews">
                                  @if (count($reviews)>0)
                                    @foreach ($reviews as $review)
                                      <b>usuario: <b> <a href="{{ route('user_profile', $review['username']) }}">{{ $review['username'] }}</a>
                                      <b>Fecha: <b>{{ $review['created_at'] }}
                                      <b>titulo: <b>{{ $review['titulo'] }}
                                      <b>descripcion:<b> {{ $review['descripcion'] }}
                                      <b>Likes: <b> {{ $review['positivos'] }}
                                      <b>Dislikes: <b> {{ $review['negativos'] }}
                                      <br>
                                    @endforeach
                                  @else
                                    <p>Aun no hay reviews hechas para este film. </p>
                                  @endif
                          </div> <!-- fin div reviews-conteiner-opciones-film -->
                          <div class="opcion trailer">
                              <h1> ACA IRIA EL TRAILER DEL FILM </h1>
                          </div><!-- fin div trailer-container-opciones-film -->
                          <div class="opcion agregarReview">
                              <label for="titulo-review"> titulo </label>
                              <input type="text" name="titulo-review" value="">
                              <label for="descripcion-review"> Critica</label>
                              <input type="text" name="descripcion-review" value="">

                              <button type="button" name="button">Enviar Review</button>
                          </div><!-- fin div trailer-container-opciones-film -->
                      </div>  <!-- fin div conteiner-opciones-film -->
                </section> <!-- fin section opciones-film -->
            </div> <!-- fin div contenedor principal -->

  @endsection
