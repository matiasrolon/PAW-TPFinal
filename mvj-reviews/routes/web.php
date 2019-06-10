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

Route::get('/', function () {
    return view('home');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/perfil', 'UserController@profile')->name('perfil');

Auth::routes(); // para Login, olvido su contraseña(esta no anda), y registrarse

Route::get('/obras','ObraController@index');
