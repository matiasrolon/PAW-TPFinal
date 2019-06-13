<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
  //CLASE POR AHORA INACTIVA, YA QUE LA VALIDACION DE REGISTRO LA HACE Auth\RegistrerController
  // METODOS profile() y index() PROXIMOS A IMPLEMENTAR SI FUESEN NECESARIOS.

    // TODO: HACER FUNCION PARA CONFIRMAR EL SIGN_UP


  //----pruebas----------------------------------

  public function AuthRouteAPI(Request $request){
   return $request->user();
  }

    public function index(){
      $users = User::All();
      return view('users',compact('users'));
    }

    public function profile(Request $request){
      return view('perfil');
    }

//----------------------------------------------

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
