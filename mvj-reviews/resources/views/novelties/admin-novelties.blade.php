@extends('layouts.app')

@section('title') Admin novedades | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/novelties/admin.js',false) }}"></script>
    <script>Novelties.startNovelties("content");</script>
    <link href="{{ asset('css/novelties/admin.css',false) }}" rel="stylesheet">
@endsection

@section('content')

    <div class="create-options secondary">
        <button type="button" class="button1 option news">CREAR NOTICIA</button>
        <button  type="button" class="button1 option award">CREAR PREMIO</button>
    </div>

    <ul id='mensajes'>
        @foreach ($errors->all() as $error)
        <li class="resultado-Failed">{{ $error }}</li>
        @endforeach
    </ul>

    <div id="toolbox" class="edit-panel no-visible">
        <h3>Herramientas de edici&oacute;n</h3>
        <div class="button-section">
          <button class="option big" type="button" name="button">A</button>
          <button class="option medium" type="button" name="button">A</button>
          <button class="option small" type="button" name="button">A</button>
        </div>
        <div class="button-section">
          <button class="option bold" type="button" name="button"> <b>B</b> </button>
          <button class="option cursive" type="button" name="button"> <i>i</i></button>
          <button class="option underline" type="button" name="button"> <u>S</u></button>
        </div>
        <div class="button-section">
          <button class="option list" type="button" name="button">Lista</button>
          <button class="option image" type="button" name="button">Imagen</button>
        </div>
        <br>
        <div class="button-section award">
          <button class="option addCategory" type="button" name="button">Agregar categoria</button>
          <div class="attribute-option nominee no-visible">
            <label for="nominados">Nº Nominados</label>
            <input type="number" name="nominados" value="2">
          </div>
        </div>
    </div>

    <div class="forms-novelties" >
        <div class="form news no-visible">
          <form action="/admin/novelties/create-news" name="news" method="POST" enctype="multipart/form-data">
              @csrf

                <div class="field tittle">
                    <label class='required' for="titulo">Titulo:</label>
                    <input type="text" name="titulo" required value="{{ old('titulo') }}">
                    @error('titulo')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field description">
                    <label class="required" for="copete">Copete:</label>
                    <input type="text" name="copete" required value="{{ old('copete') }}">
                    @error('copete')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field poster">
                    <label for="portada" >Portada:</label>
                    <input name="portadaNews" type="file" value="{{ old('portada') }}">
                    @error('portadaNews')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <input type="hidden" name="cuerpo" value="{{ old('cuerpo') }}">
                <div class="field content" contentEditable="true">
                      {!! old('cuerpo') !!}
                </div>

                <div class="field author">
                    <label for="autor">Autor:</label>
                    <input name="autorNews" type="text" value="{{Auth::user()->nombre}}" disabled readonly>
                    @error('autorNews')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field source">
                    <label class="required" for="fuente">Fuente:</label>
                    <input name="fuenteNews" type="text" placeholder="MVJ Reviews" value="{{ old('fuente') }}" >
                    @error('fuenteNews')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <input class="button1 btnSendNews" type="submit" name="AgregarNews">
                <input class="button1 controls" type="reset" value="Resetear">
          </form>
        </div>

        <!-- PREMIO -->
        <div class="form award no-visible">
          <form action="/admin/novelties/create-award" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="field name">
                    <label class="required" for="nombre" class="name">Nombre:</label>
                    <input type="text" name="nombre" required value="{{ old('nombre') }}">
                    @error('nombre')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field description">
                    <label for="descripcion">Descripcion:</label>
                    <input type="text" name="descripcion" value="{{ old('descripcion') }}">
                    @error('descripcion')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field country">
                    <label class="required" for="pais">Pais:</label>
                    <input list="countries" type="text" name="pais" required value="{{ old('pais') }}">
                    @error('pais')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                    <datalist id="countries">
                        @foreach ($countries as $country)
                        <option value="{{ $country }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="field date">
                    <label class="required" for="fecha">Fecha:</label>
                    <input type="date" name="fecha" required value="{{ old('fecha') }}">
                    @error('fecha')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field poster">
                    <label for="portada" >Portada:</label>
                    <input name="portadaAward" type="file" >
                    @error('portadaAward')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="cuerpo" value="{{ old('cuerpo') }}">
                <div class="field content" >
                    {!! old('cuerpo') !!}
                </div>

                <div class="field author">
                    <label for="autor">Autor:</label>
                    <input name="autorAward" type="text" value="{{Auth::user()->nombre}}" disabled readonly>
                    @error('autorAward')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field source">
                    <label class="required" for="fuente">Fuente:</label>
                    <input name="fuenteAward" type="text" placeholder="MVJ Reviews" value="{{ old('fuente') }}">
                    @error('fuenteAward')
                    <p class="errorField">{{ $message }}</p>
                    @enderror
                </div>
                <input class="button1 btnSendAward" type="submit" name="AgregarAward">
                <input  class="button1 controls" type="reset" value="Resetear">

          </form>
        </div> <!--End div form award-->
    </div> <!--END div forms-novelties -->

@endsection
