<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Film;

class ApiController extends Controller
{
    // Esto iria en el .env?
    protected $API_KEY = '41b4c84d818976ed8ab5cb8bd88066a3';

    public function prueba(){

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
        // var_dump($json);
        // echo ($json);
        // print_r("--------------- FIN ----------------");
        return $json;
    }
    

    public function search() {
        //$user_input no esta con los %20, sino escrito bien. Sino no funciona
        $user_input = 'Rapido y furioso'; //Es lo que pone en el buscador
        $client = new Client();
        $method = 'GET';
        $url = 'https://api.themoviedb.org/3/search/multi';

        // Parametros de la API
        $parameters = ['api_key' => '41b4c84d818976ed8ab5cb8bd88066a3',
                        'language' => 'es-MX',
                        'query' => $user_input,
                        'page' => '1',
                        'include_adult' => 'true'];

        //WARNING: 40 requests every 10 seconds max

        $page = 1;
        $total_pages = 1; // Al menos una pagina
        while ($page <= $total_pages){
            // Voy pidiendo las paginas de a una.
            $parameters['page'] = strval($page); // Convierto a string
            $httpResponse = $client->request($method, $url, ['query' => $parameters]);
            $jsonApi = $httpResponse->getBody()->getContents();
            $resp = json_decode($jsonApi, true);
            $total_results = (int) $resp['total_results']; // Cant peliculas encontradas
            $total_pages = (int) $resp["total_pages"]; // Total de paginas
            $results = $resp["results"]; // Arreglo

            // Recorro Obras (Pueden ser peliculas, series o actores)
            for ($i= 0; $i < sizeof($results); $i++){
                $film = new Film();
                // ['titulo','fecha_estreno','pais','sinopsis','duracion_min',
                //          'categoria','fecha_finalizacion','puntaje','poster'];

                // ACTUALIZAR CAMPOS
                // $film['categoria'] = $results[$i]['media_type'];
                $film['titulo'] = $results[$i]['title'];
                // $film['pais'] = $results[$i]['title'];
                $film['sinopsis'] = $results[$i]['overview'];
                // $film['duracion_min'] = $results[$i]['title'];
                // $film['fecha_finalizacion'] = $results[$i]['title'];
                // $film['puntaje'] = $results[$i]['title'];
                // $film['poster'] = $results[$i]['title'];

                if ($results[$i]['media_type'] == 'movie'){ // Pelicula
                    $film['categoria'] = 'pelicula'; // REVISAR. CAMBIARON EL TIPO EN LA BD
                    $film['fecha_estreno'] = $results[$i]['release_date']; // ESTA EN INGLES. REVISAR
                } elseif ($results[$i]['media_type'] == 'tv'){ // Serie
                    $film['categoria'] = 'serie'; // REVISAR. CAMBIARON EL TIPO EN LA BD
                    $film['fecha_estreno'] = $results[$i]['first_air_date']; // ESTA EN INGLES. REVISAR
                }

            }

            $page++;
        }


        $page = $resp['page']; // Empieza en 1



    }
}
