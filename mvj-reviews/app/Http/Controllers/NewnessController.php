<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewnessController extends Controller
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

  public function news(){
    $noticias = News::all(); // luego cambiar por valor fijo, para paginacion.
       return view('novelties/news', compact('noticias'));
  }

  public function admin_novelties(){
      if (Auth()->user()->hasRole('admin')){
          return view('novelties/admin-novelties');
      }else{
        return view('404'); //personalizar error (no posee los permisos necesarios)
      }
  }


//estrenos
  public function premieres(){
    //$estrenos = Newness::where('categoria','estreno')->get();
    // return view('newness/estrenos', compact('estrenos'));
    echo "no funciona todavia";
  }

//premios
  public function awards(){
    //$premios = Newness::where('categoria','premio')->get();
     //return view('newness/premios', compact('premios'));
     echo "no funciona todavia";
  }

}
