<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dni')->nullable();
            $table->string('apellidopaterno', 200)->nullable();
            $table->string('apellidomaterno', 200)->nullable();
            $table->string('nombres', 200)->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('email', 200)->nullable();            
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
