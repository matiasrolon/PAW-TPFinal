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
              <p><b>Buscado {{$search['cant_busquedas']}} veces</b></p>
                <p>{{ $search['busqueda'] }}</p>
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
      <div class="admin-resultados">
        <div class="resultado-seleccionado">
          <div class="poster">
              <img src="" alt="">
          </div>
          <div class="info">
                  <div class="campo">
                      <label for="">Titulo:</label>
                          <textarea class="titulo" name="name" rows=1 cols=80 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for=""> Sinopsis:</label>
                          <textarea class="sinopsis" name="name" rows=6 cols=80 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="">Categoria:</label>
                          <textarea class="categoria" name="name" rows=1 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="" >Fecha estreno:</label>
                          <textarea class="fecha-estreno" name="name" rows=1 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="" >Genero:</label>
                          <textarea class="genero" name="name" rows=1 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="">Pais:</label>
                          <textarea class="pais" name="name" rows=1 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="">Duracion</label>
                          <textarea class="duracion-min"  name="name" rows=1 disabled></textarea>
                  </div>
            </div>
            <div class="opciones">
                    <label class="estado-opciones"></label>
                    <button class="boton-guardar" type="button" name="button">GUARDAR</button>
                    <button class="boton-modificar" type="button" name="button">MODIFICAR</button>
                    <button class="boton-eliminar" type="button" name="button">ELIMINAR</button>
            </div>
        </div>
        <div class="resultados-obtenidos">

        </div>
      </div>
</div>

@endsection
