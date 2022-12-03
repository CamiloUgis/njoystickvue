<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    protected $table = 'tipo_producto';
    protected $fillable = [
        'idTipos', 'idProductos'
    ];
    public function productos(){
        return $this->hasMany('App\Producto');
    }
    public function tipos(){
        return $this->hasMany('App\Tipo');
    }
    public $timestamps = false;
}

