<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('supplier_reviews')){
        Schema::create('supplier_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_id')->nullable();
            $table->integer('supplier_services_id')->unsigned()->nullable();
            $table->text('content_review')->nullable();
            $table->boolean('status')->unsigned()->nullable()->default(0);          
            $table->string('rates')->nullable();
            $table->timestamps();
        });
    
    }
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_reviews');
    }
}
