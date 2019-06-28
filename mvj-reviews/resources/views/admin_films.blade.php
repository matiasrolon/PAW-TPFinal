@extends('layouts.app')

@section('title') Admin Films | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/admin_films.css') }}" rel="stylesheet">
  <script src="{{ asset('js/admin_films.js') }}"></script>
  <script src="{{ asset('js/customSelect.js') }}"></script>
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
              <button class="button1" class="resolver-busqueda" type="button" name="button">Resuelto</button>
      </div>
    @endforeach
</div>
<div class="administrador-films">
      <div class="administrador-films-barra-busqueda">
              <input  class="button1" id="buscadorFilms" type="text" name="" value="" placeholder="Buscar Film...(ej. Star Wars Episode III)">
              <label for="">¿Dónde?</label>
              <div class="custom-select">
                <select>
                      <option value="value1">TheMovieDB</option>
                      <option value="value2" selected>MVJ Reviews</option>
                      <option value="value3">Ambos</option>
                </select>
              </div>
              <button  class="button1"  type="button" name="button" id="btnBuscadorFilms">Buscar</button>
      </div>
      <div class="admin-resultados">
        <div class="resultado-seleccionado resultado-seleccionado-oculto">
          <div class="poster">
              <img src="" alt="">
          </div>
          <div class="info">
                  <div class="campo">
                      <label for="">Titulo:</label>
                          <textarea class="field-text titulo" name="name" rows=1 cols=80 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for=""> Sinopsis:</label>
                          <textarea class="field-text sinopsis" name="name" rows=6 cols=80 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="">Categoria:</label>
                          <textarea class="field-text categoria" name="name" rows=1 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="" >Fecha estreno:</label>
                          <textarea class="field-text fecha-estreno" name="name" rows=1 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="" >Genero:</label>
                          <textarea class="field-text genero" name="name" rows=1 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="">Pais:</label>
                          <textarea class="field-text pais" name="name" rows=1 disabled></textarea>
                  </div>
                  <div class="campo">
                      <label for="">Duracion</label>
                          <textarea class="field-text duracion-min"  name="name" rows=1 disabled></textarea>
                  </div>
                  <div class="opciones">
                          <label class="estado-opciones"></label>
                          <button class="button1 boton-guardar" type="button" name="button">GUARDAR</button>
                          <button class="button1 boton-modificar" type="button" name="button">MODIFICAR</button>
                          <button class="button1 boton-eliminar" type="button" name="button">ELIMINAR</button>
                  </div>
            </div>

        </div>
        <div class="resultados-obtenidos">

        </div>
      </div>
</div>

@endsection
