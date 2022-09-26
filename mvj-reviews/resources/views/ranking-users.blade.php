@extends('layouts.app')

@section('title') MVJ Reviews | Ranking Criticos @endsection

@section('publics')
    <meta name="description" content="Ranking de criticos (usuarios) segun los votos que han recibido sus criticas (reviews)">
    <link href="{{ asset('css/ranking_users.css',false) }}" rel="stylesheet">
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
            <th>Puntaje</th>
        </thead>
        <tbody>
            @foreach($users as $indexKey =>$user)
            <tr class="user-position">
                <td class="position">{{ $indexKey +1 }}</td>
                <td class="username">
                    <a href="{{route('user_profile',$user['username']) }}" class="link-user">{{$user['username']}}</a>
                </td>
                <td class="desde">{{$user['created_at']->format('d-m-Y')}}</td>
                <td class="rango">{{$user['rnom']}}</td>
                <td class="reviews-cant">{{ $user['cantReviews'] }}</td>
                <td>{{ number_format($user['puntos'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
