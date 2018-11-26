<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidToActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notebooks', function (Blueprint $table) {
            //
            $table->text('data')->nullable();
            $table->text('attached')->nullable();
            $table->string('activity_type')->nullable();
            $table->integer('alumno_id')->unsigned()->nullable()->after('id');
            //relation
            $table->foreign('alumno_id')->references('id')->on('alumnos')
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
        Schema::table('notebooks', function (Blueprint $table) {
            //
            // 1. Drop foreign key constraints
            $table->dropForeign(['alumno_id']);

            // 2. Drop the column
            $table->dropColumn('alumno_id');
            $table->dropColumn('data');
            $table->dropColumn('attached');
            $table->dropColumn('activity_type');
        });
    }
}
