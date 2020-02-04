<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneroProducto extends Model
{
    protected $table = 'genero_producto';
    protected $fillable = [
        'idGeneros', 'idProductos'
    ];
    public function genero(){
        return $this->belongsTo('App\Genero');
    }
    public function producto(){
        return $this->belongsTo('App\Producto');
    }
}
