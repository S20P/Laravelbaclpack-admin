<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->integer('service_id')->unsigned()->nullable();
            $table->string('business_name')->nullable();
            $table->longText('service_description')->nullable();
            $table->longText('location')->nullable();
            $table->string('facebook_title')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('instagram_title')->nullable();
            $table->string('instagram_link')->nullable();            
            $table->enum('price_range', [1,2,3])->default(1);
            $table->enum('status', ['Active', 'Deactive'])->default('Deactive');
            $table->boolean('featured')->default(0);
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
        Schema::dropIfExists('supplier_services');
    }
}
