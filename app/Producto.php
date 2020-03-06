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
        'precioNuevoProductos',
        'precioUsadoProductos',
        'stockProductos',
    ];
   
    public function plataforma(){
        return $this->hasOne('App\Plataforma');
    }
    public function generoProducto(){
        return $this->belongsTo('App\GeneroProducto');
    }
    
}
