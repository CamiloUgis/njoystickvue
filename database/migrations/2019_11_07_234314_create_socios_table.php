<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->unsignedInteger('idClientes');
            $table->foreign('idClientes')->references('idClientes')->on('clientes');
            $table->boolean('estadoSocios');
            $table->integer('puntosSocios');
            $table->timestamps();
            $table->unsignedInteger('Socio_idClientes');
            $table->foreign('Socio_idClientes')->references('idClientes')->on('socios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socios');
    }
}
