<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaccionesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'transacciones';

    /**
     * Run the migrations.
     * @table Transacciones
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            
            $table->increments('idTransacciones');
            $table->string('tipoTransacciones', 8);
            $table->string('observacionTransacciones', 500);
            $table->dateTime('fechaTransacciones');
            $table->integer('valorFinalTransacciones');
            $table->string('formaPagoTransacciones', 8);
            $table->date('plazoTransacciones');
            $table->string('EstadoTransacciones', 20);
            //compra o canje es null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
