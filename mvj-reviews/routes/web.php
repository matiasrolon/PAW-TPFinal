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

Auth::routes(); // para Login, olvido su contraseña(no anda), y registrarse
//home
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home'); //---> EMPEZADA.
//usuarios
Route::get('/ranking-users', 'UserController@ranking')->name('ranking-users'); //-->SIN ESTILO.
Route::get('/users/{username}', 'UserController@profile')->name('user_profile');
//reviews
Route::post('/addReview','ReviewController@addReview')->name('addReview');
Route::post('/addScoreReview','ReviewController@addScoreReview')->name('addScoreReview');
Route::get('/lastReviews','ReviewController@lastReviews');
//films
Route::post('/storeFilm', 'FilmController@store')->name('store-film');
Route::get('/film-by-genre/{genro}/{category}/{offset}/{qty}', 'FilmController@searchByGenre')->name('film-by-genre');
Route::get('/ranking-films', 'FilmController@ranking')->name('ranking-films');
Route::get('/films/{id}', 'FilmController@profile')->name('film_profile');
Route::post('/scoreFilm','FilmController@scoreFilm')->name('scoreFilm');
Route::get('/searchSuggestions/{filmname}','FilmController@searchSuggestions')->name('searchLocalFilm');
Route::get('/search/{filmname}','FilmController@searchResults')->name('search');
//novedades
Route::get('/novelties/news','NewnessController@news')->name('news');
Route::get('/novelties/admin','NewnessController@admin_novelties')->name('admin-novelties');
Route::get('/novelties/premieres','NewnessController@premiere')->name('premieres');//NO ANDA
Route::get('/novelties/awars','NewnessController@awards')->name('awards');//NO ANDA

//para administradores
Route::get('/admin/films','FilmController@admin_films')->name('admin-films');
Route::get('/admin/searchFilms/API/{filmname}','ApiController@admin_search');
Route::get('/admin/searchFilms/DB/{filmname}','FilmController@admin_search');
Route::get('/get-last-reviews','ReviewController@getLastReviews')->name('get-last-reviews');
//Route::get('/searchAPI/{keywords}', 'ApiController@search');
//Route::post('/storeFilm', 'ApiController@storeFilm');
