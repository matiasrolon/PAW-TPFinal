@extends('layouts.app')

@section('title') {{ $film['titulo'] }} | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/film_profile.js') }}"></script>
    <script>Pagina.iniciarPagina("content");</script>
      <link href="{{ asset('css/film_profile.css') }}" rel="stylesheet">
@endsection

@section('content')
            <div id="page_info" class="content" film="{{ $film['id'] }}" user="@guest{{ -1 }}@else{{ Auth::user()->id }}@endguest">
                <section class="info-film">
                    <img class="poster" src="data:image/png;base64,{{$film['poster']}}">
                    <div class="detalles-pelicula">
                      <ul>
                        <h2>{{ $film['titulo'] }} </h2>
                        <li> <strong>Categoria:</strong> {{ $film['categoria'] }} </li>
                        <li> <strong>Sinopsis:</strong> {{ $film['sinopsis'] }} </li>
                        <li> <strong>Fecha de estreno:</strong> {{ $film['fecha_estreno'] }} </li>
                        @if ( ($film['fecha_finalizacion']) )
                          <li> <strong>Fecha de finalizacion:</strong> {{ $film['fecha_finalizacion'] }} </li>
                        @endif
                        <li> <strong>Pais:</strong> {{ $film['pais'] }} </li>
                        <li> <strong>Genero:</strong>
                          @if ( count($generos) > 0 )
                            {{-- Lo mismo que hacer un forEach a mano --}}
                            {{ $generos->pluck('nombre')->implode(', ') }}
                          @else
                            No disponible
                          @endif
                        </li>
                        <li> <strong>Puntaje:</strong> {{ $film['puntaje'] }} </li>
                      </ul>
                    </div>
                  <!-- AGREGAR MAS CAMPOS ;SI ES NECESARIO. -->
                </section>

                <section class="opciones-film">
                      <div class="acciones">
                            <div class="iconos-puntaje">
                            	<div class="estrella"  data-value="1" >&#9733; <p>1</p></div>
                            	<div class="estrella"  data-value="2" >&#9733;<p>2</p></div>
                            	<div class="estrella"  data-value="3" >&#9733;<p>3</p></div>
                            	<div class="estrella"  data-value="4" >&#9733;<p>4</p></div>
                            	<div class="estrella"  data-value="5" >&#9733;<p>5</p></div>
                              <div class="estrella"  data-value="6" >&#9733;<p>6</p></div>
                              <div class="estrella"  data-value="7" >&#9733;<p>7</p></div>
                              <div class="estrella"  data-value="8" >&#9733;<p>8</p></div>
                              <div class="estrella"  data-value="9" >&#9733;<p>9</p></div>
                              <div class="estrella"  data-value="10" >&#9733;<p>10</p></div>
                            </div>
                            <label class="info-puntaje"> </label>
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
                                  @isset ($reviewIni)
                                  <div class="review-user inicial">
                                      <section class="info-review-user">
                                        <label>
                                          usuario:  <a href="{{ route('user_profile', $reviewIni['username']) }}">{{ $reviewIni['username'] }}</a>
                                        </label>
                                        <label>
                                          Fecha: {{ $reviewIni['created_at']->format('d-m-Y') }}
                                        </label>
                                        <label>
                                          titulo: {{ $reviewIni['titulo'] }}
                                        </label>
                                        <label for=""> Likes: {{ $reviewIni['positivos'] }}
                                            <button type="button" class="like-review" review="{{$reviewIni['id']}}" user="{{$reviewIni['user_id']}}" name="button">Like</button>
                                        </label>
                                        <label for=""> Dislikes: {{ $reviewIni['negativos'] }}
                                            <button type="button" class="dislike-review" review="{{$reviewIni['id']}}" user="{{$reviewIni['user_id']}}" name="button">Dislike</button>
                                        </label>
                                        <div review="{{$reviewIni['id']}}" class="estado-puntaje-review">
                                            <label class="descripcion"> </label>
                                        </div>
                                      </section>
                                      <section class="descripcion-review-user">
                                        <label>
                                          descripcion: {{ $reviewIni['descripcion'] }}
                                        <label>
                                      </section>
                                  </div>
                                  @endisset <!-- fin primer review -->
                                  @if (count($reviews)>0)
                                    @foreach ($reviews as $review)
                                      <div class="review-user">
                                          <section class="info-review-user">
                                            <label>
                                              usuario:  <a href="{{ route('user_profile', $review['username']) }}">{{ $review['username'] }}</a>
                                            </label>
                                            <label>
                                              Fecha: {{ $review['created_at']->format('d-m-Y') }}
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
