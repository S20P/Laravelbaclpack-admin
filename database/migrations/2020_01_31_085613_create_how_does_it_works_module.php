<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHowDoesItWorksModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('how_does_it_works_module', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('heading')->nullable();
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->string('step_number')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('how_does_it_works_module');
    }
}
