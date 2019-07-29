<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
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

  public function create_news(Request $request){
    //mensajes en caso de fallar cada validacion
      $messages = [
        'required' => 'El campo :attribute es requerido.',
      ];
      //validaciones
      $validator = Validator::make($request->input(), [
          'titulo' => 'required',
          'copete' => 'required',
          'cuerpo' => 'required',
      ],$messages);

      if ($validator->fails()) {
          return redirect()
                 ->back()
                 ->withInput()
                 ->withErrors($validator);
      }else{ // no hubo campos invalidos -> guardo la noticia
        $news = new News();
        $news->titulo = $request->input('titulo');
        $news->copete = $request->input('copete');
        $news->cuerpo = $request->input('cuerpo');
        $news->autor = Auth()->user()->nombre;
        $news->fuente = $request->input('fuente');
        $news->portada = file_get_contents($request->file('portada'));
        $news->fecha = Carbon::today();
        $news->save();
        return redirect()->route('news-profile', ['news_id' => $news->id]);
      };
  }//end create_news


  public function create_award(Request $request){
    var_dump($request->input());
  }



  /* --------------   VISTAS   ---------------*/

  //noticias
  public function news(){
    $noticias = News::all();
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

//info de noticia en especifico, cuando se entra a el y/o cuando se la crea.
    public function news_profile($news_id){
      $news = News::where('id',$news_id)
              ->select('titulo','copete','cuerpo',\DB::raw('TO_BASE64(portada) as portada'),
                      'autor','fuente')
              ->first();

      return view('novelties/news_profile', compact('news'));
    }


}