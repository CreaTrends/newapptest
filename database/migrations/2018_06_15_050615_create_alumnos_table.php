<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->increments('id');

            // profile
            $table->string('firstname');
            $table->string('lastname');
            $table->string('city')->nullable();
            $table->string('address')->nullable();

            $table->enum('gender', ['Male', 'Female'])->default('Female');
            $table->enum('allow_photos', ['0', '1'])->default('0');
            $table->string('image')->default('default.jpg');

            
            $table->string('doctor_name')->nullable();
            $table->string('doctor_phone')->nullable();

            $table->string('emergencycontact1_firstname')->nullable();
            $table->string('emergencycontact1_lastname')->nullable();
            $table->string('emergencycontact1_phone')->nullable();
            
            $table->text('allergies')->nullable();
            $table->text('medications')->nullable();

            $table->datetime('birthday')->nullable();

            $table->boolean('status')->default(false);
            
            $table->timestamps();

            //relation

            
        });
        // alumno curso
        Schema::create('alumno_curso', function (Blueprint $table) {

          $table->unsignedInteger('alumno_id');
          $table->unsignedInteger('curso_id');
          $table->foreign('alumno_id')->references('id')->on('alumnos')
              ->onDelete('cascade')
              ->onUpdate('cascade');
          $table->foreign('curso_id')->references('id')->on('cursos')
              ->onDelete('cascade')
              ->onUpdate('cascade');


        });
        // alumno teacher
        Schema::create('alumno_teacher', function (Blueprint $table) {

          $table->unsignedInteger('alumno_id');
          $table->unsignedInteger('user_id');
          
          $table->timestamps();
          //relation
          $table->foreign('alumno_id')->references('id')->on('alumnos')
              ->onDelete('cascade')
              ->onUpdate('cascade');
          $table->foreign('user_id')->references('id')->on('users')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        });
        // alumno to parent
        Schema::create('alumno_parent', function (Blueprint $table) {

          $table->unsignedInteger('alumno_id');
          $table->unsignedInteger('user_id');
          $table->enum('is_parent_type', ['0', '1'])->default('1');
          
          $table->timestamps();
          //relation
          $table->foreign('alumno_id')->references('id')->on('alumnos')
              ->onDelete('cascade')
              ->onUpdate('cascade');
          $table->foreign('user_id')->references('id')->on('users')
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
        
        Schema::dropIfExists('alumno_curso');
        Schema::dropIfExists('alumno_teacher');
        Schema::dropIfExists('alumno_parent');
        Schema::dropIfExists('alumnos');
    }
}
