<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Film;

class NoveltiesController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //  $this->middleware('auth'); //Para que pase por el login si no es usuario
  }

  public function admin_novelties(){
      if (Auth()->user()->hasRole('admin')){
          return view('novelties/admin-novelties');
      }else{
        return view('404'); //personalizar error (no posee los permisos necesarios)
      }
  }

  public function create_news(){
    //echo
  }

  //noticias
  public function news(){
    $noticias = News::all(); // luego cambiar por valor fijo, para paginacion.
       return view('novelties/news', compact('noticias'));
  }

//estrenos
  public function premieres(){
    $hoy = Carbon::today();
    $premieres = Film::whereDate('fecha_estreno', '>=', $hoy)->select('titulo','fecha_estreno','sinopsis')->get();
     return view('novelties/premieres', compact('premieres'));
  }

//premios
  public function awards(){
    //$premios = Newness::where('categoria','premio')->get();
     //return view('newness/premios', compact('premios'));
     echo "no funciona todavia";
  }

}
