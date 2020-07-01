<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('booking_id')->unsigned()->nullable();
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->longText('response')->nullable();
            $table->string('amount')->nullable();
            $table->boolean('status')->unsigned()->nullable()->default(0);
            $table->string('payment_status')->nullable();            
            $table->boolean('paid_unpaid')->unsigned()->nullable()->default(0);
            $table->string('payment_date')->nullable();
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
        Schema::dropIfExists('payment');
    }
}
