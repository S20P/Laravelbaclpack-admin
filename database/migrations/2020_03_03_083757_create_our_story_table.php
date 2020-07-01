<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOurStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_story', function (Blueprint $table) {
            $table->increments('id');
            $table->string('section1_subtitle')->nullable();
            $table->string('section1_title')->nullable();
            $table->string('section1_description_title')->nullable();
            $table->longText('section1_description')->nullable();
            $table->string('section2_subtitle')->nullable();
            $table->string('section2_tile')->nullable();
            $table->string('section2_description_title')->nullable();
            $table->longText('section2_description')->nullable();
            $table->string('section3_subtitle')->nullable();
            $table->string('section3_title')->nullable();
            $table->string('section3_description_title')->nullable();
            $table->longText('section3_description')->nullable();
            $table->string('color1')->nullable();
            $table->string('color2')->nullable();
            $table->string('color3')->nullable();
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
        Schema::dropIfExists('our_story');
    }
}
