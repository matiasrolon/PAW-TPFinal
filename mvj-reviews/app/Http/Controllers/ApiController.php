<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Film;
use Storage;
// use function GuzzleHttp\json_decode;

class ApiController extends Controller
{
    // Esto iria en el .env?
    protected $API_KEY = '41b4c84d818976ed8ab5cb8bd88066a3';

    public function getConfig($config, $abreviacion)
    {
        if ($config == 'pais') {
            $archivo = Storage::get('api.countries.json');
            $contenido = json_decode($archivo);
            $i = 0;
            $idioma = false;
            while (!$idioma && $i < sizeof($contenido)) {
                if ($contenido[$i]->iso_3166_1 == $abreviacion) {
                    $idioma =  $contenido[$i]->english_name;
                }
                $i++;
            }
            return $idioma;
        }
        if ($config == 'genero') {
            $archivo = Storage::get('api.genres.json');
            $contenido = json_decode($archivo);
            $i = 0;
            $genero = false;
            while (!$genero && $i < sizeof($contenido)) {
                if ($contenido[$i]->id == $abreviacion) {
                    $genero =  $contenido[$i]->name;
                }
                $i++;
            }
            return $genero;
        }
        if ($config == 'config') { }
    }


    /**
     * * Utilizada para comparar la obra obtenida de la API con el hash almacenado en la BD,
     * el cual pertenece la misma obra, que fue almacenada en un momento anterior.
     * @param $obraApi 
     * Recibe una obra como arreglo.
     * @return string. sha1 de la obra.
     */
    private function getHashObra($obraApi)
    {
        // La funcion serialize es muy lenta comparada con json_encode
        // Pero json_encode dio el error: Malformed UTF-8 characters, possibly incorrectly encoded.
        // Algun otra alternativa?
        return sha1(serialize($obraApi));
    }

    /**
     * Recupera la portada de la obra mediante la API.
     * Esta funcion es CONSIDERABLEMENTE lenta.
     * @param string $urlPoster URL que proporciona la API.
     * @return binary|false la imagen.
     */
    private function getPortadaObra($urlPoster)
    {
        $client = new Client();
        $basePath = 'https://image.tmdb.org/t/p/original';
        $path =  $basePath . $urlPoster; // Trae un Slash / por defecto.
        $httpResponse = $client->request('GET', $path);
        if ($httpResponse->getStatusCode() == 200) {
            $poster = $httpResponse->getBody()->getContents();
            // Es necesario guardar la extension? En ese caso, viene al final de poster_path.
            // $film['poster'] = base64_encode($poster);
            return $poster;
        } else {
            return false;
        }
    }

    /**
     * Recibe la pelicula o serie de la API.
     * En Film['poster'] guarda la URL de la imagen. Mas tarde debera ser recuperada.
     * Para ello utilizar getPortadaObra()
     * @todo 
     * * Que agregue el trailer sugerido por la API. Esta tarea podria quedar a cargo del administrador?
     * * Cantidad de temporadas? --> Si lo agregan en la BD
     * @return Film|false. Devuelve una instancia de Film lista para almacenar en la BD.
     */
    private function parsearObra($obraAPI)
    {
        try {
            $film = new Film();
            /* protected $fillable = ['titulo','fecha_estreno','pais','sinopsis','duracion_min',
                          'categoria','fecha_finalizacion','puntaje','poster','trailer'];
                          */

            if (isset($obraAPI['title'])) {
                $film['titulo'] = $obraAPI['title'];
            }
            // Convierto pais a string separado por comas.
            if (isset($obraAPI['origin_country'])) {
                $abreviacion = trim(implode(',', $obraAPI['origin_country']));
                $pais = $this->getConfig('pais', $abreviacion);
                $film['pais'] = $pais;
            }
            if (isset($obraAPI['overview'])) {
                $film['sinopsis'] = $obraAPI['overview'];
            }
            // A menudo este campo no esta disponible
            if (isset($obraAPI['runtime'])) {
                $film['duracion_min'] = $obraAPI['runtime'];
            }
            if (isset($obraAPI['media_type'])) {
                $film['categoria'] = $obraAPI['media_type'];
            }
            // Ya termino la serie
            if (isset($obraAPI['in_production']) && isset($obraAPI['last_air_date'])) {
                if ($obraAPI['in_production'] == false) {
                    $film['fecha_finalizacion'] = $obraAPI['last_air_date'];
                }
            }
            // if (isset()) {$film[''] = ;}
            // $film['puntaje'] = $obraAPI['vote_average'];

            if (isset($obraAPI['poster_path'])) {
                $film['poster'] = $obraAPI['poster_path'];
            }

            // Requiere de un parseo complejo
            // $film['trailer'] = "";

            // Categoria
            if (isset($obraAPI['media_type'])) {
                if ($obraAPI['media_type'] == 'movie') { // Pelicula
                    $film['categoria'] = 'pelicula';
                } elseif ($obraAPI['media_type'] == 'tv') { // Serie
                    $film['categoria'] = 'serie';
                }
            }

            // Fecha de estreno
            if (isset($obraAPI['release_date'])) {
                $film['fecha_estreno'] = $obraAPI['release_date']; // ESTA EN INGLES.
            }
            if (isset($obraAPI['first_air_date'])) {
                $film['fecha_estreno'] = $obraAPI['first_air_date']; // ESTA EN INGLES.
            }

            // ID. idPelicula != idSerie para la API
            if (isset($obraAPI['id'])) {
                $film['id_themoviedb'] = $obraAPI['id'];
            }

            // Funcion hasa sobre la obra para posterior comparacion
            // Paso la obra a json para que sea string (necesario para el sha1)
            // $film['hash'] = $this->getHashObra($obraAPI);

            return $film;
        } catch (Exception $e) {
            Log::error($e . ' --- Error en el metodo parsearObra() de ApiController. IdObraAPI: ' . $obraAPI['title'] || '');
            return false;
        }
    }


    /**
     * Esta funcion debe ser utilizada para almacenar la obra. Aunque no se si deberia hacerlo aca.
     * Hace una nueva solicitud a la API para traer todos los detalles.
     * @return boolean Se guardo o no en la BD
     */
    public function guardarObra()
    {
        try {
            // Objeto Film
            $film = json_decode($_POST('objeto'), TRUE);
            // $film = array();
            // $film['id_themoviedb'] = 238;
            // $film['categoria'] = 'pelicula';
            $client = new Client();
            $method = 'GET';
            if ($film['categoria'] == 'serie') {
                $url = 'https://api.themoviedb.org/3/tv/' . $film['id_themoviedb'];
            } elseif ($film['categoria'] == 'pelicula') {
                $url = 'https://api.themoviedb.org/3/movie/' . $film['id_themoviedb'];
            }

            // Parametros de la API
            $parameters = [
                'api_key' => '41b4c84d818976ed8ab5cb8bd88066a3',
                'language' => 'es-MX',
            ];

            $httpResponse = $client->request($method, $url, ['query' => $parameters]);
            if ($httpResponse->getStatusCode() == 200) {
                $jsonApi = $httpResponse->getBody()->getContents();
                $resp = json_decode($jsonApi, true);
                $tmp = $this->parsearObra($resp);
                if ($tmp != false) {
                    $obra = $tmp;
                    // Consigo la portada
                    $obra['poster'] = $this->getPortadaObra($obra['poster']);
                    if ($obra['poster'] == false) {
                        $obra['poster'] = "";
                    } else {
                        $obra['hash'] = $this->getHashObra($tmp); // Evito el hash de la imagen
                        $obra['categoria'] = $film['categoria']; // Esto NO esta demas

                        // Guardo la obra en la BD. ESTA BIEN QUE LO HAGA ACA? CREO QUE NO. #PREGUNTAEXISTENCIAL
                        // Deberia ser un JSON?
                        if ($obra->save()) {
                            return response()->json('OK: Obra guardada correctamente.');
                        } else {
                            return response()->json('Error: No se ha guardado la obra.', 500);
                        }

                        // return response($obra['hash'], 200);
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            Log::error($e . " --- Error en el metodo guardarObra() de ApiController.");
        }
    }

    /**
     * Busca tanto peliculas como series en base a su nombre en castellano e ingles.
     * @param string $keywords Lo que introduce el usuario en el buscador 
     * @return array|false. Un arreglo de Film con los resultados que dio la API.
     * Los campos del arreglo son los mismos que los de Film
     */
    public function search($keywords)
    {
        try {
            //$user_input no esta con los %20, sino escrito bien. Sino no funciona
            // $user_input = 'Silicon valley'; //Es lo que pone en el buscador
            $user_input = $keywords;
            $client = new Client();
            $method = 'GET';
            $url = 'https://api.themoviedb.org/3/search/multi';

            // Parametros de la API
            $parameters = [
                'api_key' => '41b4c84d818976ed8ab5cb8bd88066a3',
                'language' => 'es-MX',
                'query' => $user_input,
                'page' => '1',
                'include_adult' => 'true'
            ];

            //WARNING: 40 requests every 10 seconds max
            $films = array(); // Aca devuelvo el resultado
            $page = 1;
            $total_pages = 1; // Al menos una pagina
            while ($page <= $total_pages) {
                // Voy pidiendo las paginas de a una.
                $parameters['page'] = strval($page); // Convierto a string
                $httpResponse = $client->request($method, $url, ['query' => $parameters]);
                if ($httpResponse->getStatusCode() == 200) {
                    $jsonApi = $httpResponse->getBody()->getContents();
                    $resp = json_decode($jsonApi, true);
                    $total_results = (int)$resp['total_results']; // Cant peliculas encontradas
                    $total_pages = (int)$resp["total_pages"]; // Total de paginas
                    $results = $resp["results"]; // Arreglo

                    // Recorro Obras (Pueden ser peliculas, series o actores)
                    for ($i = 0; $i < sizeof($results); $i++) {
                        $tmp = $this->parsearObra($results[$i]);
                        if ($tmp != false) {
                            //Agrego la obra al arreglo
                            $films[] = $tmp;
                        }
                    }
                    $page++;
                } else {
                    $films = false;
                }

                // Para que no se cuelgue la API, espero 1 seg entre cada pagina.
                sleep(1);
            }
            // var_dump($httpResponse->getStatusCode());
            // print("AQUI VA MI VAR DUMP: \n");
            $json = json_encode($films); // Todo debe ser UTF-8
            return response()->json($films);
        } catch (Exception $e) {
            Log::error($e . ' --- Error en el metodo search() de ApiController.');
        }
    }
}
