@extends('layouts.app')

@section('title') {{ $searchText }} | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/home.css',false) }}" rel="stylesheet">
@endsection

@section('content')

<h2>Resultados para "{{ $searchText }}"<h2>
  @if (count($results) > 0)
        @foreach ($results as $result)
          <div class="result">
            <a href="/films/{{$result['id']}}">
                  <label class="info-result" for="">  {{ $result['titulo'] }}</label>
          </div>
        @endforeach
 @else
      <h3> No se encontraron resultados </h3>
 @endif

@endsection
