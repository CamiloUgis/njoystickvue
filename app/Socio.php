<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    protected $table= 'socios';
    protected $primaryKey='idClientes';
    public $incrementing = false;
    protected $foreignKey= 'invitador';
   
    protected $fillable=['idClientes',
    'estadoSocios',
    'invitador',
    'puntosActualesSocios',
    'puntosReferidosSocios',
    'puntosPropiosSocios'
    ];
    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }
    public function referidos(){
        return $this->hasMany('App\Socio');
    }
    public function anfitrion(){
        return $this->belongsTo('App\Socio', 'invitador', 'idClientes');
    }
}
