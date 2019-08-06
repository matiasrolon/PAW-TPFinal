@extends('layouts.app')

@section('title') Ranking Criticos | MVJ Reviews @endsection

@section('publics')
    <link href="{{ asset('css/ranking_users.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="rank">
    <h2>Ranking de criticos de MVJ:</h2>
    <table class="table-rank">
        <thead>
            <th class="position"></th>
            <th class="username">Usuario</th>
            <th>Desde</th>
            <th>Rango</th>
            <th>Reviews</th>
            <th>Puntos</th>
        </thead>
        <tbody>
            @foreach($users as $indexKey =>$user)
            <tr class="user-position">
                <td class="position">{{ $indexKey +1 }}</td>
                <td class="username">
                    <p>@<a href="{{route('user_profile',$user['username']) }}" class="link-user">{{$user['username']}}
                    </a></p>
                </td>
                <td>{{$user['created_at']->format('d-m-Y')}}</td>
                <td>{{$user['rnom']}}</td>
                <td>{{ $user['cantReviews'] }}</td>
                <!--aca irian las reviews totales del user-->
                <td>{{ number_format($user['puntos'], 2) }}</td>
                <!-- </div> -->
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
