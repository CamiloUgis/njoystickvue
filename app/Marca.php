<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table= 'marcas';
    protected $primaryKey= 'idMarcas';
    protected $fillable= ['nombreMarcas', 'descripcionMarcas', 'cantidadMarcas'];

   
    public function producto(){
        return $this->hasMany('App\Producto');
    }
}