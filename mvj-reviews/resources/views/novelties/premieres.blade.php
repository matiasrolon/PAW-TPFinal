@extends('layouts.app')

@section('title') Estrenos | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/novelties/premieres.js') }}"></script>
    <script>Estrenos.iniciarEstrenos("content");</script>
    <link href="{{ asset('css/novelties/premieres.css') }}" rel="stylesheet">
@endsection

@section('content')

@foreach ($estrenos as $estreno)
      <div class="">
        <p>
          <b>{{$estreno['titulo']}}</b>
          {{$estreno['cuerpo']}}
        </p>
        <br>
      </div>
@endforeach


@endsection
