@extends('layouts.app')

@section('title') Noticia | MVJ Reviews @endsection

@section('publics')

@endsection

@section('content')
      <div class="news">
          <h1>{{$news['titulo']}}</h1>
          <h2>{{$news['copete']}}</h2>
          <img src="data:image/png;base64, {{$news['portada']}}" alt="">
          <div class="content">
            {!! $news['cuerpo'] !!} <!-- EN HTML -->
          </div>
          <p>{{$news['fuente']}}</p>
      </div>
@endsection
