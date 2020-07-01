<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceRange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('price_range')) {

        Schema::create('price_range', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('price_range')->nullable();
            $table->string('status')->nullable();
            $table->string('symbol')->nullable();
            $table->timestamps();
        });

    }
          // price_range = ["low","medium","high"];
          // status = [1,2,3];
          // symbol = ['€','€€',€€€'];
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_range');
    }
}
