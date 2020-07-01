<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_profile')) {
            Schema::create('customer_profile', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable();
                $table->string('name')->nullable();
                $table->string('email')->unique();
                $table->string('phone')->nullable();
                $table->string('image')->nullable()->default('/images/avtar.png');
                $table->enum('status', ['Approved', 'Disapproved'])->default('Disapproved');
                $table->string('password')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
            // Schema::table('customer_profile', function($table) {
            //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_profile');
    }
}
