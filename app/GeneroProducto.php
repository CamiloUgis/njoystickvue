<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneroProducto extends Model
{
    protected $table = 'genero_producto';
    protected $fillable = [
        'idGeneros', 'idProductos'
    ];
    public function productos(){
        return $this->hasMany('App\Producto');
    }
    public function generos(){
        return $this->hasMany('App\Genero');
    }
    public $timestamps = false;
}

