@extends('layouts.app')

@section('title') Ranking Criticos | MVJ Reviews @endsection

@section('publics')
    <link href="{{ asset('css/ranking_users.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h2>Ranking de criticos de MVJ:</h2>
    <table class="tabla">
        <thead>
            <th>Usuario</th>
            <th>Rango</th>
            <th>Reviews</th>
            <th>Puntos</th>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <!-- <div class="tupla-user"> -->
                <td>
                    <a href="{{route('user_profile',$user['username']) }}">
                        {{$user['username']}}</td>
                </a>
                <td>{{$user['rnom']}}</td>
                <td>{{ $user['cantReviews'] }}</td>
                <!--aca irian las reviews totales del user-->
                <td>{{ number_format($user['puntos'], 2) }}</td>
                <!-- </div> -->
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection