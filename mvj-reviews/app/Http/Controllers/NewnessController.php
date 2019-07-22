<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newness;

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

  public function noticiaDelDia(){
    $noticias = Newness::where('categoria','noticia')->get();
     return view('newness/noticias', compact('noticias'));
  }

  public function estrenos(){
    $estrenos = Newness::where('categoria','estreno')->get();
     return view('newness/estrenos', compact('estrenos'));
  }

  public function premios(){
    $premios = Newness::where('categoria','premio')->get();
     return view('newness/premios', compact('premios'));
  }
}
