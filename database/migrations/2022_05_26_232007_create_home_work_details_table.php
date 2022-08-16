<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeWorkDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_work_details', function (Blueprint $table) {
            $table->id();
            $table->integer('homework_id')->unsigned();
            $table->string('question');
            $table->json('answer')->nullable();
            $table->string('final_answer');
            $table->timestamps();
            $table->foreign('homework_id')->references('id')->on('home_works')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_work_details');
    }
}
