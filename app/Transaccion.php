<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table= 'transacciones';
    protected $primaryKey= 'idTransacciones';
    protected $foreignKey= 'socio_Id';
    protected $fillable= ['tipoTransacciones', 'puntosTransacciones'];
    public function socio()
    {
        return $this->belongsTo('App\Socio', 'socio_Id');
    }
    
    
}
