@extends('layouts.app')

@section('title') Admin novedades | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/novelties/admin.js') }}"></script>
    <script>Novelties.startNovelties("content");</script>
    <link href="{{ asset('css/novelties/admin.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="create-options initial">
        <button type="button" class="option news">
            CREAR NOTICIA
        </button>
        <button  type="button" class="option award">
            CREAR PREMIO
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
          <button class="option addCategory" type="button" name="button">Add Category</button>
          <div class="attribute-option nominee no-visible">
              <input type="number" name="" value="2">
              <p>Nominados</p>
          </div>
        </div>
    </div>
    <div class="forms-novelties" >
        <div class="form news no-visible">
          <form action="/admin/novelties/create-news" name="news" method="POST" enctype="multipart/form-data">
              @csrf

                <div class="field tittle">
                  <label for="titulo"> Titulo:
                      <input type="text" name="titulo" required value="{{ old('titulo') }}">*
                      <p class="errorField">@error('titulo'){{ $message }} @enderror</p>
                  </label>
                </div>
                <div class="field description">
                  <label for="copete"> Copete:
                      <input type="text" name="copete" required value="{{ old('copete') }}">*
                      <p class="errorField">@error('copete'){{ $message }} @enderror</p>
                  </label>
                </div>
                <div class="field poster">
                    <label for="portada" >Portada:
                        <input name="portadaNews" type="file" value="{{ old('portada') }}">
                        <p class="errorField">@error('portadaNews'){{ $message }} @enderror</p>
                    </label>
                </div>
                <input type="hidden" name="cuerpo" value="{{ old('cuerpo') }}">
                <div class="field content" contentEditable="true">
                      {!! old('cuerpo') !!}
                </div>

                <div class="field author">
                    <label for="autor">Autor:
                        <input name="autorNews" type="text" value="{{Auth::user()->nombre}}" disabled readonly>
                        <p class="errorField">@error('autorNews'){{ $message }} @enderror</p>
                    </label>
                </div>
                <div class="field source">
                    <label for="fuente">Fuente:
                        <input name="fuenteNews" type="text" placeholder="MVJ Reviews" value="{{ old('fuente') }}" >*
                        <p class="errorField">@error('fuenteNews'){{ $message }} @enderror</p>
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
                      <input type="text" name="nombre" required value="{{ old('nombre') }}">*
                      <p class="errorField">@error('nombre'){{ $message }} @enderror</p>
                  </label>
                </div>
                <div class="field description">
                  <label for="descripcion"> descripcion:
                      <input type="text" name="descripcion" value="{{ old('descripcion') }}">*
                      <p class="errorField">@error('descripcion'){{ $message }} @enderror</p>
                  </label>
                </div>
                <div class="field country">
                  <label for="pais"> Pais:
                      <input list="countries" type="text" name="pais" required value="{{ old('pais') }}">*
                      <p class="errorField">@error('pais'){{ $message }} @enderror</p>
                      <datalist id="countries">
                          @foreach ($countries as $country)
                            <option value="{{ $country }}">
                          @endforeach
                      </datalist>
                  </label>
                </div>
                <div class="field date">
                  <label for="fecha"> Fecha:
                      <input type="date" name="fecha" required value="{{ old('fecha') }}">*
                      <p class="errorField">@error('fecha'){{ $message }} @enderror</p>
                  </label>
                </div>
                <div class="field poster">
                    <label for="portada" >Portada:
                        <input name="portadaAward" type="file" >
                        <p class="errorField">@error('portadaAward'){{ $message }} @enderror</p>
                    </label>
                </div>

                <input type="hidden" name="cuerpo" value="{{ old('cuerpo') }}">
                <div class="field content" >
                    {!! old('cuerpo') !!}
                </div>

                <div class="field author">
                    <label for="autor">Autor:
                        <input name="autorAward" type="text" value="{{Auth::user()->nombre}}" disabled readonly>
                        <p class="errorField">@error('autorAward'){{ $message }} @enderror</p>
                    </label>
                </div>
                <div class="field source">
                    <label for="fuente">Fuente:
                        <input name="fuenteAward" type="text" placeholder="MVJ Reviews" value="{{ old('fuente') }}">*
                        <p class="errorField">@error('fuenteAward'){{ $message }} @enderror</p>
                    </label>
                </div>
                <input class="btnSendAward" type="submit" name="AgregarAward">
                <input  class="controls" type="reset" value="Resetear">

          </form>
        </div> <!--End div form award-->
    </div> <!--END div forms-novelties -->

@endsection
