<?php
/* Esto lo puso automaticamente el VS Code cuando escribi Route */
//use Symfony\Component\Routing\Annotation\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*CONSIDERACIONES GENERALES
  FILM -> tiene PUNTAJE (Promedio entre puntajes)
  USER -> tiene PUNTOS (Suma de las reviews)
  REVIEW -> tiene VOTOS NEGATIVOS y VOTOS POSITIVOS. (o solo votos, hay que ver).
*/

//PONER ESTADO DE LAS RUTAS Y VIEWS PARA ENTRAR A WEB.PHP Y DISTINGUIR LAS PENDIENTES MAS FACIL

Auth::routes(); // para Login, olvido su contraseña(no anda), y registrarse
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home'); //---> EMPEZADA.
Route::get('/ranking-users', 'UserController@ranking')->name('ranking-users'); //-->SIN ESTILO.
//Route::get('/profile', 'UserController@profile')->name('profile');
Route::get('/users/{username}', 'UserController@profile')->name('user_profile'); //-->SIN ESTILO.
Route::get('/ranking-films', 'FilmController@ranking')->name('ranking-films'); //-->SIN ESTILO.
Route::get('/films/{id}', 'FilmController@profile')->name('film_profile'); //-->SIN ESTILO.
Route::post('/scoreFilm','FilmController@scoreFilm')->name('scoreFilm');
Route::post('/addReview','ReviewController@addReview')->name('addReview');
Route::post('/addScoreReview','ReviewController@addScoreReview')->name('addScoreReview');
Route::get('/searchAPI', 'ApiController@search');
Route::get('/search/{filmname}','FilmController@searchLocalFilm')->name('searchFilm');




//
