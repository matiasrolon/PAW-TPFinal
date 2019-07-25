@extends('layouts.app')

@section('title') Premios | MVJ Reviews @endsection

@section('publics')
    <script src="{{ asset('js/novelties/awards.js') }}"></script>
    <script>Awards.startAwards("content");</script>
    <link href="{{ asset('css/novelties/awards.css') }}" rel="stylesheet">
@endsection

@section('content')
<h3> Festibales y premios </h3>
@foreach ($awards as $award)
      <div class="award">
        <a href="/novelties/awards/{{$award['award_id']}}">
            <img class="portada" src="data:image/png;base64,{{$award['portada']}}">
            <div class="data">
              <p><b>{{$award['nombreAward']}}</b> </p>
              <p>Fecha: {{$award['fecha_realizacion']}}</p>
            </div>
        </a>
        <br>
      </div>
@endforeach


@endsection
