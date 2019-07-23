@extends('layouts.app')

@section('title') Admin novedades | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/novelties/admin.js') }}"></script>
    <script>Novedades.iniciarNovedades("content");</script>
    <link href="{{ asset('css/novelties/admin.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="admin">

    <div class="create-options initial">
        <div class="option premiere">
            CREAR ESTRENO
        </div>
        <div class="option news">
            CREAR NOTICIA
        </div>
        <div class="option award">
            CREAR PREMIOS
        </div>
    </div>
    <div class="forms-noveties no-visible" >
        <div class="form news">

        </div>
        <div class="form premiere no-visible">

        </div>
        <div class="form award no-visible">

        </div>

    </div>

  </div>
@endsection
