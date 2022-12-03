<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos'; //asigna la base de datos
    protected $primaryKey ='idProductos'; // clave primaria
    protected $fillable = [
        'nombreProductos',
        'descripcionProductos',
        'precioProductos',
        'stockProductos',
    ];
   
    public function marca(){
        return $this->hasOne('App\Marca');
    }
    public function tipoProducto(){
        return $this->belongsTo('App\TipoProducto');
    }
    
}
