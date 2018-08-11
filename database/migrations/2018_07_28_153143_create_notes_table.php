<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curso_id');
            $table->unsignedInteger('user_id');
            $table->string('subject');
            $table->text('body');
            $table->string('attached', 128)->nullable();
            $table->enum('status', ['0', '1'])->default('0');
            $table->enum('sticky', ['0', '1'])->default('0');
            $table->timestamps();

            $table->foreign('curso_id')->references('id')->on('cursos')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('note_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('note_id');
            $table->unsignedInteger('user_id');
            $table->enum('readed', ['0', '1'])->default('0');
            $table->timestamp('readed_at')->nullable();

            $table->foreign('note_id')->references('id')->on('notes')
                ->onUpdate('cascade')->onDelete('cascade');
                
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('note_user');
        Schema::dropIfExists('notes');
        
    }
}
