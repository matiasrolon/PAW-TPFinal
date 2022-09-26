@extends('layouts.app')

@section('title') MVJ Reviews | Noticias @endsection

@section('publics')
    <meta name="description" content="Noticias de actualidad sobre el mundo del cine">
    <script src="{{ asset('js/novelties/news.js',false) }}"></script>
    <script>Noticias.iniciarNoticias("content");</script>
    <link href="{{ asset('css/novelties/news.css',false) }}" rel="stylesheet">
@endsection

@section('content')
<section class="noticias">
    <h1> Noticias </h1>
    <div class="list-news">
        @foreach ($noticias as $noticia)
            <div class="news">
                <a href="/novelties/news/{{ $noticia['id'] }}">
                    <span class="fecha">{{ date('d-m-Y', strtotime($noticia['fecha'])) }}</span>
                    <h3>{{$noticia['titulo']}}</h3>
                    <img class="portada" src="data:image/png;base64,{{$noticia['portada']}}" alt="Portada de la noticia">
                    {{-- <b>{{$noticia['titulo']}}</b> --}}
                    <p>{{$noticia['copete']}}</p>
                </a>
            </div>
        @endforeach
    </div>
</section>
@endsection
