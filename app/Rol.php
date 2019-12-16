<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rol;

class Rol extends Model
{
    protected $table='roles';
    protected $primarykey='idRoles';
    protected $fillable =['nombreRoles', 'descripcionRoles'];
    public $timestamps = false;

    public function usuarios(){
        return $this->hasMany('App\User');
    }
}
