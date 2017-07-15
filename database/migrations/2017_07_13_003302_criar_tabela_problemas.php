<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaProblemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_problema' , function(Blueprint $table) {
            $table->increments('id');
            $table->text('descricao');
            $table->string('tipo_geom');
            $table->timestamps();
        });

        Schema::create('problemas' , function(Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id');
            $table->integer('tipo_problema_id');
            $table->text('descricao');
            $table->string('geom');
            $table->boolean('resolvido');
            $table->timestamps();
            $table->foreign('tipo_problema_id')->references('id')->on('tipos_problema');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('problemas' , function(Blueprint $table) {
            $table->dropForeign(['tipo_problema_id']);
        });

        Schema::drop('tipos_problema');
        Schema::drop('problemas');
    }
}
