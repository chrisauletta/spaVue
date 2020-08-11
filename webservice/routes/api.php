<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use app\Conteudo;
use app\Comentario;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/cadastro', 'UsuarioController@cadastro');

Route::post('/login','UsuarioController@login');



Route::middleware('auth:api')->get('/usuario', 'UsuarioController@usuario');

Route::middleware('auth:api')->put('/perfil', 'UsuarioController@perfil');

Route::get('/teste', function(){
    $user = User::find(1);
    $user->conteudos()->create([
        'titulo' => "teste1",
        'texto' => "testetex",
        'imagem' => "imagem",
        'link' => "link",
        'data' => "2020-08-11"
    ]);
    return $user->conteudos;
});