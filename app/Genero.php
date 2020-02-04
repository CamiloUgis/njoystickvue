<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    protected $table= 'generos';
    protected $primaryKey= 'idGeneros';
    protected $fillable= ['nombreGeneros', 'descripcionGeneros'];

    public function generoProducto(){
        return $this->hasMany('App\GeneroProducto');
    }
    
}
