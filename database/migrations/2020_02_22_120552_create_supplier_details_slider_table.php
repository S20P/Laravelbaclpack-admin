<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierDetailsSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_details_slider', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('supplier_services_id')->unsigned()->nullable();
            $table->string('heading')->nullable();
            $table->text('content')->nullable();
            $table->longText('image')->nullable();
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
        Schema::dropIfExists('supplier_details_slider');
    }
}
