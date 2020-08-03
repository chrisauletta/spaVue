<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function cadastro(Request $request) {
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
    }

    public function login(Request $request) {
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
          $user->imagem = asset($user->imagem);
          return $user;
        }else{
          return ['status'=>false];
        }
    
    }
    
    public function usuario(Request $request) {
        return $request->user();
    }

    public function perfil(Request $request) {
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
        //$user->password = bcrypt($data['password']);
        $user->name = $data['name'];
        //$user->email = $data['email'];
        // return 'foi';
        if(isset($data['imagem'])){
            $time = time();
            $diretorioPai = 'perfils';
            $diretorioImagem = $diretorioPai.DIRECTORY_SEPARATOR.'perfil_id'.$user->id;
            $ext = substr($data['imagem'], 11, strpos($data['imagem'], ';') - 11);
            $urlImagem = $diretorioImagem.DIRECTORY_SEPARATOR.$time.'.'.$ext;
    
            $file = str_replace('data:image/'.$ext.';base64,','',$data['imagem']);
            $file = base64_decode($file);
            if(!file_exists($diretorioPai)){
            mkdir($diretorioPai,0700);
            }
            if($user->imagem){
            if(file_exists($user->imagem)){
            unlink($user->imagem);
            }
            }
            if(!file_exists($diretorioImagem)){
            mkdir($diretorioImagem,0700);
            }
            file_put_contents($urlImagem,$file);
    
            $user->imagem = $urlImagem;
        }
        //return $data['imagem'];
        $user->save();
        $user->imagem = asset($user->imagem);
        $user->token = $user->createToken($user->email)->accessToken;
        
        return $user;
    }
}
