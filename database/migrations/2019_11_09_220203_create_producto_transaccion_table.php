<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTransaccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_transaccion', function (Blueprint $table) {
            $table->Integer('idProductos')->unsigned();
            $table->Integer('idTransacciones')->unsigned();
            

            $table->foreign('idProductos')->references('idProductos')->on('productos');
            $table->foreign('idTransacciones')->references('idTransacciones')->on('transacciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_transaccion');
    }
}
