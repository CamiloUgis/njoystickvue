<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table= 'clientes';
    protected $primaryKey= 'idClientes';
    protected $fillable= ['nombreClientes', 'rutClientes', 'telefonoClientes', 'comunaClientes', 
    'correoClientes'];
   
   
   
    
}
