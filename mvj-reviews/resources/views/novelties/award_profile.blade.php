@extends('layouts.app')

@section('title') Premio | MVJ Reviews @endsection

@section('publics')

@endsection

@section('content')
      <div class="award">
          <p> Evento:{{$award['nombre']}}</p>
          <p></p>
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
