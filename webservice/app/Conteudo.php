<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conteudo extends Model
{ 
    protected $fillable = [
        'titulo','texto','imagem','link','data'
    ];
    public function comentarios(){
        return $this->hasMany('App\Comentario');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function curtidas(){
        return $this->belongsToMany('App\User', 'curtidas', 'user_id', 'conteudo_id');
    }
}
