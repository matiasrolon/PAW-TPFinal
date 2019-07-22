@extends('layouts.app')

@section('title') Noticia del Dia | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/newness/noticias.js') }}"></script>
    <script>Noticias.iniciarNoticias("content");</script>
    <link href="{{ asset('css/newness/noticias.css') }}" rel="stylesheet">
@endsection

@section('content')

  @foreach ($noticias as $noticia)
        <div class="">
          <p>
            <b>{{$noticia['titulo']}}</b>
            {{$noticia['cuerpo']}}
          </p>
          <br>
        </div>
  @endforeach
@endsection
