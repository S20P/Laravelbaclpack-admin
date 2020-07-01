<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalytics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('supplier_services_id')->unsigned()->nullable();
            $table->string('slug')->nullable();
            $table->enum('analytics_event_type', ['impressions','clicks_view','photo_view','mobile_view','email_view','message_view','page_view'])->nullable();
            $table->string('image_url')->nullable();
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
        Schema::dropIfExists('analytics');
    }
}
