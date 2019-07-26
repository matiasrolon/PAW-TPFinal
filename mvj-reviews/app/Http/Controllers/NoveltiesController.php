<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Award;
use App\Models\Category;
use App\Models\Nominee;
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

//premios (general)
  public function awards(){
    $date = new Carbon('first day of this year');
    $awards = Award::whereDate('fecha_realizacion','>=',$date)
            ->select('award.nombre as nombreAward','award.id as award_id','fecha_realizacion',
            \DB::raw('TO_BASE64(portada) as portada'),'pais')
            ->orderBy('fecha_realizacion','asc')
            ->get();
    return view('novelties/awards', compact('awards'));
  }

//info de premio en especifico, cuando se entra a el.
  public function award_profile($award_id){
    $award = Award::find($award_id);
    $categories = Category::where('award_id',$award->id)->get();
    foreach ($categories as $cat ) {
       $cat->nominees = Nominee::where('category_id',$cat->id)->get();
    }
    return view('novelties/award_profile', compact('award','categories'));

  }


}
