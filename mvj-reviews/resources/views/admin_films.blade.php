@extends('layouts.app')

@section('title') Admin Films | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/admin_films.css') }}" rel="stylesheet">
  <script src="{{ asset('js/admin_films.js') }}"></script>
  <script>AdminFilms.iniciarPagina("content");</script>
@endsection

@section('content')

<div class="pendientes">
              <p>Busquedas sin resultados</p>
    @foreach ($searches as $search)
      <div text="{{ $search['busqueda'] }}" class="busqueda">
            <div class="info-busqueda">
                <p>{{ $search['busqueda'] }}</p>
                <p><b>({{$search['cant_busquedas']}} veces)</b></p>
            </div>
              <button class="resolver-busqueda" type="button" name="button">Resuelto</button>
      </div>
    @endforeach
</div>
<div class="administrador-films">
      <div class="">
              <input id="buscadorFilms" type="text" name="" value="" placeholder="buscar film">
              <select name="select">
                    <option value="value1">TheMovieDB</option>
                    <option value="value2" selected>MVJ Reviews</option>
                    <option value="value3">Ambos</option>
              </select>
              <button type="button" name="button" id="btnBuscadorFilms">Buscar</button>
      </div>
      <div class="resultados">
      </div>
      <div class="botones-opciones">
            <button class="boton-opcion" type="button" name="button">GUARDAR</button>
            <button class="boton-opcion" type="button" name="button">MODIFICAR</button>
            <button class="boton-opcion" type="button" name="button">ELIMINAR</button>
      </div>
</div>

@endsection
