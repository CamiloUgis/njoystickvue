<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('idUsuarios');
            $table->string('nickUsuarios');
            $table->string('password');

            $table->integer('idRoles')->unsigned();
            $table->foreign('idRoles')->references('idRoles')->on('roles');
            $table->timestamps();
        });
        DB::table('usuarios')->insert(
            array(
                'nickUsuarios' => 'njoystick',
                'password' => 'njoystick12345',
                'idRoles'=>1
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
