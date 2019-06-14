@extends('layouts.app')

@section('title') Ranking Criticos | MVJ Reviews @endsection

@section('publics')
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h2>Usuarios:</h2>
    <ul>
    @foreach($users as $user)
        <li>{{ $user }}</li>
    @endforeach
    </ul>
@endsection
