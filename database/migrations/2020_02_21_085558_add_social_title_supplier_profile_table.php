<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialTitleSupplierProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier_profile', function (Blueprint $table) {
            $table->string('facebook_title')->after('facebook_link');
            $table->string('instagram_title')->after('instagram_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier_profile', function (Blueprint $table) {
            
        });
    }
}
