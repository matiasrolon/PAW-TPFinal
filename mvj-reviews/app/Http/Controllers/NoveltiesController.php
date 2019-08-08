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

      if (Auth()->user()!=null){
          if (Auth()->user()->hasRole('admin')){
              $countries = FilmController::getCountries();
              return view('novelties/admin-novelties',compact('countries'));

          }else{return response()->view('errors.403', [], 404);} //personalizar error (no posee los permisos necesarios)
      }else{return response()->view('errors.403', [], 404);}
  }

  public function create_news(Request $request){
    //mensajes en caso de fallar cada validacion
      $messages = [
        'required' => 'El campo :attribute es requerido.',
      ];
      //validaciones (AGREGAR)
      $validator = Validator::make($request->input(), [
          'titulo' => 'required',
          'copete' => 'required',
          'cuerpo' => 'required',

          'fuenteNews' => 'required',
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
        $news->fuente = $request->input('fuenteNews');
        $news->portada = file_get_contents($request->file('portadaNews'));
        $news->fecha = Carbon::today();
        $news->save();

        return redirect()->route('news-profile', ['news_id' => $news->id]);
      };
  }//end create_news


  public function create_award(Request $request){
    //mensajes en caso de fallar cada validacion
      $messages = [
        'required' => 'El campo :attribute es requerido.',
      ];
      //validaciones (AGREGAR)
      $validator = Validator::make($request->all(), [
          'nombre' => 'required',
          'fecha' => 'required',
          'pais' => 'required',
          'fuenteAward' => 'required',
          'portadaAward' => 'required',
      ],$messages);

      if ($validator->fails()) {
          return redirect()
                 ->route('admin-novelties')
                 ->withInput()
                 ->withErrors($validator);
      }else{
        //Si no hay errores, guardo el premio
        $award = new Award();
        $award->nombre = $request->input('nombre');
        $award->descripcion = $request->input('descripcion');
        $award->fecha_realizacion = $request->input('fecha');
        $award->pais = $request->input('pais');
        $award->autor = Auth()->user()->nombre;
        $award->fuente = $request->input('fuenteAward');
        $award->portada = file_get_contents($request->file('portadaAward'));
        $award->save();

        //guardo las categorias
        $nroCategory = 1;
        $finish1 = false;
        // saldra cuando el nro de categoria a buscar no exista en ningun name de un input
        while (!$finish1){
            $fieldNombre = 'categoria_nombre_' . $nroCategory;//nombre del input
            $fieldDescripcion = 'categoria_descripcion_' . $nroCategory;
            if($request->has($fieldNombre)){//si la categoria a buscar existe.
              $category = new Category();
              $category->nombre = $request->input($fieldNombre);
              $category->descripcion = $request->input($fieldDescripcion);
              $category->award_id = $award->id;
              $category->save();
                  //inserto nominados para esa categoria
                  $nroNominee = 1;
                  $finish2 = false;
                  while (!$finish2){
                    $fieldNombre = 'nominado_nombre_' . $nroCategory . '_' . $nroNominee;//nombre del input
                    $fieldDescripcion = 'nominado_descripcion_' . $nroCategory . '_' . $nroNominee;
                    if ($request->has($fieldNombre)){//si ese numero de nominado existe.
                      $nominee = new Nominee();
                      $nominee->nombre = $request->input($fieldNombre);
                      $nominee->descripcion = $request->input($fieldDescripcion);
                      //AGREGAR > CAMPO INPUT RESULTADO.
                      $nominee->resultado = "nominado";
                      $nominee->category_id = $category->id;
                      $nominee->save();
                    }else{
                      $finish2=true;
                    }
                    $nroNominee++;
                  }// end while finish2
            }else{//si esa categoria no existe
              $finish1 = true;
            }
            $nroCategory++;//paso a la siguiente categoria si existe ($finish=false).
        }
        //var_dump($request->input());
        return redirect()->route('award-profile', ['award_id' =>$award->id]);
    }//end ELSE VALIDATOR->FAILS()
}

   /* -----------------------------------------*/
  /* --------------   VISTAS   ---------------*/
 /* -----------------------------------------*/
  //noticias
  public function news(){
    //MODIFICAR> Noticias de la ultima semana, y luego cargar las mas antiguas por scroll
    $noticias = News::select('titulo','id','fecha','copete','autor',
               \DB::raw('TO_BASE64(portada) as portada'))
               ->orderBy('fecha','desc')
               ->get();
    return view('novelties/news', compact('noticias'));
  }

//estrenos
  public function premieres(){
    $hoy = Carbon::today();
    $premieres = Film::whereDate('fecha_estreno', '>=', $hoy)->select('titulo','fecha_estreno','sinopsis')->get();
     return view('novelties/premieres', compact('premieres'));
  }

//premios (general) -> Se filtran los que todavia no fueron llevados a cabo mediante la fecha.
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
    $award = Award::where('id',$award_id)
                    ->select('id','nombre','descripcion','pais','fecha_realizacion',
                             \DB::raw('TO_BASE64(portada) as portada'),'autor','fuente')
                    ->first();
    $categories = Category::where('award_id',$award->id)->get();
    foreach ($categories as $cat ) {//uno cada categoria con sus nominaciones
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
