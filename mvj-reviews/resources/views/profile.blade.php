@extends('layouts.app')

@section('title') Perfil | MVJ Reviews @endsection

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    <p> Estas en el perfil del usuario con ID= {{$user['id']}} </p>
                    {{$user}}
                </div>
              </div>

  @endsection
