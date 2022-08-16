<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFocusAreaTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('focus_area_teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('focusarea_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->integer('lesson_id')->unsigned();
            $table->string('embeded_url')->nullable();
            $table->timestamps();
            $table->foreign('focusarea_id')->references('id')->on('focus_areas')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lesson_subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('focus_area_teachers');
    }
}
