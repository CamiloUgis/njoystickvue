<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteProducto extends Model
{
    protected $table = 'cliente_producto';
    protected $fillable = [
        'idClientes', 'idProductos', 'abonoClienteProducto'
    ];
    public function productos(){
        return $this->hasMany('App\Producto');
    }
    public function clientes(){
        return $this->hasMany('App\Cliente');
    }
    public $timestamps = false;
}
