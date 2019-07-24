@extends('layouts.app')

@section('title') Estrenos | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/novelties/premieres.js') }}"></script>
    <script>Premieres.startPremieres("content");</script>
    <link href="{{ asset('css/novelties/premieres.css') }}" rel="stylesheet">
@endsection

@section('content')

@foreach ($premieres as $premiere)
      <div class="">
        <p>
          <b>{{$premiere['titulo']}}</b>
          {{$premiere['fecha_estreno']}}
        </p>
        <br>
      </div>
@endforeach


@endsection
