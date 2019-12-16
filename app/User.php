<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table='usuarios';
    protected $primarykey='idUsuarios';
    protected $fillable =['nickUsuarios', 'passwordUsuarios'];
    
    protected $hidden=[
        'passwordUsuarios', 'remember_token',
    ];

    public function rol(){
        return $this->belongsTo('App\Rol');
    }

}
