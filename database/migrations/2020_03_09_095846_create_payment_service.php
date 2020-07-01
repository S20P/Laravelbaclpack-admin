<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('service_id')->unsigned();
            $table->integer('supplier_id')->unsigned();
            $table->string('subscribe_id')->nullable();
            $table->string('payment_date')->nullable();
            $table->longText('response')->nullable();
            $table->string('amount')->nullable();
            $table->string('payment_status')->nullable();
            $table->boolean('status')->unsigned()->nullable()->default(0);
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
        Schema::dropIfExists('payment_service');
    }
}
