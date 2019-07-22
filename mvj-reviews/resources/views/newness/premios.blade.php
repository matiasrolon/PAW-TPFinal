@extends('layouts.app')

@section('title') Premios | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/newness/premios.js') }}"></script>
    <script>Premios.iniciarPremios("content");</script>
    <link href="{{ asset('css/newness/premios.css') }}" rel="stylesheet">
@endsection

@section('content')
@foreach ($premios as $premio)
      <div class="">
        <p>
          <b>{{$premio['titulo']}}</b>
          {{$premio['cuerpo']}}
        </p>
          <br>
      </div>
@endforeach


@endsection
