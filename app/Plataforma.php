<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{
    protected $table= 'plataformas';
    protected $primaryKey= 'idPlataformas';
    protected $fillable= ['nombrePlataformas', 'descripcionPlataformas', 'cantNuevoPlataformas', 'cantUsadoPlataformas'];

   

    public function producto(){
        return $this->hasMany('App\Producto');
    }
}