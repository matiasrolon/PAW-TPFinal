@extends('layouts.app')

@section('title') Noticia | MVJ Reviews @endsection

@section('publics')
    <link href="{{ asset('css/novelties/news.css',false) }}" rel="stylesheet">
@endsection

@section('content')
<section class="noticias">
      <div class="noticia">
          <h1>{{$news['titulo']}}</h1>
          <h2>{{ date('d-m-Y', strtotime($news['fecha'])) }} - {{$news['copete']}}</h2>
          <img src="data:image/png;base64, {{$news['portada']}}" alt="">
          <div class="content">
            {!! $news['cuerpo'] !!} <!-- EN HTML -->
          </div>
          <h5>Fuente: {{$news['fuente']}}</h5>
      </div>
</section>
@endsection
