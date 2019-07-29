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
          $type=null;$info=null;$errors=null;
          return view('novelties/admin-novelties',compact('type','info','errors'));
      }else{
        return view('404'); //personalizar error (no posee los permisos necesarios)
      }
  }

  public function create_news(Request $request){
      //return redirect()->route('news-profile', ['news_id' => 30]);

      $messages = [
        'required' => 'The :attribute PORTADA is required.',
      ];

      $validator = Validator::make($request->all(), [
          'portada' => 'required',
      ],$messages);

//    $validator->errors()->add('field', 'Something is wrong with this field!');
//    var_dump($validator->errors());

      if ($validator->fails()) {
          return redirect()
                 ->back()
                 ->withErrors($validator->errors())
                 ->withInput();
      }else{
        return redirect()->route('news-profile', ['news_id' => 30]);
      };
  }//end create_news


  public function create_award(){

  }

/*
  public function create_noveltie(){
      return redirect()->route('home');
      $obj = json_decode($_POST["object"]);
      $validateResponse ="";
      if ($obj->type == "news"){
        $validateResponse = $this->create_news($obj);
      }
      if ($obj->type == "award"){
        $validateResponse = $this->create_award($obj);
      }

      if ($validateResponse['state'] == "ERROR"){      //Si hay campos no validos
        $obj->state = "ERROR";
        $obj->message = "Campos erroneos";
        $obj->errors = $validateResponse['errors'];
        return response()->json($obj); //responde en la misma pagina con los errores.
      }else{      //Si se guardo correctamente la novedad
        if ($obj->type == "news"){
            $news = $validateResponse['news'];
            return redirect()->route('news-profile', ['news_id' => $news->id]);
        }
      }

  }


  //crea una noticia
  public function create_news($obj){

    $errors = array();
    $news = new News();
    //Se valida campo por campo
    // $errors['titulo'] = "Maximo de 100 caracteres.";

    $news->titulo = $obj->titulo;
    $news->copete = $obj->copete;
    $news->cuerpo = $obj->cuerpo;
    $news->autor = Auth()->user()->nombre;
    $news->fuente = $obj->fuente;
    $news->portada = $obj->portada;
    $news->fecha = Carbon::today();
    //$news->portada = file_get_contents();
    $news->save();

    //si se encuentran errores, el estado de la validacion es ERROR, si no es OK.
    if (sizeof($errors)>0){
      $validateResponse['state']  = "ERROR";
      $validateResponse['errors'] = $errors;
    }else{
      $validateResponse['state']  = "OK";
      $validateResponse['news']  = $news;
    }

    return $validateResponse;
  }

//crea un premio
  public function create_award($obj){
      echo "llego a la pagina de crear premios";
  }*/


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
      $news = News::find($news_id);
      return view('novelties/news_profile', compact('news'));
    }


}
