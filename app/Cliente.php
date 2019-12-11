<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table= 'clientes';
    protected $primaryKey= 'idClientes';
    protected $fillable= ['nombreClientes', 'rutClientes', 'telefonoClientes', 'comunaClientes', 'correoClientes', 'anfitrionClientes'];
    public function transaccion(){
        return $this->hasMany('App\transaccion');
    }
//    public function referido(){
//        return $this->belongsTo('socios', 'asociar', 'idSocios', 'asociadoId');
//    }
    // public function sconereferir(){
    //     return $this->hasMany('socios', 'asociar', 'idSocios', 'asociadoId');
    // }
    
}
