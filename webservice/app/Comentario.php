<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'conteudo_id','texto', 'data'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function Conteudo(){
        return $this->belongsTo('App\Conteudo');
    }
}
