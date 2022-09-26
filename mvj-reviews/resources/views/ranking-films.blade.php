@extends('layouts.app')

@section('title') MVJ Reviews | Ranking Films @endsection

@section('publics')
    <meta name="description" content="Ranking de peliculas y series segun los usuarios registrados">
    <link href="{{ asset('css/ranking_films.css',false) }}" rel="stylesheet">
@endsection

@section('content')
<section class="rank">
  <h2>Ranking films de MVJ</h2>
  <table class="table-rank">
    <thead class="col-attributes">
      <th class="position"></th>
      <th class="filmname">Titulo</th>
      <th class="category">Categoria</th>
      <th class="date">Estreno</th>
      <th class="pais">Pais</th>
      <th>Puntaje</th>
    </thead>
    <tbody>
      @foreach($films as $indexKey => $film)
        <tr class="film-position">
          <td class="position">{{$indexKey +1}}</td>
          <td class="filmname">
              <a href="{{ route('film_profile', $film['id']) }}" class="link-film">
                @if ($film['poster64'] == null)
                    <img src="/images/noimage.jpg" class="poster" alt="{{$film['titulo']}} (portada no disponible)">
                @else
                    <img src="data:image/png;base64,{{$film['poster64']}}" class="poster" alt="{{$film['titulo']}}">
                @endif
                {{ str_limit($film['titulo'], $limit = 40, $end = '...') }}
              </a>
          </td>
          <td class="category">{{ $film['categoria'] }}</td>
          <td class="date">{{ date('d-m-Y', strtotime($film['fecha_estreno'])) }}</td>
          <td class="pais">{{ $film['pais'] }}</td>
          <td>{{ number_format($film['puntaje'], 2) }}</td>
        </tr>
      @endforeach
      </tbody>
  </table>
</section>

@endsection
