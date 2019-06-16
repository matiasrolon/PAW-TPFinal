@extends('layouts.app')

@section('title') Ranking Criticos | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h2>Ranking de criticos de MVJ:</h2>
    <table>
              <tr>
                <td>Usuario</td>
                <td>Rango</td>
                <td>Reviews</td>
                <td>Puntos</td>
              </tr>
        @foreach($users as $user)
              <tr>
                  <div class="tupla-user">
                      <td>
                          <a href="{{route('user_profile',$user['username']) }}">
                             {{$user['username']}}</td>
                          </a>
                      <td>{{$user['nombre']}}</td>
                      <td>100</td> <!--aca irian las reviews totales del user-->
                      <td>{{$user['puntos']}}</td>
                  </div>
              </tr>
        @endforeach
    </table>
@endsection
