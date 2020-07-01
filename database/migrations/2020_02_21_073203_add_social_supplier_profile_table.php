<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialSupplierProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier_profile', function (Blueprint $table) {
            $table->string('facebook_link')->after('status');
            $table->string('instagram_link')->after('facebook_link');
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
