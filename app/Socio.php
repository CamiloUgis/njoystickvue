<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    protected $table= 'socios';
    protected $foreignKey= 'idClientes';
   
    protected $fillable=['idClientes',
    'estadoSocios',
    'invitador',
    'puntosReferidosSocios',
    'puntosPropiosSocios'
    ];
    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }
    public function referidos(){
        return $this->hasMany('App\Socio');
    }
}
