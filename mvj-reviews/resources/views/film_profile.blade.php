@extends('layouts.app')

@section('title') {{ $film['titulo'] }} | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/film_profile.js') }}"></script>
    <script>Pagina.iniciarPagina("content");</script>
      <link href="{{ asset('css/film_profile.css') }}" rel="stylesheet">
@endsection

@section('content')
            <div id="page_info" class="content" film="{{ $film['id'] }}" user="@guest{{ -1 }}@else{{ Auth::user()->id }}@endguest">
                <section class="resultado-seleccionado info-film">
                    <img class="poster" src="data:image/png;base64,{{$film['poster']}}">
                    <div class="detalles-pelicula">
                      <ul>
                        <h2>{{ $film['titulo'] }} </h2>
                        <li class="puntuacion-pelicula"><h4>{{ number_format($film['puntaje'], 1) }}</h4><h2>/10</h2></li>
                        <li> <label>Sinopsis:</label> <p>{{ $film['sinopsis'] }} </p> </li>
                        <li> <label>Fecha de estreno:</label> <p>{{ $film['fecha_estreno'] }}</p> </li>
                        @if ( ($film['fecha_finalizacion']) )
                          <li> <label>Fecha de finalizacion:</label>  <p>{{ $film['fecha_finalizacion'] }} </p> </li>
                        @endif
                        <li> <label>Pais:</label> <p>{{ $film['pais'] }}</p> </li>
                        <li>
                          <ul class="generos">
                          @if ( count($generos) > 0 )
                              @foreach ($generos as $genero)
                              <li>{{ $genero['nombre'] }}</li>
                              @endforeach
                          @else
                            No disponible
                          @endif
                          </ul>
                        </li>
                      </ul>
                    </div>
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

                      <div class="container reviews-film-container">
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
                                            <label>
                                              usuario:  <a href="{{ route('user_profile', $review['username']) }}">{{ $review['username'] }}</a>
                                            </label>
                                            <label>
                                              Fecha: {{ $review['created_at'] }}
                                            </label>
                                            <label>
                                              titulo: {{ $review['titulo'] }}
                                            </label>
                                            <label for=""> Likes: {{ $review['positivos'] }}
                                                <button type="button" class="like-review" review="{{$review['id']}}" user="{{$review['user_id']}}" name="button">Like</button>
                                            </label>
                                            <label for=""> Dislikes: {{ $review['negativos'] }}
                                                <button type="button" class="dislike-review" review="{{$review['id']}}" user="{{$review['user_id']}}" name="button">Dislike</button>
                                            </label>
                                            <div review="{{$review['id']}}" class="estado-puntaje-review">
                                                <label class="descripcion"> </label>
                                            </div>
                                          </section>
                                          <section class="descripcion-review-user">
                                            <label>
                                              descripcion: {{ $review['descripcion'] }}
                                            <label>
                                          </section>
                                      </div>
                                    @endforeach
                                  @else
                                    <p class="no-reviews">Aun no hay reviews hechas para este film. </p>
                                  @endif
                          </div> <!-- fin div info-reviews -->
                          <div class="opcion trailer">

                          </div><!-- fin div opcion trailer -->
                          <div class="opcion agregarReview">
                            <form class="form-agregar-review" method="post">
                                  <label for="titulo-review"> Titulo: </label>
                                  <input type="text" class="titulo-review" placeholder="Titulo">
                                  <label for="descripcion-review"> Review: </label>
                                  <input type="text" class="descripcion-review" placeholder="Ingrese review aqui">
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
