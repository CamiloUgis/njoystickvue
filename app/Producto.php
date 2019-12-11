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
        'stockNuevoProductos',
        'stockUsadoProductos',
    ];
   
    public function plataforma(){
        return $this->hasOne('App\Plataforma');
    }
    
    public function generos(){
        return $this->belongsToMany('App\Genero');
    }
}
