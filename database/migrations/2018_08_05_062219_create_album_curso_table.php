<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_curso', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('album_id')->unsigned();
            $table->integer('curso_id')->unsigned();
            
            $table->timestamps();
            //relation
            $table->foreign('album_id')->references('album_id')->on('albums')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_curso');
    }
}
