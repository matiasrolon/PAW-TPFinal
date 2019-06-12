<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Film;

class FilmController extends Controller
{
    //

    public function index(){
      //Ejemplo de interaccion con api de mercado libre
          //$data = json_decode( file_get_contents('https://api.mercadolibre.com/users/226384143/'), true );
          //echo $data['nickname'];
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
