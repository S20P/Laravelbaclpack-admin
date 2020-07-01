<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contact_number')->nullable();
            $table->string('contact_email')->nullable();
            $table->longText('address')->nullable();
            $table->longText('logo1')->nullable();
            $table->longText('logo2')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('pagination_per_page')->nullable();
            $table->longText('stripe_key')->nullable();
            $table->longText('stripe_secret')->nullable();
            $table->string('instagram_user_id')->nullable();
            $table->longText('instagram_secret')->nullable();
            $table->string('number_of_feeds')->nullable();
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
        Schema::dropIfExists('site_details');
    }
}
