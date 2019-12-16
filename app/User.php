<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table='usuarios';
    protected $primarykey='id';
    protected $fillable =['nickUsuarios', 'password'];
    
    protected $hidden=[
        'password', 'remember_token',
    ];

    public function rol(){
        return $this->belongsTo('App\Rol');
    }

}
