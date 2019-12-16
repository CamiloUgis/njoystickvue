<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('idProductos');
                $table->string('nombreProductos', 100)->unique();
                $table->string('descripcionProductos', 200);
                $table->integer('stockNuevoProductos');
                $table->integer('stockUsadoProductos');
                $table->integer('precioNuevoProductos');
                $table->integer('precioUsadoProductos');
                $table->timestamps();
                $table->unsignedInteger('idPlataformas');
                $table->foreign('idPlataformas')->references('idPlataformas')->on('plataformas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
