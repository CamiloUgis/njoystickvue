<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneroProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genero_producto', function (Blueprint $table) {
            $table->Integer('idGeneros')->unsigned();
            $table->Integer('idProductos')->unsigned();
            

            $table->foreign('idGeneros')->references('idGeneros')->on('generos');
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
        Schema::dropIfExists('genero_producto');
    }
}
