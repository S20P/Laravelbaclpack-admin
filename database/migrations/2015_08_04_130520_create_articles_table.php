<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->integer('category_id')->unsigned();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('short_content')->nullable();
            $table->longText('quote')->nullable();
            $table->string('banner_image')->nullable();
            $table->longText('column1_image')->nullable();
            $table->longText('column1_title')->nullable();
            $table->longText('column1_description')->nullable();
            $table->longText('column2_image')->nullable();
            $table->longText('column2_title')->nullable();
            $table->longText('column2_description')->nullable();
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->longText('image')->nullable();
            $table->longText('video')->nullable();
            $table->enum('status', ['PUBLISHED', 'DRAFT'])->default('PUBLISHED');
            $table->date('date')->nullable();
            $table->string('author')->nullable();
            $table->boolean('featured')->default(0);
            $table->string('filter_by')->default('all');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
