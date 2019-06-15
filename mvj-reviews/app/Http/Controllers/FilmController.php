<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Film;
use App\Models\Review;

use GuzzleHttp\Client;

class FilmController extends Controller
{
    //
    public function ranking(){
      $films = Film::orderBy('puntaje','desc')->take(100)->get();
      return view('ranking-films',compact('films'));
    }

    public function profile($film_id){
      $film = Film::where('id','=',$film_id)->first();
      $reviews = Review::where('id','=',$film_id)->get();
  //var_dump($film->titulo);
     //return $film->titulo;
      return view('film_profile',compact('film','reviews'));
    }

    public function index(){
      //Ejemplo de interaccion con api de mercado libre
          //$data = json_decode( file_get_contents('https://api.mercadolibre.com/users/226384143/'), true );
          //echo $data['nickname'];

        //Lo hago aca para probar. Despues hay que crear la estructura de objetos adecuada

        //$user_input no esta con los %20, sino escrito bien. Sino no funciona
        $user_input = 'Rapido y furioso'; //Es lo que pone en el buscador
        $client = new Client();
        $method = 'GET';
        $url2 = 'https://api.themoviedb.org/3/search/movie?api_key=41b4c84d818976ed8ab5cb8bd88066a3&language=es-MX&query=Rapido%20y%20furioso&page=1&include_adult=false';
        $url = 'https://api.themoviedb.org/3/search/movie';
        // Parametros de la API
        $parameters = ['api_key' => '41b4c84d818976ed8ab5cb8bd88066a3',
                        'language' => 'es-MX',
                        'query' => $user_input,
                        'page' => '1',
                        'include_adult' => 'false'];
        $httpResponse = $client->request($method, $url, ['query' => $parameters]);
        // $httpResponse = $client->request($method, $url2);
        // $jsonApi = $httpResponse->getBody()->getContents();
        $jsonApi = $httpResponse->getBody()->getContents();
        $json = $jsonApi;

        // $json = json_decode(file_get_contents('https://api.themoviedb.org/3/search/movie?api_key=41b4c84d818976ed8ab5cb8bd88066a3&language=es-MX&query=Rapido%20y%20furioso&page=1&include_adult=false'), true);

        // print_r("RESULTADO: ");
        echo ($json);
        // print_r("--------------- FIN ----------------");
        return $json;
    }

    /**
     * Esta funcion busca en la BD si hay coincidencias de Obras en la BD. Sino, lo busca en la API
     * y agrega las coincidencias traidas de la API.
     * Luego responde con las coincidencias.
     * @var filmName query que inserto el usuario en el buscador
     */
    public function search($filmName) {
        // Busco en nuestra BD

        // Busco en OMDB

    }

    public function store(Request $request)
    {
        // Validate the request...
        $validator = Validator::make($request, [
            'titulo' => 'required|max:100',
            'fecha_estreno' => 'date',
            'sinopsis' => 'required|max:500',
            'anio' => 'regex:/[0-9]{4}/',
            'pais' => 'max:30',
            'duracion_min' => 'regex:/[0-9]+/',
            'categoria' => 'regex:/[0-9]{4}/',
            'fecha_finalizacion' => 'date'
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();

        $obra = new Film;
        $obra->titulo = $request->titulo;
        $obra->fecha_estreno = $request->fecha_estreno;
        $obra->sinopsis = $request->sinopsis;
        $obra->pais = $request->pais;
        $obra->duracion_min = $request->duracion_min;
        $obra->categoria = $request->categoria;
        $obra->fecha_finalizacion = $request->fecha_finalizacion;
        $obra->puntaje = 0;
        $obra->save();
    };
}

}
