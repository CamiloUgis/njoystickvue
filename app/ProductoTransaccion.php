<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoTransaccion extends Model
{
    protected $table = 'producto_transaccion';
    protected $fillable = [
        'idProductos', 'idTransacciones'
    ];
}
