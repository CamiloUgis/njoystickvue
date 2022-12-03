<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table= 'tipos';
    protected $primaryKey= 'idTipos';
    protected $fillable= ['nombreTipos', 'descripcionTipos'];

    public function tipoProducto(){
        return $this->belongsTo('App\TipoProducto');
    }
    
}
