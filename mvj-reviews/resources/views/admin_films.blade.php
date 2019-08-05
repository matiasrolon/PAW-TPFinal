@extends('layouts.app')

@section('title') Admin Films | MVJ Reviews @endsection

@section('publics')
<link href="{{ asset('css/admin_films.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<script src="{{ asset('js/admin_films.js') }}"></script>
<script>
    AdminFilms.iniciarPagina("content");
</script>
@endsection

@section('content')

<div class="pendientes">
    <h2>Busquedas sin resultados</h2>
    @foreach ($searches as $search)
    <div text="{{ $search['busqueda'] }}" class="busqueda">
        <button class="button1" class="resolver-busqueda" type="button" name="button">&#10004;</button>
        <h3> Buscado {{$search['cant_busquedas']}} veces</h3>
        <p>{{ $search['busqueda'] }}</p>
    </div>
    @endforeach
</div>

<div class="administrador-films">
    <div class="administrador-films-barra-busqueda">
        <input class="button1" id="buscadorFilms" type="text" name="" value="" placeholder="Buscar Film...(ej. Star Wars Episode III)">
        <label for="">¿D&oacute;nde?</label>
            <select id="src-selector">
                <option value="TheMovieDB">TheMovieDB</option>
                <option value="MVJ Reviews">MVJ Reviews</option>
                <option value="Ambos" selected>Ambos</option>
            </select>
        <button class="button1" type="button" name="button" id="btnBuscadorFilms">Buscar</button>
    </div>

    <div class="admin-resultados">
        <form id="film-form" class="resultado-seleccionado resultado-seleccionado-oculto">
            <div class="poster">
                <img src="" alt="">
                <ul id="mensajes">

                </ul>
            </div>
            <div class="info">
                <div class="campo titulo">
                    <label class="required" for="titulo">Titulo:</label>
                    <input type="text" required class="editable titulo" name="titulo" rows=1 cols=80 disabled>
                </div>

                <div class="campo categoria">
                    <label class="required" for="categorias">Categoria:</label>
                    <select required class="editable categoria" name="categorias" disabled>
                        <option hidden selected>Elija una categoria</option>
                        @for ($i = 0; $i < count($categorias); $i++)
                            <option value="{{ $categorias[$i] }}">{{ $categorias[$i] }}</option>
                        @endfor
                    </select>
                </div>

                <div class="campo sinopsis">
                    <label class="required" for="sinopsis">Sinopsis:</label>
                    <textarea required class="editable sinopsis" name="sinopsis" rows=6 cols=80 disabled></textarea>
                </div>
                
                <div class="campo pais">
                    <label for="paises">Pais:</label>
                    <select name="paises" id="paises" class='editable pais' disabled>
                        <option hidden selected>Elija un pais</option>
                        @for ($i = 0; $i < count($paises); $i++)
                        <option value="{{ $paises[$i] }}">{{ $paises[$i] }}</option>
                        @endfor
                    </select>
                </div>

                <div class="campo fecha-estreno">
                    <label class="required" for="fecha-estreno">Fecha estreno:</label>
                    <input type="text" required class="editable fecha-estreno" name="fecha-estreno" rows=1 disabled>
                </div>

                <div class="campo fecha-finalizacion">
                    <label for="fecha-finalizacion">Fecha finalizacion:</label>
                    <input type="text" class="editable fecha-finalizacion" name="fecha-finalizacion" rows=1 disabled>
                </div>

                <div class="campo genero">
                    <label class="required" for="generos">Genero:</label>
                    <ul class="editable genero" disabled>
                    </ul>
                    <select name="generos" id="generos" class="editable genero" disabled>
                        <option hidden selected>Elija un genero</option>
                        @for ($i = 0; $i < count($generos); $i++)
                        <option value="{{ $generos[$i] }}">{{ $generos[$i] }}</option>
                        @endfor
                    </select>
                    <!-- button type="button" para que no haga el submit() -->
                    <button type="button" id="agregar-genero" class="button1 editable" disabled>Agregar</button>
                </div>

                <div class="campo duracion_min">
                    <label for="duracion">Duracion (min):</label>
                    <input type="text" class="editable duracion-min" name="duracion" rows=1 disabled>
                </div>

                <div class="campo trailer">
                    <label for="trailer-url">Trailer URL:</label>
                    <textarea class="editable trailer-url" name="trailer-url" rows=2 disabled></textarea>
                </div>

                <div class="opciones">
                    <label class="estado-opciones"></label>
                    <button class="button1 boton-guardar" type="button" name="button">Guardar</button>
                    <button class="button1 boton-modificar" type="button" name="button">Modificar</button>
                    <button class="button1 boton-eliminar" type="button" name="button">Eliminar</button>
                </div>
            </div>
        </form>

        <div class="resultados-obtenidos">

        </div>
    </div>
</div>

@endsection
