<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_producto', function (Blueprint $table) {
            $table->Integer('idTipos')->unsigned();
            $table->Integer('idProductos')->unsigned();
            

            $table->foreign('idTipos')->references('idTipos')->on('tipos');
            $table->foreign('idProductos')->references('idProductos')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_producto');
    }
}
