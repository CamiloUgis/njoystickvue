<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClienteProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_producto', function (Blueprint $table) {
            $table->Integer('idClientes')->unsigned();
            $table->Integer('idProductos')->unsigned();
            $table->Integer('abonoClienteProducto');

            $table->foreign('idClientes')->references('idClientes')->on('clientes');
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
        Schema::dropIfExists('cliente_producto');

    }
}
