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
            $table->integer('puntosReferidosSocios');
            $table->integer('puntosPropiosSocios');
            $table->integer('puntosActualesSocios');
            $table->timestamps();
            $table->unsignedInteger('invitador');
            $table->foreign('invitador')->references('idClientes')->on('socios');
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
