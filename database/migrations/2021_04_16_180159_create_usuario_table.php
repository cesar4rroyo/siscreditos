<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login');
            $table->string('password');
            $table->unsignedInteger('tipousuario_id')->nullable();
            $table->foreign('tipousuario_id', 'fk_usuario_tipousuario')
                ->nullable()
                ->references('id')
                ->on('tipousuario')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedInteger('persona_id')->nullable();
            $table->foreign('persona_id', 'fk_usuario_persona')
                ->nullable()
                ->references('id')
                ->on('persona')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
        Schema::dropIfExists('usuario');
    }
}
