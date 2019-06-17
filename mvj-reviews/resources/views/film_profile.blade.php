@extends('layouts.app')

@section('title') pelicula | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/film_profile.js') }}"></script>
    <script>Pagina.iniciarPagina("content");</script>
      <link href="{{ asset('css/film_profile.css') }}" rel="stylesheet">
@endsection

@section('content')
            <div id="page_info" class="content" film="{{ $film['id'] }}" user="@guest{{ -1 }}@else{{ Auth::user()->id }}@endguest">
                <section class="info-film">
                  <h2>Info pelicula:</h2>
                    <img class="poster" src="data:image/png;base64,{{$film['poster']}}">
                    <div> {{ $film['titulo'] }} </div>
                    <div> {{ $film['fecha_estreno'] }} </div>
                    <div> {{ $film['pais'] }} </div>
                    <div> {{ $film['sinopsis'] }} </div>
                    <div> {{ $film['categoria'] }} </div>
                  <!-- AGREGAR MAS CAMPOS ;SI ES NECESARIO. -->

                </section>

                <section class="opciones-film">
                      <div class="acciones">
                          <!-- QUITAR ESTA PARTE, HACERLA CON JAVASCRIPT -->
                          <!--para pruebas con AJAX por ahora el puntaje sera mandado mediante un input comun-->

                            <input id="puntajeFilm" type="number" name="puntos" min=0 max=10 value="" placeholder="">
                            <button id="enviarPuntaje" type="button" name="button"> Puntuar {{ $film['categoria'] }}</button>
                            <label class="info-puntaje"> </label>
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
                              <div class="item agregarReview flotante">
                                  AgregarReview
                              </div>
                          </nav>

                          <div id='info-reviews' href="#" class="opcion reviews">
                                  @if (count($reviews)>0)
                                    @foreach ($reviews as $review)
                                      <div class="review-user">
                                          <section class="info-review-user">
                                            <b>usuario: </b> <a href="{{ route('user_profile', $review['username']) }}">{{ $review['username'] }}</a>
                                            <b>Fecha: </b>{{ $review['created_at'] }}
                                            <b>titulo: </b>{{ $review['titulo'] }}
                                            <b>Likes: </b> {{ $review['positivos'] }}
                                            <b>Dislikes: </b> {{ $review['negativos'] }}
                                          </section>
                                          <section class="descripcion-review-user">
                                            <b>descripcion:</b> {{ $review['descripcion'] }}
                                          </section>
                                      </div>
                                    @endforeach
                                  @else
                                    <p>Aun no hay reviews hechas para este film. </p>
                                  @endif
                          </div> <!-- fin div info-reviews -->
                          <div class="opcion trailer">
                              <h1> ACA IRIA EL TRAILER DEL FILM </h1>
                          </div><!-- fin div opcion trailer -->
                          <div class="opcion agregarReview">
                            <form class="form-agregar-review" method="post">
                                  <label for="titulo-review"> titulo
                                      <input type="text" class="titulo-review" placeholder="Titulo">
                                  </label>
                                  <label for="descripcion-review"> Critica
                                      <input type="text" class="descripcion-review" placeholder="Ingrese review aqui">
                                  </label>
                                      <input id="enviarReview" type="button" name="button" value="Enviar Review">
                            </form>
                            <div class="estado">
                                  <label class="descripcion-estado"> </label>
                            </div>
                          </div><!-- fin div opcion agregarReview -->
                      </div>  <!-- fin div container -->
                </section> <!-- fin section opciones-film -->
            </div> <!-- fin div contenedor principal -->

  @endsection
