<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use App\Models\PendentSearch;

class UserController extends Controller
{

  public function AuthRouteAPI(Request $request){
   return $request->user();
  }

    public function ranking(){
      $users = User::join('range', 'users.range_id', '=', 'range.id')
                    ->orderBy('puntos','desc')
                    ->take(100)
                    ->select('users.*', 'range.id as rid', 'range.nombre as rnom')
                    ->get();
      /* SOLUCIONADO: ERA EL LARAVEL PIJA ESTE.
      CUANDO DOS TABLAS DISTINTAS TIENEN UN CAMPO CON EL MISMO NOMBRE Y HACES UN JOIN DE ESAS 2 TABLAS
      SOBREESCRIBE LOS CAMPOS CON EL MISMO NOMBRE.
      PARA EVITAR ESTO HAY QUE RENOMBRAR LOS CAMPOS QUE TIENEN EL MISMO NOMBRE. */
      // $cantReviews = User::join('review', 'users.id', '=', 'review.user_id')->count('review.user_id')->groupBy('users.id')->get();

      // echo $users;
      foreach ($users as $user) {
        $user->avatar = base64_encode($user->avatar);
        $cantReviews = DB::table('review')->select('film_id')->where('user_id', $user->id)->get();
        // $cantReviews = Review::selectRaw('COUNT(film_id) as asd')->where('user_id', '=', $user->id)->get();
        $user->cantReviews = $cantReviews->count();
        // echo $user->id . ' - - - ' . $cantReviews;
      }
      return view('ranking-users',compact('users'));
    }


    public function profile($username){
      $user = User::join('range','users.range_id','=','range.id')
                    ->where('username',$username)
                    ->select('users.username','users.nombre','users.email',
                    'users.fecha_nacim','users.biografia','users.genero_fav',
                    'users.pelicula_fav','users.serie_fav','users.puntos',
                    'range.nombre as rango','users.created_at','users.id',
                     \DB::raw('TO_BASE64(avatar) as avatar'))
                    ->first();

      if ($user != null) {
        // $user->avatar =  base64_decode($user->avatar);
        $reviews = Review::join('film','film_id','=','film.id')
                            ->where('review.user_id',$user->id)
                            ->select('review.*','film.titulo as pelicula',
                            \DB::raw('TO_BASE64(poster) as poster'))
                            ->orderBy('review.created_at')
                            ->take(4)
                            ->get();

        $user->cantReviews = count($reviews);
        //var_dump(json_decode($reviews));
        return view('user_profile',compact('user','reviews'));
      } else {
        abort(404, 'Not found.');
      }

    }

    public function update(Request $request){

        if (Auth()->user()){
          $user = User::find(Auth()->user()->id);
          $user->nombre = $request->input('name');
          $user->email = $request->input('email');
              $time = strtotime($request->input('birth_date'));
          $user->fecha_nacim = date('Y-m-d',$time);
          $user->biografia = $request->input('biography');
          $user->genero_fav =$request->input('genre_fav');
          $user->pelicula_fav = $request->input('movie_fav');
          $user->serie_fav = $request->input('tvseries_fav');
          if (null!=($_FILES['avatar']['tmp_name'])){
            $user->avatar = file_get_contents($_FILES['avatar']['tmp_name']);
          }
          $user->save();

          return redirect()
                ->route('user_profile',Auth()->user()->username);
        }
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
