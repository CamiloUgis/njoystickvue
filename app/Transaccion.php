<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table= 'transacciones';
    protected $primaryKey= 'idTransacciones';
    protected $fillable= ['tipoTransacciones', 'observacionTransacciones', 'fechaTransacciones',
     'valorFinalTransacciones'. 'formaPagoTransacciones', ];

}
