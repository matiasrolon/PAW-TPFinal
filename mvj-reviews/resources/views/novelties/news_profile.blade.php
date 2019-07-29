@extends('layouts.app')

@section('title') Noticia | MVJ Reviews @endsection

@section('publics')

@endsection

@section('content')
      <div class="news">
          <h1>{{$news['titulo']}}</h1>
          <h2>{{$news['copete']}}</h2>
          <div class="content">
            {!! $news['cuerpo'] !!} <!-- EN HTML -->
          </div>
      </div>
@endsection
