<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_works', function (Blueprint $table) {
            $table->id();
            $table->integer('focusarea_id')->unsigned();
            $table->integer('lesson_id')->unsigned();
            $table->string('name');
            $table->timestamps();
            $table->foreign('focusarea_id')->references('id')->on('focus_areas')->onDelete('cascade');
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
        Schema::dropIfExists('home_works');
    }
}
