@extends('layouts.app')

@section('title') MVJ Reviews | Premio @endsection

@section('publics')
    <meta name="description" content="{{ $award['descripcion'] }}">
    <link href="{{ asset('css/novelties/awards.css',false) }}" rel="stylesheet">
@endsection

@section('content')
<section class="awards">
  <div class="encabezado">
    <h2>Evento: {{$award['nombre']}}</h2>
    <p> Fecha: {{ date('d-m-Y', strtotime( $award['fecha_realizacion'] ) ) }}</p>
    <p>{{$award['descripcion']}}</p>
    <img src="data:image/png;base64, {{$award['portada']}}" alt="">
  </div>
  <div class="cuerpo">
    <ul class="categorias">
      @foreach ($categories as $category)
      <li>
        <p><b>Categoria: </b>{{$category['nombre']}}</p>
        <ul>
          @foreach ($category['nominees'] as $nominee)
          <li>{{$nominee['nombre']}} - por {{$nominee['descripcion']}} </li>
          @endforeach
        </ul>
      </li>
      @endforeach
    </ul>
  </div>
</section>
@endsection
