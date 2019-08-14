@extends('layouts.app')

@section('title') Estrenos | MVJ Reviews @endsection

@section('publics')
<script src="{{ asset('js/novelties/premieres.js',false) }}"></script>
<script>
  Premieres.startPremieres("content");
</script>
<link href="{{ asset('css/novelties/premieres.css',false) }}" rel="stylesheet">
@endsection

@section('content')

<section id="container1" class="estrenos">
  <h1>Pr&oacute;ximos estrenos</h1>

  @for ($i = 0; $i <= 11; $i++)
    <section class="mes">
      <h2>{{ $meses[ ($mesActual + $i) % 12 ] }}</h2>
      <div class="pelicula">
        @if ( $premieres[($mesActual + $i) % 12]->isEmpty() )
          <h3>No hay estrenos</h3>
        @else
          @foreach($premieres[($mesActual + $i) % 12] as $premiere)
          <div class="flip-card">
            <a style="display:block" href="/films/{{$premiere['id']}}">
              <div class="cuadro-film flip-card-inner">
                <div class="flip-card-front">
                  <img class="poster" src="data:image/png;base64,{{$premiere['portada']}}">
                </div>
                <div class="flip-card-back">
                  <p>{{ date('d-m-Y', strtotime($premiere['fecha_estreno'])) }}</p>
                  <p class="titulo-film">{{ $premiere['titulo']}}</p>
                  <p>{{ str_limit($premiere['sinopsis'], $limit = 90, $end = '...') }}</p>
                </div>
              </div>
            </a>
          </div>
          @endforeach
        @endif
      </div>
    </section>
  @endfor
</section>

@endsection
