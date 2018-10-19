<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotebooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('notebooks', function (Blueprint $table) {
            $table->increments('id');
            $table->text('foods')->nullable();
            $table->text('moods')->nullable();
            $table->text('naps')->nullable();
            $table->text('depositions')->nullable();
            $table->text('accidents')->nullable();
            $table->text('comment')->nullable();
            $table->text('activity')->nullable();
            $table->timestamp('notebook_date');
            $table->timestamps();
            // realtion

        });
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->timestamp('activity_date');
            $table->timestamps();

        });
        Schema::create('attaches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file')->nullable();
            $table->timestamps();
        });
        Schema::create('alumno_notebook', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('alumno_id')->unsigned();
            $table->integer('notebook_id')->unsigned();
            $table->timestamps();

            // realtion
            $table->foreign('alumno_id')->references('id')->on('alumnos')
                ->onUpdate('cascade')->onDelete('cascade');
            // realtion
            $table->foreign('notebook_id')->references('id')->on('notebooks')
                ->onUpdate('cascade')->onDelete('cascade');

        });
        
        Schema::create('activity_notebook', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned();
            $table->integer('notebook_id')->unsigned();
            $table->timestamps();

            $table->foreign('activity_id')->references('id')->on('activities')
                ->onUpdate('cascade')->onDelete('cascade');
            // realtion
            $table->foreign('notebook_id')->references('id')->on('notebooks')
                ->onUpdate('cascade')->onDelete('cascade');    

        });
        Schema::create('attached_notebook', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attached_id')->unsigned();
            $table->integer('notebook_id')->unsigned();

            // realtion
            $table->foreign('attached_id')->references('id')->on('attaches')
                ->onUpdate('cascade')->onDelete('cascade');
            // realtion
            $table->foreign('notebook_id')->references('id')->on('notebooks')
                ->onUpdate('cascade')->onDelete('cascade');

        });

        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('alumno_notebook');
        Schema::dropIfExists('activity_notebook');
        Schema::dropIfExists('attached_notebook');
        Schema::dropIfExists('notebooks');
        Schema::dropIfExists('attaches'); 
        Schema::dropIfExists('activities');   
        
        
    }
}
