<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table= 'transacciones';
    protected $primaryKey= 'idTransacciones';
    protected $foreignKey= 'idClientes';
    protected $fillable= ['tipoTransacciones', 'observacionTransacciones', 'fechaTransacciones',
    'puntosTransacciones', 'valorFinalTransacciones', 'descuentoTransacciones', 'formaPagoTransacciones', 'plazoTransacciones',
    'estadoTransacciones'];
    public $timestamps = false;

    public function clientes(){
        return $this->belongsTo('App\Cliente', 'idClientes');
    }
    
    
}
