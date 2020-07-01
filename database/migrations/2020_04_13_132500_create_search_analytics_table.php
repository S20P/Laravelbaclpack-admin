<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_analytics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('service_id')->unsigned()->nullable();
            $table->integer('event_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->string('date')->nullable();
            $table->string('browser_session')->nullable();            
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
        Schema::dropIfExists('search_analytics');
    }
}
