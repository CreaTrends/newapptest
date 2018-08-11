<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        //relacion de cursos usuarios
        Schema::create('curso_teacher', function (Blueprint $table) {
            $table->unsignedInteger('curso_id');
            $table->unsignedInteger('user_id');
            
            $table->timestamps();
            //relation
            $table->foreign('curso_id')->references('id')->on('cursos')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'curso_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('curso_teacher');
        Schema::dropIfExists('cursos');
    }
}
