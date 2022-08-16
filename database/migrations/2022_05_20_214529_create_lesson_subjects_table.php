<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('focusarea_id')->unsigned();
            $table->string('name');
            $table->timestamps();
            $table->foreign('focusarea_id')->references('id')->on('focus_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_subjects');
    }
}
