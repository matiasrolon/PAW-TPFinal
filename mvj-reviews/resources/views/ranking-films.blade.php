@extends('layouts.app')

@section('title') Ranking Films | MVJ Reviews @endsection

@section('publics')
  <!-- <link href="{{ asset('css/home.css') }}" rel="stylesheet"> -->
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
                <img src="data:image/png;base64,{{$film['poster64']}}" class="poster" alt="">
                <div>{{ str_limit($film['titulo'], $limit = 40, $end = '...')  }}</div>
              </a>
          </td>
          <td class="category">{{ $film['categoria'] }}</td>
          <td class="date">{{ date('d-m-Y', strtotime($film['fecha_estreno'])) }}</td>
          <td class="pais">{{ $film['pais'] }}</td>
          <td>{{ number_format($film['puntaje'], 2) }}</td>
            <!-- </div> -->
        </tr>
      @endforeach
      </tbody>
  </table>
</section>

@endsection
