<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneroProducto extends Model
{
    protected $table = 'genero_producto';
    protected $fillable = [
        'idGeneros', 'idProductos'
    ];
}
