<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
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
Route::post('/cadastro', function (Request $request) {
    $data = $request->all();

    $valiacao = Validator::make($data, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if($valiacao->fails()){
      return $valiacao->errors();
    }

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);
    $user->token = $user->createToken($user->email)->accessToken;

    return $user;
});

Route::post('/login', function (Request $request) {
    $data = $request->all();

    $valiacao = Validator::make($data, [
        'email' => 'required|string|email|max:255',
        'password' => 'required|string',
    ]);

    if($valiacao->fails()){
      return $valiacao->errors();
    }

    if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
      $user = auth()->user();
      $user->token = $user->createToken($user->email)->accessToken;
      return $user;
    }else{
      return ['status'=>false];
    }


});



Route::middleware('auth:api')->get('/usuario', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->put('/perfil', function (Request $request) {
//Route::put('/perfil', function (Request $request) {
  $user = $request->user();
  $data = $request->all(); 
  // $valiacao = Validator::make($data, [
  //   'name' => 'required|string|max:255',
  //   'email' => 'required|string|email|max:255|unique:users',
  //   'password' => 'required|string|min:6|confirmed',
  // ]);

  // if($valiacao->fails()){
  //   return $valiacao->errors();
  // }
  $user->password = bcrypt($data['password']);
  $user->name = $data['name'];
  $user->email = $data['email'];
  if(isset($data['imagem'])){
    $time = time();
    $diretorioPai = 'perfils';
    $diretorioImagem = $diretorioPai.DIRECTORY_SEPARATOR.'perfil_id'.user.id;
    $ext = substr($data['imagem'], 11, strpos($data['imagem'], ';') - 11);
    $urlImagem = $diretorioImagem.DIRECTORY_SEPARATOR.$time.'.'.$ext;
    return ['ok'];
  }
  $user->save();
  $user->token = $user->createToken($user->email)->accessToken;
  return $user;
});