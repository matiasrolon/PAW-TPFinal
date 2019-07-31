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
    <h2>Busquedas sin resultados</h2>
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
                      <textarea class="editable titulo" name="name" rows=1 cols=80 disabled></textarea>
                  </div>

                  <div class="campo">
                      <label for=""> Sinopsis:</label>
                      <textarea class="editable sinopsis" name="name" rows=6 cols=80 disabled></textarea>
                  </div>

                  <div class="campo">
                      <label for="">Categoria:</label>
                      <textarea class="editable categoria" name="name" rows=1 disabled></textarea>
                  </div>

                  <div class="campo">
                      <label for="" >Fecha de estreno:</label>
                      <textarea class="editable fecha-estreno" name="name" rows=1 disabled></textarea>
                  </div>

                  <div class="campo">
                      <label for="">Fecha de finalizacion:</label>
                          <textarea class="editable fecha-finalizacion"  name="name" rows=1 disabled></textarea>
                  </div>

                  <div class="campo">
                      <label for="" >Genero:</label>
                      <ul class="editable genero" disabled>
                      </ul>
                      <select name="generos" id="generos" class="editable genero" disabled>
                        <option hidden selected>Elija un genero</option>
                        @for ($i = 0; $i < count($generos); $i++)
                            <option value="{{ $generos[$i] }}">{{ $generos[$i] }}</option>
                        @endfor
                      </select>
                      <button id="agregar-genero" class="button1 editable" disabled>Agregar</button>
                  </div>

                  <div class="campo">
                      <label for="">Pais:</label>
                      <select name="paises" id="paises" class='editable pais' disabled>
                        <option hidden selected>Elija un pais</option>
                        @for ($i = 0; $i < count($paises); $i++)
                            <option value="{{ $paises[$i] }}">{{ $paises[$i] }}</option>
                        @endfor
                        </select>
                  </div>

                  <div class="campo">
                      <label for="">Duracion (en minutos):</label>
                          <textarea class="editable duracion-min"  name="name" rows=1 disabled></textarea>
                  </div>

                  <div class="campo">
                      <label for="">Trailer URL:</label>
                          <textarea class="editable trailer-url"  name="name" rows=2 disabled></textarea>
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
