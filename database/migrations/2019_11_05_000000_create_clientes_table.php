<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'clientes';

    /**
     * Run the migrations.
     * @table Clientes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
           
            $table->increments('idClientes');
            $table->string('nombreClientes', 100);
            $table->string('rutClientes', 100)->unique();
            $table->string('comunaClientes', 100)->nullable();
            $table->string('correoClientes', 100)->nullable();
            $table->integer('telefonoClientes')->nullable();
            $table->timestamps();

            
        });
        DB::update("ALTER TABLE clientes AUTO_INCREMENT = 99");
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
