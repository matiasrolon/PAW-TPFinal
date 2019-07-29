@extends('layouts.app')

@section('title') Noticia del Dia | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/novelties/news.js') }}"></script>
    <script>Noticias.iniciarNoticias("content");</script>
    <link href="{{ asset('css/novelties/news.css') }}" rel="stylesheet">
@endsection

@section('content')
<p></p>
<textarea id="texto" name="name" rows="8" cols="80"></textarea>
<button id="boton" type="button" name="button" > SELECCIONAR TEXTO </button>
  @foreach ($noticias as $noticia)
        <div class="">
          <p>

            <b>{{$noticia['id']}} : {{$noticia['titulo']}}</b>
            {{$noticia['cuerpo']}}
            {{$noticia['portada']}}
            <img src="{{$noticia['portada']}}" alt="">
          </p>
          <br>
        </div>
  @endforeach
@endsection
