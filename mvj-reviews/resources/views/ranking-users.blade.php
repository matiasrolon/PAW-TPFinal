@extends('layouts.app')

@section('title') Ranking Criticos | MVJ Reviews @endsection

@section('publics')
    <link href="{{ asset('css/ranking_users.css',true) }}" rel="stylesheet">
@endsection

@section('content')
<section class="rank">
    <h2>Ranking de criticos de MVJ:</h2>
    <table class="table-rank">
        <thead>
            <th class="position"></th>
            <th class="username">Usuario</th>
            <th class="desde">Desde</th>
            <th class="rango">Rango</th>
            <th class="reviews-cant">Reviews</th>
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
                <td class="desde">{{$user['created_at']->format('d-m-Y')}}</td>
                <td class="rango">{{$user['rnom']}}</td>
                <td class="reviews-cant">{{ $user['cantReviews'] }}</td>
                <!--aca irian las reviews totales del user-->
                <td>{{ number_format($user['puntos'], 2) }}</td>
                <!-- </div> -->
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
