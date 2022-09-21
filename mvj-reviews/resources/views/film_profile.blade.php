@extends('layouts.app')

@section('title') MVJ Reviews | {{$film['titulo']}} @endsection

@section('publics')
    <meta name="description" content="Detalles sobre {{$film['titulo']}}. {{$film['sinopsis']}}">
    <link href="{{ asset('css/film_profile.css',false) }}" rel="stylesheet">
    <script src="{{ asset('js/film_profile.js',false) }}"></script>
    <script>Pagina.iniciarPagina("content");</script>
    <script type="application/ld+json">
        {!! $jsonLD !!}
    </script>
@endsection

@section('content')
<div id="page_info" class="content" data-film="{{ $film['id'] }}">
  <section class="resultado-seleccionado info-film opciones-film">
    <div class="poster-container">
      @if($film->poster == null)
        <img class="poster" src="/images/noimage.jpg" alt="Poster">
      @else
        <img class="poster" src="data:image/png;base64,{{$film['poster']}}" alt="Poster">
      @endif
    </div>
    <div class="detalles-pelicula">
      <ul>
        <li class="titulo-pelicula-head">
          <h2>{{ $film['titulo'] }} </h2>
          <span class="puntuacion-pelicula"><h4>{{ number_format($film['puntaje'], 1) }}</h4><h2>/10</h2></span>
        </li>
        <li> <label>Sinopsis:</label> <p>{{ $film['sinopsis'] }} </p> </li>
        <li class="extra-data">
          <i class="fas fa-tag"></i>
          <label>Datos:</label>
          <ul>
            @if ( ($film['fecha_estreno'] || $film['fecha_finalizacion'] || $film['pais']) )
              @if ( ($film['fecha_estreno']) )
              <li><label>Fecha de estreno: {{ date('d-m-Y', strtotime($film['fecha_estreno'])) }}</label> </li>
              @endif
              @if ( ($film['fecha_finalizacion']) )
              <li class="inline-data"> <label>Fecha de finalizacion: {{ date('d-m-Y', strtotime($film['fecha_finalizacion'])) }}</label></li>
              @endif
              @if ( ( $film['pais'] ) )
              <li class="inline-data"> <label>Pais: {{ $film['pais'] }}</label> </li>
              @endif
            @else
              <li class="inline-data"> No disponible </li>
            @endif
          </ul>
        <li>
        <ul class="generos">
            @if ( count($generos) > 0 )
            @foreach ($generos as $genero)
            <li>
                <a href="/home?genreId={{$genero['id']}}">{{ $genero['nombre'] }}</a>
            </li>
            @endforeach
            @else
            No disponible
            @endif
          </ul>
        </li>
      </ul>
    </div>
    <!-- AGREGAR MAS CAMPOS ;SI ES NECESARIO. -->

    <div class="acciones">
      <div class="iconos-puntaje">
        <div class="estrella"  data-value="1" ><i class="fas fa-star"></i> <p>1</p></div>
        <div class="estrella"  data-value="2" ><i class="fas fa-star"></i><p>2</p></div>
        <div class="estrella"  data-value="3" ><i class="fas fa-star"></i><p>3</p></div>
        <div class="estrella"  data-value="4" ><i class="fas fa-star"></i><p>4</p></div>
        <div class="estrella"  data-value="5" ><i class="fas fa-star"></i><p>5</p></div>
        <div class="estrella"  data-value="6" ><i class="fas fa-star"></i><p>6</p></div>
        <div class="estrella"  data-value="7" ><i class="fas fa-star"></i><p>7</p></div>
        <div class="estrella"  data-value="8" ><i class="fas fa-star"></i><p>8</p></div>
        <div class="estrella"  data-value="9" ><i class="fas fa-star"></i><p>9</p></div>
        <div class="estrella"  data-value="10" ><i class="fas fa-star"></i><p>10</p></div>
      </div>
      <label class="info-puntaje"> </label>
    </div><!-- fin div acciones-film -->

    <div class="container reviews-film-container">
      <nav class="menu">
        <div class="item trailer">
          <i class="fas fa-film"></i>
          <span>Trailer</span>
        </div>
        {{-- Solo permito reviews para los films que ya se estrenaron --}}
        @if ($film['fecha_estreno'] <= \Carbon\Carbon::today())
          <div class="item reviews">
            <i class="fas fa-newspaper"></i>
            <span>Reviews</span>
          </div>
          <div class="item agregarReview flotante">
            <i class="fas fa-plus-square"></i>
            <span> Agregar Review</span>
          </div>
        @endif
      </nav>

      <div id='info-reviews' href="#" class="opcion reviews">
        @isset ($reviewIni)
        <div class="review-user inicial">
          <section class="info-review-user">
            <label class="info-review-user-placeholder">
              @<a href="{{ route('user_profile', $reviewIni['username']) }}">{{ $reviewIni['username'] }}</a>
            </label>
            <label class="fecha-review">
              {{ $reviewIni['created_at']->format('d-m-Y') }}
            </label>

            <!-- <section class="descripcion-review-user info-review-descrip "> -->
            <label class="info-review-title">
              {{ $reviewIni['titulo'] }}
            </label>
            <!-- </section> -->
            <label class="info-review-descrip">
              {{ $reviewIni['descripcion'] }}
            </label>
            <label class="like-review" data-review="{{$reviewIni['id']}}" for="">
                <i class="fas fa-thumbs-up"></i> <p>{{ $reviewIni['positivos'] }}</p>
            </label>
            <label class="dislike-review" data-review="{{$reviewIni['id']}}"  for="">
                <i class="fas fa-thumbs-down"></i> <p>{{ $reviewIni['negativos'] }}</p>
            </label>
          </section>
        </div>
            @endisset <!-- fin primer review -->

            @if (count($reviews)>0)
            @foreach ($reviews as $review)
                @if ($review['id']!=$reviewIni['id'])
                  <div data-review="{{$review['id']}}" class="estado-puntaje-review">
                    <label class="descripcion"> </label>
                  </div>
                  <div class="review-user">
                    <section class="info-review-user">
                      <label class="info-review-user-placeholder">
                        @<a href="{{ route('user_profile', $review['username']) }}">{{ $review['username'] }}</a>
                      </label>
                      <label class="fecha-review">
                        {{ $review['created_at']->format('d-m-Y') }}
                      </label>

                      <!-- <section class="descripcion-review-user info-review-descrip "> -->
                      <label class="info-review-title">
                        {{ $review['titulo'] }}
                      </label>
                      <!-- </section> -->
                      <label class="info-review-descrip">
                        {{ $review['descripcion'] }}
                      </label>
                      <label class="like-review" data-review="{{$review['id']}}" for="">
                          <i class="fas fa-thumbs-up"></i> <p>{{ $review['positivos'] }}</p>
                      </label>
                      <label class="dislike-review" data-review="{{$review['id']}}"  for="">
                          <i class="fas fa-thumbs-down"></i> <p>{{ $review['negativos'] }}</p>
                      </label>
                    </section>
                  </div>
              @endif
            @endforeach
            @else
                <p class="no-reviews">Aun no hay reviews hechas para este film. </p>
              @endif
              </div> <!-- fin div info-reviews -->
              <div class="opcion trailer">
                @if ($film['trailer'] != '')
                <iframe src="{{ str_replace('watch?v=','embed/',$film['trailer']) }}" frameborder="0" allowfullscreen ng-show="showvideo"></iframe>
                @else
                <p class="no-reviews">Trailer no disponible.</p>
                @endif
              </div><!-- fin div opcion trailer -->
              <div class="opcion agregarReview">
                <form class="form-agregar-review" method="post">
                  <label for="titulo-review"> Titulo: </label>
                  <textarea type="text" class="titulo-review" placeholder="Titulo"></textarea>
                  <label for="descripcion-review"> Review: </label>
                  <textarea type="text" class="descripcion-review" placeholder="Ingrese review aqui"></textarea>
                  <br>
                  <input id="enviarReview" type="button" name="button" value="Enviar Review">
                </form>
                <div class="estado">
                  <label class="descripcion-estado no-visible"> </label>
                </div>
              </div><!-- fin div opcion agregarReview -->
            </div>  <!-- fin div container -->
          </section> <!-- fin section opciones-film -->
        </div> <!-- fin div contenedor principal -->

        @endsection
