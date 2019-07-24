@extends('layouts.app')

@section('title') Admin novedades | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/novelties/admin.js') }}"></script>
    <script>Novelties.startNovelties("content");</script>
    <link href="{{ asset('css/novelties/admin.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="admin">

    <div class="create-options secondary">
        <button type="button" class="option news">
            CREAR NOTICIA
        </button>
        <button  type="button" class="option award">
            CREAR PREMIOS
        </button>
    </div>
    <div class="edit-panel">
        <button class="option big" type="button" name="button"><big>A</big></button>
        <button class="option medium" type="button" name="button">A</button>
        <button class="option small" type="button" name="button"> <small>A</small></button>
        <button class="option bold" type="button" name="button"> <b>B</b> </button>
        <button class="option cursive" type="button" name="button"> <i>i</i></button>
        <button class="option underline" type="button" name="button"> <u>S</u></button>
        <button class="option list" type="button" name="button">List</button>
        <button class="option image" type="button" name="button">IMG</button>

    </div>
    <div class="forms-novelties" >
        <div class="form news">
          <form action="/admin/create-news" method="POST" enctype="multipart/form-data">
                <div class="field">
                  <label for="titulo" class="tittle"> Titulo:
                      <input type="text" name="titulo" required >*
                  </label>
                </div>
                <div class="field" class="description">
                  <label for="copete"> Copete:
                      <input type="text" name="copete" required >*
                  </label>
                </div>
                <div class="field" class="poster">
                    <label for="portada" >Portada:
                        <input name="portada" type="file" >
                    </label>
                </div>
                <div class="field content" contentEditable="true">
                      hola esto es una prueba a ver si funciona como tal, solo para verificar
                </div>
                <div class="field author">
                    <label for="autor">Autor:
                        <input name="autor" type="text" value="{{Auth::user()->nombre}}" disabled readonly>
                    </label>
                </div>
                <div class="field source">
                    <label for="fuente">Fuente:
                        <input name="fuente" type="text" placeholder="MVJ Reviews" >*
                    </label>
                </div>
                <input class="btnEnviar" type="submit" name="Agregar">
                <input  class="controls" type="reset" value="Resetear">
          </form>
        </div>
        <div class="form award no-visible">

        </div>
    </div> <!--END div forms-novelties -->
  </div>
@endsection
