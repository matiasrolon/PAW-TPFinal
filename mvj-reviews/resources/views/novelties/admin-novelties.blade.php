@extends('layouts.app')

@section('title') Admin novedades | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/novelties/admin.js') }}"></script>
    <script>Novelties.startNovelties("content");</script>
    <link href="{{ asset('css/novelties/admin.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="admin">
    @if ($errors)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <div class="create-options secondary">
        <button type="button" class="option news">
            CREAR NOTICIA
        </button>
        <button  type="button" class="option award">
            CREAR PREMIOS
        </button>
    </div>
    <div class="edit-panel">
        <div class="button-section">
          <button class="option big" type="button" name="button"><big>A</big></button>
          <button class="option medium" type="button" name="button">A</button>
          <button class="option small" type="button" name="button"> <small>A</small></button>
        </div>
        <div class="button-section">
          <button class="option bold" type="button" name="button"> <b>B</b> </button>
          <button class="option cursive" type="button" name="button"> <i>i</i></button>
          <button class="option underline" type="button" name="button"> <u>S</u></button>
        </div>
        <div class="button-section">
          <button class="option list" type="button" name="button">List</button>
          <button class="option image" type="button" name="button">IMG</button>
        </div>
        <br>
        <div class="button-section award">
          <button class="option addCategory" type="button" name="button">Category</button>
          <div class="attribute-option nominee no-visible">
              <input type="number" name="" value="2">
              <p>Nominados</p>
          </div>
        </div>
    </div>
    <div class="forms-novelties" >
        <div class="form news">
          <form action="/admin/novelties/create-news" name="news" method="POST" enctype="multipart/form-data">
              @csrf

                <div class="field tittle">
                  <label for="titulo"> Titulo:
                      <input type="text" name="titulo" required value="{{ old('titulo') }}">*
                  </label>
                </div>
                <div class="field description">
                  <label for="copete"> Copete:
                      <input type="text" name="copete" required value="{{ old('copete') }}">*
                  </label>
                </div>
                <div class="field poster">
                    <label for="portada" >Portada:
                        <input name="portada" type="file" value="{{ old('portada') }}">
                    </label>
                </div>
                <input type="hidden" name="cuerpo" value="{{ old('cuerpo') }}">
                <div class="field content" contentEditable="true">
                      {!! old('cuerpo') !!}
                </div>

                <div class="field author">
                    <label for="autor">Autor:
                        <input name="autor" type="text" value="{{Auth::user()->nombre}}" disabled readonly>
                    </label>
                </div>
                <div class="field source">
                    <label for="fuente">Fuente:
                        <input name="fuente" type="text" placeholder="MVJ Reviews" value="{{ old('fuente') }}" >*
                    </label>
                </div>
                <input class="btnSendNews" type="submit" name="AgregarNews">
                <input  class="controls" type="reset" value="Resetear">
          </form>
        </div>

        <div class="form award no-visible">
          <form action="/admin/novelties/create-award" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="field name">
                  <label for="nombre" class="name"> Nombre:
                      <input type="text" name="nombre" required >*
                  </label>
                </div>
                <div class="field description">
                  <label for="descripcion"> descripcion:
                      <input type="text" name="descripcion" required >*
                  </label>
                </div>
                <div class="field country">
                  <label for="pais"> Pais:
                      <input type="text" name="pais" required >*
                  </label>
                </div>
                <div class="field date">
                  <label for="fecha"> Fecha:
                      <input type="date" name="fecha" required >*
                  </label>
                </div>
                <div class="field poster">
                    <label for="portada" >Portada:
                        <input name="portada" type="file" >
                    </label>
                </div>

                <div class="field content" contentEditable="true">
                    <div class="category no-visible" nroCategory=0>
                        <div class="attribute name">
                            <label for="category" >Categoria:
                               <input name="category" type="text" >
                            </label>
                        </div>
                        <div class="attribute description">
                            <label for="descripcion" >Descripcion:
                               <input name="descripcion" type="text" >
                            </label>
                        </div>
                        <ul class="attribute nominees-list">Nominados
                            <li class="nominee">
                                <div class="name">
                                  <label for="nominado" >
                                     <input name="nominado" type="text" placeholder="nombre">
                                  </label>
                                </div>
                                <div class="description">
                                  <label for="descripcion" >por
                                     <input name="descripcion" type="text" placeholder="pelicula">
                                  </label>
                                </div>
                            </li>
                        </ul>
                    </div>
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
                <input class="btnSendAward" type="submit" name="AgregarAward">
                <input  class="controls" type="reset" value="Resetear">

          </form>
        </div> <!--End div form award-->
    </div> <!--END div forms-novelties -->
  </div>
@endsection
