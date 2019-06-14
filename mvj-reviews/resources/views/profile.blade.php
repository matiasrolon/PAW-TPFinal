@extends('layouts.app')

@section('title') Perfil | MVJ Reviews @endsection

@section('content')
            <div class="content">
                <div class="title m-b-md">

                    @if (Auth::user()->username == $user['username'])
                      El perfil al que entro es el del usuario logeado
                    
                    @else
                      <p> Estas en el perfil del usuario con ID= {{$user['id']}} </p>
                      {{$user}}
                      @endif
                </div>
              </div>

  @endsection
