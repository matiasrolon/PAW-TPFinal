@extends('layouts.app')

@section('title') Premios | MVJ Reviews @endsection

@section('publics')
<script src="{{ asset('js/novelties/awards.js',false) }}"></script>
<script>
  Awards.startAwards("content");
</script>
<link href="{{ asset('css/novelties/awards.css',false) }}" rel="stylesheet">
@endsection

@section('content')
<section class="awards">
  <h1> Festivales y premios </h1>
  @foreach ($awards as $award)
  <div class="award">
    <a href="/novelties/awards/{{$award['award_id']}}">
      <img class="portada" src="data:image/png;base64,{{$award['portada']}}">
      <div class="data">
        <h2>{{$award['nombreAward']}}</p>
        <p>Fecha: {{ date('d-m-Y', strtotime( $award['fecha_realizacion'] ) ) }}</p>
      </div>
    </a>
  </div>
  @endforeach

</section>
@endsection
