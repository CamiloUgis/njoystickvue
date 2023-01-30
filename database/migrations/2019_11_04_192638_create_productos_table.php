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
                $table->string('descripcionProductos', 200)->nullable();
                $table->string('marcaProductos', 30);
                $table->string('tipoProductos', 30);
                $table->integer('stockProductos')->nullable();
                $table->integer('precioProductos')->nullable();
                $table->timestamps();
                $table->unsignedInteger('idMarcas');
                $table->foreign('idMarcas')->references('idMarcas')->on('marcas');
                $table->unsignedInteger('idTipos');
                $table->foreign('idTipos')->references('idTipos')->on('tipos');
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
