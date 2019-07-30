@extends('layouts.app')

@section('title') Premio | MVJ Reviews @endsection

@section('publics')

@endsection

@section('content')
      <div class="award">
          <h2> Evento:{{$award['nombre']}}</h2>
          <p> Fecha: {{$award['fecha_realizacion']}}</p>
          <p>{{$award['descripcion']}}</p>
          <img src="data:image/png;base64, {{$award['portada']}}" alt="">
      </div>
    <ul>
      @foreach ($categories as $category)
          <li><p><b>Categoria: </b>{{$category['nombre']}}</p>
              <ul>
                  @foreach ($category['nominees'] as $nominee)
                    <li>{{$nominee['nombre']}} - por {{$nominee['descripcion']}} </li>
                  @endforeach
            </ul>
          </li>
      @endforeach
    </ul>
@endsection
