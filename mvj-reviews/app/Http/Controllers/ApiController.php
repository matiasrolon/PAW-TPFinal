<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Film;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

// use function GuzzleHttp\json_decode;

class ApiController extends Controller
{
    // Esto iria en el .env?
    protected $API_KEY = '41b4c84d818976ed8ab5cb8bd88066a3';

    /**
     * Modificado para que funcione con los archivos en castellano.
     */
    public function getConfig($config, $abreviacion)
    {
        if ($config == 'pais') {
            // $archivo = Storage::get('api.countries.json');
            $archivo = Storage::get('api.countries.es.json');
            $contenido = json_decode($archivo);
            $i = 0;
            $idioma = false;
            while (!$idioma && $i < sizeof($contenido)) {
                // Error raro sino pongo el isset()
                if (isset($contenido[$i]->iso_3166_1) && $contenido[$i]->iso_3166_1 == $abreviacion) {
                    // $idioma =  $contenido[$i]->english_name;
                    $idioma =  $contenido[$i]->spanish_name;
                }
                $i++;
            }
            return $idioma;
        }
        if ($config == 'genero') {
            // $archivo = Storage::get('api.genres.json');
            $archivo = Storage::get('api.genres.es.json');
            $contenido = json_decode($archivo);
            $i = 0;
            $genero = false;
            while (!$genero && $i < sizeof($contenido)) {
                if (isset($contenido[$i]->id) && $contenido[$i]->id == $abreviacion) {
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
    private function getFilmHash($filmApi)
    {
        // La funcion serialize es muy lenta comparada con json_encode
        // Pero json_encode dio el error: Malformed UTF-8 characters, possibly incorrectly encoded.
        // Algun otra alternativa?
        return sha1(serialize($filmApi));
    }

    /**
     * Recupera la portada de la obra mediante la API.
     * Esta funcion es CONSIDERABLEMENTE lenta.
     * @param string $urlPoster URL que proporciona la API.
     * @return binary|false la imagen.
     */
    private function getPosterFilm($urlPoster) {
        if (Auth()->user() != null && Auth()->user()->hasRole('admin')) {
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
        } else {
            return response()->view('errors.403', [], 403);
        }
    }

    /**
     * Recibe la pelicula o serie de la API.
     * En Film['poster'] guarda la URL de la imagen. Mas tarde debera ser recuperada.
     * Para ello utilizar getPosterFilm()
     * @todo
     * * Que agregue el trailer sugerido por la API. Esta tarea podria quedar a cargo del administrador?
     * * Cantidad de temporadas? --> Si lo agregan en la BD
     * @return Film|false. Devuelve una instancia de Film lista para almacenar en la BD.
     */
    private function parseFilm($filmAPI)
    {
        try {
            $film = new Film();

            if (isset($filmAPI['title'])) {
                $film['titulo'] = $filmAPI['title'];
            } else {
                $film['titulo'] = '';
            }
            // Convierto pais a string separado por comas.
            if (isset($filmAPI['origin_country'])) {
                $abreviacion = trim(implode(',', $filmAPI['origin_country']));
                $pais = $this->getConfig('pais', $abreviacion);
                $film['pais'] = $pais;
            } else {
                $film['pais'] = '';
            }
            // Generalmente vienen varios generos
            if (isset($filmAPI['genre_ids'])) {
                $generos = array();
                for ($i = 0; $i < sizeof($filmAPI['genre_ids']); $i++) {
                    $generos[] = $this->getConfig('genero', $filmAPI['genre_ids'][$i]);
                }
                $film['genero'] = $generos; // Arreglo
            } else {
                $film['genero'] = '';
            }
            if (isset($filmAPI['overview'])) {
                $film['sinopsis'] = $filmAPI['overview'];
            } else {
                $film['sinopsis'] = '';
            }
            // A menudo este campo no esta disponible
            if (isset($filmAPI['runtime'])) {
                $film['duracion_min'] = $filmAPI['runtime'];
            } else {
                $film['duracion_min'] = '';
            }
            // Categoria
            if (isset($filmAPI['media_type'])) {
                if ($filmAPI['media_type'] == 'movie') { // Pelicula
                    $film['categoria'] = Film::PELICULA;
                } elseif ($filmAPI['media_type'] == 'tv') { // Serie
                    $film['categoria'] = Film::SERIE;
                }
            } else {
                $film['categoria'] = '';
            }
            // Ya termino la serie
            if (isset($filmAPI['in_production']) && isset($filmAPI['last_air_date'])) {
                if ($filmAPI['in_production'] == false) {
                    $film['fecha_finalizacion'] = $filmAPI['last_air_date'];
                }
            } else {
                $film['fecha_finalizacion'] = '';
            }

            if (isset($filmAPI['poster_path'])) {
                $film['poster'] = 'https://image.tmdb.org/t/p/w500' . $filmAPI['poster_path'];
            } else {
                $film['poster'] = '';
            }

            // Requiere de un parseo complejo
            // $film['trailer'] = "";

            // Fecha de estreno
            if (isset($filmAPI['release_date'])) {
                $film['fecha_estreno'] = $filmAPI['release_date']; // ESTA EN INGLES.
            } else {
                $film['fecha_estreno'] = '';
            }
            if (isset($filmAPI['first_air_date'])) {
                $film['fecha_estreno'] = $filmAPI['first_air_date']; // ESTA EN INGLES.
            }

            // ID. idPelicula != idSerie para la API
            if (isset($filmAPI['id'])) {
                $film['id_themoviedb'] = $filmAPI['id'];
            } else {
                $film['id_themoviedb'] = '';
            }

            // Funcion hasa sobre la obra para posterior comparacion
            // Paso la obra a json para que sea string (necesario para el sha1)
            // $film['hash'] = $this->getFilmHash($obraAPI);

            return $film;
        } catch (Exception $e) {
            Log::error($e . ' --- Error en el metodo parseFilm() de ApiController. IdObraAPI: ' . $filmAPI['title'] || '');
            return false;
        }
    }


    /**
     * Esta funcion debe ser utilizada para almacenar la obra. Aunque no se si deberia hacerlo aca.
     * Hace una nueva solicitud a la API para traer todos los detalles.
     * @return boolean Se guardo o no en la BD
     */
    public function storeFilm()
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
                $tmp = $this->parseFilm($resp);
                if ($tmp != false) {
                    $obra = $tmp;
                    // Consigo la portada
                    $obra['poster'] = $this->getPosterFilm($obra['poster']);
                    if ($obra['poster'] == false) {
                        $obra['poster'] = "";
                    } else {
                        $obra['hash'] = $this->getFilmHash($tmp); // Evito el hash de la imagen
                        $obra['categoria'] = $film['categoria']; // Esto NO esta demas

                        // Guardo la obra en la BD. ESTA BIEN QUE LO HAGA ACA? CREO QUE NO. #PREGUNTAEXISTENCIAL
                        // IMPORTANTE: No se como validar que no existe otro film con el mismo 'id_themoviedb'
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
            Log::error($e . " --- Error en el metodo storeFilm() de ApiController.");
        }
    }



    /**
     * Busca tanto peliculas como series en base a su nombre en castellano e ingles.
     * @param string $keywords Lo que introduce el usuario en el buscador
     * @return array|false. Un arreglo de Film con los resultados que dio la API.
     * Los campos del arreglo son los mismos que los de Film
     */
    public function admin_search($keywords) {
        if (Auth()->user() != null && Auth()->user()->hasRole('admin')) {
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
                    'include_adult' => 'false'
                ];

                //WARNING: 40 requests every 10 seconds max
                $films = array(); // Aca devuelvo el resultado
                $page = 1;
                $total_pages = 1; // Al menos una pagina
                // Modifico para que no traiga mas de 3 paginas
                while ($page <= $total_pages && $total_pages <= 3) {
                    // Voy pidiendo las paginas de a una.
                    $parameters['page'] = strval($page); // Convierto a string
                    $httpResponse = $client->request($method, $url, ['query' => $parameters]);
                    if ($httpResponse->getStatusCode() == 200) {
                        $jsonApi = $httpResponse->getBody()->getContents();
                        $resp = json_decode($jsonApi, true);
                        $total_results = (int)$resp['total_results']; // Cant peliculas encontradas
                        $total_pages = (int)$resp["total_pages"]; // Total de paginas
                        $results = $resp["results"]; // Arreglo

                        $fc = new FilmController;
                        // Recorro films (Pueden ser peliculas, series o actores)
                        for ($i = 0; $i < sizeof($results); $i++) {
                            if ($results[$i]['media_type'] != 'person') { //por ahora no buscamos personas
                                $tmp = $this->parseFilm($results[$i]);
                                if ($tmp != false) {
                                    $films[] = $tmp;
                                }
                            }
                        }
                        $page++;
                    } else { // si la request a la API no fue exitosa
                        $films = false;
                    }


                    // Para que no se cuelgue la API, espero 0.33 segundos.
                    // Creo que aun puede mejorarse, pero hay otras prioridades.
                    usleep(333333);
                }
                /* Revisar este codigo */
                /* FIXME: Aca lo correcto es devolver 500 */
                return response()->json($films, $httpResponse->getStatusCode());
            } catch (RequestException $e) {
                // http://docs.guzzlephp.org/en/stable/quickstart.html#exceptions
                Log::error($e . ' --- Error en el metodo search() de ApiController.');
                return response()->json('Error de TheMovieDB', $e->getResponse()->getStatusCode());
            }
        } else {
            return response()->view('errors.403', [], 403);
        }
    }
}
