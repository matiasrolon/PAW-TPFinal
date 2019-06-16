<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;

class UserController extends Controller
{

  // TODO: HACER FUNCION PARA CONFIRMAR EL SIGN_UP
  //       PROFILE()


  public function AuthRouteAPI(Request $request){
   return $request->user();
  }

    public function ranking(){
      $users = User::join('range', 'users.range_id', '=', 'range.id')->orderBy('puntos','desc')->take(100)->get();
      foreach ($users as $user) {
        $user->avatar = base64_encode($user->avatar);
      }
      return view('ranking-users',compact('users'));
    }

    public function profile($username){
      $user = User::where('username',$username)->first();
      $user->avatar =  base64_decode($user->avatar);
      $reviews = Review::join('film','film_id','=','film.id')
                          ->where('review.user_id',$user->id)
                            ->select('review.*','film.titulo as pelicula','film.poster')
                              ->orderBy('review.created_at')
                                ->get();

      foreach ($reviews as $re) {//convierte el poster para que despues pueda insertarse como imagen
        $re->poster = base64_encode($re->poster);
      }
      $user->cantReviews = count($reviews);
      //var_dump(json_decode($reviews));

      return view('user_profile',compact('user','reviews'));
    }

//PROCEDIMIENTOS INACTIVOS, YA QUE LA VALIDACION DE REGISTRO LA HACE Auth\RegistrerController
    public function store(Request $request)
    {
        // Validate the request...
        $validator = Validator::make($request, [
            'username' => 'required|max:100',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|max:32',
            'nombre' => 'required|max:100',
            'fecha_nacim' => 'max:100',
            'biografia' => 'max:500',
            'genero_fav' => 'max:50',
            'pelicula_fav' => 'max:50',
            'serie_fav' => 'max:50',
            'avatar' => 'image|dimensions:min_width=100,min_height=200'
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        // TODO: Buscar como hashear la PASSWORD
        $user->password = $request->password;
        $user->nombre = $request->nombre;
        $user->fecha_nacim = $request->fecha_nacim;
        $user->biografia = $request->biografia;
        $user->genero_fav = $request->genero_fav;
        $user->avatar = $request->avatar;
        // TODO: DEFINIR como rango mas bajo el 1.
        $user->rango = App\Models\User::find(1);
        $user->puntos = 0;
        $user->save();
    }
}
